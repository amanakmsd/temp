<?php
    $user_permissions = explode(',',$this->session->userdata('user_permissions'));

    if($query_booking_id) {
        $booking_query = "&booking_type=".$query_booking_id;
    } else {
        $booking_query = "";
    }

    if($query_department_id) {
        $department_query = "&department=".$query_department_id;
    } else {
        $department_query = "";
    }

    if($query_hospital_id) {
        $hospital_query = "&hospital_id=".$query_hospital_id;
    } else {
        $hospital_query = "";
    }
?>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-md-9">
                        <ul class="nav nav-tabs">
                            <li class="<?php if($query_booking_id == 'new' || $query_booking_id == '') { echo 'active'; } ?>"><a href="?booking_type=new<?php echo $department_query.$hospital_query ?>">New / Upcoming</a></li>
                            <li class="<?php if($query_booking_id == 'on_going') { echo 'active'; } ?>"><a href="?booking_type=on_going<?php echo $department_query.$hospital_query ?>">On Going</a></li>
                            <li class="<?php if($query_booking_id == 'past') { echo 'active'; } ?>"><a href="?booking_type=past<?php echo $department_query.$hospital_query ?>">Past</a></li>
                        </ul>
                    </div>
                    <?php if($this->session->userdata('user_role') == 2 || in_array('4', $user_permissions)) { ?>
                    <div class="col-md-3" align="right">
                        <form id="bookingFilterForm" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET">
                            <input type="hidden" name="booking_type" value="<?php echo $query_booking_id;?>">
                            <div class="form-group">
                                <select onchange="filterBookingForm('bookingFilterForm');" name="department" class="form-control">
                                    <option value="">- Select department -</option>
                                    <?php
                                        foreach ($department_list as $key => $value) {
                                            if($key == $this->my_encrypt->decode($query_department_id)) {
                                                $selectedValue = "selected='selected'";
                                            } else {
                                                $selectedValue = '';
                                            }

                                            echo "<option value='".$this->my_encrypt->encode($key)."' ".$selectedValue.">".$value."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                    <?php if($this->session->userdata('user_role') == 1) { ?>
                    <div class="col-md-3" align="right">
                        <form id="hospitalFilterForm" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET">
                            <input type="hidden" name="booking_type" value="<?php echo $query_booking_id;?>">
                            <div class="form-group">
                                <select onchange="filterBookingForm('hospitalFilterForm');" name="hospital_id" class="form-control">
                                    <option value="">- Select Hospital -</option>
                                    <?php
                                        foreach ($hospital_list as $hospital_row) {
                                            if($hospital_row->hospital_id == $this->my_encrypt->decode($query_hospital_id)) {
                                                $selectedValue1 = "selected='selected'";
                                            } else {
                                                $selectedValue1 = '';
                                            }

                                            echo "<option value='".$this->my_encrypt->encode($hospital_row->hospital_id)."' ".$selectedValue1.">".$hospital_row->name."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Address</th>
                            <th>Concern</th>
                            <th>Hospital Name</th>
                            <th>Doctor Name</th>
                            <th>Department</th>
                            <th>Date and Time</th>
                            <th>Paid/Unpaid</th>
                            <?php if($this->session->userdata('user_role') == 2 || in_array('4', $user_permissions)) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings)) { //print_r($bookings);exit; ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($bookings as $booking) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo html_escape($booking->firstname); ?></td>
                                    <td><?php echo html_escape($booking->age); ?></td>
                                    <td><?php echo html_escape($booking->address); ?></td>
                                    <td><?php echo html_escape($booking->concern); ?></td>
                                    <td><?php echo html_escape($booking->hospital_name); ?></td>
                                    <td><?php echo html_escape($booking->doctor_name); ?></td>
                                    <td><?php echo html_escape($booking->department_name); ?></td>
                                    <td>
                                        <?php
                                            if($booking->schedule_date != '' & $booking->schedule_time != '') {
                                                echo date('d M Y', strtotime($booking->schedule_date)) . ' '.$booking->schedule_time;
                                            } else {
                                                echo 'Unpaid';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($booking->payment_status == 2) {
                                                echo 'Paid';
                                            } else {
                                                echo 'Unpaid';
                                            }
                                        ?>
                                    </td>
                                    
                                    <?php if($this->session->userdata('user_role') == 2 || in_array('4', $user_permissions)) { ?>
                                    <td>
                                        <div class="ui buttons">
                                            <?php if($booking->status != 2) { ?>
                                            <a class="ui button" href="<?php echo base_url("booking/reject/".$this->my_encrypt->encode($booking->booking_id)) ?>" onclick="return confirm('Are you sure! You want to reject? ')">Reject</a>
                                            <div class="or"></div>
                                            <?php } ?>
                                            <a class="ui positive button" href="<?php echo base_url("booking/rescdule/".$this->my_encrypt->encode($booking->booking_id)) ?>" onclick="return confirm('Are you sure! You want to reschedule? ')">Reschedule</a>
                                        </div>
                                    </td>
                                    <?php } ?>
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
<style>
    .ui.button {
        padding: 11px 15px;
        border-radius: 7px !important;
    }
</style>
<script>
    function filterBookingForm(formId) {
        var oForm = document.getElementById(formId);
        if (oForm) {
            oForm.submit(); 
        }
    }
</script>
