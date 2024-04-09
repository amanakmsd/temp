<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Registration Date</th>
                            <th>Action</th> 
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($patients)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($patients as $patient) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td>
                                        <img src="<?php echo (!empty($patient->picture)?base_url($patient->picture):base_url("assets/images/no-img.png")) ?>" alt="" width="65" height="50"/>
                                        <?php echo html_escape($patient->firstname); ?>
                                    </td>
                                    <td><?php echo html_escape($patient->email); ?></td>
                                    <td><?php echo html_escape($patient->mobile); ?></td>
                                    <td><?php echo html_escape($patient->address); ?></td>
                                    <td><?php echo html_escape(date('d M Y', strtotime($patient->create_date))); ?></td>
                                    <td>
                                        <div class="action-btn">
                                            <a href="<?php echo base_url("patient/profile/$patient->user_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                            <a href="<?php echo base_url("patient/delete/$patient->user_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! You want to delete?')"><i class="fa fa-trash"></i></a>
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
