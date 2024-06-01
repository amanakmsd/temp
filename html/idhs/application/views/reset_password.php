<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('dashboard/change-password/','class="form-inner"') ?> 
                            <?php echo form_hidden('user_id',$this->session->userdata('user_id')) ?>

                            <div class="form-group">
                                <label for="password">Current Password <i class="text-danger">*</i></label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Current Password" required="required">
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password <i class="text-danger">*</i></label>
                                <input name="new_password" type="password" class="form-control" id="new_password" placeholder="New Password" required="required">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password <i class="text-danger">*</i></label>
                                <input name="confirm_password" type="password" class="form-control" id="confirm_password" placeholder="Confirm New Password" required="required">
                            </div>

                            <div class="form-group">
                                <div class="ui buttons">
                                    <button class="ui positive button">Submit</button>
                                </div>
                            </div>
                        <?php echo form_close() ?>
                        
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>

</div>

 