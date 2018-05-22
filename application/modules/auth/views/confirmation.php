<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Mypouch | Registration Success </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel='icon' type='image/png' href='<?=base_url()?>appsources/mypouch-favicon.png'/>
    <link rel="stylesheet" href="<?=base_url()?>appsources/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/swiper.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/animate.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/lity.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/gradient_colors/theme_color_1.css" id="color-option">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-target="#bs-example-navbar-collapse-1" data-offset="5" class="scrollspy-example without_bg_images">
<!-- Header
========================================-->
<header class="active-navbar appsLand-header" id="home">
    <div class="app-overlay">
        <div class="header-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <form id="uploadterm" class="en-form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center">
                                    <img style="width:200px" alt="" src="<?=base_url()?>appsources/mypouch-white.png">
                                    <h4 class="text-center">Upload Your Document Here</h4>
                                    <div class="custom-input-group wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                                        <input required id="mc-email" type="file" class="form-control" placeholder="Email">
                                        <button class="appsLand-btn appsLand-btn-gradient subscribe-btn"><span>Upload</span></button>
                                        <div class="clearfix"></div>
                                    </div>
                                    <label for="mc-email"></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Loading
========================================-->
<div class="loading">
    <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>

<!-- Footer
========================================-->
<footer class="apps-footer">
    <div class="footer-top">
        <div class="container">
            <div class="apps-short-info">
                <a href="#">
                    
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>All Rights Reserved © <?=date("Y")?> <a href="https://mypouch.co.id/">Mypouch</a></p>
        </div>
    </div>
</footer>

<!-- start the script -->
<script src="<?=base_url()?>appsources/applanding/js/jquery-2.2.4.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/swiper.jquery.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/wow.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/jquery.countTo.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/lity.min.js"></script>

<script src="<?=base_url()?>appsources/applanding/js/plugins.js"></script>

<script src="<?=base_url()?>appsources/applanding/js/jquery.ajaxchimp.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/jquery.ajaxchimp.langs.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/ajax.js"></script>
<!-- end the script -->
</body>

</html>
<script>
    $('#uploadterm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $("#btnBatch").html('<span class="btn gradient-45deg-light-blue-cyan">Please Wait .....</span>');
        $.ajax({
            type : 'POST',
            url  : toUrl+"/auth/uploadterm",
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