<?php
    $disease_operated = explode(',',$this->session->userdata('disease_operated'));
?>
<div class="row">
    <!--  table area -->
    <div class="col-md-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="nav nav-tabs">
                            <li class="<?php if($query_disease_id == 'all' || $query_disease_id == '') { echo 'active'; } ?>"><a href="?disease_type=all">All</a></li>
                            <li class="<?php if($query_disease_id == 'top_care') { echo 'active'; } ?>"><a href="?disease_type=top_care">Top Care</a></li>
                            <li class="<?php if($query_disease_id == 'seasonal_care') { echo 'active'; } ?>"><a href="?disease_type=seasonal_care">Seasonal Care</a></li>
                            <li class="<?php if($query_disease_id == 'emergency_care') { echo 'active'; } ?>"><a href="?disease_type=emergency_care">Emergency Care</a></li>
                        </ul>
                    </div>
                    <?php if($this->session->userdata('user_role') == 1) { ?>
                    <div class="col-md-4" align="right">
                        <div class="btn-group"> 
                            <a class="btn btn-success" href="<?php echo base_url("disease/create") ?>" style="border-radius: 7px;">Add Disease</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <input type="hidden" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <thead>
                        <tr>
                            <?php if($this->session->userdata('user_role') == 2 && !empty($diseases)) { ?>
                            <th>
                                <div class="ui buttons">
                                    <button class="ui positive button" id="submit_button">Save</button>
                                </div>
                            </th>
                            <?php } ?>
                            <th>Disease Name</th>
                            <th>Organs Related</th>
                            <th>Disease Type</th>
                             <?php if($this->session->userdata('user_role') == 1) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($diseases)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($diseases as $disease) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <?php if($this->session->userdata('user_role') == 2) { ?>
                                    <td>
                                        <input type="checkbox" name="disease_operated[]" value="<?php echo html_escape($disease->disease_id); ?>" <?php if(in_array($disease->disease_id,$disease_operated)) { echo 'checked'; }?> />
                                    </td>
                                    <?php } ?>
                                    <td><?php echo html_escape($disease->name); ?></td>
                                    <td>
                                        <?php
                                            $organ_related = html_escape($disease->organ_related);
                                            if($organ_related) {
                                                $organ_related_array = explode(',', $organ_related);
                                                $numItems = count($organ_related_array);
                                                $oi = 0;

                                                foreach ($organ_related_array as $organ_value) {
                                                    echo $organ_list[$organ_value];

                                                    if(++$oi != $numItems) {
                                                        echo ", ";
                                                    }
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $diseaseTypeList = array( 
                                                '1' => 'Top Care',
                                                '2' => 'Seasonal Care',
                                                '3' => 'Emergency Care'
                                            );
                                            $disease_type = html_escape($disease->disease_type);
                                            echo $diseaseTypeList[$disease_type];
                                        ?>
                                    </td>
                                    <?php if($this->session->userdata('user_role') == 1) { ?>
                                    <td>
                                        <div class="action-btn">
                                        <a href="<?php echo base_url("disease/edit/".$this->my_encrypt->encode($disease->disease_id)) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                                        <a href="<?php echo base_url("disease/delete/".$this->my_encrypt->encode($disease->disease_id)) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure! You want to delete? ')"><i class="fa fa-trash"></i></a>
                                        </div> 
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

<script>
$(document).ready(function() {
    $("#submit_button").click(function () {
        var CSRF_TOKEN = $('#CSRF_TOKEN').val();
        var user_id = $('#user_id').val();
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });

        $.ajax({
            url  : _baseURL+'hospital/update_disease_operated/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                disease_operated : val,
                user_id : user_id
            },
            success : function(data) 
            {
                alert('Disease have been saved successfully.');
                location.replace("/disease");
            }, 
            error : function()
            {
                
            }
        });

    });
});
</script>
