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
        $tabing .= '<li class="tab"><a '.$active.' href="#" id="'.$idtab.'">'.$title.'</a></li>';
    }
?>
<div class="col s12">
  <div id="fixed-width-tab" class="section">
    <div class="row">
      <div class="col s12 m12 l12">
        <div class="row">
          <div class="col s12 m12 l12">
            <ul class="tabs tab-profile z-depth-1 accent-2">
              <?=$tabing?>
              <li class="indicator" style="right: 434px; left: 128px;"></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="settings">
        <?=$tabSetting?>
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
<div id="modal4" class="modal col s12 l4" style="margin-bottom:20px;height:400px">
    <div class="modal-content" style="margin-top:-20px" >
        <br>
        <form class="col s12" id="createUser">
            <div class="row">
                <div class="input-field col s12 l6">
                    <input required placeholder="Email" id="email" name="email" type="email" class="validate">
                    <label for="first_name">Email</label>
                </div>
                <div class="input-field col s12 l6">
                    <input required placeholder="Full Name" id="name" name="name" type="text" class="validate">
                    <label for="first_name">Full Name</label>
                </div>
                <div class="input-field col s12 l6">
                    <input required placeholder="New Password" id="new_pass" name="new_pass" type="password" class="validate">
                    <label for="first_name">New Password</label>
                </div>
                <div class="input-field col s12 l6">
                    <input required placeholder="Re-Type Password" id="re_pass" name="re_pass" type="password" class="validate">
                    <label for="first_name">Re-Type Password</label>
                </div>
                <?=$optPermission?>
                <div class="col s12">
                    <button class="btn cyan">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="modal1" class="modal col s12 l4" style="margin-bottom:20px;height:400px">
    <div class="modal-content" style="margin-top:-20px" >
        <h5 class="center">Change New Password</h5><hr>
        <form class="col s12" id="changePassword">
            <div class="row">
                <div class="input-field col s12">
                    <input required placeholder="Current Password" id="cur_pass" name="cur_pass" type="password" class="validate">
                    <label for="first_name">Current Password</label>
                </div>
                <div class="input-field col s12">
                    <input required placeholder="New Password" id="new_pass" name="new_pass" type="password" class="validate">
                    <label for="first_name">New Password</label>
                </div>
                <div class="input-field col s12">
                    <input required placeholder="Retype New Password" id="re_new_pass" name="re_new_pass" type="password" class="validate">
                    <label for="first_name">Retype New Password</label>
                </div>
                <div class="col s12">
                    <button class="btn cyan">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="modal2" class="modal col s12 l4" style="margin-bottom:20px;height:400px">
    <div class="modal-content" style="margin-top:-20px" >
        <h5 class="center">Change Your PIN</h5><hr>
        <form class="col s12" id="changePIN">
            <div class="row">
                <div class="input-field col s12">                            
                    <input required maxlength="6" id="txtChar" onkeypress="return isNumberKey(event)" placeholder="Type Your New Pin" name="pin" type="password" class="validate">
                    <label for="first_name">Type Your New Pin</label>
                    <span id="notepin"></span><br>
                </div>
                <div class="col s12">
                    <button class="btn cyan">Update</button>
                </div>
            </div>
        </form>
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
<div id="modal5" class="modal col s12 l4" style="margin-bottom:20px;height:400px">
    <div class="modal-content" style="margin-top:-20px" >
        <br>
        <form class="col s12" id="createBank">
            <div class="container">
                <div class="row">
                    <div class="col s12 l12">
                        <label for="first_name">Bank</label>
                        <select class="browser-default" name="bank"><?=$optbank?></select>
                    </div>
                    <div class="input-field col s12 l12">
                        <input required placeholder="Account Name" id="account_name" name="account_name" type="text" class="validate">
                        <label for="first_name">Account Name</label>
                    </div>
                    <div class="input-field col s12 l12">
                        <input required placeholder="Account Number" id="account_number" name="account_number" type="text" class="validate">
                        <label for="first_name">Account Number</label>
                    </div>
                </div>
                <div class="row">
                    <button class="btn cyan">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
