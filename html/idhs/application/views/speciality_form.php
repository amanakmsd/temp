<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        <?php echo form_open('speciality/create','class="form-inner"') ?>
                            <?php echo form_hidden('speciality_id',html_escape($speciality->speciality_id)) ?>
                            <div class="form-group">
                                <label for="name">Speciality Name <i class="text-danger">*</i></label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Speciality Name" value="<?php echo html_escape($speciality->name); ?>" >
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/speciality">Cancel</a>
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