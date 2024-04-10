<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
//get site_align setting
$settings = $this->db->select("site_align")
    ->get('setting')
    ->row();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Login - IDHS Hospital Management</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo (!empty($favicon)?$favicon:null) ?>">

        <!-- Bootstrap --> 
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>
        
        <!-- 7 stroke css -->
        <link href="<?php echo base_url(); ?>assets/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>

        <!-- style css -->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <!-- Content Wrapper -->
        <div class="login-wrapper"> 
            <div class="container-center">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Hospital Management</h3>
                                <small><strong>Please Login</strong></small>
                            </div>
                        </div>
                        <div class="">
                        
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
                        </div>
                    </div>


                    <div class="panel-body">
                        <?php echo form_open($this->uri->segment(1).'/login','id="loginForm" novalidate'); ?>
                            <div class="form-group">
                                <label class="control-label" for="email">Email ID</label>
                                <input type="text" placeholder="Email ID" name="email" id="email" class="form-control"> 
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password"  placeholder="Password" name="password" id="password" class="form-control"> 
                            </div> 
                            <div class="form-group" align="center"> 
                                <button  type="submit" class="btn btn-success">Log In</button> 
                            </div>
                        </form>
                    </div>
                </div>
                <?php if($this->uri->segment(1) == 'hospital') { ?>
                <div class="form-group" align="center">
                    <strong>Do not have an account? <a href="signup">Sign Up</a></strong>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- jQuery -->
        <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js') ?>" type="text/javascript"></script>
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/login.js') ?>" type="text/javascript"></script>
    </body>
</html>