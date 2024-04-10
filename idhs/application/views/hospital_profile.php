<div class="row">

    <div class="col-sm-12" id="PrintMe">

        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-md-1" align="left" style="padding-right: 0px;">
                        <img alt="Picture" src="<?php echo (!empty($hospital->picture)?base_url($hospital->picture):base_url("assets/images/no-img.png")) ?>" class="img-thumbnail img-responsive img-hospital-thumbnail">
                    </div>
                    <div class="col-md-8" style="padding: 12px;">
                        <div>
                            <h1>
                            <?php echo (!empty($hospital->name)?html_escape($hospital->name):'NA') ?>
                            </h1>
                        </div>
                        <div>
                            Address: 
                            <span style="font-weight: 600;">
                            <?php
                                echo (!empty($hospital->address) ? html_escape($hospital->address).', ':'');
                                echo (!empty($hospital->address2) ? html_escape($hospital->address2).', ':'');
                                echo (!empty($hospital->city) ? html_escape($hospital->city).', ':'');
                                echo (!empty($hospital->state) ? html_escape($hospital->state):'');
                            ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3" align="right" style="padding: 21px;">
                        <div class="btn-group"> 
                            <a class="btn btn-success" href="<?php echo base_url("hospital/edit/".$hospital->hospital_id) ?>">Edit</a>  
                            
                        </div>
                    </div>
                </div>
            </div> 

            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-12">  
                        <table class="table table-sm">
                            
                            <tbody>
                                <tr>
                                    <td class="border-right">License Number</td>
                                    <td>
                                        <?php echo (!empty($hospital->license_no)?html_escape($hospital->license_no):'NA') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">Year of commencement</td>
                                    <td>
                                        <?php echo (!empty($hospital->year_of_commencement)?html_escape($hospital->year_of_commencement):'NA') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">Hospital Ownership</td>
                                    <td>
                                        <?php echo (!empty($hospital->hospital_ownership)?html_escape($hospital->hospital_ownership):'NA') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">No. of Ambulance</td>
                                    <td>
                                        <?php echo (!empty($hospital->no_of_ambulance)?html_escape($hospital->no_of_ambulance):'NA') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">Organs Operated</td>
                                    <td>
                                        <ul class="horizontal-list">
                                        <?php
                                            if(!empty($hospital->organs_operated)) {
                                                $organs_operated = explode(',', $hospital->organs_operated);
                                                foreach ($organs_operated as $organ_key => $organs_value) {
                                                    echo '<li>'.$organs_value.'</li>';
                                                    
                                                }
                                            }
                                        ?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">Specific Operations</td>
                                    <td>
                                        <ul class="horizontal-list">
                                        <?php
                                            if(!empty($hospital->speciality_operations)) {
                                                $speciality_operations = explode(',', $hospital->speciality_operations);
                                                foreach ($speciality_operations as $speciality_key => $speciality_value) {
                                                    echo '<li>'.$speciality_value.'</li>';
                                                    
                                                }
                                            }
                                        ?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">Facility Available</td>
                                    <td>
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="border-right">Bed Type</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <?php echo 'Manual| Rs.'. (!empty($hospital->manual)?html_escape($hospital->manual):'NA') ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <?php echo 'Semi Electric| Rs.'. (!empty($hospital->semi_electric)?html_escape($hospital->semi_electric):'NA') ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <?php echo 'Fully Electric| Rs.'. (!empty($hospital->fully_electric)?html_escape($hospital->fully_electric):'NA') ?>
                                                            </div>
                                                        </div>
                                                        
                                                            
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border-right">Parking areas</td>
                                                    <td><?php echo (!empty($hospital->parking_area)?html_escape($hospital->parking_area).' square feet':'NA') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="border-right">Waiting hall</td>
                                                    <td><?php echo (!empty($hospital->waiting_hall)?html_escape($hospital->waiting_hall):'NA') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="border-right">Labs</td>
                                                    <td><?php echo (!empty($hospital->labs)?html_escape($hospital->labs):'NA') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="border-right">Pharmacy</td>
                                                    <td><?php echo (!empty($hospital->pharmacy)?html_escape($hospital->pharmacy):'NA') ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">Total Area of Premises</td>
                                    <td><?php echo (!empty($hospital->premises_area)?html_escape($hospital->premises_area).' square feet':'NA') ?></td>
                                </tr>
                                <tr>
                                    <td class="border-right">Emergency</td>
                                    <td><?php echo (!empty($hospital->emergency_service)?html_escape($hospital->emergency_service):'NA') ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div> 
        </div>
    </div>
 
</div>
<style>
    ul.horizontal-list {
      
    }
    ul.horizontal-list li {
      float: left;
      margin: 0px 15px 0px 15px;
    }
    .border-right {
        border-right: 1px solid #e4e5e7;
        width: 25%;
    }
    .img-hospital-thumbnail {
        border-radius: 50%;
        height: 80px;
        width: 80px;
    }
</style
