<div class="col s12">
  <div class="row">
    <div id="fixed-width-tab" class="section">
    <div class="row" id="batch_disbursement" style="margin-top:-15px">
        <div class="col s12 m12 l12">
          <div class="card">
            <div class="card-action">
              <div class="col s6 m6 l6">
                <a href="#!" class="black-text text-accent-1">Upload Batch</a>
              </div>
              <div class="col s6 m6 l6" style="margin-top:-5px;padding-bottom:10px">
                <a href="<?=base_url()?>templates/pouch_disburse_v1a.xlsx" target="_blank" class="right btn btn-primary cyan lighten-5 black-text"><i class="material-icons left">file_download</i>Download Template</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m12">
          <div class="card border-radius-3">
            <div class="card-content">
                <h5 class="center">Upload Batch</h5>
                <p class="grey-text center">Click to upload your file below</p>                
                <div class="col s12 m12 l3">
                </div>
                <div class="col s12 m12 l6">
                    <div class="card">
                        <div class="card-content left">
                          <form id="uploadBatch" method="POST" enctype="multipart/form-data">
                            <p clas="left">Reference</p>
                            <p class="grey-text left" style="font-size:9pt">Please enter a reference that is important to you, such as batch ID</p>
                            <input type="text" name="reference" id="reference" placeholder="e.g 8719231"/>
                            <input name="filenm" id="filenm" type="file" />
                            <div class="center" style="margin-top:10px" id="btnBatch">
                                <hr>
                                <!-- <span onclick="uploadBatch()" class="btn gradient-45deg-light-blue-cyan">Upload Batch</span> -->
                                <button class="btn gradient-45deg-light-blue-cyan">Upload Batch</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('contextmenu', event => event.preventDefault());

  $('#uploadBatch').submit(function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $("#btnBatch").html('<span class="btn gradient-45deg-light-blue-cyan">Please Wait .....</span>');
    $.ajax({
      type : 'POST',
      url  : toUrl+"/disbursements/uploadBatch",
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
            window.location.href=toUrl+"/disbursements";
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

