  <?php
	class ModelUser extends CI_Model {
        
        function getTransactions($companyID,$vdt,$vdt2){
            $dttm   = $vdt." 00:00:00";
            $dttm2  = $vdt2." 23:59:59";
            $sql    = " SELECT count(a.transaction_id) as jml_transaction "
                    . " FROM `pouch_mastertransactiondetail` as a "
                    . " WHERE a.company_id = '$companyID' AND a.transaction_date >= '$dttm' "
                    . "AND a.transaction_date <= '$dttm2' AND a.status in ('success','approved')";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $row        = $query->row();
                $jml_transaction = $row->jml_transaction;
                if($jml_transaction > 0){
                    $jml_transaction = number_format($jml_transaction);
                }

                $data = $jml_transaction;
            }else{
                $data = null;
            }
            return $data;
        }

        function getBalance($companyID){
            $sql = " SELECT b.company_balance FROM pouch_mastercompanyaccount as b"
                 . " WHERE b.company_id = '$companyID'";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $row        = $query->row();
                $company_balance = $row->company_balance;
                if($company_balance > 0){
                    $company_balance = number_format($company_balance);
                }

                $data = $company_balance;
            }else{
                $data = null;
            }
            return $data;
        }

        function getIncome($companyID,$vdt,$vdt2){
            $dttm   = $vdt." 00:00:00";
            $dttm2  = $vdt2." 23:59:59";
            $sql    = " SELECT sum(a.company_balance) as company_balance FROM pouch_mastercompanybalancetransaction as a 
                        WHERE a.company_id = '$companyID'
                        AND a.balance_date >= '$dttm' AND a.balance_date <= '$dttm2'";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $row        = $query->row();
                $company_balance = $row->company_balance;
                if($company_balance > 0){
                    $company_balance = number_format($company_balance);
                }else{
                    $company_balance = 0;
                }

                $data = $company_balance;
            }else{
                $data = null;
            }
            return $data;
        }

        function getOutCome($companyID,$vdt,$vdt2){
            $dttm   = $vdt." 00:00:00";
            $dttm2  = $vdt2." 23:59:59";
            $sql    = " SELECT sum(a.amount) as outcome FROM `pouch_mastertransactiondetail` as a
                        WHERE a.company_id = '$companyID'
                        AND a.transaction_date >= '$dttm'
                        AND a.transaction_date <= '$dttm2'
                        AND a.status='approved'";
            $query  = $this->db->query($sql);
            if($query -> num_rows() > 0){
                $row        = $query->row();
                $outcome = $row->outcome;
                if($outcome > 0){
                    $outcome = number_format($outcome);
                }else{
                    $outcome = 0;
                }

                $data = $outcome;
            }else{
                $data = null;
            }
            return $data;
        }
	}
?>