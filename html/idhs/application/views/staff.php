<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-sm-12" style="text-align: right;">
                        <div class="btn-group"> 
                            <a class="btn btn-success" href="<?php echo base_url("staff/create") ?>">Add Staff</a>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Action</th> 
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($staffs)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($staffs as $staff) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td>
                                        <img src="<?php echo (!empty($staff->picture)?base_url($staff->picture):base_url("assets/images/no-img.png")) ?>" alt="" width="65" height="50"/>
                                        <?php echo html_escape($staff->firstname); ?>
                                    </td>
                                    <td><?php echo html_escape($staff->email); ?></td>
                                    <td><?php echo html_escape($staff->mobile); ?></td>
                                    <td><?php echo html_escape($staff->relationship); ?></td>
                                    <td>
                                        <div class="action-btn">
                                            <a href="<?php echo base_url("staff/edit/".$this->my_encrypt->encode($staff->user_id)) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                        
                                            <a href="<?php echo base_url("staff/delete/".$this->my_encrypt->encode($staff->user_id)) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! You want to delete?')"><i class="fa fa-trash"></i></a>
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
