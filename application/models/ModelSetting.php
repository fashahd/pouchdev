<?php
	class ModelSetting extends CI_Model {

        function checkUserExist($email){
            $sql = "SELECT userID FROM pouch_masteremployeecredential WHERE email = ?";
            $query  = $this->db->query($sql,$email);
            if($query->num_rows()>0){
                return "exist";
            }else{
                return "false";
            }
        }

        function updateUser($userID,$arrpermission){
            $this->db->trans_begin();
            if(count($arrpermission)>0){
                $this->db->where('userID', $userID);
                $this->db->delete('pouch_roleuser');
                for($i = 0; $i<count($arrpermission);$i++){
                    $dataPermission = array(
                        'userID' => $userID,
                        'permission_id' => $arrpermission[$i]
                    );
                    $this->db->insert('pouch_roleuser', $dataPermission);
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                //if something went wrong, rollback everything
                $this->db->trans_rollback();
                return json_encode(array("status"=>400,"keterangan"=>"Gagal Update User, Harap Hubungi Customer Service Kami"));
            } else {
                //if everything went right, commit the data to the database
                $this->db->trans_commit();
                return json_encode(array("status"=>200,"keterangan"=>"Berhasil Update User"));
            }
        }

        function addBank($bank,$account_name,$account_number){
            $companyID 	= $this->session->userdata("sessCompanyID");
            $data = array(
                'withdraw_bank_id'  => "", 
                'bank_code'         =>$bank,
                'account_name'      =>$account_name,
                'account_number'    =>$account_number,
                'company_id'        =>$companyID
            );
            $this->db->trans_begin();
            $this->db->insert('pouch_withdraw_account', $data);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                //if something went wrong, rollback everything
                $this->db->trans_rollback();
                return json_encode(array("status"=>400,"keterangan"=>"Bank Account Gagal Ditambahkan, Harap Hubungi Customer Service Kami"));
            } else {
                //if everything went right, commit the data to the database
                $this->db->trans_commit();
                return json_encode(array("status"=>200,"keterangan"=>"Bank Account Berhasil Ditambahkan"));
            }
        }

        function createNewUser($email,$name,$password,$arrpermission){
            $companyID 	= $this->session->userdata("sessCompanyID");
            $userID     = $this->createUserID();
            $data = array(
                'userID'        =>$userID, 
                'fullName'      =>$name,
                'password'      =>$password,
                'email'         =>$email,
                'company_id'    =>$companyID,
                'status'        =>'active'
            );
            $this->db->trans_begin();
            $this->db->insert('pouch_masteremployeecredential', $data);
            if(count($arrpermission)>0){
                for($i = 0; $i<count($arrpermission);$i++){
                    $dataPermission = array(
                        'userID' => $userID,
                        'permission_id' => $arrpermission[$i]
                    );
                    $this->db->insert('pouch_roleuser', $dataPermission);
                }
            } 
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                //if something went wrong, rollback everything
                $this->db->trans_rollback();
                return json_encode(array("status"=>400,"keterangan"=>"User Gagal Ditambahkan, Harap Hubungi Customer Service Kami"));
            } else {
                //if everything went right, commit the data to the database
                $this->db->trans_commit();
                return json_encode(array("status"=>200,"keterangan"=>"User Berhasil Ditambahkan"));
            }
        }

        function updateNewPassword($cur_pass,$new_pass,$re_new_pass){
            $userID = $this->session->userdata("sessUserID");
            $sql    = ' SELECT a.* FROM pouch_masteremployeecredential as a
                        WHERE a.userID = ? AND a.password = ?';
            // return $sql;
            $query  = $this->db->query($sql, array($userID,$cur_pass));
            if($query->num_rows()>0){                
                if($new_pass != $re_new_pass){
                    $data   = array("status"=>"new_not_match");
                }else{
                    $datapassword = array("password"=>$new_pass);
                    $this->db->where("userID",$userID);
                    $query = $this->db->update("pouch_masteremployeecredential",$datapassword);
                    if($query){
                        $data   = array("status"=>"success");
                    }else{
                        $data   = array("status"=>"not_conected");
                    }
                }
            }else{
                $data   = array("status"=>"not_match");
            }

            return json_encode($data);
        }

        function updateNewPIN($new_pin){
            $company_id = $this->session->userdata("sessCompanyID");
            $datapin = array("company_pin"=>$new_pin);
            $this->db->where("company_id",$company_id);
            $query = $this->db->update("pouch_mastercompanyaccount",$datapin);
            if($query){
                $data   = array("status"=>"success");
            }else{
                $data   = array("status"=>"not_conected");
            }

            return json_encode($data);
        }

        function updateAccountInformation($data){
            $userID = $this->session->userdata("sessUserID");
            $this->db->where("userID",$userID);
            $this->db->update("pouch_masteremployeecredential",$data);

            return json_encode(array("status"=>200));
        }
        
        function updateBusinessInformation($data){
            $company_id = $this->session->userdata("sessCompanyID");
            $this->db->where("company_id",$company_id);
            $this->db->update("pouch_mastercompanydata",$data);

            return json_encode(array("status"=>200));
        }

        function getBusinessInformation($userID){
            $sql = "SELECT * FROM pouch_mastercompanydata WHERE userID = '$userID'";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $row        = $query->row();
                $company_id = $row->company_id;
                $company_name    = $row->company_name;
                $company_address = $row->company_address;
                $company_email   = $row->company_email;
                $company_logo    = $row->company_logo;

                $data = array($company_id,$company_name,$company_address,$company_email,$company_logo);
            }else{
                $data = null;
            }
            return $data;
        }

        function getPermssionList(){
            $sql    = "SELECT id,permission_id, permission_name, permission_icon,permission_ket FROM `permission_map`";
            $query  = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result();
            }else{
                return false;
            }
        }

        function getAccountPermission($userID){
            $sql    = "SELECT a.permission_id, a.id, b.permission_icon FROM `pouch_roleuser`  as a 
            LEFT JOIN permission_map as b on b.permission_id = a.permission_id
            WHERE userID = '$userID'";
            $query  = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result();
            }else{
                return false;
            }
        }

        function getAccountInformation($userID){
            $sql = "SELECT * FROM pouch_masteremployeecredential WHERE userID = '$userID'";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $row        = $query->row();
                $fullName   = $row->fullName;
                $email      = $row->email;
                $phoneNumber      = $row->phoneNumber;

                $data = array($fullName,$email,$phoneNumber);
            }else{
                $data = null;
            }
            return $data;
        }
        
        function getCompanyAccountInformation($company_id){
            $sql = "SELECT * FROM pouch_mastercompanyaccount WHERE company_id = '$company_id'";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $row        = $query->row();
                $company_account_name   = $row->company_account_name;
                $company_account_number = $row->company_account_number;

                $data = array($company_account_name,$company_account_number);
            }else{
                $data = null;
            }
            return $data;
        }

        function getDataUsers(){
            $userID = $this->session->userdata("sessUserID");
            $companyID 	= $this->session->userdata("sessCompanyID");
            $sql    = "SELECT * FROM pouch_masteremployeecredential WHERE company_id = '$companyID' and status='active'";
            $query  = $this->db->query($sql);
            $ret    = "";
            if($query->num_rows()>0){
                foreach($query->result() as $row){
                    $sql    = "SELECT a.permission_id, b.permission_icon, b.permission_name
                                FROM `pouch_roleuser` as a 
                                LEFT JOIN permission_map as b on b.permission_id = a.permission_id
                                WHERE a.userID = '$row->userID'";
                    $query  = $this->db->query($sql);
                    $retpermit = "";
                    if($query->num_rows()>0){
                        foreach($query->result() as $key){
                            $retpermit .= "<i class='material-icons'>$key->permission_icon</i>";
                        }
                    }
                    $btnaction = "";
                    if($userID != $row->userID){
                        $btnaction = "
                        <a class='btn-flat waves-effect blue-text'onclick='editUser(\"$row->userID\")'><i class='material-icons left'>border_color</i>Edit</a>
                        <a class='btn-flat waves-effect red-text'onclick='deleteuser(\"$row->userID\")'><i class='material-icons left'>highlight_off</i>Delete</a>";
                    }
                    $ret .= "<tr><td>$row->fullName</td><td>$row->email</td><td>$retpermit</td><td>$btnaction</td></tr>";
                }
            }

            return $ret;
        }

        function getTabUsers($userID){
            $dataUsers = $this->getDataUsers();
            $ret = '
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card-panel">
                        <span class="btn blue right" onClick="addUser()"><i class="material-icons left">add</i>Create User</span><br>
                        <div class="row">
                            <div class="col l12">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Permissions</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        '.$dataUsers.'
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';

            return $ret;
        }

        function getTabBilling($userID){
            $ret = '
            <div id="work-collections" class="seaction">
                <div class="row">
                    <div class="col s12 m12 l6">
                        <div class="col s12 m12 l12">
                            <ul id="issues-collection" class="collection z-depth-1">
                                <li class="collection-item">
                                    <h5 class="collection-header">Billing Balance</h5>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s7">
                                            <h4 class="collections-content">Rp. 0 </h4>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m12 l6">
                        <div class="col s12 m12 l12">
                            <ul id="issues-collection" class="collection z-depth-1">
                                <li class="collection-item">
                                    <h5 class="collection-header">Rate Card</h5>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s7">
                                            <p class="collections-title">Virtual Account</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s7">
                                            <p class="collections-content">Price </p>
                                        </div>
                                        <div class="col s2">
                                            
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content">Rp. 3.500 </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s7">
                                            <p class="collections-title">Disbursements</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s7">
                                            <p class="collections-content">Price </p>
                                        </div>
                                        <div class="col s2">
                                            
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content">Rp. 3.500 </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            ';

            return $ret;
        }

        function getWithdrawList($companyID){
            $sql = "SELECT a.withdraw_bank_id,b.bank_name, a.account_name, a.account_number FROM `pouch_withdraw_account` as a 
                    LEFT JOIN pouch_bankcode as b on b.bank_code = a.bank_code
                    WHERE company_id = '$companyID'";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $data = $query->result();
            }else{
                $data = null;
            }
            return $data;
        }

        function getTabWithdraw($userID){
            $companyID 	    = $this->session->userdata("sessCompanyID");
            $withdrawlist   = $this->getWithdrawList($companyID);
            $dataRet = '';
            if($withdrawlist){
                foreach($withdrawlist as $row){
                    $account_number = $this->aes->decrypt_aes256($row->account_number);
                    $dataRet .= "<tr><td>$row->bank_name</td><td>$account_number</td><td>$row->account_name</td><td><button onclick='deletewithdrawbank(\"$row->withdraw_bank_id\")' class='btn red'>Delete</button><td/></tr>";
                }
            }
            $ret = '
            <div id="work-collections" class="seaction">
                <div class="row">
                    <div class="col s12 m12 l8">
                        <div class="col s12 m12 l12">
                            <ul id="issues-collection" class="collection z-depth-1">
                                <li class="collection-item">
                                    <h5 class="collection-header left">Bank accounts</h5>
                                    <span class="btn blue right" onClick="addBankWithdraw()"><i class="material-icons left">add</i>Add Bank</span>
                                    <br>
                                    <br>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s12">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <td>Bank</td>
                                                        <td>Account number</td>
                                                        <td>Account name</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    '.$dataRet.'
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m12 l4">
                        <div class="col s12 m12 l12">
                        </div>
                    </div>
                </div>
            </div>
            ';

            return $ret;
        }

        function getTabGeneral($userID){
            $account    = $this->getAccountInformation($userID);
            $business   = $this->getBusinessInformation($userID);
            list($fullName,$email,$phoneNumber)=$account;
            list($company_id,$company_name,$company_address,$company_email,$company_logo)=$business;
            $companyaccount = $this->getCompanyAccountInformation($company_id);
            list($company_account_name,$company_account_number)=$companyaccount;
            $ret = '
            <div class="row">
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <h4 class="header2">Account Information</h4><hr>
                        <div class="row">
                            <form class="col s12" id="account_information">
                                <div class="row">
                                    <div class="input-field col s12">
                                    <p>Full Name</p>
                                        <input placeholder="Full Name" name="fullname" id="fullname" type="text" value="'.$fullName.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <p>Email</p>
                                        <input placeholder="example@domain.com" name="email" id="email" type="email" value="'.$email.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <p>Phone Number</p>
                                        <input placeholder="Phone Number" name="phone" id="phone" type="text" value="'.$phoneNumber.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                    <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Save
                                        <i class="material-icons right">send</i>
                                    </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <h4 class="header2">Business Information</h4><hr>
                        <div class="row">
                            <form class="col s12" id="business_information">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <p>Bussiness Name</p>
                                        <input placeholder="Business Name" id="business_name" name="business_name" type="text" value="'.$company_name.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <p>Bussiness Email</p>
                                        <input placeholder="example@domain.com" id="business_email" name="business_email" type="email" value="'.$company_email.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <p>Bussiness Address</p>
                                        <input placeholder="Business Address" id="address" name="address" type="text" value="'.$company_address.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                    <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Save
                                        <i class="material-icons right">send</i>
                                    </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <h4 class="header2">Business Logo</h4><hr>
                        <div class="row">
                            <div class="input-field col s12">
                                <figure class="card-profile-image">
                                    <div id="imgContainer">
                                        <form enctype="multipart/form-data" action="settings/uploadlogo" method="post" name="image_upload_form" id="image_upload_form">
                                            <div id="imgArea" class="card-avatar">
                                                <img src="'.$company_logo.'" alt="" class="responsive-img activator">
                                                <div class="progressBar">
                                                    <div class="bar"></div>
                                                    <div class="percent">0%</div>
                                                </div>
                                                <div id="imgChange">
                                                    <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </figure>
                            </div>
                        </div>
                        <p>Upload Notes : <br> Smaller than 512 Kb <br> Size 128px by 128px </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <h4 class="header2">Top Up Balance</h4><hr>
                        <div class="row">
                            <div class="input-field col s12">
                                <figure class="card-profile-image">
                                    <div id="imgContainer">
                                        <img src="'.base_url().'assets/logo_company/logo_mandiri_2016.png" alt="" class="responsive-img activator">
                                    </div>
                                </figure>
                            </div>
                        </div>
                        <table>
                            <tr>
                                <td>Payment Method</td>
                                <td>: Virtual Account</td>
                            </tr>
                            <tr>
                                <td>Account Number</td>
                                <td>: '.$company_account_number.'</td>
                            </tr>
                            <tr>
                                <td>Account Name</td>
                                <td>: '.$company_account_name.'</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center"><button class="btn cyan">How to Pay</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <h4 class="header2">Security</h4><hr>
                        <div class="row">
                            <div class="input-field col s12 center">
                                <button class="btn btn-primary amber darken-4" onClick="changePassword()">Change Password</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 center">
                            <button class="btn btn-primary amber darken-4" onClick="changePIN()">Change PIN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           ';

           return $ret;
        }

        function getTabDeveloper($userID){
            $account    = $this->getAccountInformation($userID);
            $business   = $this->getBusinessInformation($userID);
            list($fullName,$email,$phoneNumber)=$account;
            list($company_id,$company_name,$company_address,$company_email,$company_logo)=$business;
            $companyaccount = $this->getCompanyAccountInformation($company_id);
            list($company_account_name,$company_account_number)=$companyaccount;
            $apidev = $this->getApiDev($userID,$company_id,"");
            list($public_key_dev,$secret_key_dev)=$apidev;
            $ret = '
            <div class="row">
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <h4 class="header2">Development Keys</h4><hr>
                        <div class="row">
                            <form class="col s12" id="account_information">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <span>Public Key</span>
                                        <input disabled id="public_key_development" type="text" value="'.$public_key_dev.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <span>Secret Key</span>
                                        <input disabled id="secret_key_development" type="text" value="'.$secret_key_dev.'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                    <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Save
                                        <i class="material-icons right">send</i>
                                    </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           ';

           return $ret;
        }        

        function getApiDev($userID,$company_id,$password){
            $shacompany_id  = $this->aes->encrypt_aes256($company_id);
            $shauserID      = $this->aes->encrypt_aes256API($userID);
            $public_key_dev = "pouch_dev_pub_".$shauserID;
            $secret_key_dev = "pouch_dev_key_".$shacompany_id;

            return array($public_key_dev,$secret_key_dev);
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