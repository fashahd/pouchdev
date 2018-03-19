<!DOCTYPE html>
<?php $company_logo = $this->session->userdata("sessCompanyLogo");?>
<?php $company_name = $this->session->userdata("sessCompanyName");?>
<?php $fullname = $this->session->userdata("sessFullNam");?>
<?php
    /* This sets the $time variable to the current hour in the 24 hour clock format */
    $time = date("H");
    /* Set the $timezone variable to become the current timezone */
    $timezone = date("e");
    $greeting = "";
    /* If the time is less than 1200 hours, show good morning */
    if ($time < "12") {
        $greeting = "Good Morning";
    } else
    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
    if ($time >= "12" && $time < "17") {
        $greeting = "Good Afternoon";
    } else
    /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
    if ($time >= "17" && $time < "19") {
        $greeting = "Good Evening";
    } else
    /* Finally, show good night if the time is greater than or equal to 1900 hours */
    if ($time >= "19") {
        $greeting = "Good Night";
    }
    ?>
<?=$this->layout->headercontent($module)?>
<body>
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?=base_url()?>"><?=$this->layout->logo_white()?></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
            
            <div class="navbar-right">
                <p class="navbar-text"><?=$greeting?>, <?=$fullname?></p>
            </div>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-default">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user-material">
						<div class="category-content">
							<div class="sidebar-user-material-content">
								<a href="#"><img src="<?=$company_logo?>" class="img-circle img-responsive" alt=""></a>
								<h6><?=$fullname?></h6>
								<span class="text-size-small"><?=$company_name?></span>
							</div>
														
							<div class="sidebar-user-material-menu">
								<a href="#user-nav" data-toggle="collapse"><span>My account</span> <i class="caret"></i></a>
							</div>
						</div>
						
						<div class="navigation-wrapper collapse" id="user-nav">
							<ul class="navigation">
								<li><a href="#"><i class="icon-coins"></i> <span>My balance</span></a></li>
								<li class="divider"></li>
								<li><a href="<?=base_url()?>settings"><i class="icon-cog5"></i> <span>Account settings</span></a></li>
								<li><a href="<?=base_url()?>auth/signout"><i class="icon-switch2"></i> <span>Logout</span></a></li>
							</ul>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								<li>
									<a href="#"><i class="icon-stack2"></i> <span>All Account</span></a>
									<ul>
										<li><a href="<?=base_url()?>dashboard/cash"><i class="icon-coins"></i>Cash</a></li>
									</ul>
								</li>
								<li>
									<a href="<?=base_url()?>disbursements"><i class="icon-wallet"></i> <span>Disbursements</span></a>
								</li>
								<li>
									<a href="<?=base_url()?>batch"><i class="icon-stack4"></i> <span>Batch Disbursements</span></a>
								</li>
								<li>
									<a href="<?=base_url()?>settings"><i class="icon-cog"></i> <span>Account Settings</span></a>
								</li>
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->
			<!-- Main content -->
			<div class="content-wrapper">
				<noscript>
					<div class="alert alert-warning alert-styled-left alert-bordered">
						<span class="text-semibold">Warning</span> To Enjoy Your Full Feature of This App, Please Enable Javascript From Your Browser</a>.
					</div>
				</noscript>
				<?=$this->load->view($pages)?>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	
	<script src="<?=base_url()?>appsources/sweetalert/dist/sweetalert.min.js"></script>
	<script src="<?=base_url()?>appsources/js/custom-script.js"></script> 
	<script src="<?=base_url()?>appsources/js/jquery.form.js"></script> 
            
	<script src="<?=base_url()?>appsources/pouch/default.js"></script>      
	<script src="<?=base_url()?>appsources/pouch/module/batch.js"></script>  
	<script src="<?=base_url()?>appsources/pouch/module/settings.js"></script>
	<script src="<?=base_url()?>appsources/pouch/module/cash.js"></script>
</body>
</html>