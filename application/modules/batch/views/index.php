
<!-- Page header -->
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
  <div id="batch_disbursement" >
  <div class="breadcrumb-line">
    <div class="panel-flat">
      <div class="panel-body">
        <div class="tabbable col-lg-6">
          <ul class="nav nav-tabs nav-tabs-bottom">
            <?php 
            if($tab == "need"){
              echo '<li class="active"><a href="#needApprove" onClick="setTab(\'need\')" data-toggle="tab">Need Approval</a></li>
              <li><a href="#approved" onClick="setTab(\'approved\')" data-toggle="tab">Approved</a></li>';
            }else{
              echo '<li><a href="#needApprove" onClick="setTab(\'need\')" data-toggle="tab">Need Approval</a></li>
              <li class="active"><a href="#approved" onClick="setTab(\'approved\')" data-toggle="tab">Approved</a></li>';
            }
            ?>
          </ul>
        </div>
        <div class="tabbale col-lg-6">
          <div class="pull-right">
            <span id="btndis"><a type="button" class="btn btn-danger btn-labeled btn-sm disabled"><b><i class="icon-trash"></i></b> Delete</a>
            <a type="button" class="btn btn-primary btn-labeled btn-sm disabled"><b><i class="icon-checkmark-circle"></i></b> Approve</a></span>
            <a href="#upload" onClick="showDownloadTemplate()" class="btn btn-primary btn-labeled btn-sm"><b><i class="icon-cloud-upload"></i></b> Upload</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="col-lg-12">
          <!-- Default thead border -->
					<div class="panel panel-flat" id="content_approve">
            <?=$content?>
					</div>
					<!-- /default thead border -->
      </div>
    </div>
  </div>
  </div>
</div>
<div id="modal_small" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Delete Disbursement</h5>
      </div>
      <form id="setDelete">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Please Enter Your PIN</label>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group has-feedback has-feedback-left">
                  <input type="password" id="txtChar" onkeypress="return isNumberKey(event)" name="pin" class="form-control input-xlg" placeholder="Enter Your PIN">
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
<div id="modal_approve" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Approve Disbursement</h5>
      </div>
      <form id="setApprove">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Please Enter Your PIN</label>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group has-feedback has-feedback-left">
                  <input type="password" id="txtChar" onkeypress="return isNumberKey(event)" name="pin" class="form-control input-xlg" placeholder="Enter Your PIN">
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
<!-- /page header -->
<script>
$("input").change(function(){
	if(this.checked){
		$("#btndis").html('<a type="button" id="deleteBatch" data-toggle="modal" data-target="#modal_small" class="btn btn-danger btn-labeled btn-sm"><b><i class="icon-trash"></i></b> Delete</a> '
      +'<a type="button" id="approveBatch" data-toggle="modal" data-target="#modal_approve" class="btn btn-primary btn-labeled btn-sm"><b><i class="icon-checkmark-circle"></i></b> Approve</a>');
	}else{
    $("#btndis").html('<a type="button" class="btn btn-danger btn-labeled btn-sm disabled"><b><i class="icon-trash"></i></b> Delete</a> '
      +'<a type="button" class="btn btn-primary btn-labeled btn-sm disabled"><b><i class="icon-checkmark-circle"></i></b> Approve</a>');
  }
})
</script>