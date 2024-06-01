<div class="row">

    <div class="col-sm-12" id="PrintMe">
        <div  class="panel panel-default thumbnail"> 
            <?php /*?>
            <div class="panel-heading no-print">
                 <div class="btn-group">
                    <button type="button" onclick="printContent('PrintMe')" class="btn btn-success" ><i class="fa fa-print"></i></button>            
                    <a href="<?php echo base_url('dashboard/form/') ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a> 
                </div>
            </div>
            <?php */?>


            <div class="panel-body">  
                <div class="row">
                    <div class="col-sm-12" align="center">  
                    <br>
                    </div>

                    <div class="col-sm-4" align="center"> 
                        <img alt="Picture" src="<?php echo html_escape((!empty($user->picture)?base_url($user->picture):base_url("assets/images/no-img.png"))); ?>" class="img-responsive img-hw-200" >
                        
                    </div> 

                    <div class="col-sm-8"> 
                        <dl class="dl-horizontal">
                        <?php if(!empty($user->firstname)) { ?>
                            <dt><?php echo 'Name' ?></dt><dd><?php echo html_escape($user->firstname); ?></dd>
                        <?php } ?>
                        <?php if(!empty($user->email)) { ?>
                            <dt><?php echo 'Email' ?></dt><dd><?php echo html_escape($user->email); ?></dd>
                        <?php } ?>

                        <?php if(!empty($user->designation)) { ?>
                            <dt><?php echo display('designation') ?></dt><dd><?php echo html_escape($user->designation); ?></dd>
                        <?php } ?>

                        <?php if(!empty($user->department)) { ?>
                            <dt><?php echo display('department') ?></dt><dd><?php echo html_escape($user->department); ?></dd>
                        <?php } ?>

                        

                        

                        <?php if(!empty($user->mobile)) { ?>
                            <dt><?php echo 'Mobile Number' ?></dt><dd><?php echo html_escape($user->mobile); ?></dd>
                        <?php } ?> 

                        <?php if(!empty($user->relationship)) { ?>
                            <dt><?php echo 'Role' ?></dt><dd><?php echo html_escape($user->relationship); ?></dd>
                        <?php } ?> 
   
                        <?php if(!empty($user->sex)) { ?>
                            <dt><?php echo display('sex') ?></dt><dd><?php echo html_escape($user->sex); ?></dd>
                        <?php } ?> 
  
                        <?php if(!empty($user->education_degree)) { ?>
                            <dt><?php echo display('education_degree') ?></dt><dd><?php echo html_escape($user->education_degree); ?></dd>
                        <?php } ?> 
  
                        <?php if(!empty($user->create_date)) { ?>
                            <dt><?php echo 'Registration Date' ?></dt><dd><?php echo html_escape($user->create_date); ?></dd>
                        <?php } ?>  
                        
                        <?php if(!empty($user->address)) { ?>
                            <dt><?php echo 'Address' ?></dt><dd><?php echo html_escape($user->address); ?></dd>
                        <?php } ?> 
                    
   
                        <?php if(!empty($user->status)) { ?>
                            <dt><?php echo display('status') ?></dt><dd><?php echo (!empty($user->status)?
                            display('active'):display('inactive')) ?></dd>
                        <?php } ?>  
                        </dl> 
                    </div>
                </div>  

            </div> 

            <div class="panel-footer">
                <div class="text-center">
                    <strong><?php echo html_escape($this->session->userdata('title')); ?></strong>
                    <p class="text-center"><?php echo html_escape($this->session->userdata('address')); ?></p>
                </div>
            </div>
        </div>
    </div>
 

</div>
