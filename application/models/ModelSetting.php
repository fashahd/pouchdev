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

        function createNewUser($email,$arrpermission){
            $companyID 	= $this->session->userdata("sessCompanyID");
            $userID     = $this->createUserID();
            $data = array(
                'userID'        =>$userID,
                'email'         =>$email,
                'company_id'    =>$companyID,
                'status'        =>'deactive'
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
                return json_encode(array("status"=>400,"keterangan"=>"User Failed to Invited, Please Call Our Customer Service"));
            } else {
                //SMTP & mail configuration
                $config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => 'ssl://mail.mypouch.co.id',
                    'smtp_port' => 465,
                    'smtp_user' => 'info@mypouch.co.id',
                    'smtp_pass' => 'mypouch2018',
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8'
                );
                $this->email->initialize($config);
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");

                //Email content
                $htmlContent = '<h1>Sending email via SMTP server</h1>';
                $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

                $this->email->to($email);
                $this->email->from('info@mypouch.co.id','Test');
                $this->email->subject('How to send email via SMTP server in CodeIgniter');
                $this->email->message($htmlContent);

                //Send email
                $result = $this->email->send();
                //if everything went right, commit the data to the database
                $this->db->trans_commit();
                return json_encode(array("status"=>200,"keterangan"=>"User Invited Success"));
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
            $sql    = "SELECT * FROM pouch_masteremployeecredential WHERE company_id = '$companyID'";
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
                            $retpermit .= "<i style='font-size:16pt;margin-right:10px' class='$key->permission_icon' title='$key->permission_name'></i> ";
                        }
                    }
                    $btnaction = "";
                    if($userID != $row->userID){
                        $btnaction = "
                        <a class='btn btn-primary'onclick='editUser(\"$row->userID\")'><i class='icon-pencil3'></i> Edit</a>
                        <a class='btn btn-danger' onclick='deleteuser(\"$row->userID\")'><i class='icon-eraser2'></i> Delete</a>";
                    }
                    $ret .= "<tr><td>$row->fullName</td><td>$row->email</td><td>$retpermit</td><td>$btnaction</td></tr>";
                }
            }

            return $ret;
        }

        function getTabUsers($userID){
            $dataUsers = $this->getDataUsers();
            $ret = '
            <div class="panel-heading">
                <h5 class="panel-title">Users Settings</h5>
                <a data-toggle="modal"  data-target="#modal_users" type="button" class="btn btn-primary btn-labeled btn-sm pull-right"><b><i class="icon-user-plus"></i></b> Invite Account</a></span>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-framed">
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
            ';

            return $ret;
        }

        function getTabBilling($userID){
            $ret = '
			<div class="">
				<div class="col-lg-6">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Billing</h5>
						</div>

						<div class="panel panel-body">
							<div class="row">
								<h2 class="text-semibold panel-title" style="padding-left:20px">
									<i class="icon-wallet icon-2x text-info position-left"></i>
									IDR 0
								</h2>
								<h4 class="text-semibold text-muted" style="padding-left:20px">
									Billing Balance
								</h4>
							</div>
							<hr>
							<div class="row">
								<h2 class="text-semibold panel-title" style="padding-left:20px">
									<i class=" icon-credit-card icon-2x text-warning position-left"></i>
									IDR 0
								</h2>
								<h4 class="text-semibold text-muted" style="padding-left:20px">
									Outstanding Fees Amount
								</h4>
							</div>
							<div class="row">
								<div class="panel panel-body">
								<ul class="media-list">
									<li class="media stack-media-on-mobile">
			        					<div class="media-left">
											<div class="thumb">
												<a href="#">
													<img style="width:100px"src="'.base_url().'assets/logo_company/logo_mandiri_2016.png" class="img-responsive img-rounded media-preview" alt="">
												</a>
											</div>
										</div>
			        					<div class="media-body">
											<table class="table">
												<tr><td>Payment method</td><td>MANDIRI Virtual Account </td></tr>
												<tr><td>Account Number</td><td>886082002290</td></tr>
												<tr><td><button class="btn btn-primary">How To Pay</button></td></tr>
											</table>
										</div>
									</li>
								</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Rate Card</h5>
						</div>

						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Disbursements</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Price</td>
											<td>IDR 4.500</td>
										</tr>
									</tbody>
								</table>
								<table class="table">
									<thead>
										<tr>
											<th>Virtual accounts</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Price</td>
											<td>IDR 4.500</td>
										</tr>
									</tbody>
								</table>
								<table class="table">
									<thead>
										<tr>
											<th>Name validators</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Price</td>
											<td>IDR 0</td>
										</tr>
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

        function getCompanyBalance($companyID){
            $sql = "SELECT company_balance FROM pouch_mastercompanyaccount WHERE company_id = ?";
            $query = $this->db->query($sql,array($companyID));
            if($query){
                $row = $query->row();
                $balance = $row->company_balance;
            }else{
                $balance = 0;
            }

            return $balance;
        }

        function getTabWithdraw($userID){
            $companyID 	    = $this->session->userdata("sessCompanyID");
            $withdrawlist   = $this->getWithdrawList($companyID);
            $balance        = $this->getCompanyBalance($companyID);
            $dataRet = '';
			$optdest = "";
            if($withdrawlist){
				$dataRet .= '
					<table class="table">
					<thead>
						<tr>
							<td>Bank</td>
							<td>Account number</td>
							<td>Account name</td>
							<td></td>
						</tr>
					</thead>
					<tbody>';
                foreach($withdrawlist as $row){
                    $account_number = $this->aes->decrypt_aes256($row->account_number);
                    $dataRet .= "<tr><td>$row->bank_name</td><td>$account_number</td><td>$row->account_name</td><td><button onclick='deletewithdrawbank(\"$row->withdraw_bank_id\")' class='btn btn-danger'><i class=' icon-trash'></i></button><td/></tr>";
					$optdest .= "<option value='$account_number'>$account_number - $row->account_name</option>";
				}
				$dataRet .= '			
						</tbody>
					</table>
				';
            }else{
				$dataRet = "<table><tr><td>There no bank account</td></tr></table>";
			}
            $ret = '
			<div class="panel-heading">
                <h5 class="panel-title">Withdraw Settings</h5>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8">
					<!-- Basic layout-->
							<div class="panel-heading">
								<h5 class="panel-title">Bank Account</h5><a data-toggle="modal"  data-target="#modal_bank" type="button" class="btn btn-primary btn-labeled btn-sm pull-right"><b><i class="icon-wallet"></i></b> Add Bank Account</a></span>
							</div>
						<div class="panel panel-flat">
							<div class="panel-body">
								<div class="table-responsive">
								'.$dataRet.'
								</div>
							</div>
						</div>
					</div>
                    <div class="col-md-4">
					<!-- Basic layout-->
						<div class="panel-heading">
							<h5 class="panel-title">Withdraw</h5>
						</div>
						<div class="panel panel-flat">
							<div class="panel-body">
							<p>Available cash for withdrawal</p>
							<h4>IDR '.number_format($balance).'</h4>
							<form id="doBalance">
								<div class="form-group">
									<label>Amount:</label>
									<input required onkeypress="return isNumberKey(event)" type="text" class="form-control" placeholder="Amount" name="amount">
									<span id="notepin"></span>
								</div>
								<div class="form-group">
									<label>Destination:</label>
									<select required name="account" id="account" data-placeholder="Destination" class="select" name="account">\
										<option></option>
										'.$optdest.'
									</select>
								</div>
								<div class="form-group">
									<button class="btn btn-primary">Withdraw</button>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$("#account").select2();
			</script>
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
            <div class="panel-heading">
                <h5 class="panel-title">General Settings</h5>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <!-- Basic layout-->
                        <form  id="account_information">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Account Information</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Full Name:</label>
                                        <input placeholder="Full Name" name="fullname" id="fullname" type="text" value="'.$fullName.'" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input placeholder="example@domain.com" name="email" id="email" type="email" value="'.$email.'" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number:</label>
                                        <input placeholder="Phone Number" name="phone" id="phone" type="text" value="'.$phoneNumber.'" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <!-- Basic layout-->
                        <form  id="business_information">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Business Information</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Bussiness Name:</label>
                                        <input placeholder="Business Name" name="business_name" id="business_name" type="text" value="'.$company_name.'" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Bussiness Email:</label>
                                        <input placeholder="example@domain.com" name="business_email" id="business_email" type="email" value="'.$company_email.'" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Bussiness Address:</label>
                                        <input placeholder="Business Address" name="address" id="address" type="text" value="'.$company_address.'" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <!-- Basic layout-->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Top Up Balance</h5>
                            </div>
                            <div class="panel-body">
                                <div class="thumbnail">
                                    <div class="thumb">
                                        <img src="'.base_url().'assets/logo_company/logo_mandiri_2016.png" alt="" style="width:250px">
                                        <div class="caption-overflow">
                                            <span>
                                                <a href="'.base_url().'assets/logo_company/logo_mandiri_2016.png" data-popup="lightbox" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
                                                <a href="#" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-link2"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-borderless">
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
                                        <td colspan="2" style="text-align:center"><button class="btn btn-primary" data-toggle="modal" data-target="#modal_how_to_pay">How to Pay</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <!-- Basic layout-->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Business Logo</h5>
                            </div>
                            <div class="panel-body">
                                <figure class="card-profile-image">
                                    <div id="imgContainer">
                                        <form enctype="multipart/form-data" action="settings/uploadlogo" method="post" name="image_upload_form" id="image_upload_form">
                                            <div id="imgArea" class="card-avatar">
                                                <img src="'.base_url().$company_logo.'" alt="" class="responsive-img activator">
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
                                <hr>
                                <h6>Upload Notes : <br> Smaller than 512 Kb <br> Size 128px by 128px </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Basic layout-->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Account Security</h5>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center; margin-bottom:10px">
                                        <button class="btn btn-primary amber darken-4" data-toggle="modal" data-target="#modal_small1">Change Password</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center">
                                        <button class="btn btn-primary amber darken-4" data-toggle="modal" data-target="#modal_small">Change PIN</button>
                                    </div>
                                </div>
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
			<div class="panel-heading">
                <h5 class="panel-title">API Settings</h5>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
					<!-- Basic layout-->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Development Keys</h5>
							</div>
							<div class="panel-body">
								<!--<div class="form-group">
									<label>Public Key:</label>
									<input class="form-control"  disabled id="public_key_development" type="text" value="'.$public_key_dev.'">
								</div>
								<div class="form-group tooltips">
									<button class="btn btn-primary" id="user_cre_dev" data-popup="tooltip" title="Copy to Clipboard" >Copy</button>
								</div>-->
								<div class="form-group">
									<label>Secret Key:</label>
									<input class="form-control" disabled id="secret_key_development" type="text" value="'.$secret_key_dev.'">
								</div>
								<div class="form-group tooltips">
									<button class="btn btn-primary" id="user_key_dev" data-popup="tooltip" title="Copy to Clipboard" >Copy</button>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-md-6">
					<!-- Basic layout-->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Live Keys</h5>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<label>Secret Key:</label>
									<input class="form-control" disabled id="" type="text" value="Not Available">
								</div>
								<div class="form-group">
									<button class="btn btn-primary" id="">Copy</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>				
				$("#user_cre_dev").on("click",function() {
					var text = $("#public_key_development").val();
					// alert(text);
					var textArea = document.createElement( "textarea" );
					textArea.value = text;
					document.body.appendChild( textArea );

					textArea.select();

					try {
						var successful = document.execCommand( "copy" );
						var msg = successful ? "successful" : "unsuccessful";
						new PNotify({
							title: "Copy Success",
							text: "Public Key Was Copied",
							addclass: "alert alert-info alert-styled-right",
							type: "info"
						});
					} catch (err) {
						console.log("Oops, unable to copy");
					}
					document.body.removeChild( textArea );
				})
				$("#user_key_dev").on("click",function() {
					var text = $("#secret_key_development").val();
					var textArea = document.createElement( "textarea" );
					textArea.value = text;
					document.body.appendChild( textArea );

					textArea.select();

					try {
						var successful = document.execCommand( "copy" );
						var msg = successful ? "successful" : "unsuccessful";
						new PNotify({
							title: "Copy Success",
							text: "Secret Key Was Copied",
							addclass: "alert alert-info alert-styled-right",
							type: "info"
						});
					} catch (err) {
						console.log("Oops, unable to copy");
					}
					document.body.removeChild( textArea );
				})
			</script>
           ';

           return $ret;
        }        

        function getApiDev($userID,$company_id,$password){
            $public_key  = $this->aes->encrypt_aes256($company_id."_".$userID);
            $secret_key  = $this->aes->encrypt_aes256API($company_id."_".$userID);
            $public_key_dev = "pouch_dev_pub_".$public_key;
            $secret_key_dev = "pouch_dev_secret_".$secret_key;

            return array($public_key_dev,$secret_key_dev);
        }

        function createUserID(){
            $initiatx = "MPC";
            $month   = date("m");
            $day     = date("d");
            $year    = date("y");
            $sql    = "SELECT left(a.userID,2) as fmonth, mid(a.userID,3,2) as fday," 
                    . " mid(a.userID,5,2) as fyear, mid(a.userID,7,3) as initiat,"
                    . " right(a.userID,4) as fno FROM pouch_masteremployeecredential AS a"
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