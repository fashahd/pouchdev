<?php
	class ModelAuth extends CI_Model {

        function createUser($email,$password,$name,$phone,$business_name,$business_email){
            $sql    = "SELECT * FROM pouch_masteremployeecredential where email = ?";
            $query  = $this->db->query($sql, array($email));
            if($query->num_rows()>0){
                return json_encode(array("status"=>401,"keterangan"=>" Try again, make sure your email unique"));
            }
            $userID     = $this->createUserID();
            $companyID  = $this->createCompanyID();
            $permission = $this->getPermission();
            // return print_r($permission);
            $data = array(
                'userID'        =>$userID, 
                'fullName'      =>$name,
                'password'      =>$password,
                'email'         =>$email,
                'phoneNumber'   =>$phone,
                'company_id'    =>$companyID,
                'status'        =>'active'
            );
            $dataCompany = array(
                'company_id'     =>$companyID, 
                'company_name'   =>$business_name,
                'company_email'  =>$business_email,
                'userID'         =>$userID
            );
            $dataAccount = array(
                'company_id'                =>$companyID,
                'company_account_name'      =>$business_name
            );
            $this->db->trans_begin();
            $this->db->insert('pouch_masteremployeecredential', $data);      
            $this->db->insert('pouch_mastercompanydata', $dataCompany);      
            $this->db->insert('pouch_mastercompanyaccount', $dataAccount);
            if(count($permission)>0){
                for($i = 0; $i<count($permission);$i++){
                    $dataPermission = array(
                        'userID' => $userID,
                        'permission_id' => $permission[$i]
                    );
                    $this->db->insert('pouch_roleuser', $dataPermission);
                }
            }  
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                //if something went wrong, rollback everything
                $this->db->trans_rollback();
                return json_encode(array("status"=>400,"keterangan"=>"Pendaftaran Gagal, Harap Hubungi Customer Service Kami"));
            } else {
                //if everything went right, commit the data to the database
                $this->db->trans_commit();
                return json_encode(array("status"=>200,"keterangan"=>"Create account successfull"));
            }
        }

        function getPermission($type = null){
            $sql    = "SELECT * FROM `permission_map` ORDER BY id asc";
            $query  = $this->db->query($sql);
            if($query->num_rows()>0){
                foreach($query->result() as $row){
                    $arrData[] = $row->permission_id;
                }
            }else{
                $arrData = null;
            }

            return $arrData;
        }

		function validation($email,$password){
            $encrypted_pwd = $this->aes->encrypt_aes256($_POST["password"]);
            $sql    = " SELECT a.*, a.company_id, b.company_logo, b.company_name FROM pouch_masteremployeecredential as a"
                    . " LEFT JOIN pouch_mastercompanydata as b on b.company_id = a.company_id"
                    . " WHERE a.email = ? AND a.password = ?";
            // return $sql;
            $query  = $this->db->query($sql,array($email,$encrypted_pwd));
            if($query->num_rows()>0){
                $row    = $query->row();
                $userID = $row->userID;
                $fullName  = $row->fullName;
                $email  = $row->email;
                $company_id = $row->company_id;
                $company_logo = $row->company_logo;
                $company_name = $row->company_name;
                $data = array(
                    "status"    => "sukses",
                    "userID"    => $userID,
                    "fullName"  => $fullName,
                    "email"     => $email,
                    "company_id" => $company_id,
                    "company_logo" => $company_logo,
                    "company_name"  => $company_name
                );
            }else{
                $data = array(
                    "status"    => "error"
                );
            }
            return json_encode($data);
        }

        function xrequest($url,$jsonDataEncoded){
            $arrheader =  array(
                'Content-Type: Application/json'
            );
            $session = curl_init($url);
            curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
            curl_setopt($session, CURLOPT_POST, 1);
            curl_setopt($session, CURLOPT_POSTFIELDS, $jsonDataEncoded);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
            
            $response = curl_exec($session);
            return $response;
        }

        function createCompanyID(){
            $initiatx = "CMP".date("m");
            $month   = date("m");
            $day     = date("d");
            $year    = date("y");
            $sql    = "SELECT left(a.company_id,2) as fmonth, mid(a.company_id,3,2) as fday," 
                    . " mid(a.company_id,5,2) as fyear, mid(a.company_id,7,5) as initiat,"
                    . " right(a.company_id,4) as fno FROM pouch_mastercompanydata AS a"
                    . " where left(a.company_id,2) = '$month' and mid(a.company_id,3,2) = '$day'"
                    . " and mid(a.company_id,5,2) = '$year' and mid(a.company_id,7,5)= '$initiatx'"
                    . " order by fmonth desc, CAST(fno AS SIGNED) DESC LIMIT 1";
                 
            $result = $this->db->query($sql);	
                
            if($result->num_rows($result) > 0) {
                $row = $result->row();
                $initiat = $row->initiat;
                $fyear = $row->fyear;
                $fmonth = $row->fmonth;
                $fday = $row->fday;
                $fno = $row->fno;
                $fno++;
            } else {
                $initiat = $initiatx;
                $fyear   = $year;
                $fmonth  = $month;
                $fday    = $day;
                $fno     = 0;
                $fno++;
            }
            if (strlen($fno)==1){
                $strfno = "000".$fno;
            } else if (strlen($fno)==2){
                $strfno = "00".$fno;
            } else if (strlen($fno)==3){
                $strfno = "0".$fno;
            } else if (strlen($fno)==4){
                $strfno = $fno;
            }
            
            $company_id = $month.$day.$year.$initiat.$strfno;
    
            return $company_id;
        }

        function createUserID(){
            $initiatx = "MPC";
            $month   = date("m");
            $day     = date("d");
            $year    = date("y");
            $sql    = "SELECT left(a.userID,2) as fmonth, mid(a.userID,3,2) as fday," 
                    . " mid(a.userID,5,2) as fyear, mid(a.userID,7,3) as initiat,"
                    . " right(a.userID,4) as fno FROM POUCH_MasterEmployeeCredential AS a"
                    . " where left(a.userID,2) = '$month' and mid(a.userID,3,2) = '$day'"
                    . " and mid(a.userID,5,2) = '$year' and mid(a.userID,7,3)= '$initiatx'"
                    . " order by fmonth desc, CAST(fno AS SIGNED) DESC LIMIT 1";
                 
            $result = $this->db->query($sql);	
                
            if($result->num_rows($result) > 0) {
                $row = $result->row();
                $initiat = $row->initiat;
                $fyear = $row->fyear;
                $fmonth = $row->fmonth;
                $fday = $row->fday;
                $fno = $row->fno;
                $fno++;
            } else {
                $initiat = $initiatx;
                $fyear   = $year;
                $fmonth  = $month;
                $fday    = $day;
                $fno     = 0;
                $fno++;
            }
            if (strlen($fno)==1){
                $strfno = "000".$fno;
            } else if (strlen($fno)==2){
                $strfno = "00".$fno;
            } else if (strlen($fno)==3){
                $strfno = "0".$fno;
            } else if (strlen($fno)==4){
                $strfno = $fno;
            }
            
            $userID = $month.$day.$year.$initiat.$strfno;
    
            return $userID;
        }
	}
?>