  <?php
	class ModelUser extends CI_Model {        
        function getTransactions($companyID,$vdt,$vdt2){
            $dttm   = $vdt." 00:00:00";
            $dttm2  = $vdt2." 23:59:59";
            $amount = 0;
            $amountdisburse = 0;
            $sql    = " SELECT a.transaction_id, a.amount"
                    . " FROM `pouch_mastertransactiondetail` as a "
                    . " WHERE a.company_id = ? AND a.transaction_date >= ? "
                    . "AND a.transaction_date <= ? AND a.status in ('success')";
            $query  = $this->db->query($sql, array($companyID,$dttm,$dttm2));
            if($query -> num_rows() > 0){
                foreach($query->result() as $row){
                    $amount = ($amount+$row->amount);
                }
                $jmltransactionbatch = number_format($query->num_rows());
            }else{
                $jmltransactionbatch = 0;
            }

            $sql2 = " SELECT disburse_id, amount FROM `pouch_disbursements` "
                 . " WHERE company_id = ? AND created_datetime >= ? AND created_datetime <= ? AND status = ?";
            $query2  = $this->db->query($sql2, array($companyID,$dttm,$dttm2,"COMPLETED"));
            // echo $this->db->last_query();
            if($query2 -> num_rows() > 0){
                foreach($query2->result() as $row2){
                    $amountdisburse = ($amountdisburse+$row2->amount);
                }
                $jmltransactiondisburse = number_format($query2->num_rows());
            }else{
                $jmltransactiondisburse = 0;
            }
            $jmltransaction = $jmltransactionbatch + $jmltransactiondisburse;
            $jmlamount      = $amount + $amountdisburse;
            return array($jmltransaction,$jmlamount);
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