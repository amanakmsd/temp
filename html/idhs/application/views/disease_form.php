<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        <?php echo form_open('disease/create','class="form-inner"') ?>
                            <?php echo form_hidden('disease_id',html_escape($disease->disease_id)) ?>
                            <div class="form-group">
                                <label for="name">Name <i class="text-danger">*</i></label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="<?php echo html_escape($disease->name); ?>" >
                            </div>
                            <div class="form-group">
                                <label for="organ_related">Organ Related<i class="text-danger">*</i></label>
                                <?php
                                    if(is_array($disease->organ_related)) {
                                        $selected_organ_related = $disease->organ_related;
                                    } else {
                                        $selected_organ_related = explode(',', $disease->organ_related);
                                    }

                                    echo form_dropdown('organ_related[]',$organ_list,html_escape($selected_organ_related),'class="form-control" id="organ_related" multiple="multiple"'); 
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="disease_type">Disease Type<i class="text-danger">*</i></label>
                                <?php
                                    $diseaseTypeList = array( 
                                        ''   => '- Select -',
                                        '1' => 'Top Care',
                                        '2' => 'Seasonal Care',
                                        '3' => 'Emergency Care'
                                    );
                                    echo form_dropdown('disease_type', $diseaseTypeList, html_escape(isset($disease->disease_type) ? $disease->disease_type : ''), 'class="form-control" id="disease_type" ');
                                ?>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/disease">Cancel</a>
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
<script>
    $(document).ready(function() {
        $('#organ_related').select2({
            placeholder: '- Select -'
        });
    });
</script>