<?php
    if(is_array($staff->user_permissions)) {
        $user_permissions = $staff->user_permissions;
    } else {
        $user_permissions = explode(',', $staff->user_permissions);
    }
?>
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">

            <div class="panel-body panel-form">
                <div class="row">
                    <?php echo form_open_multipart('staff/create','class="form-inner"') ?> 
                    <div class="col-md-3">
                        <!-- if representative picture is already uploaded -->
                        <?php if(!empty($staff->picture)) {  ?>
                        <div class="form-group row">
                            <div class="col-xs-12">
                                <img src="<?php echo base_url(html_escape($staff->picture)) ?>" alt="Picture" class="img-thumbnail staff-form-picture" id="staff-form-picture-img" />
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <img src="<?php echo base_url('assets/images/'.html_escape('staff.png')) ?>" alt="Picture" class="img-thumbnail staff-form-picture" id="staff-form-picture-img" />
                                    
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group row">
                            <div class="col-xs-12" style="text-align: center;">
                                <span id="customFileInputName" style="height: auto; display: block; word-wrap: break-word;"></span>
                                <label for="picture" class="btn" style="font-size: 16px; font-weight: bold; color: #00B29A;">Change Picture</label>
                                <input type="file" name="picture" id="picture" style="visibility:hidden;">
                                <input type="hidden" name="old_picture" value="<?php echo html_escape($staff->picture) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                            <?php echo form_hidden('user_id',html_escape($staff->user_id)) ?>

                            <div class="form-group">
                                <label for="name">Name <i class="text-danger">*</i></label>
                                <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Name" value="<?php echo html_escape($staff->firstname); ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">Email <i class="text-danger">*</i></label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Email" value="<?php echo html_escape($staff->email); ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Phone Number <i class="text-danger">*</i></label>
                                <input name="mobile" class="form-control" type="number" placeholder="Phone Number" id="mobile" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" value="<?php echo html_escape($staff->mobile); ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="relationship">Role <i class="text-danger">*</i></label>
                                <?php
                                    $relationshipList = array( 
                                        ''   => '- Select -',
                                        'Manager' => 'Manager',
                                        'Receptionist' => 'Receptionist'
                                    );
                                    echo form_dropdown('relationship', $relationshipList, html_escape(isset($staff->relationship) ? $staff->relationship : ''), 'class="form-control" id="relationship" ');
                                ?>
                            </div>
                            <div class="form-group" style="margin-top: 26px; font-size: 20px;">
                                <label>Permission</label>
                            </div>
                            <div class="form-group">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Features</th>
                                            <th scope="col">View only</th>
                                            <th scope="col">Full access</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Doctor Management</td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="doctor_view_only" name="user_permissions[]" value="1" <?php if(in_array('1', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="doctor_full_access" name="user_permissions[]" value="2" <?php if(in_array('2', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Booking Management</td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="booking_view_only" name="user_permissions[]" value="3" <?php if(in_array('3', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="booking_full_access" name="user_permissions[]" value="4" <?php if(in_array('4', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Schedule Management</td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="schedule_view_only" name="user_permissions[]" value="5" <?php if(in_array('5', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="schedule_full_access" name="user_permissions[]" value="6" <?php if(in_array('6', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Department Management</td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="department_view_only" name="user_permissions[]" value="7" <?php if(in_array('7', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" id="department_full_access" name="user_permissions[]" value="8" <?php if(in_array('8', $user_permissions)) echo 'checked' ?>>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/staff">Cancel</a>
                                        <div class="or"></div>
                                        <button class="ui positive button">Save</button>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .staff-form-picture {
        border-radius: 50%;
        height: 220px;
        width: 220px;
    }
</style>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#staff-form-picture-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#picture").change(function(){
        readURL(this);
    });
</script>
