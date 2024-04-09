<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        <?php echo form_open('organ/create','class="form-inner"') ?>
                            <?php echo form_hidden('organ_id',html_escape($organ->organ_id)) ?>
                            <div class="form-group">
                                <label for="name">Organ Name <i class="text-danger">*</i></label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Organ Name" value="<?php echo html_escape($organ->name); ?>" >
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/organ">Cancel</a>
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