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
                            <?php echo (!empty($user->speciality)?html_escape($user->speciality):'NA') ?>
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
                            <?php
                                if($user->start_time) {
                                    echo 'Scheduled';
                                } else {
                                    echo 'No Schedule';
                                }
                                
                            ?>
                            </span>
                        </div>
                        
                    </div>
                    
                </div>
            </div> 

            <div class="panel-body">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12"> 
                        <div class="col-md-8"> 
                            <h1>Doctor Schedule</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">  
                        <div class="col-md-5">
                            <div id="doctor-schedule-datepicker"></div>
                            <div id="doctor_id" style="display: none;"><?php echo $user->user_id ;?></div>
                        </div>
                        <div class="col-md-7">
                            <div><span>Manage slots</span></div>
                            <div class='btn-group' id="available-slots">
                            <?php
                                $doctor_start_slots = $user->start_time;
                                $doctor_end_slots = $user->end_time;
                                if($doctor_start_slots) {
                                    $start_slots_array = explode(',', $doctor_start_slots);
                                    $end_slots_array = explode(',', $doctor_end_slots);

                                    for ($i=0; $i < count($start_slots_array); $i++) { 
                                        echo " 
                                            <button type='button' class='btn btn-success'>".date('h:i A', strtotime($start_slots_array[$i]))." - ".date('h:i A', strtotime($end_slots_array[$i]))."</button>  
                                        ";
                                    }
                                }
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
</style>

<script src="<?php echo base_url('assets/js/admin/appointment.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $( "#doctor-schedule-datepicker" ).datepicker({
            dateFormat: "dd-mm-yy",
        });
    });
    //doctor_id
    $("#doctor-schedule-datepicker").on('change', function(){
        var CSRF_TOKEN = $('#CSRF_TOKEN').val();
        var doctor_id = $('#doctor_id').text();
        var available_slots = $('#available-slots');

        $.ajax({
            url  : _baseURL+'schedule/doctor_schedule_by_date/',
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