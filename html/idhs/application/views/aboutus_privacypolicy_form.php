<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-10 col-sm-12">

                        <?php echo form_open('content/update','class="form-inner"') ?>
                            <?php echo form_hidden('content_id',html_escape($data->content_id)) ?>
                            <div class="form-group">
                                <textarea name="content" class="tinymce form-control" placeholder="Description" id="content" maxlength="300" rows="10"><?php echo html_escape($data->content); ?></textarea>
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