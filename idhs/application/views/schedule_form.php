<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('schedule/create','class="form-inner"') ?>
                            
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
                                        <div class="col-xs-6">
                                            <input name="start_date" autocomplete="off" class="form-control" type="text" placeholder="Start Date" id="schedule_start_date" value="<?php echo !empty($schedule->start_date) ? date('d-m-Y',strtotime($schedule->start_date)) : ''; ?>">
                                        </div>
                                        <div class="col-xs-6">
                                            <input name="end_date" autocomplete="off" class="form-control" id="schedule_end_date" type="text" placeholder="End Date"  value="<?php echo !empty($schedule->end_date) ? date('d-m-Y',strtotime($schedule->end_date)) : ''; ?>">
                                        </div>
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
                                <label for="petient_per_day" class="col-xs-3 col-form-label">Total petient per day</label>
                                <div class="col-xs-9"> 
                                    <input name="petient_per_day" class="form-control" type="number" placeholder="Total petient per day" id="petient_per_day" value="<?php echo html_escape($schedule->petient_per_day); ?>" >

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
                                        <a class="ui button" href="/idhs/doctor">Cancel</a>
                                        <div class="or"></div>
                                        <button class="ui positive button">Save</button>
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
<script>
    $(document).ready(function(){
        $( "#doctor-schedule-datepicker" ).datepicker({
            dateFormat: "dd-mm-yy",
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
</script>