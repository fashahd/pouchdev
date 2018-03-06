<div class="col s12">
  <div class="row">
    <div id="fixed-width-tab" class="section">
      <div class="row" id="batch_disbursement" style="margin-top:-15px">
        <div class="col s12 m12 l12">
          <div class="card">
            <div class="card-action">
              <div class="col s12 m6 l4" id="tab">
                <?php 
                  if($tab == "need"){
                    echo '
                      <u><a href="#needApprove" onClick="setTab(\'need\')" class="blue-text darken-4">Needs Approval</a></u>
                      <a href="#approved" onClick="setTab(\'approved\')" class="grey-text text-accent-1">Approved</a>
                    ';
                    $btnshow  = "
                      <button class='btn red' id='deleteBatch'><i class='material-icons left'>cloud_upload</i>Delete</button>
                      <button class='btn cyan' id='approveBatch'><i class='material-icons left'>cloud_upload</i>Approve</button>
                    ";
                  }else{
                    $btnshow = "";
                    echo '
                      <a href="#needApprove" onClick="setTab(\'need\')" class="grey-text text-accent-1">Needs Approval</a>
                      <u><a href="#approved" onClick="setTab(\'approved\')" class="blue-text  darken-4">Approved</a></u>
                    ';
                  }
                ?>
              </div>
              <div class="col s12 m6 l8" style="margin-top:-5px;padding-bottom:10px">
                  <a href="#upload" class="right btn btn-primary gradient-45deg-light-blue-cyan" onClick="showDownloadTemplate()"><i class="material-icons left">cloud_upload</i>Upload</a>
                  <span id="btnneed" class="right" style="margin-right:10px"><?=$btnshow?></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m12" id="content_approve">
          <?=$content?>
        </div>
        <div id="modal4" class="modal col s12 l4" style="margin-bottom:20px;height:400px">
            <div class="modal-content" style="margin-top:-20px" >
                <h5 class="center">Enter Your PIN</h5><hr>
                <form class="col s12" id="setApprove">
                    <div class="row">
                        <div class="input-field col s12">                            
                            <input required maxlength="6" id="txtChar" onkeypress="return isNumberKey(event)" placeholder="Please Enter Your PIN" name="pin" type="password" class="validate">
                            <label for="first_name">Please Enter Your PIN</label>
                            <span id="notepin"></span><br>
                        </div>
                        <div class="col s12">
                            <button class="btn cyan">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="modal3" class="modal col s12 l4" style="margin-bottom:20px;height:400px">
            <div class="modal-content" style="margin-top:-20px" >
                <h5 class="center">Enter Your PIN</h5><hr>
                <form class="col s12" id="setDelete">
                    <div class="row">
                        <div class="input-field col s12">                            
                            <input required maxlength="6" id="txtChar" onkeypress="return isNumberKey(event)" placeholder="Please Enter Your PIN" name="pin" type="password" class="validate">
                            <label for="first_name">Please Enter Your PIN</label>
                            <span id="notepin"></span><br>
                        </div>
                        <div class="col s12">
                            <button class="btn cyan">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

