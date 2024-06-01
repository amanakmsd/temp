<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print" align="right">
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("schedule/create") ?>" style="border-radius: 7px; margin-right: 20px;">Add Schedule</a> 
                </div>
            </div> 
            <div class="panel-body">
                <table width="100%" class="datatable table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Doctor Name</th>
                            <th>Department</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Slots</th>
                            <th>Patient Per Day</th>
                            <?php /* ?>
                            <th>Off Duty Days</th>
                            <th>Leave Days</th>
                            <?php */?>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schedules)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($schedules as $schedule) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    
                                    <td><?php echo html_escape($schedule->firstname); ?> <?php echo html_escape($schedule->lastname); ?></td>
                                    <td><?php echo html_escape($schedule->name); ?></td>
                                    <td><?php echo (!empty($schedule->start_date) ? date('d M Y', strtotime($schedule->start_date)) : 'NA'); ?></td>
                                    <td><?php echo (!empty($schedule->end_date) ? date('d M Y', strtotime($schedule->end_date)) : 'NA'); ?></td>
                                    <td>
                                        <?php
                                        $start_slots = explode(',', $schedule->start_time);
                                        $end_slots = explode(',', $schedule->end_time);

                                        for ($i=0; $i < count($start_slots) ; $i++) {
                                            echo date('h:i A', strtotime($start_slots[$i])).' - '.date('h:i A', strtotime($end_slots[$i]));

                                            if($i+1 < count($start_slots)) {
                                                echo ', ';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo html_escape($schedule->petient_per_day); ?></td>
                                    <?php /* ?>
                                    <td><?php echo html_escape($schedule->off_duty_days); ?></td>
                                    <td><?php echo html_escape($schedule->leave_days); ?></td>
                                    <?php */?>
                                    
                                    <td><?php echo (($schedule->status==1)?'Active':'Inactive'); ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("doctor/profile/".$this->my_encrypt->encode($schedule->doctor_id)) ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo base_url("schedule/edit/".$this->my_encrypt->encode($schedule->schedule_id)) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                                        <a href="<?php echo base_url("schedule/delete/".$this->my_encrypt->encode($schedule->schedule_id)) ?>" onclick="return confirm('Are you sure,  You want to delete ?')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a> 
                                    </td>
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>