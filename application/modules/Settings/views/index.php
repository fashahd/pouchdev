<?php
    $arrTab = array(
        "General"=>"general",
        "Users"=>"users",
        "Configuration"=>"configuration",
        "API Keys"=>"developer",
        "Withdraw"=>"withdraw",
        "Billing"=>"billing"
    );
    $tabing = "";
    foreach($arrTab as $title => $idtab){
        if($idtab == $tab){
            $active = "class='active'";
        }else{
            $active = "";
        }
        $tabing .= '<li '.$active.' ><a href="#" id="'.$idtab.'" data-toggle="tab">'.$title.'</a></li>';
        // $tabing .= '<li class="tab"><a '.$active.' href="#" id="'.$idtab.'">'.$title.'</a></li>';
    }
?>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><?=$module?></h4>
        </div>
        <div class="heading-elements">
            <div class="col-md-6">
            
            </div>        
        </div>
    </div>
    <div class="breadcrumb-line">
        <div class="panel-flat">
            <div class="panel-body">
            <div class="tabbable col-lg-12">
                <ul class="nav nav-tabs nav-tabs-bottom">
                <?=$tabing?>
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <!-- Form horizontal -->
    <div class="panel panel-flat">
        <div id="settings">
            <?=$tabSetting?>
        </div>
    </div>
</div>
<?php
  $sql    = "SELECT id,permission_id, permission_name, permission_icon,permission_ket FROM `permission_map`";
  $query  = $this->db->query($sql);
  $optPermission = "";
  if($query->num_rows()>0){
    foreach($query->result() as $row){
      $optPermission .= '
        <p>
          <input type="checkbox" name="permission[]" id="pemr_'.$row->permission_id.'" value="'.$row->permission_id.'"/>
          <label for="pemr_'.$row->permission_id.'"><i class="material-icons">'.$row->permission_icon.'</i> '.$row->permission_name.'</label>
        </p>
        <p style="font-size:8pt;color:grey">'.$row->permission_ket.'</p>
        <hr>
      ';
      // $optPermission .= "<input name='permission[]' id='pemr_$row->permission_id' type='checkbox' value='$row->permission_id'> $row->permission_name";
    }
  }
?>
<div id="modal_small" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Change Your PIN</h5>
      </div>
      <form id="changePIN">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Please Enter Your new PIN</label>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group has-feedback has-feedback-left">
                  <input type="password" id="txtChar" onkeypress="return isNumberKey(event)" name="pin" class="form-control input-xlg" placeholder="Enter Your New PIN">
                  <div class="form-control-feedback">
                    <i class="icon-lock"></i>
                  </div>
                  <span id="notepin"></span><br>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <span class="btn btn-link" data-dismiss="modal">Close</span>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="modal_small1" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5 class="modal-title">Change Your Password</h5>
        </div>
        <form id="changePassword">
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Current Password</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback has-feedback-left">
                                <input required placeholder="Current Password" id="cur_pass" name="cur_pass" type="password" class="form-control input-xlg">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2"></i>
                                </div>
                                <span id="notepin"></span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Your new Password</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback has-feedback-left">
                                <input required placeholder="New Password" id="new_pass" name="new_pass" type="password" class="form-control input-xlg">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2"></i>
                                </div>
                                <span id="notepin"></span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Retype new Password</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback has-feedback-left">
                                <input required placeholder="Retype New Password" id="re_new_pass" name="re_new_pass" type="password"  class="form-control input-xlg">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2"></i>
                                </div>
                                <span id="notepin"></span><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-link" data-dismiss="modal">Close</span>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="modal_how_to_pay" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">How To Pay</h5>
        </div>
        <div class="modal-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-component nav-justified">
                    <li class="active"><a href="#solid-rounded-justified-tab1" data-toggle="tab">ATM</a></li>
                    <li><a href="#solid-rounded-justified-tab2" data-toggle="tab">iBanking</a></li>
                    <li><a href="#solid-rounded-justified-tab3" data-toggle="tab">M-Banking</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="solid-rounded-justified-tab1">
                        Silakan baca petunjuk di bawah ini untuk menyelesaikan transaksi Anda:
                        <div class="list-group no-border no-padding-top">
                            <a href="#" class="list-group-item">1. Masukkan kartu ATM dan pilih "Bahasa Indonesia"</a>
                            <a href="#" class="list-group-item">2. Ketik nomor PIN kartu ATM</a>
                            <a href="#" class="list-group-item">3. Pilih menu BAYAR/BELI, kemudian pilih menu MULTI PAYMENT</a>
                            <a href="#" class="list-group-item">4. Ketik kode perusahaan, yaitu "1092" (PT SAKUKU DIGITAL INDONESIA), tekan "BENAR"</a>
                            <a href="#" class="list-group-item">5. Masukkan nomor Virtual Account 886081002290</a>
                            <a href="#" class="list-group-item">6. Isi NOMINAL, kemudian tekan "BENAR"</a>
                        </div>
                    </div>

                    <div class="tab-pane" id="solid-rounded-justified-tab2">
                        Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid laeggin.
                    </div>

                    <div class="tab-pane" id="solid-rounded-justified-tab3">
                        DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg whatever.
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-link" data-dismiss="modal">Close</span>
        </div>
    </div>
  </div>
