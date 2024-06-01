<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
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
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('schedule/create','class="form-inner" id="schedule_form"') ?>
                            
                            <?php echo form_hidden('schedule_id',html_escape($schedule->schedule_id)) ?>
                            <div class="form-group row">
                                <label for="department_id" class="col-xs-3 col-form-label">Department<i class="text-danger">*</i> </label>
                                <div class="col-xs-9">
                                    <?php
                                        $department_list1 = array_replace(array('' => '- Select Department -'), $department_list); 
                                        echo form_dropdown('department_id',$department_list1,html_escape($schedule->department_id),'class="form-control" id="department_id"') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_id" class="col-xs-3 col-form-label">Doctor <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('doctor_id',$doctor_list,html_escape($schedule->doctor_id),'class="form-control" id="doctor_id"') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xs-3 col-form-label">Select Date Range <i class="text-danger">*</i> </label>
                                <div class="col-xs-9">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <input name="start_date" autocomplete="off" class="form-control" type="text" placeholder="Start Date" id="schedule_start_date" value="<?php echo !empty($schedule->start_date) ? date('d-m-Y',strtotime($schedule->start_date)) : ''; ?>">
                                        </div>
                                        <div class="col-xs-4">
                                            <input name="end_date" autocomplete="off" class="form-control" id="schedule_end_date" type="text" placeholder="End Date"  value="<?php echo !empty($schedule->end_date) ? date('d-m-Y',strtotime($schedule->end_date)) : ''; ?>">
                                        </div>

                                        <?php if($this->uri->segment(2) == 'edit') { ?>
                                        <div class="col-xs-4" align="right">
                                            <div class="form-check">
                                                <input class="form-check-input" name="add_schedule_between" value="1" type="checkbox" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                Update date between
                                                </label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="off_duty_days" class="col-xs-3 col-form-label">Off duty days</label>
                                <div class="col-xs-9"> 
                                    <?php
                                        if(is_array($schedule->off_duty_days)) {
                                            $schedule_off_duty_days = $schedule->off_duty_days;
                                        } else {
                                            $schedule_off_duty_days = explode(',', $schedule->off_duty_days);
                                        }

                                        $AvailableDays = array(
                                            'Sunday'   => 'Sunday', 
                                            'Monday'   => 'Monday', 
                                            'Tuesday'  => 'Tuesday', 
                                            'Wednesday' => 'Wednesday', 
                                            'Thursday' => 'Thursday', 
                                            'Friday'   => 'Friday', 
                                            'Saturday' => 'Saturday' 
                                        );
                                        echo form_dropdown('off_duty_days[]',$AvailableDays,html_escape($schedule_off_duty_days),'class="form-control" id="off_duty_days" multiple="multiple"'); 
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-xs-3 col-form-label">Leave Days</label>
                                <div class="col-xs-9"> 
                                    <input autocomplete="off" name="leave_days" type="text" value="<?php echo html_escape($schedule->leave_days); ?>" class="form-control" id="leave_days" placeholder="Leave days">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xs-3 col-form-label">Select Slots <i class="text-danger">*</i> </label>
                                <div class="col-xs-7" id="more_slots_container">
                                    <?php
                                        if(is_array($schedule->start_time) && is_array($schedule->end_time)) {
                                            $schedule_start_time = $schedule->start_time;
                                            $schedule_end_time = $schedule->end_time;
                                        } else {
                                            $schedule_start_time = explode(',',$schedule->start_time);
                                            $schedule_end_time = explode(',',$schedule->end_time);
                                        }

                                        for ($i=0; count($schedule_start_time) > $i; $i++) { 
                                            
                                    ?>
                                    <div class="row" <?php echo $i > 0 ? 'style="margin-top: 10px;"' : ''; ?>>
                                        <div class="col-xs-5">
                                            <input name="start_time[]" autocomplete="off" class="timepicker form-control" type="time" placeholder="Start Time" value="<?php echo html_escape($schedule_start_time[$i]); ?>">
                                        </div>
                                        <div class="col-xs-5">
                                            <input name="end_time[]" autocomplete="off" class="timepicker form-control" type="time" placeholder="End Time"  value="<?php echo html_escape($schedule_end_time[$i]); ?>">
                                        </div>
                                        <div class="col-xs-2">
                                            <a href="javascript:void(0);" class="remove_button" style="color: red; font-size: 23px;"><i class="fa fa-minus-circle"></i></a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-xs-2">
                                    <div class="btn-group"> 
                                        <button type="button" class="btn btn-primary" id="add_more_slots">Add more slot</button>  
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="petient_per_day" class="col-xs-3 col-form-label">Total patient per day</label>
                                <div class="col-xs-9"> 
                                    <input name="petient_per_day" class="form-control" type="number" placeholder="Total patient per day" id="petient_per_day" value="<?php echo html_escape($schedule->petient_per_day); ?>" >

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xs-3">Status</label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="1" <?php echo  html_escape(set_radio('status', '1', TRUE)); ?> >Active
                                        </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="0" <?php echo  html_escape(set_radio('status', '0')); ?> >Inactive
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/schedule">Cancel</a>
                                        <div class="or"></div>
                                        <button id="schedule_submit_button" class="ui positive button">Save</button>
                                    </div>
                                </div>
                            </div>

                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/admin/appointment.js') ?>" type="text/javascript"></script>
<style>
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
<script>
    $(document).ready(function(){

        var start_date_leave_days = "<?php echo !empty($schedule->start_date) ? date('d-m-Y',strtotime($schedule->start_date)) : 0; ?>";
        var end_date_leave_days = "<?php echo !empty($schedule->end_date) ? date('d-m-Y',strtotime($schedule->end_date)) : '+3M'; ?>";

        $( "#schedule_start_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
            onSelect: function(dateText) {
                $( "#schedule_end_date" ).datepicker( "option", "minDate", dateText );
                $( "#leave_days" ).datepicker( "option", "minDate", dateText );
            }  
        });

        $( "#schedule_end_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
            onSelect: function(dateText) {
                $( "#leave_days" ).datepicker( "option", "maxDate", dateText );
            }
        });

        
        $('#leave_days').multiDatesPicker({
            dateFormat: "dd-mm-yy",
            minDate: start_date_leave_days,
            maxDate: end_date_leave_days
        });

        $('#off_duty_days').select2({
            placeholder: 'Select days'
        });

        $( "#doctor-schedule-datepicker" ).datepicker({
            dateFormat: "dd-mm-yy",
        });

        // Submit button 
        $("#schedule_submit_button").click(function (e) {
            e.preventDefault();
            var CSRF_TOKEN = $('#CSRF_TOKEN').val();
            var doctor_id = $('#doctor_id').val();
            var start_date = $('#schedule_start_date').val();
            var end_date = $('#schedule_end_date').val();
            var schedule_id_hidden = $('#schedule_form').find('input[name="schedule_id"]').val();

            var arrayStartTime = $('#schedule_form').find('input[name="start_time[]"]').map(function(){return $(this).val();}).get();
            var arrayEndTime = $('#schedule_form').find('input[name="end_time[]"]').map(function(){return $(this).val();}).get();

            var start_date_js = start_date.split("-").reverse().join("-");
            var end_date_js = end_date.split("-").reverse().join("-");
            
            if(new Date(start_date_js) > new Date(end_date_js)) {
                alert('End Date should be greater than equal to Start Date.');
                return false;
            }

            for (var i = 0; i < arrayStartTime.length; i++) {
                var strStartTime = arrayStartTime[i];
                var strEndTime = arrayEndTime[i];

                if(strStartTime != '' && strEndTime != '') {
                    var timefrom = new Date();
                    temp = strStartTime.split(":");
                    timefrom.setHours((parseInt(temp[0]) - 1 + 24) % 24);
                    timefrom.setMinutes(parseInt(temp[1]));

                    var timeto = new Date();
                    temp = strEndTime.split(":");
                    timeto.setHours((parseInt(temp[0]) - 1 + 24) % 24);
                    timeto.setMinutes(parseInt(temp[1]));

                    if (timeto < timefrom){
                        alert('End Time should be greater than Start Time.');
                        return false;
                    }
                } else {
                    alert('Please enter valid Start Time and End Time.');
                    return false;
                }
            }

            if(schedule_id_hidden) {
                $( "#schedule_form" ).trigger( "submit" );
            } else {
                $.ajax({
                    url  : _baseURL+'doctor/check_doctor_schedule/',
                    type : 'post',
                    dataType : 'JSON',
                    data : {
                        'csrf_stream_token' : CSRF_TOKEN,
                        doctor_id : doctor_id,
                        start_date : start_date,
                        end_date : end_date
                    },
                    success : function(data) 
                    {
                        //console.log(data);
                        if (data.status == true) {
                            if (confirm(data.message) == true) {
                                location.replace("/schedule/edit/"+data.result.schedule_id);
                            }
                        } else {
                            $( "#schedule_form" ).trigger( "submit" );
                        }
                    }, 
                    error : function()
                    {
                        return false;
                    }
                });
                //return false;
            }
            
        });
    });
    //doctor_id
    $("#department_id").on('change', function(){
        var CSRF_TOKEN = $('#CSRF_TOKEN').val();
        var department_id = $('#department_id').val();

        $.ajax({
            url  : _baseURL+'doctor/doctor_list_by_depart_id/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                department_id : department_id
            },
            success : function(data) 
            {
                $('#doctor_id').find('option').remove();
                $('#doctor_id').append($('<option>').val('').text('- Select -'));
                $.each(data , function(index, item) { 
                    $('#doctor_id').append($('<option>').val(item.user_id).text(item.name));
                });
            }, 
            error : function()
            {
                $('#doctor_id').find('option').remove();
            }
        });
    });

    //doctor_id
    $("#doctor_id").on('change', function(){
        var CSRF_TOKEN = $('#CSRF_TOKEN').val();
        var doctor_id = $('#doctor_id').val();

        if(doctor_id) {
            $.ajax({
                url  : _baseURL+'doctor/doctor_schedule_by_id/',
                type : 'post',
                dataType : 'JSON',
                data : {
                    'csrf_stream_token' : CSRF_TOKEN,
                    doctor_id : doctor_id
                },
                success : function(data) 
                {
                    // An array of dates
                    var scheduledDates = data.scheduled_days_dates;
                    var offDutyDates = data.off_duty_days_dates;
                    var leaveDates = data.leave_days_dates;

                    $("#schedule_start_date").datepicker("destroy");
                    $( "#schedule_start_date" ).datepicker({
                        minDate: 0,
                        //maxDate: "+3M",
                        dateFormat: "dd-mm-yy",
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
                        },
                        onSelect: function(dateText) {
                            $( "#schedule_end_date" ).datepicker( "option", "minDate", dateText );
                            $( "#leave_days" ).datepicker( "option", "minDate", dateText );
                        }
                    });
                    $( "#schedule_start_date" ).datepicker("refresh");


                    $("#schedule_end_date").datepicker("destroy");
                    $( "#schedule_end_date" ).datepicker({
                        minDate: 0,
                        //maxDate: "+3M",
                        dateFormat: "dd-mm-yy",
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
                        },
                        onSelect: function(dateText) {
                            $( "#leave_days" ).datepicker( "option", "maxDate", dateText );
                        }
                    });
                    $( "#schedule_end_date" ).datepicker("refresh");
                }, 
                error : function()
                {
                    //$('#doctor_id').find('option').remove();
                }
            });
        }
    });
</script>