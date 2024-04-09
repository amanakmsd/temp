<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">

            <div class="panel-body panel-form">
                <div class="row">
                    <?php echo form_open_multipart('package/create','class="form-inner"') ?> 
                    <div class="col-md-11 col-sm-12">
                            <?php echo form_hidden('package_id',html_escape($package->package_id)) ?>

                            <div class="form-group">
                                <label for="name">Package Name <i class="text-danger">*</i></label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="<?php echo html_escape($package->name); ?>" >
                            </div>
                            <div class="form-group">
                                <label for="price">Price <i class="text-danger">*</i></label>
                                <input name="price" type="number" class="form-control" id="price" placeholder="Price" value="<?php echo html_escape($package->price); ?>" >
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start Date <i class="text-danger">*</i></label>
                                <input name="start_date" autocomplete="off" class="form-control" type="text" placeholder="Start Date" id="package_start_date" value="<?php echo !empty($package->start_date) ? date('d-m-Y',strtotime($package->start_date)) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date <i class="text-danger">*</i></label>
                                <input name="end_date" autocomplete="off" class="form-control" type="text" placeholder="Start Date" id="package_end_date" value="<?php echo !empty($package->end_date) ? date('d-m-Y',strtotime($package->end_date)) : ''; ?>">
                            </div>
                            <?php if($this->session->userdata('user_role') != 1) { ?>
                            <div class="form-group">
                                <label for="department_id">Department <i class="text-danger">*</i> </label>
                                
                                    <?php echo form_dropdown('department_id',$department_list,html_escape($package->department_id),'class="form-control" id="department_id"') ?>
                                
                            </div>
                            <div class="form-group">
                                <label for="test_includes">Test Includes <i class="text-danger">*</i></label>
                                <textarea name="test_includes" class="form-control" placeholder="Test Includes" id="test_includes"><?php echo html_escape($package->test_includes); ?></textarea>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="description">Description <i class="text-danger">*</i></label>
                                <textarea name="description" class="form-control" placeholder="Description" id="description"><?php echo html_escape($package->description); ?></textarea>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/package">Cancel</a>
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
<script>
    $(document).ready(function() {
        $( "#package_start_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
            onSelect: function(dateText) {
                $( "#package_end_date" ).datepicker( "option", "minDate", dateText );
            }
        });

        $( "#package_end_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
        });
    });
</script>
