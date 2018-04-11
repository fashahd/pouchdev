
<div class="page-header page-header-default">
  <div class="page-header-content">
    <div class="page-title">
      <h4>Batch Disbursements</h4>
    </div>
  </div>
  <div class="breadcrumb-line">
    <div class="panel-flat">
      <div class="panel-body">
        <div class="pull-right">
          <a href="<?=base_url()?>templates/pouch_disburse_v1a.xlsx" target="_blank" class="btn btn-default btn-labeled btn-sm"><b><i class="icon-cloud-download"></i></b> Download Template</a>
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
        <div class="panel panel-flat" style="margin: auto; width:100%">
          <div class="panel-body"style="margin: auto; width:50%">
            <form class="form-horizontal" id="uploadBatch" method="POST" enctype="multipart/form-data">
              <fieldset class="content-group">
                <legend class="text-bold">Upload Batch</legend>
                <div class="form-group">
                  <label class="control-label">Reference</label>
                  <p style="color:#919191;font-size:8pt">Please enter a reference that is important to you, such as batch ID</p>
                  <input type="text" class="form-control" name="reference" id="reference" placeholder="e.g 8719231">
                </div>
                <div class="form-group">
                  <label class="control-label">Styled file input</label>
                  <input type="file" name="filenm" id="filenm" >
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Upload Batch</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>     
<script type="text/javascript" src="'.base_url().'appsources/js/plugins/uploaders/dropzone.min.js"></script>
<script type="text/javascript" src="'.base_url().'appsources/js/pages/uploader_dropzone.js"></script>

<script>
  document.addEventListener('contextmenu', event => event.preventDefault());

  $('#uploadBatch').submit(function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $("#btnBatch").html('<span class="btn gradient-45deg-light-blue-cyan">Please Wait .....</span>');
    $.ajax({
      type : 'POST',
      url  : toUrl+"/batch/uploadBatch",
      data: formData,
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        if(data == 200){
          swal({    
            title: "Good Job !",
            text: "Uploaded Success",
            type: "success",
            closeOnConfirm: false },
            function(){
            window.location.href=toUrl+"/batch";
          });
        }else if(data == 201){
          swal("Ooopps!", "Please Choose File", "warning");
          $("#btnBatch").html('<button class="btn gradient-45deg-light-blue-cyan">Upload Batch</button>');
        }else{
          swal("Ooopps!", "Please Try Again Later", "error");
          $("#btnBatch").html('<button class="btn gradient-45deg-light-blue-cyan">Upload Batch</button>');
        }
      },error: function(xhr, ajaxOptions, thrownError){            
        alert(xhr.responseText);
      }
    });
  });

</script>
                