<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('department/create','class="form-inner"') ?>

                            <?php echo form_hidden('dprt_id',html_escape($department->dprt_id)) ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Department Name <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name"  type="text" class="form-control" id="name" placeholder="Department Name" value="<?php echo html_escape($department->name); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label">Description</label>
                                <div class="col-xs-9">
                                    <textarea name="description" class="form-control"  placeholder="Description" rows="7"><?php echo html_escape($department->description); ?></textarea>
                                </div>
                            </div>

                            <!--Radio-->
                            <div class="form-group row">
                                <label class="col-xs-3 col-form-label">Status</label>
                                <div class="col-xs-9"> 
                                    <div class="form-check">
                                        <label class="radio-inline"><input type="radio" name="status" value="1" checked>Active</label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0">Inactive</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
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