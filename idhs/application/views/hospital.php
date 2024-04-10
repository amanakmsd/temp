<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo 'Hospital Logo' ?></th>
                            <th><?php echo 'Hospital Name' ?></th>
                            <th><?php echo 'License No' ?></th>
                            <th><?php echo 'Year of commencement' ?></th>
                            <th><?php echo 'Hospital Ownership' ?></th>
                            <th><?php echo 'No. of ambulance' ?></th>
                            <th><?php echo 'Emergency Service' ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($hospitals)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($hospitals as $hospital) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td>

                                        <img src="<?php echo (!empty($hospital->picture)?base_url($hospital->picture):base_url("assets/images/no-img.png")) ?>" alt="" width="65" height="50"/>
                                    </td>
                                    <td><?php echo html_escape($hospital->name); ?></td>
                                    <td><?php echo html_escape($hospital->license_no); ?></td>
                                    <td><?php echo html_escape($hospital->year_of_commencement); ?></td>
                                    <td><?php echo html_escape($hospital->hospital_ownership); ?></td>
                                    <td><?php echo html_escape($hospital->no_of_ambulance); ?></td>
                                    <td><?php echo html_escape($hospital->emergency_service); ?></td>
                                    <td>
                                        <div class="action-btn">
                                        <?php if($hospital->status == 2) { ?>
                                        <a href="<?php echo base_url("hospital/approve/$hospital->user_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! you want to approve?')"><i class="fa fa-check"></i></a>
                                        <?php } ?>
                                        <a href="<?php echo base_url("hospital/profile/$hospital->hospital_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a> 
                                        <a href="<?php echo base_url("hospital/edit/$hospital->hospital_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                                        <a href="<?php echo base_url("hospital/delete/$hospital->hospital_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! You want to delete? ')"><i class="fa fa-trash"></i></a>
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
