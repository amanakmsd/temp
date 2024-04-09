<?php
    $user_permissions = explode(',',$this->session->userdata('user_permissions'));
?>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="nav nav-tabs">
                            <li class="<?php if($query_depart_id == 'all' || $query_depart_id == '') { echo 'active'; } ?>"><a href="?department=all">All Doctors</a></li>
                            <?php if(!empty($department_list)) { foreach($department_list as $departKey => $departValue) { ?>
                            <li class="<?php if($query_depart_id == $departKey) { echo 'active'; } ?>"><a href="?department=<?php echo $departKey; ?>"><?php echo $departValue; ?></a></li>
                            <?php } } ?>
                        </ul>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <div class="btn-group"> 
                            <?php if($this->session->userdata('user_role') == 2 || in_array('2', $user_permissions)) { ?>
                            <a class="btn btn-success" href="<?php echo base_url("doctor/create") ?>" style="border-radius: 7px; margin-right: 20px;">Add Doctor</a>
                            <?php } ?>
                            <?php if($this->session->userdata('user_role') == 2 || in_array('6', $user_permissions)) { ?>
                            <a class="btn btn-success" href="<?php echo base_url("schedule/create") ?>" style="border-radius: 7px;">Add Schedule</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Specialist</th>
                            <th>Registration Number</th>
                            <th>Consultancy Fees</th>
                            <th>Rating & Review</th>
                            <th>Department</th> 
                            <th>Experience</th>
                            <th>Calendar</th> 
                            <th>Action</th> 
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($doctors)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($doctors as $doctor) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td>
                                        <img src="<?php echo (!empty($doctor->picture)?base_url($doctor->picture):base_url("assets/images/no-img.png")) ?>" alt="" width="65" height="50"/>
                                        <?php echo html_escape($doctor->firstname); ?>
                                    </td>
                                    <td><?php echo html_escape($doctor->specialist); ?></td>
                                    <td><?php echo html_escape($doctor->registration_number); ?></td>
                                    <td><?php echo html_escape($doctor->consultancy_fees); ?></td>
                                    <td><?php echo (!empty($doctor->rating_review)?html_escape($doctor->rating_review):'NA') ?></td>
                                    <td><?php echo html_escape($doctor->department_name); ?></td>
                                    <td><?php echo html_escape($doctor->experience).' Years'; ?></td>
                                    <td>
                                        <?php
                                            if($doctor->schedule_ids) {
                                                echo 'Scheduled';
                                            } else {
                                                echo 'No Schedule';
                                            }
                                            
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <div class="action-btn">
                                        <?php if($this->session->userdata('user_role') == 1 || $this->session->userdata('user_role') == 2 || in_array('1', $user_permissions) || in_array('2', $user_permissions)) { ?>
                                        <a href="<?php echo base_url("doctor/profile/$doctor->user_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                        <?php } ?>
                                        <?php if($this->session->userdata('user_role') == 2 || in_array('2', $user_permissions)) { ?>
                                        <a href="<?php echo base_url("doctor/edit/$doctor->user_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo base_url("doctor/delete/$doctor->user_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! You want to delete?')"><i class="fa fa-trash"></i></a>
                                        <?php } ?>
                                        </div> 
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
