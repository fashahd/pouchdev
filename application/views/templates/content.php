<!DOCTYPE html>
<?php $company_logo = $this->session->userdata("sessCompanyLogo");?>
<?php $company_name = $this->session->userdata("sessCompanyName");?>
<html lang="en">
    <?=$this->layout->headercontent($module)?>
    <body class="layout-semi-dark">
        <!-- Start Page Loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper">
                    <div class="header-search-wrapper hide-on-med-and-down sideNav-lock">
                        <h5 style="color:#000"><?=$module?></h5>
                    </div>
                    <ul class="right hide-on-med-and-down">
                        <li>
                            <span class="avatar-status">
                                <img src="<?=$company_logo?>" alt="avatar">
                                <i></i>
                            </span>
                        </li>
                        <li>
                            <span style="padding-right:10px;padding-left:10px;" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                                <p style="color:#000;margin-top:-10px;margin-bottom:-40px"><?=$email?></p>
                                <p style="color:#878787;margin-top:-10px;margin-bottom:-14px"><?=$company_name?></p>
                            </span>
                        </li>
                    </ul>
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li>
                            <a href="<?=base_url()?>settings" class="grey-text text-darken-1">
                            <i class="material-icons">face</i> Profile</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>auth/signout" class="grey-text text-darken-1">
                            <i class="material-icons">keyboard_tab</i> Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        </header>
        <div id="main">
            <!-- START WRAPPER -->
            <div class="wrapper">
                <!-- START LEFT SIDEBAR NAV-->
                <aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible">
                    <div class="brand-sidebar">
                        <h1 class="logo-wrapper">
                        <a href="<?=base_url()?>dashboard/cash" class="brand-logo darken-1">
                            <?=$this->layout->logo_mini()?>
                            <span class="logo-text hide-on-med-and-down">MyPOUCH</span>
                        </a>
                        <a href="#" class="navbar-toggler">
                            <i class="material-icons">radio_button_checked</i>
                        </a>
                        </h1>
                    </div>
                </aside>
                <?=$this->layout->sidemenu()?>
                <section id="content">
                    <div class="container">
                        <?=$this->load->view($pages)?>
                    </div>
                </section>    
            </div>
        </div>

        <?=$this->layout->loadjscontent()?>
    </body>
</html>

<script>
    // Pikadate datepicker
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        selectYears: true,
        selectMonths: true
    });
</script>
