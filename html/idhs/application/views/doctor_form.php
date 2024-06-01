<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('doctor/create','class="form-inner"') ?> 

                            <?php echo form_hidden('user_id',html_escape($doctor->user_id)) ?>

                            <!-- if representative picture is already uploaded -->
                            <?php if(!empty($doctor->picture)) {  ?>
                            <div class="form-group row">
                                <label for="picturePreview" class="col-xs-3 col-form-label"></label>
                                <div class="col-xs-9">
                                    <img src="<?php echo base_url(html_escape($doctor->picture)) ?>" alt="Picture" class="img-thumbnail hospital-form-logo" id="doctor-form-picture-img" />
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="picture" class="col-xs-3 col-form-label">Doctor Image</label>
                                <div class="col-xs-9">
                                    <input type="file" name="picture" id="picture" value="<?php echo html_escape($doctor->picture) ?>">
                                    <input type="hidden" name="old_picture" value="<?php echo html_escape($doctor->picture) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Doctor Name <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Doctor Name" value="<?php echo html_escape($doctor->firstname); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="specialist" class="col-xs-3 col-form-label">Speciality<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input type="text" name="specialist" class="form-control" placeholder="Speciality" id="specialist" value="<?php echo html_escape($doctor->specialist); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-xs-3 col-form-label">Phone Number <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="mobile" class="form-control" type="number" min="0" placeholder="Phone Number" autocomplete="off" id="mobile" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" value="<?php echo html_escape($doctor->mobile); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-xs-3 col-form-label">Email ID<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="email" class="form-control" type="email" placeholder="Email ID" id="email" autocomplete="off" value="<?php echo html_escape($doctor->email); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">Start Career</label>
                                <div class="col-xs-9">
                                    <input name="start_career" class="dropdown-month-years form-control" type="text" placeholder="Start Career" id="date_of_birth" value="<?php echo html_escape($doctor->start_career); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="registration_number" class="col-xs-3 col-form-label">Registration Number<i class="text-danger"> *</i></label>
                                <div class="col-xs-9">
                                    <input name="registration_number" type="text" class="form-control" id="registration_number" placeholder="Registration Number" value="<?php echo html_escape($doctor->registration_number); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="consultancy_fees" class="col-xs-3 col-form-label">Consultancy fees (Rs.) <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="consultancy_fees" type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control" id="consultancy_fees" placeholder="Rs" value="<?php echo html_escape($doctor->consultancy_fees); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="consultancy_validity" class="col-xs-3 col-form-label">Consultancy validity (Days) <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="consultancy_validity" type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control" id="consultancy_validity" placeholder="Days" value="<?php echo html_escape($doctor->consultancy_validity); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-xs-3 col-form-label">Department</label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('department_id',$department_list,html_escape($doctor->department_id),'class="form-control" id="department_id"') ?>

                                    <?php
                                        /*
                                        if(is_array($doctor->department_id)) {
                                            $selected_department = $doctor->department_id;
                                        } else {
                                            $selected_department = explode(',', $doctor->department_id);
                                        }

                                        echo form_dropdown('department_id[]',$department_list,html_escape($selected_department),'class="form-control" id="department_id" multiple="multiple"');
                                        */
                                    ?>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="experience" class="col-xs-3 col-form-label">Experience (Years) <i class="text-danger">*</i> </label>
                                <div class="col-xs-9">
                                    <input name="experience" type="number" class="form-control" id="experience" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder="Years" value="<?php echo html_escape($doctor->experience); ?>" >
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/doctor">Cancel</a>
                                        <div class="or"></div>
                                        <button class="ui positive button">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#doctor-form-picture-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#picture").change(function(){
        readURL(this);
    });

    /*$(document).ready(function() {
        $('#department_id').select2({
            placeholder: '- Select -'
        });
    });
    */
</script>