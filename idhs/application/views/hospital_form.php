<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">

            <div class="panel-body panel-form">
                <div class="row">
                    <?php echo form_open_multipart('hospital/create','class="form-inner"') ?> 
                    <div class="col-md-3">
                        <!-- if representative picture is already uploaded -->
                        <?php if(!empty($hospital->picture)) {  ?>
                        <div class="form-group row">
                            <div class="col-xs-12">
                                <img src="<?php echo base_url(html_escape($hospital->picture)) ?>" alt="Picture" class="img-thumbnail hospital-form-logo" />
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <img src="<?php echo base_url('assets/images/hospital/'.html_escape('default-hospital-logo.jpg')) ?>" alt="Picture" class="img-thumbnail hospital-form-logo" />
                                    
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group row">
                            <div class="col-xs-12" style="text-align: center;">
                                <span id="customFileInputName" style="height: auto; display: block; word-wrap: break-word;"></span>
                                <label for="picture" class="btn" style="font-size: 16px; font-weight: bold; color: #00B29A;">Change Logo</label>
                                <input type="file" name="picture" id="picture" style="visibility:hidden;">
                                <input type="hidden" name="old_picture" value="<?php echo html_escape($hospital->picture) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        
                            <?php echo form_hidden('hospital_id',html_escape($hospital->hospital_id)) ?>
                            <?php echo form_hidden('user_id',html_escape($hospital->user_id)) ?>

                            <div class="form-group">
                                <label for="name">Hospital Name <i class="text-danger">*</i></label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Hospital Name" value="<?php echo html_escape($hospital->name); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="email">Email <i class="text-danger">*</i></label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Email" value="<?php echo html_escape($hospital->email); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="license_no">Licence Number <i class="text-danger">*</i></label>
                                <input name="license_no" type="text" class="form-control" id="license_no" placeholder="Licence Number" value="<?php echo html_escape($hospital->license_no); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="year_of_commencement">Year of Commencement<i class="text-danger">*</i></label>
                                <input name="year_of_commencement" class="form-control" type="text" placeholder="Year of commencement" id="year_of_commencement" value="<?php echo html_escape($hospital->year_of_commencement); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="hospital_ownership">Hospital Ownership<i class="text-danger">*</i></label>
                                <?php
                                    $ownershipList = array( 
                                        ''   => 'Select',
                                        'Gov' => 'Gov',
                                        'Semi-Gov' => 'Semi-Gov',
                                        'Private' => 'Private'
                                    );
                                    echo form_dropdown('hospital_ownership', $ownershipList, html_escape(isset($hospital->hospital_ownership) ? $hospital->hospital_ownership : ''), 'class="form-control" id="hospital_ownership" ');
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="mobile">Phone Number</label>
                                <input name="mobile" class="form-control" type="number" placeholder="Phone Number" id="mobile" value="<?php echo html_escape($hospital->mobile); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="no_of_ambulance">No. of Ambulance <i class="text-danger">*</i></label>
                                <input name="no_of_ambulance" class="form-control" type="number" placeholder="No. of Ambulance" id="no_of_ambulance" value="<?php echo html_escape($hospital->no_of_ambulance); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="organs_operated">Organs Operated</label>
                                    <?php
                                        $organsOperated = explode(',',$hospital->organs_operated);
                                    ?>
                                <div class="form-check">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="organs_operated[]" value="Heart" <?php echo in_array("Heart", $organsOperated) ? 'checked' : ''; ?>>Heart
                                    </label>

                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="organs_operated[]" value="Kidney" <?php echo in_array("Kidney", $organsOperated) ? 'checked' : ''; ?>>Kidney
                                    </label>

                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="organs_operated[]" value="Liver" <?php echo in_array("Liver", $organsOperated) ? 'checked' : ''; ?>>Liver
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="organs_operated">Speciality Operations</label>
                                
                                <?php
                                    $speciality_operations = explode(',',$hospital->speciality_operations);
                                ?>
                                <div class="form-check">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="speciality_operations[]" value="Heart" <?php echo in_array("Heart", $speciality_operations) ? 'checked' : ''; ?>>Heart
                                    </label>

                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="speciality_operations[]" value="Kidney" <?php echo in_array("Kidney", $speciality_operations) ? 'checked' : ''; ?>>Kidney
                                    </label>

                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="speciality_operations[]" value="Liver" <?php echo in_array("Liver", $speciality_operations) ? 'checked' : ''; ?>>Liver
                                    </label>
                                </div>
                                
                            </div>
                            <div class="form-group" style="margin-top: 26px; font-size: 20px;">
                                <label>Facility available</label>
                            </div>
                            <div class="form-group" style="font-size: 17px; margin-bottom: 3px;">
                                <label>Bed Type</label>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-md-4">
                                    <label for="manual">Manual</label>
                                    <input type="text" name="manual" placeholder="Price" value="<?php echo html_escape($hospital->manual); ?>" class="form-control" id="manual" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="semi_electric">Semi Electric</label>
                                    <input type="text" name="semi_electric" placeholder="Price" value="<?php echo html_escape($hospital->semi_electric); ?>" class="form-control" id="semi_electric" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fully_electric">Fully Electric</label>
                                    <input type="text" name="fully_electric" placeholder="Price" value="<?php echo html_escape($hospital->fully_electric); ?>" class="form-control" id="fully_electric" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="parking_area">Parking Area</label>
                                <input name="parking_area" class="form-control" type="text" placeholder="Parking Area" id="parking_area" value="<?php echo html_escape($hospital->parking_area); ?>" >
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-md-4">
                                    <label for="waiting_hall">Waiting Hall</label>
                                    <input name="waiting_hall" class="form-control" type="number" placeholder="No. of Waiting Hall" id="waiting_hall" value="<?php echo html_escape($hospital->waiting_hall); ?>" >
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="labs">Labs</label>
                                    <input name="labs" class="form-control" type="number" placeholder="No. of Labs" id="labs" value="<?php echo html_escape($hospital->labs); ?>" >
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="pharmacy">Pharmacy</label>
                                    <input name="pharmacy" class="form-control" type="number" placeholder="No. of Pharmacy" id="pharmacy" value="<?php echo html_escape($hospital->pharmacy); ?>" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="premises_area">Total area of premises</label>
                                <input name="premises_area" class="form-control" type="number" placeholder="Total area of premises" id="premises_area" value="<?php echo html_escape($hospital->premises_area); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="emergency_service">Emergency service availability <i class="text-danger">*</i></label>
                                <?php
                                    $ownershipList = array( 
                                        ''   => 'Select',
                                        'Yes' => 'Yes',
                                        'No' => 'No'
                                    );
                                    echo form_dropdown('emergency_service', $ownershipList, html_escape(isset($hospital->emergency_service) ? $hospital->emergency_service : ''), 'class="form-control" id="emergency_service" ');
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="address">Building Name</label>
                                <input type="text" name="address" class="form-control" id="inputAddress" value="<?php echo html_escape($hospital->address); ?>" placeholder="1234 Main St" />
                            </div>
                            <div class="form-group">
                                <label for="address2">Street Name</label>
                                <input type="text" name="address2" class="form-control" id="address2" value="<?php echo html_escape($hospital->address2); ?>" placeholder="Apartment, studio, or floor" />
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" name="city" placeholder="City" value="<?php echo html_escape($hospital->city); ?>" class="form-control" id="city" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="state">State</label>
                                    <input type="text" name="state" placeholder="State" value="<?php echo html_escape($hospital->state); ?>" class="form-control" id="state" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="zip">Pin code</label>
                                    <input type="text" name="Pin code" placeholder="Zip" value="<?php echo html_escape($hospital->zip); ?>" class="form-control" id="zip" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Hospital Images</label>
                                    <input type="hidden" name="old_hospital_images" value="<?php echo html_escape($hospital->hospital_images) ?>">
                                    <div class="upload__box">
                                        <div class="upload__btn-box">
                                            <label class="upload__btn">
                                                <p style="margin-bottom: 0;">Upload images</p>
                                                <input type="file" name="hospital_images[]" data-max_length="20" class="upload__inputfile" multiple>
                                            </label>
                                        </div>
                                        <div class="upload__img-wrap">
                                            <?php
                                                $hospital_images_string = $hospital->hospital_images;
                                                $hospital_images_array = explode(',', $hospital_images_string);
                                                if(!empty($hospital_images_array) && $hospital_images_string != NULL) {
                                                    foreach ($hospital_images_array as $img_key => $hospital_image) {
                                                        $hos_img_name_array = explode('/',$hospital_image);
                                                        $hos_img_name = end($hos_img_name_array);
                                            ?>
                                            <div class="upload__img-box">
                                                <div style="background-image: url('<?php echo base_url($hospital_image); ?>')"  data-number="<?php echo $img_key; ?>" data-file="<?php echo $hos_img_name; ?>" class="img-bg">
                                                    <div class="upload__img-close"></div>
                                                </div>
                                            </div>
                                            <?php } } ?>
                                        </div>
                                    </div>
                                

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a class="ui button" href="/idhs/hospital">Cancel</a>
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

<style>

.upload__box { }
.upload__inputfile {
    width: .1px;
    height: .1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
  }
  
.upload__btn {
    display: inline-block;
    font-weight: 600;
    color: #fff;
    text-align: center;
    min-width: 116px;
    padding: 5px;
    transition: all .3s ease;
    cursor: pointer;
    border: 2px solid;
    background-color: #00B29A;
    border-color: #00B29A;
    border-radius: 10px;
    line-height: 26px;
    font-size: 14px;
}
    
.upload__btn:hover {
      background-color: unset;
      color: #4045ba;
      transition: all .3s ease;
    }
    
.upload__btn-box {
      margin-bottom: 10px;
  }
  
.upload__img-wrap {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -10px;
    }
    
.upload__img-box {
      width: 200px;
      padding: 0 10px;
      margin-bottom: 12px;
    }
    
.upload__img-close {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        line-height: 24px;
        z-index: 1;
        cursor: pointer;
    }

.upload__img-close:after {
      content: '\2716';
      font-size: 14px;
      color: white;
}

.img-bg {
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  position: relative;
  padding-bottom: 100%;
}
</style>
<script type="text/javascript">
    $(document).ready(function () {
      ImgUpload();
    });

function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
              iterator++;
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}
</script>