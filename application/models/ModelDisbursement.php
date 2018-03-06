<?php
	class ModelDisbursement extends CI_Model {
        
        private $transactionTable   = 'pouch_mastertransaction';
        private $transactionDetail  = 'pouch_mastertransactiondetail';
        function __construct() {
            parent::__construct();
        }

        function checkPin($pin){
            $company_id    = $this->session->userdata("sessCompanyID");
            $sql    = ' SELECT a.* FROM pouch_mastercompanyaccount as a
                        WHERE a.company_id = ? AND a.company_pin = ?';
            // return $sql;
            $query  = $this->db->query($sql, array($company_id,$pin));
            if($query->num_rows()>0){
                $data   = array("status"=>"match");
            }else{
                $data   = array("status"=>"not_match");
            }

            return json_encode($data);
        }

        function deleteBatch($arrID){
            $this->db->trans_start(); # Starting Transaction
            $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

            for($i=0;$i<count($arrID);$i++){
                $this->db->where('transaction_id', $arrID[$i]);
                $this->db->delete($this->transactionTable);
                $this->db->where('transaction_id', $arrID[$i]);
                $this->db->delete($this->transactionDetail);
            }

            $this->db->trans_complete(); # Completing transaction
            if ($this->db->trans_status() === FALSE) {
                # Something went wrong.
                $this->db->trans_rollback();
                return json_encode(array("status"=>400));
            } 
            else {
                # Everything is Perfect. 
                # Committing data to the database.
                $this->db->trans_commit();
                return json_encode(array("status"=>200));
            }            
        }

        function approveBatch($arrID){
            $arrIDx  = implode("','",$arrID);
            $sql    = " SELECT sum(amount) as total_batch FROM `pouch_mastertransactiondetail`"
                    . " WHERE transaction_id in ('$arrIDx')";
            $query  = $this->db->query($sql);
            $row    = $query->row();
            $total_batch =   $row->total_batch;

            $sql    = "SELECT company_balance FROM `pouch_mastercompanyaccount` WHERE company_id = ?";
            $query  = $this->db->query($sql,array($this->session->userdata("sessCompanyID")));
            $row    = $query->row();
            $balance = $row->company_balance;

            if($balance < $total_batch){
                return json_encode(array("status"=>401,"balance"=>$balance));
            }
            $company_balance = $balance - $total_batch;
            
            $this->db->trans_start(); # Starting Transaction
            $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

            for($i=0;$i<count($arrID);$i++){
                $data 	= array(
                    "status" 		=> "approved"
                );
                $this->db->where("transaction_id",$arrID[$i]);
                $this->db->update($this->transactionTable,$data);
                $this->db->where("transaction_id",$arrID[$i]);
                $this->db->update($this->transactionDetail,$data);
            }

            $saldo  = array("company_balance"=>$company_balance);

            $this->db->where("company_id",$this->session->userdata("sessCompanyID"));
            $this->db->update("pouch_mastercompanyaccount",$saldo);

            $this->db->trans_complete(); # Completing transaction
            if ($this->db->trans_status() === FALSE) {
                # Something went wrong.
                $this->db->trans_rollback();
                return json_encode(array("status"=>400));
            } 
            else {
                # Everything is Perfect. 
                # Committing data to the database.
                $this->db->trans_commit();
                return json_encode(array("status"=>200));
            } 

        }

        function getTransaction($transaction_id){
            $sql    = " SELECT a.*, b.fullName FROM ".$this->transactionTable." as a "
                    . " LEFT JOIN pouch_masteremployeecredential as b on b.userID = a.created_user_id"
                    . " WHERE a.transaction_id = ?";
            $query  =$this->db->query($sql, array($transaction_id));
            if($query->num_rows()>0){
                $row    = $query->row();
                $data   = array($row->reference,$row->fullName,$row->created_dttm,$row->status);
            }else{
                $data   = null;
            }

            return $data;
        }

        function getTransactionDetail($transaction_id){
            $sql    = " SELECT a.* FROM ".$this->transactionDetail." as a"
                    . " WHERE a.transaction_id = '$transaction_id'";
            $query  = $this->db->query($sql);
            $data = "";
            if($query->num_rows()>0){
                foreach($query->result() as $row){
                    if($row->status == "pending"){
                        $status = "Need Approval";
                    }else{
                        $status = "$row->status";
                    }
                    $account_number = $this->aes->decrypt_aes256($row->account_number);
                    $data .= "
                        <tr>
                        <td><span class='btn gradient-45deg-red-pink' style='font-size:9pt'>$status</span></td>
                        <td>$row->amount</td>
                        <td>$row->bank_code</td>
                        <td>$row->account_holder_name</td>
                        <td>$account_number</td>
                        <td></td>
                       </tr>
                    ";
                }
            }else{
                $data .= "<tr><td colspan='6'>Nothing On List</td></tr>";
            }

            return $data;
        }

        function getDataNeedApprove($company_id){
            $sql    = 'SELECT a.*, b.fullName, count(c.transaction_id) as jml_transaksi, sum(c.amount) as total
                        FROM '.$this->transactionTable.' as a
                        LEFT JOIN pouch_masteremployeecredential as b on b.userID = a.created_user_id
                        LEFT JOIN '.$this->transactionDetail.' as c on c.transaction_id = a.transaction_id
                        WHERE a.company_id = ? AND a.status = ? GROUP BY a.transaction_id';
            // $sql    = 'SELECT * FROM '.$this->transactionTable.' WHERE company_id = ?';
            $query  =$this->db->query($sql, array($company_id,"active"));
            if($query->num_rows()>0){
                $data = "";
                foreach($query->result() as $row){
                    $created_date = date("d M Y, H:i", strtotime($row->created_dttm));
                    $total  = number_format($row->total);
                    if($row->status == "pending"){
                        $status = "Need Approval";
                    }else{
                        $status = "$row->status";
                    }
                    $data .= "
                        <tr>
                        <td><input name='batch_disburse[]' type='checkbox' id='chck_$row->transaction_id' value='$row->transaction_id'/>
                        <label for='chck_$row->transaction_id'></label></td>
                        <td>$row->reference</td>
                        <td>$created_date</td>
                        <td>$row->fullName</td>
                        <td>$row->jml_transaksi</td>
                        <td>$total</td>
                        <td><button onClick='showDetailBatch(\"$row->transaction_id\")' class='btn gradient-45deg-red-pink' style='font-size:9pt'>$status</button></td></tr>
                    ";
                }

                $content = '
                <div class="card border-radius-3">
                    <div class="card-content center">
                    <div id="table-datatables">
                        <div class="row">
                            <div class="col s12">
                                <table id="" class="responsive-table display" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th><input type="checkbox" onchange="checkAll(this)" id="all" /><label for="all"></label></th>
                                        <th>Reference</th>
                                        <th>Date Uploaded</th>
                                        <th>Uploader</th>
                                        <th>Qty Transaction</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        '.$data.'
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                 
                    </div>                 
                </div>                 
                ';
            }else{                
                $content = '			
                    <div class="card border-radius-3">
                        <div class="card-content center">
                        <i class="material-icons grey-text" style="font-size:100px">assignment</i>
                        <h5 class="black-text">You do not have any disbursements to approve</h5>
                        <p class="grey-text">Come back after your uploader has uploaded one :)</p>
                        </div>
                    </div>
                ';
            }
            return $content;
        }
        
        function getDataApproved($company_id){
            $sql    = 'SELECT a.*, b.fullName, count(c.transaction_id) as jml_transaksi, sum(c.amount) as total
                        FROM '.$this->transactionTable.' as a
                        LEFT JOIN pouch_masteremployeecredential as b on b.userID = a.created_user_id
                        LEFT JOIN '.$this->transactionDetail.' as c on c.transaction_id = a.transaction_id
                        WHERE a.company_id = ? AND a.status in ? GROUP BY a.transaction_id';
            // $sql    = 'SELECT * FROM '.$this->transactionTable.' WHERE company_id = ?';
            $query  =$this->db->query($sql, array($company_id,array("success","approved")));
            if($query->num_rows()>0){
                $data = "";
                foreach($query->result() as $row){
                    $created_date = date("d M Y, H:i", strtotime($row->created_dttm));
                    $total  = number_format($row->total);
                    if($row->status == "pending"){
                        $status = "Need Approval";
                    }else{
                        $status = "$row->status";
                    }
                    $data .= "
                        <tr>
                        <td>$row->reference</td>
                        <td>$created_date</td>
                        <td>$row->fullName</td>
                        <td>$row->jml_transaksi</td>
                        <td>$total</td>
                        <td><button onClick='showDetailBatch(\"$row->transaction_id\")' class='btn gradient-45deg-red-pink' style='font-size:9pt'>$status</button></td></tr>
                    ";
                }

                $content = '
                <div class="card border-radius-3">
                    <div class="card-content center">
                    <div id="table-datatables">
                        <div class="row">
                            <div class="col s12">
                                <table id="" class="responsive-table display" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>Reference</th>
                                        <th>Date Uploaded</th>
                                        <th>Uploader</th>
                                        <th>Qty Transaction</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        '.$data.'
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                 
                    </div>                 
                </div>                 
                ';
            }else{                
                $content = '			
                    <div class="card border-radius-3">
                        <div class="card-content center">
                        <i class="material-icons grey-text" style="font-size:100px">assignment</i>
                        <h5 class="black-text">You do not have any disbursements</h5>
                        <p class="grey-text">Come back after your approved some batch :)</p>
                        </div>
                    </div>
                ';
            }
            return $content;
        }

        function insertTransaction($companyID,$trnscID,$reference,$userID){
            $now    = date("Y-m-d H:i:s");
            $sql    = "INSERT INTO ".$this->transactionTable." VALUE('$trnscID','$reference','$companyID','active','$now','$userID')";
            $query  = $this->db->query($sql);
            if($query){
                return true;
            }else{
                return false;
            }
        }

        function insertTransactionDetail($data){
            $query  = $this->db->insert_batch($this->transactionDetail, $data);
            if($query){
                return true;
            }else{
                return false;
            }
        }

        function getTransactionID($company_id){
            $initiatx   = "TRDSB".$company_id;
            $trnsc      = strlen($initiatx);
            $month   = date("m");
            $day     = date("d");
            $year    = date("y");
            $sql    = "SELECT left(a.transaction_id,2) as fmonth, mid(a.transaction_id,3,2) as fday," 
                    . " mid(a.transaction_id,5,2) as fyear, mid(a.transaction_id,7,$trnsc) as initiat,"
                    . " right(a.transaction_id,4) as fno FROM ".$this->transactionTable." AS a"
                    . " where left(a.transaction_id,2) = '$month' and mid(a.transaction_id,3,2) = '$day'"
                    . " and mid(a.transaction_id,5,2) = '$year' and mid(a.transaction_id,7,$trnsc)= '$initiatx'"
                    . " order by fmonth desc, CAST(fno AS SIGNED) DESC LIMIT 1";
            // return $sql;
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
            
            $transaction_id = $month.$day.$year.$initiat.$strfno;

            return $transaction_id;
        }

        function saveDisbursment($data){
            
        }
	}
?>