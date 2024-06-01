<div class="row">

    <div class="col-sm-12" id="PrintMe">
        <div  class="panel panel-default thumbnail"> 
            
            <div class="panel-body">  
                <div class="row">
                    <div class="col-sm-4" align="center"> 
                        <img alt="Picture" src="<?php echo html_escape((!empty($user->picture)?base_url($user->picture):base_url("assets/images/no-img.png"))); ?>" class="img-responsive img-hw-200" >
                        
                    </div> 

                    <div class="col-sm-8"> 
                        <dl class="dl-horizontal">
                        <?php if(!empty($user->firstname)) { ?>
                            <dt><?php echo 'Name' ?></dt><dd><?php echo html_escape($user->firstname); ?></dd>
                        <?php } ?>
                        <?php if(!empty($user->email)) { ?>
                            <dt><?php echo 'Email' ?></dt><dd><?php echo html_escape($user->email); ?></dd>
                        <?php } ?>

                        <?php if(!empty($user->designation)) { ?>
                            <dt><?php echo display('designation') ?></dt><dd><?php echo html_escape($user->designation); ?></dd>
                        <?php } ?>

                        <?php if(!empty($user->department)) { ?>
                            <dt><?php echo display('department') ?></dt><dd><?php echo html_escape($user->department); ?></dd>
                        <?php } ?>

                        <?php if(!empty($user->mobile)) { ?>
                            <dt><?php echo 'Mobile Number' ?></dt><dd><?php echo html_escape($user->mobile); ?></dd>
                        <?php } ?> 

                        <?php if(!empty($user->relationship)) { ?>
                            <dt><?php echo 'Role' ?></dt><dd><?php echo html_escape($user->relationship); ?></dd>
                        <?php } ?> 
   
                        <?php if(!empty($user->sex)) { ?>
                            <dt><?php echo display('sex') ?></dt><dd><?php echo html_escape($user->sex); ?></dd>
                        <?php } ?> 
  
                        <?php if(!empty($user->education_degree)) { ?>
                            <dt><?php echo display('education_degree') ?></dt><dd><?php echo html_escape($user->education_degree); ?></dd>
                        <?php } ?> 
  
                        <?php if(!empty($user->create_date)) { ?>
                            <dt><?php echo 'Registration Date' ?></dt><dd><?php echo html_escape($user->create_date); ?></dd>
                        <?php } ?>  
                        
                        <?php if(!empty($user->address)) { ?>
                            <dt><?php echo 'Address' ?></dt><dd><?php echo html_escape($user->address); ?></dd>
                        <?php } ?> 
                    
   
                        <?php if(!empty($user->status)) { ?>
                            <dt><?php echo display('status') ?></dt><dd><?php echo (!empty($user->status)?
                            display('active'):display('inactive')) ?></dd>
                        <?php } ?>  
                        </dl> 
                    </div>
                </div>
                <div class="row" style="margin-top: 45px; margin-bottom: 15px;">
                    <div class="col-md-10">
                        <h3>Booking List</h3>
                    </div>
                </div>
                
                <?php foreach ($user_booking as $booking_row) { ?>
                <div class="doctor-booking-box mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-3 mb-lg-0 mb-2">
                            <h4 class="clr545454 f-16 mb-3 fw-500" style="padding-top: 8px;">Doctor Information</h4>
                            <div class="d-md-flex align-items-start d-lg-block">
                                <div class="d-flex booking-dr-profile mb-3 align-items-center">
                                    <div class="text-center report-sh-icon align-items-center d-flex justify-content-center me-3">
                                        <img src="https://www.sarvodayahospital.com/img/default-doctor-male.jpg" class="img-fluid" alt="...">
                                    </div>
                                    <div>
                                        <p class="clr5c f-14 mb-0"><?php echo $booking_row->doctor_name; ?></p>
                                    </div>
                                </div>
                                <div class="d-flex booking-SH-img align-items-center ps-md-4 ps-lg-0">
                                    <div class="text-center report-sh-icon align-items-center d-flex justify-content-center me-3">
                                        <img src="https://www.sarvodayahospital.com/img/SH-icon.svg" class="img-fluid rounded-0 shadow-none" alt="...">
                                    </div>
                                    <div>
                                        <p class="clr5c f-14 mb-0"><?php echo $booking_row->hospital_name; ?></p>
                                        <p class="clrAc f-12  mb-0"><?php echo $booking_row->hospital_address; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="pateint-info-box bg-f7f7f7">
                                <h3 class="clrBlueDark f-16 fw-500 py-2 mb-0">Patient Information</h3>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="fw-500 clr545454 f-14">Name</td>
                                            <td class="fw-500 clr545454 f-14">Appointment ID</td>
                                            <td class="fw-500 clr545454 f-14">Booking Timing</td>
                                        </tr>
                                        <tr>
                                            <td class="clr8e8e8e f-14"><?php echo $booking_row->firstname; ?></td>
                                            <td class="clr8e8e8e f-14"><?php echo $booking_row->booking_id; ?></td>
                                            <td class="clr8e8e8e f-14"><?php echo date('d M, Y', strtotime($booking_row->schedule_date)).' / '.$booking_row->schedule_time; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fw-500 clr545454 f-14">Concern</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="clr8e8e8e f-14"><?php echo $booking_row->concern; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <?php } ?>
            </div> 
        </div>
    </div>
</div>
<style>
    .doctor-booking-box {
        padding: 15px 10px;
        border: 1px solid #CBCBCB;
        border-radius: 5px;
    }

.mb-4 {
    margin-bottom: 1.5rem !important;
}
.align-items-center {
    align-items: center !important;
}
.mb-2 {
    margin-bottom: 0.5rem !important;
}
.f-16 {
    font-size: 16px;
}
.fw-500 {
    font-weight: 500;
}
.mb-3 {
    margin-bottom: 1rem !important;
}
.d-lg-block {
    display: block !important;
}
.report-sh-icon {
    width: 43px;
    height: 43px;
    min-width: 43px;
}
.text-center {
    text-align: center !important;
}
.me-3 {
    margin-right: 1rem !important;
}
.justify-content-center {
    justify-content: center !important;
}
.d-flex {
    display: flex !important;
}
.booking-dr-profile img {
    width: 45px;
    height: 45px;
    min-width: 45px;
    padding: 2px;
    box-shadow: 0 4px 4px 2px #0000000d;
    border-radius: 50%;
    object-fit: cover;
    object-position: top;
}
.img-fluid {
    max-width: 100%;
    height: auto;
}
.ps-lg-0 {
    padding-left: 0 !important;
}
.report-sh-icon {
    width: 43px;
    height: 43px;
    min-width: 43px;
}
.clr5c {
    color: #5C5C5C;
}
.f-14 {
    font-size: 14px;
}
.mb-0 {
    margin-bottom: 0 !important;
}
.f-12 {
    font-size: 12px;
}
.clrAc {
    color: #ACACAC;
}
.clrBlueDark {
    color: #00B29A !important;
}
.pateint-info-box table tr:nth-child(odd) {
    background: #DCDCDC;
}
.pateint-info-box table tr td, .pateint-info-box table tr th {
    padding: 6px 15px;
    border: none;
}
.py-2 {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}

</style>