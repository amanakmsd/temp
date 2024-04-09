<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-10 col-sm-12">

                        <?php echo form_open('content/faq/create','class="form-inner"') ?>
                            <?php echo form_hidden('content_id',html_escape($faq->content_id)) ?>
                            <div class="form-group">
                                <label for="name">Queston <i class="text-danger">*</i></label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Question" value="<?php echo html_escape($faq->name); ?>" >
                            </div>
                            <div class="form-group">
                                <label for="content">Answer <i class="text-danger">*</i></label>
                                <textarea name="content" class="tinymce form-control" placeholder="Description" id="content" maxlength="300" rows="10"><?php echo html_escape($faq->content); ?></textarea>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/content/faq">Cancel</a>
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