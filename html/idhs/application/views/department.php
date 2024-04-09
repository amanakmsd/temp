<?php
    $user_permissions = explode(',',$this->session->userdata('user_permissions'));
?>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <?php if($this->session->userdata('user_role') == 2 || in_array('8', $user_permissions)) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($departments)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($departments as $department) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo html_escape($department->name); ?></td>
                                    <td><?php echo html_escape(character_limiter($department->description, 60)); ?></td>
                                    <td><?php echo ((html_escape($department->status)==1) ? 'Active' : 'Inactive'); ?></td>
                                    <?php if($this->session->userdata('user_role') == 2 || in_array('8', $user_permissions)) { ?>
                                    <td class="center">
                                        <a href="<?php echo base_url("department/edit/$department->dprt_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <a href="<?php echo base_url("department/delete/$department->dprt_id") ?>" onclick="return confirm('Are you sure! You want to delete this?')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a> 
                                    </td>
                                    <?php } ?>
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
