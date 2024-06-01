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
        <title>Signup - IDHS Hospital Management</title>

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
            <div class="signup-container-center">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="logo-class" align="center">
                                <img src="<?php echo base_url("assets/images/idhs_fullsize_logo.jpeg") ?>" alt="">
                            </div>
                            <div class="header-title" align="center"    >
                                <h3>Hospital Signup</h3>
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
                        <?php echo form_open_multipart($this->uri->segment(1).'/signup','id="signupForm" novalidate'); ?>
                            
                            <div class="form-group">
                                <label class="control-label" for="name">Hospital Name</label>
                                <input type="text" placeholder="Hospital Name" name="name" id="name" value="<?php echo html_escape($hospital->name); ?>" class="form-control"> 
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="license_no">License Number</label>
                                <input type="text" placeholder="License Number" name="license_no" <?php echo html_escape($hospital->license_no); ?> id="license_no" class="form-control"> 
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input type="text" placeholder="Email" name="email" id="email" value="<?php echo html_escape($hospital->email); ?>" class="form-control"> 
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="hospital_ownership">Hospital Ownership</label>
                                <?php
                                    $ownershipList = array( 
                                        ''   => '- Select Option -',
                                        'Gov' => 'Gov',
                                        'Semi-Gov' => 'Semi-Gov',
                                        'Private' => 'Private'
                                    );
                                    echo form_dropdown('hospital_ownership', $ownershipList, html_escape(isset($hospital->hospital_ownership) ? $hospital->hospital_ownership : ''), 'class="form-control" id="hospital_ownership" ');
                                ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="services_type">Services Type</label>
                                <?php
                                    $servicesTypeList = array( 
                                        '' => '- Select Option -',
                                        'Hospital' => 'Hospital',
                                        'Clinic' => 'Clinic',
                                        'Wellness Center' => 'Wellness Center'
                                    );
                                    echo form_dropdown('services_type', $servicesTypeList, html_escape(isset($hospital->services_type) ? $hospital->services_type : ''), 'class="form-control" id="services_type" ');
                                ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="mobile">PM-JAY</label>
                                <div class="form-check">
                                    <label class="radio-inline">
                                    <input type="radio" name="pm_jay" value="1" <?php if($hospital->pm_jay == 1) { echo 'checked'; } ?> >Yes
                                    </label>
                                    <label class="radio-inline">
                                    <input type="radio" name="pm_jay" value="0" <?php if($hospital->pm_jay == 0) { echo 'checked'; } ?> >No
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Hospital Timing </label>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input name="start_time" autocomplete="off" class="timepicker form-control" type="time" placeholder="Start Time" value="<?php echo html_escape($hospital->start_time); ?>">
                                    </div>
                                    <div class="col-xs-6">
                                        <input name="end_time" autocomplete="off" class="timepicker form-control" type="time" placeholder="End Time"  value="<?php echo html_escape($hospital->end_time); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="mobile">Mobile</label>
                                <input type="text" placeholder="Mobile" name="mobile" id="mobile" class="form-control" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" value="<?php echo html_escape($hospital->mobile); ?>"> 
                            </div>
                            <div class="form-group">
                                <label for="address" class="control-label">Building Name</label>
                                <input type="text" name="address" class="form-control" id="inputAddress" value="<?php echo html_escape($hospital->address); ?>" placeholder="1234 Main St" />
                            </div>
                            <div class="form-group">
                                <label for="address2" class="control-label">Street Name</label>
                                <input type="text" name="address2" class="form-control" id="address2" value="<?php echo html_escape($hospital->address2); ?>" placeholder="Apartment, studio, or floor" />
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-md-5">
                                    <label for="city" class="control-label">City</label>
                                    <input type="text" name="city" placeholder="City" value="<?php echo html_escape($hospital->city); ?>" class="form-control" id="city" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="state" class="control-label">State</label>
                                    <input type="text" name="state" placeholder="State" value="<?php echo html_escape($hospital->state); ?>" class="form-control" id="state" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="zip" class="control-label">Pin code</label>
                                    <input type="text" name="zip" placeholder="Zip" value="<?php echo html_escape($hospital->zip); ?>" class="form-control" id="zip" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="picture" class="control-label">Hospital Logo</label>
                                <input type="file" name="picture" id="picture" class="form-control">
                            </div>
                            <div class="form-group" align="center" style="margin-top: 40px;"> 
                                <button  type="submit" class="btn btn-success">Sign Up</button> 
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-group" align="center">
                    <strong>Already have an account? <a href="login">Log In</a></strong>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- jQuery -->
        <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js') ?>" type="text/javascript"></script>
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/login.js') ?>" type="text/javascript"></script>
        <style>
            .logo-class {
                font-size: 60px;
                color: #37a000;
                line-height: 0;
            }
            .logo-class img {
                max-width: 323px;
                height: 103px;
            }
            .view-header .header-title {
                margin-left: 0px !important;
            }
        </style>
    </body>
</html>