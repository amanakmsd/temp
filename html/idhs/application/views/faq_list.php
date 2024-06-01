<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-md-12" align="right">
                        <div class="btn-group"> 
                            
                            <a class="btn btn-success" href="<?php echo base_url("content/faq/create") ?>" style="border-radius: 7px;">Add FAQ</a>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($faqs)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($faqs as $faq) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo html_escape($faq->name); ?></td>
                                    <td><?php echo $faq->content; ?></td>
                                    <td>
                                        <div class="action-btn">
                                        <a href="<?php echo base_url("content/edit/".$this->my_encrypt->encode($faq->content_id)) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                                        <a href="<?php echo base_url("content/delete/".$this->my_encrypt->encode($faq->content_id)) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! You want to delete? ')"><i class="fa fa-trash"></i></a>
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
