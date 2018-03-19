<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout {

    public function headercontent($module = null){
        $ret = '
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>'.$module.' | My Pouch</title>
                <link rel="shortcut icon" href="'.base_url().'appsources/mypouch-favicon.png" type="image/x-icon" />
            
                <!-- Global stylesheets -->
                <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
                <link href="'.base_url().'appsources/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
                <link href="'.base_url().'appsources/css/bootstrap.css" rel="stylesheet" type="text/css">
                <link href="'.base_url().'appsources/css/core.css" rel="stylesheet" type="text/css">
                <link href="'.base_url().'appsources/css/components.css" rel="stylesheet" type="text/css">
                <link href="'.base_url().'appsources/css/colors.css" rel="stylesheet" type="text/css">
                <link href="'.base_url().'appsources/css/custom/custom.css" rel="stylesheet" type="text/css">
                '.link_tag("appsources/sweetalert/dist/sweetalert.css").'
                '.link_tag("appsources/css/custom/custom.css").'
                <!-- /global stylesheets -->
            
                <!-- Core JS files -->
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/loaders/pace.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/core/libraries/jquery.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/core/libraries/bootstrap.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/loaders/blockui.min.js"></script>
                <!-- /core JS files -->
            
                <!-- Theme JS files -->
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/visualization/d3/d3.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/visualization/d3/d3_tooltip.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/forms/styling/switchery.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/forms/styling/uniform.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/ui/moment/moment.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/pickers/daterangepicker.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/pickers/anytime.min.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/pickers/pickadate/picker.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/pickers/pickadate/picker.date.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/pickers/pickadate/picker.time.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/pickers/pickadate/legacy.js"></script>
				<script type="text/javascript" src="'.base_url().'appsources/js/pages/components_popups.js"></script>
				<script type="text/javascript" src="'.base_url().'appsources/js/plugins/notifications/pnotify.min.js"></script>
				<script type="text/javascript" src="'.base_url().'appsources/js/plugins/forms/selects/select2.min.js"></script>
				<script type="text/javascript" src="'.base_url().'appsources/js/plugins/forms/styling/uniform.min.js"></script>
				<script type="text/javascript" src="'.base_url().'appsources/js/plugins/loaders/progressbar.min.js"></script>
            
                <script type="text/javascript" src="'.base_url().'appsources/js/core/app.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/pages/dashboard.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/pages/picker_date.js"></script>
                <script type="text/javascript" src="'.base_url().'appsources/js/pages/components_modals.js"></script>
				<script type="text/javascript" src="'.base_url().'appsources/js/pages/components_notifications_pnotify.js"></script>
				<script type="text/javascript" src="'.base_url().'appsources/js/pages/form_layouts.js"></script>
            
                <script type="text/javascript" src="'.base_url().'appsources/js/plugins/ui/ripple.min.js"></script>
                <!-- /theme JS files -->
            
            </head>';

        return $ret;
    }
    
	public function headerlogin()
	{
        $ret = "
            
            <head>
                <title>Mypouch | Dashboard</title>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <!--===============================================================================================-->	
                <link rel='icon' type='image/png' href='".base_url()."appsources/mypouch-favicon.png'/>
                <!--===============================================================================================-->
                <link rel='stylesheet' type='text/css' href='".base_url()."appsources/login/vendor/bootstrap/css/bootstrap.min.css'>
                <!--===============================================================================================-->
                <link rel='stylesheet' type='text/css' href='".base_url()."appsources/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css'>
                <!--===============================================================================================-->
                <link rel='stylesheet' type='text/css' href='".base_url()."appsources/login/vendor/animate/animate.css'>
                <!--===============================================================================================-->	
                <link rel='stylesheet' type='text/css' href='".base_url()."appsources/login/vendor/css-hamburgers/hamburgers.min.css'>
                <!--===============================================================================================-->
                <link rel='stylesheet' type='text/css' href='".base_url()."appsources/login/vendor/select2/select2.min.css'>
                <!--===============================================================================================-->
                <link rel='stylesheet' type='text/css' href='".base_url()."appsources/login/css/util.css'>
                <link rel='stylesheet' type='text/css' href='".base_url()."appsources/login/css/main.css'>
                <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Muli' />
                <!--===============================================================================================-->
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-TG56HNW');</script>
                <!-- End Google Tag Manager -->
            </head>
        ";

        return $ret;
    }
    
    public function loadjslogin()
	{
        $ret = "
            <!--===============================================================================================-->	
            <script src='".base_url()."appsources/login/vendor/jquery/jquery-3.2.1.min.js'></script>
            <!--===============================================================================================-->
            <script src='".base_url()."appsources/login/vendor/bootstrap/js/popper.js'></script>
            <script src='".base_url()."appsources/login/vendor/bootstrap/js/bootstrap.min.js'></script>
            <!--===============================================================================================-->
            <script src='".base_url()."appsources/login/vendor/select2/select2.min.js'></script>
            <!--===============================================================================================-->
            <script src='".base_url()."appsources/login/vendor/tilt/tilt.jquery.min.js'></script>
            
            <script src='".base_url()."appsources/pouch/default.js'></script>
            <script src='".base_url()."appsources/pouch/module/login.js'></script>
            <script >
                $('.js-tilt').tilt({
                    scale: 1.1
                })
            </script>
            <!--===============================================================================================-->
            <script src='".base_url()."appsources/login/js/main.js'></script>
        ";

        return $ret;
    }
    
    public function content($view,$data = null){
		$CI =   &get_instance();
        $data["pages"]  = $view;
        $CI->load->view("templates/content",$data);
    }

    public function loadjscontent(){
        $ret = "
            <script src='".base_url()."appsources/jquery-3.2.1.min.js'></script>
            <script src='".base_url()."appsources/js/materialize.min.js'></script>
            <script src='".base_url()."appsources/prism/prism.js'></script>
            <script src='".base_url()."appsources/perfect-scrollbar/perfect-scrollbar.min.js'></script>
            <script src='".base_url()."appsources/js/plugins.js'></script>
            <script src='".base_url()."appsources/js/custom-script.js'></script> 
            <script src='".base_url()."appsources/js/jquery.form.js'></script> 
            <script src='".base_url()."appsources/data-tables/js/jquery.dataTables.min.js'></script>
            <script src='".base_url()."appsources/js/scripts/data-tables.js'></script>
            <script src='".base_url()."appsources/js/scripts/advanced-ui-modals.js'></script>
            <script src='".base_url()."appsources/sweetalert/dist/sweetalert.min.js'></script>
            
            <script src='".base_url()."appsources/pouch/default.js'></script>      
            <script src='".base_url()."appsources/pouch/module/batch.js'></script>  
            <script src='".base_url()."appsources/pouch/module/settings.js'></script>
            <script src='".base_url()."appsources/pouch/module/cash.js'></script>
            <script>
                $('#tableDisbursement').dataTable( {
                    'searching': false,
                    'bLengthChange': false,
                } );
            </script>
        ";

        return $ret;
    }
    
    public function sidemenu(){
		$CI =   &get_instance();
        
        $ret = '
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="no-padding">
                <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <i class="material-icons">payment</i>
                            <span class="nav-text">All Accounts</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="'.base_url().'dashboard/cash">
                                        <i class="material-icons">attach_money</i>
                                        <span>Cash</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="'.base_url().'disbursements">
                            <i class="material-icons">local_shipping</i>
                            <span>Batch Disbursements</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a class="waves-effect waves-cyan" href="'.base_url().'settings">
                            <i class="material-icons">settings</i>
                            <span class="nav-text">Setting</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        ';

        return $ret;
    }

    function childmenu($menu_id){
		$CI =   &get_instance();
        $sql    = "SELECT * FROM tect_mastermenu WHERE menu_parent_id = '$menu_id' AND menu_is_show = 'Y' order by menu_sort asc";
        $query  = $CI->db->query($sql);
        $ret = "";
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $ret .= '<li><a href="'.base_url().''.$row->menu_url.'">'.$row->menu_tittle.'</a></li>';
            }
        }

        return array($query->num_rows(),$ret);
    }

    public function logo_color(){
        $logo = '<img src="'.base_url().'appsources/mypouch.png" width="250px"/>';
        return $logo;
    }
    
    public function logo_white(){
        $logo = '<img src="'.base_url().'appsources/mypouch-white.png"/>';
        return $logo;
    }
    
    public function logo_mini(){
        $logo = '<img style="width:30px;height:30px;float:left;margin-right:10px;margin-top:-5px" src="'.base_url().'appsources/mypouch-mini.png" />';
        return $logo;
    }
}