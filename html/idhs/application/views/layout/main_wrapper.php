<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
//get site_align setting
$settings = $this->db->select("site_align")
    ->get('setting')
    ->row();

$user_permissions = explode(',',$this->session->userdata('user_permissions'));

//print '<pre>';print_r($user_permissions);exit;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo (!empty($title)?html_escape($title):null) ?></title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url($this->session->userdata('favicon')) ?>">

        <!-- jquery ui css -->
        <link href="<?php echo base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- Bootstrap --> 
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>

        <!-- Font Awesome 4.7.0 -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- semantic css -->
        <link href="<?php echo base_url(); ?>assets/css/semantic.min.css" rel="stylesheet" type="text/css"/> 
        <!-- sliderAccess css -->
        <link href="<?php echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css"/> 
        <!-- slider  -->
        <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/> 
        <!-- DataTables CSS -->
        <link href="<?php echo base_url('assets/datatables/css/dataTables.min.css') ?>" rel="stylesheet" type="text/css"/> 
  

        <!-- pe-icon-7-stroke -->
        <link href="<?php echo base_url('assets/css/pe-icon-7-stroke.css') ?>" rel="stylesheet" type="text/css"/> 
        <!-- themify icon css -->
        <link href="<?php echo base_url('assets/css/themify-icons.css') ?>" rel="stylesheet" type="text/css"/> 
        <!-- Pace css -->
        <link href="<?php echo base_url('assets/css/flash.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- google fonts -->
        <link href="<?php echo base_url('assets/css/fonts/opensans.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/fonts/alegreyasans.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>
        <!-- custom style -->
        <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js') ?>" type="text/javascript"></script>

        <link href="<?php echo base_url('assets/css/jquery-ui.multidatespicker.css') ?>" rel="stylesheet" type="text/css"/>

    </head>

    <body class="hold-transition sidebar-mini">
        <div id="__site-base-url" data-base-url="<?php echo base_url();?>"></div>
        <script src="<?php echo base_url('assets/js/admin/languageInit.js') ?>" type="text/javascript"></script>
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header"> 

                <?php
                    if($this->session->userdata('user_role') == 1) {
                        $redirection = base_url('hospital');
                    } elseif ($this->session->userdata('user_role') == 2) {
                        $redirection = base_url('dashboard/home');
                    } elseif ($this->session->userdata('user_role') == 3) {
                        $redirection = base_url('dashboard/profile');
                    } elseif ($this->session->userdata('user_role') == 4) {
                        $redirection = base_url('dashboard/profile');
                    } else {
                        $redirection = base_url('dashboard/profile');
                    }
                    $logo = html_escape($this->session->userdata('logo'));
                ?>
                <a href="<?php echo $redirection; ?>" class="logo"> <!-- Logo -->
                    <span class="logo-mini" style="font-size: 14px; font-weight: 600;">
                        <img src="<?php echo base_url("assets/images/idhs_small_logo.png") ?>" alt="">
                    </span>
                    <span class="logo-lg" style="font-size: 18px; font-weight: 600;">
                        <img width="217px;" height="50px" src="<?php echo base_url("assets/images/idhs_fullsize_logo.jpeg") ?>" alt="">
                    </span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- settings -->
                            <li class="dropdown dropdown-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                                <ul class="dropdown-menu">
                                    <?php if($this->session->userdata('user_role') == 2) { ?>
                                    <li><a href="<?php echo base_url('hospital/profile') ?>"><i class="fa fa-user"></i> My Profile</a></li>
                                    <?php } ?>
                                    <?php if($this->session->userdata('user_role') == 4) { ?>
                                    <li><a href="<?php echo base_url('dashboard/profile') ?>"><i class="fa fa-user"></i> My Profile</a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo base_url('dashboard/change-password') ?>"><i class="fa fa-lock"></i> Change Password</a></li>
                                    <li><a href="<?php echo base_url('logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel --> 
                    <div class="user-panel text-center">
                        <?php $picture = html_escape($this->session->userdata('picture')); ?>
                        <div class="image">
                            <img src="<?php echo (!empty($picture)?base_url($picture):base_url("assets/images/no-img.png")) ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <p><?php echo $this->session->userdata('fullname') ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i>
                            <?php   
                                $userRoles = array( 
                                    '1' => 'Admin',
                                    '2' => 'Hospital',
                                    '3' => 'Doctor',
                                    '4' => 'Staff',
                                    '5' => 'Patient',
                                ); 

                                if($this->session->userdata('user_role') == 4) {
                                    echo $this->session->userdata('relationship');
                                } else {
                                    echo html_escape($userRoles[$this->session->userdata('user_role')]);
                                }
                            ?></a>
                        </div>
                    </div> 

                    <!-- sidebar menu -->
                    <ul class="sidebar-menu"> 
                        <?php if($this->session->userdata('user_role') == 1) { ?>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "hospital") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i> <span>Hospital Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("hospital") ?>">Hospital List</a></li>
                                <li><a href="<?php echo base_url("hospital/create") ?>">Add Hospital</a></li>
                            </ul>
                        </li>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "organ") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i> <span>Organ Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("organ") ?>">Organ List</a></li>
                                <li><a href="<?php echo base_url("organ/create") ?>">Add Organ</a></li>
                            </ul>
                        </li>
                        <?php /*?>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "speciality") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i> <span>Speciality Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("speciality") ?>">Speciality List</a></li>
                                <li><a href="<?php echo base_url("speciality/create") ?>">Add Speciality</a></li>
                            </ul>
                        </li>
                        <?php */?>
                        
                        <?php } ?>

                        <?php if($this->session->userdata('user_role') == 2) { ?>
                        <li class="treeview <?php echo (($this->uri->segment(2) == "home") ? "active" : null) ?>">
                            <a href="<?php echo base_url("/dashboard/home") ?>">
                                <i class="fa fa-home"></i> <span>Home</span>
                            </a>
                        </li>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "staff") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-university"></i> <span>Staff Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("staff") ?>">Staff List</a></li>
                                <li><a href="<?php echo base_url("staff/create") ?>">Add New Staff</a></li> 
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if($this->session->userdata('user_role') == 1 || $this->session->userdata('user_role') == 2 || in_array('1', $user_permissions) || in_array('2', $user_permissions)) { ?>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "doctor" || $this->uri->segment(1) == "schedule") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-user-md"></i> <span>Doctors Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("doctor") ?>">Doctor List</a></li>
                                <?php if($this->session->userdata('user_role') != 1) { ?>

                                    <?php if($this->session->userdata('user_role') == 2 || in_array('5', $user_permissions) || in_array('6', $user_permissions)) { ?>
                                        <li><a href="<?php echo base_url("schedule") ?>">Schedule List</a></li>
                                    <?php } ?>

                                    <?php if($this->session->userdata('user_role') == 2 || in_array('6', $user_permissions)) { ?>
                                        <li><a href="<?php echo base_url("schedule/create") ?>">Add Schedule</a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if($this->session->userdata('user_role') == 1 || $this->session->userdata('user_role') == 2 || in_array('3', $user_permissions) || in_array('4', $user_permissions)) { ?>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "booking") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i> <span>Bookings</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("booking") ?>">Booking List</a></li>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if($this->session->userdata('user_role') == 1 || $this->session->userdata('user_role') == 2) { ?>
                            <li class="treeview <?php echo (($this->uri->segment(1) == "disease") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i> <span>Disease Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("disease") ?>">Disease List</a></li>
                                <?php if($this->session->userdata('user_role') == 1 ) { ?>
                                <li><a href="<?php echo base_url("disease/create") ?>">Add Disease</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if($this->session->userdata('user_role') == 2 || in_array('7', $user_permissions) || in_array('8', $user_permissions)) { ?>
                        
                        <li class="treeview <?php echo (($this->uri->segment(1) == "department") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-university"></i> <span>Department Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("department") ?>">Department List</a></li>
                                <?php if($this->session->userdata('user_role') == 2 || in_array('8', $user_permissions)) { ?>
                                <li><a href="<?php echo base_url("department/create") ?>">Add Department</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if($this->session->userdata('user_role') == 1) { ?>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "patient") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-university"></i> <span>Patient Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("patient") ?>">Patient List</a></li>
                            </ul>
                        </li>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "content") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i> <span>Content Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("content/about_us") ?>">About Us</a></li>
                                <li><a href="<?php echo base_url("content/privacy_policy") ?>">Privacy Policy</a></li>
                                <li><a href="<?php echo base_url("content/faq") ?>">FAQ</a></li>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php /* ?>
                        <li class="treeview <?php echo (($this->uri->segment(1) == "package") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-university"></i> <span>Package Management</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("package") ?>">Package List</a></li>
                                <li><a href="<?php echo base_url("package/subscribed") ?>">Subscribed</a></li> 
                            </ul>
                        </li>
                        <?php */?>
                    </ul>
                </div> <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">

                    <div class="p-l-30 p-r-30">
                        
                        <div class="header-title">
                            <h1><?php echo (!empty($title)?html_escape($title):null) ?></h1>
                        </div>
                    </div>
                </section>
                <!-- Main content -->
                <div class="content"> 
                    <div id="demoModeEnable"></div>
                    <input type ="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash();?>">
                    <!-- alert message --> 
                    <?php if ($this->session->flashdata('message') != null) {  ?>
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div> 
                    <?php } ?>
                    
                    <?php if ($this->session->flashdata('exception') != null) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('exception'); ?>
                    </div>
                    <?php } ?>
                    
                    <?php if (validation_errors()) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php } ?>
                    

                    <!-- content -->
                    <?php echo (!empty($content)?$content:null) ?>

                </div> <!-- /.content -->
            </div> <!-- /.content-wrapper -->

            <footer class="main-footer">
                <span>Powered by <a href="http://britenext.com/" target="_blank">BriteNext</a></span>
            </footer>
        </div> <!-- ./wrapper -->
 
        <!-- jquery-ui js -->
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script> 
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>  
        <!-- pace js -->
        <script src="<?php echo base_url('assets/js/pace.min.js') ?>" type="text/javascript"></script>  
        <!-- SlimScroll -->
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>  

        <!-- bootstrap timepicker -->
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-sliderAccess.js" type="text/javascript"></script> 
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script> 
        <!-- select2 js -->
        <script src="<?php echo base_url() ?>assets/js/select2.min.js" type="text/javascript"></script>

        <!-- ChartJs JavaScript -->
        <script src="<?php echo base_url('assets/js/Chart.min.js') ?>" type="text/javascript"></script>
        
        <!-- semantic js -->
        <script src="<?php echo base_url() ?>assets/js/semantic.min.js" type="text/javascript"></script>
        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url("assets/datatables/js/dataTables.min.js") ?>"></script>
        <!-- tinymce texteditor -->
        <script src="<?php echo base_url() ?>assets/tinymce/tinymce.min.js" type="text/javascript"></script> 
        <!-- Table Head Fixer -->
        <script src="<?php echo base_url() ?>assets/js/tableHeadFixer.js" type="text/javascript"></script> 

        <!-- Admin Script -->
        <script src="<?php echo base_url('assets/js/frame.js') ?>" type="text/javascript"></script> 

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() ?>assets/js/custom.js?v=1" type="text/javascript"></script>

        <script src="<?php echo base_url() ?>assets/js/jquery-ui.multidatespicker.js" type="text/javascript"></script>
    </body>
</html>