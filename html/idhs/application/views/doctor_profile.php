<div class="row">

    <div class="col-sm-12" id="PrintMe">

        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-md-3" align="left" style="padding-right: 0px;">
                        <div style="float: left;"><img alt="Picture" src="<?php echo (!empty($user->picture)?base_url($user->picture):base_url("assets/images/no-img.png")) ?>" class="img-thumbnail img-responsive img-doctor-thumbnail"></div>
                        <div style="float: left; margin-top: 20px;"><span style="padding-left: 12px; font-size: 17px; font-weight: 700;"><?php echo (!empty($user->firstname)?html_escape($user->firstname):'NA') ?></span></div>
                    </div>
                    <div class="col-md-1 column-width">
                        <div><span class="column-text">Speciality</span></div>
                        <div style="padding-top: 10px;">
                            <span class="column-text-data">
                            <?php echo (!empty($user->specialist)?html_escape($user->specialist):'NA') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1 column-width">
                        <div><span class="column-text">Registration</span></div>
                        <div style="padding-top: 10px;">
                            <span class="column-text-data">
                            <?php echo (!empty($user->registration_number)?html_escape($user->registration_number):'NA') ?>
                            </span>
                        </div>
                        
                    </div>
                    <div class="col-md-1 column-width">
                        <div><span class="column-text">Fees</span></div>
                        <div style="padding-top: 10px;">
                            <span class="column-text-data">
                            <?php echo (!empty($user->consultancy_fees)?html_escape($user->consultancy_fees):'NA') ?>
                            </span>
                        </div>
                        
                    </div>
                    <div class="col-md-1 column-width">
                        <div><span class="column-text">Rating & review</span></div>
                        <div style="padding-top: 10px;">
                            <span class="column-text-data">
                            <?php echo (!empty($user->rating_review)?html_escape($user->rating_review):'NA') ?>
                            </span>
                        </div>
                        
                    </div>
                    <div class="col-md-1 column-width">
                        <div><span class="column-text">Department</span></div>
                        <div style="padding-top: 10px;">
                            <span class="column-text-data">
                            <?php echo (!empty($user->department_name)?html_escape($user->department_name):'NA') ?>
                            </span>
                        </div>
                        
                    </div>
                    <div class="col-md-1 column-width">
                        <div><span class="column-text">Experience</span></div>
                        <div style="padding-top: 10px;">
                            <span class="column-text-data">
                            <?php echo (!empty($user->experience)?html_escape($user->experience) .' Years':'NA') ?>
                            </span>
                        </div>
                        
                    </div>
                    <div class="col-md-1 column-width">
                        <div><span class="column-text">Calendar</span></div>
                        <div style="padding-top: 10px;">
                            <span class="column-text-data">
                            Scheduled
                            </span>
                        </div>
                        
                    </div>
                    
                </div>
            </div> 

            <div class="panel-body">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12"> 
                        <div class="col-md-4"> 
                            <h1>Doctor Schedule</h1>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-6" align="right">
                            <div class="color-indicator">
                                <div>
                                    <div class="square" style="background-color:green"></div>
                                    <div><span>Scheduled</span></div>
                                </div>
                                <div>
                                    <div class="square" style="background-color:yellow;"></div>
                                    <div><span>Off Duty</span></div>
                                </div>
                                <div>
                                    <div class="square" style="background-color:red"></div>
                                    <div><span>Leave</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">  
                        <div class="col-md-5">
                            <div id="doctor-schedule-datepicker"></div>
                            <div id="doctor_id" style="display: none;"><?php echo $this->my_encrypt->encode($user->user_id); ?></div>
                        </div>
                        <div class="col-md-7" style="padding-left: 42px;">
                            <div><span style="font-size: 20px;">Available slots</span></div>
                            <div class='btn-group' id="available-slots">
                                <?php
                                    echo $user_schedule['message'];
                                ?>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .img-doctor-thumbnail {
        border-radius: 20%;
        height: 80px;
        width: 80px;
    }
    .column-width {
        width: 10.70%;
        text-align: center;
    }
    .column-text {
        font-size: 15px;
        font-weight: 600;
    }
    .column-text-data {
        font-size: 15px;
    }
    .ui-datepicker.ui-widget.ui-widget-content {
        width: 22em;
    }
    .btn-success {
        background-color: #00B29A;
        border-color: #fff;
        border-radius: 7px !important;
        margin: 10px;
    }
    #available-slots {
        margin-top: 10px;
    }
    .scheduledDates a {
        background-color: green !important;
        color: #ffffff !important;
    }
    .offDutyDates a {
        background-color: yellow !important;
        color: black !important;
    }
    .leaveDates a {
        background-color: red !important;
        color: #ffffff !important;
    }
    
</style>

<script src="<?php echo base_url('assets/js/admin/appointment.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // An array of dates
        var scheduledDates = <?php echo json_encode($user_schedule['scheduled_days_dates']); ?>;
        var offDutyDates = <?php echo json_encode($user_schedule['off_duty_days_dates']); ?>;
        var leaveDates = <?php echo json_encode($user_schedule['leave_days_dates']); ?>;
        //console.log(scheduledDates1);

        $( "#doctor-schedule-datepicker" ).datepicker({
            minDate: 0,
            //maxDate: "+3M",
            dateFormat: "yy-mm-dd",
            beforeShowDay: function( date ) {
                var calDate = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0"+date.getDate()).slice(-2);
                
                if(scheduledDates.indexOf(calDate) >= 0){
                     return [true, "scheduledDates"];
                } else if( offDutyDates.indexOf(calDate) >= 0 ) {
                     return [true, "offDutyDates"];
                } else if( leaveDates.indexOf(calDate) >= 0 ) {
                     return [true, "leaveDates"];
                } else {
                     return [true, '', ''];
                }
            }
        });
    });
    //doctor_id
    $("#doctor-schedule-datepicker").on('change', function(){
        var CSRF_TOKEN = $('#CSRF_TOKEN').val();
        var doctor_id = $('#doctor_id').text();
        var available_slots = $('#available-slots');

        $.ajax({
            url  : _baseURL+'doctor/doctor_schedule_by_date/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                date : $(this).val(),
                doctor_id : doctor_id
            },
            success : function(data) 
            {
                if (data.status == true) {
                    available_slots.html(data.message);
                } else if (data.status == false) {
                    available_slots.html(data.message);
                } else {
                    available_slots.html(data.message);
                }
            }, 
            error : function()
            {
                available_slots.html('<p>No schedule svailable</p>');
            }
        });
    });
</script>