<?php
	$sql 	= "SELECT * FROM pouch_masteremployeecredential WHERE md5(userID) = ?";
	$query	= $this->db->query($sql,array($userID));
	$status = "";
	$doc = "";
	if($query->num_rows()>0){
		$row = $query->row();
		$doc = $row->doc;
		if($row->doc != "" && $row->emailVerified == 0){
			$status = "Unverified";
		}
	}

?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Mypouch | Registration Status </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel='icon' type='image/png' href='<?=base_url()?>appsources/mypouch-favicon.png'/>
    <link rel="stylesheet" href="<?=base_url()?>appsources/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/swiper.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/animate.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/lity.min.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>appsources/applanding/css/gradient_colors/theme_color_1.css" id="color-option">
    <link rel="stylesheet" href="<?=base_url()?>appsources/sweetalert/dist/sweetalert.css"  type="text/css">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-target="#bs-example-navbar-collapse-1" data-offset="5" class="scrollspy-example without_bg_images">
<!-- Header
========================================-->
<main class="entry-main">

    <!-- Mini Feature Section
    ========================================-->
    <section class="pricing" id="pricing">
        <div class="container">
            <div class="section-title style-gradient wow fadeInUp" data-wow-duration="1s" data-wow-delay="0s">
                <h2>
                    <img style="width:200px" alt="" src="<?=base_url()?>appsources/mypouch-color.png">
                </h2>
                <span><span></span></span>
            </div>
            <div class="pricing-tables">
                <div class="row">
                    <div class="col-lg-2">
					</div>
                    <div class="col-md-8 col-sm-12">
                        <div class="pricing-table wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.75s">
                            <div class="pricing-header">
                                <h4>Registration Status</h4>
                            </div>
                            <ul class="pricing-feature list-unstyled">
                                <li><span><a href="<?=base_url()?>appsources/doc/contract/<?=$doc?>">View Doc</a></span><span><?=$status?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
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
<script src='<?=base_url()?>appsources/sweetalert/dist/sweetalert.min.js'></script>

<script src="<?=base_url()?>appsources/applanding/js/plugins.js"></script>

<script src="<?=base_url()?>appsources/applanding/js/jquery.ajaxchimp.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/jquery.ajaxchimp.langs.min.js"></script>
<script src="<?=base_url()?>appsources/applanding/js/ajax.js"></script>
<script src="<?=base_url()?>appsources/pouch/default.js"></script>
<!-- end the script -->
</body>

</html>
<script>
    $('#uploadterm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('userID', $("#userID").val());
        $("#btnBatch").html('<span class="btn gradient-45deg-light-blue-cyan">Please Wait .....</span>');
        $.ajax({
            type : 'POST',
            url  : toUrl+"/auth/uploadterm",
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
		    dataType: "json",
            success: function(data){
                // alert(JSON.stringify(data));
                if(data.status == 401){
                    swal("Ooopps!", data.error, "warning");
                }
                if(data.status == 200){
                    swal({    
                        title: "Yeaaaay !",
                        text: data.error,
                        type: "success",
                        closeOnConfirm: false },
                        function(){
                        window.location.href=toUrl+"/auth/login";
                    });
                    return;
                }
            },error: function(xhr, ajaxOptions, thrownError){            
            alert(xhr.responseText);
            }
        });
    });
</script>