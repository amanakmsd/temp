<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <h2><?php echo display('reset').' '.display('password')?></h2>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('dashboard/resetPassword/','class="form-inner"') ?> 
                            <?php echo form_hidden('user_id',$this->session->userdata('user_id')) ?>

                            <div class="form-group row">
                                <label for="password" class="col-xs-3 col-form-label"><?php echo display('password') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="password" type="text" class="form-control" id="password" placeholder="<?php echo display('password') ?>" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('update') ?></button>
                                    </div>
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

 