<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-sm-12" style="text-align: right;">
                        <div class="btn-group"> 
                            <a class="btn btn-success" href="<?php echo base_url("package/create") ?>">Add Package</a>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <?php if($this->session->userdata('user_role') != 1) { ?>
                            <th>Department</th>
                            <th>Test includes</th>
                            <?php } ?>
                            <th>Description</th>
                            <th>Action</th> 
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($packages)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($packages as $package) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td>
                                        <?php echo html_escape($package->name); ?>
                                    </td>
                                    <td><?php echo html_escape($package->price); ?></td>
                                    <td><?php echo html_escape($package->start_date); ?></td>
                                    <td><?php echo html_escape($package->end_date); ?></td>
                                    <?php if($this->session->userdata('user_role') != 1) { ?>
                                    <td><?php echo html_escape($package->department_name); ?></td>
                                    <td><?php echo html_escape($package->test_includes); ?></td>
                                    <?php } ?>
                                    <td><?php echo html_escape($package->description); ?></td>
                                    <td>
                                        <div class="action-btn">
                                            <a href="<?php echo base_url("package/edit/$package->package_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                        
                                            <a href="<?php echo base_url("package/delete/$package->package_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! You want to delete?')"><i class="fa fa-trash"></i></a>
                                        </div> 
                                    </td>
                                    
                                    
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