</div>
<?php
    $sql    = "SELECT id,permission_id, permission_name, permission_icon,permission_ket FROM `permission_map`";
    $query  = $this->db->query($sql);
    $optPermission = "";
    if($query->num_rows()>0){
      foreach($query->result() as $row){
        $optPermission .= '
        
        <tr class="active border-double">
            <td><input type="checkbox" name="permission[]" id="pemr_'.$row->permission_id.'" value="'.$row->permission_id.'"/></td>
            <td>
                <div class="media-left media-middle">
                    <a href="#"><i class="'.$row->permission_icon.'"></i></a>
                </div>
                <div class="media-left">
                    <div class=""><a href="#" class="text-default text-semibold">'.$row->permission_name.'</a></div>
                    <div class="text-muted text-size-small">
                        '.$row->permission_ket.'
                    </div>
                </div>
            </td>
        </tr>
        ';
        // $optPermission .= "<input name='permission[]' id='pemr_$row->permission_id' type='checkbox' value='$row->permission_id'> $row->permission_name";
      }
    }
?>
<div id="modal_users" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Invite Users</h5>
                <p>Please input your team member email</p>
            </div>
            <form id="createUser">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback has-feedback-left">
                                <input required placeholder="Email" id="email" name="email" type="email" class="form-control input-xlg" placeholder="Enter Your New PIN">
                                <div class="form-control-feedback">
                                    <i class="icon-envelop3"></i>
                                </div>
                                <span id="notepin"></span><br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <colgroup><col width="2%"></colgroup>
                                <tbody>
                                    <?=$optPermission?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-link" data-dismiss="modal">Close</span>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
<?php
    $sql    = "SELECT * FROM pouch_bankcode order by bank_code asc";
    $query  = $this->db->query($sql);
    $optbank = "";
    if($query->num_rows()>0){
        foreach($query->result() as $row){
            $optbank .= "<option value = '$row->bank_code'>$row->bank_name</option>";
        }
    }
?>
<div id="modal_bank" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Create New Users</h5>
            </div>
			<form id="createBank">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
									<label>Select Bank:</label>
									<select name="bank" id="select2Input" data-placeholder="Select Bank" class="select">\
										<option></option>
										<?=$optbank?>
									</select>
								</div>
                                <div class="form-group">
									<label>Account Name :</label>
									<input required placeholder="ex : John D" id="account_name" name="account_name" type="text"class="form-control input-xlg">
								</div>
                                <div class="form-group">
									<label>Account Number :</label>
									<input required placeholder="ex : 123009xxxxxx" id="account_number" name="account_number" type="text"class="form-control input-xlg">
								</div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-link" data-dismiss="modal">Close</span>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
<script>
$("#select2Input").select2();
</script>