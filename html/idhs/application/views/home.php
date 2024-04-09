<div class="row">
    <div class="col-md-4">
        <!-- small box -->
        <div class="card-display-box">
            <div class="row">
                <input type="hidden" id="home_hospital_id" value="<?php echo $this->session->userdata('user_id') ?>">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 icon" align="left">
                    <i class="fa fa-hospital-o"></i>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 inner" align="right">
                    <div> 
                        <input type="radio" name="hospital_avaiability" value="Yes" class="hospital_avaiability" <?php if($this->session->userdata('hospital_avaiability') == 'Yes') echo 'checked'  ?> /> 
                        <label>Yes</label> 
                    </div>
                    <div> 
                        <input type="radio" name="hospital_avaiability" value="No" class="hospital_avaiability" <?php if($this->session->userdata('hospital_avaiability') == 'No') echo 'checked'  ?> /> 
                        <label>No</label> 
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12" align="center">
                    <h3>Hospital Availability</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <!-- small box -->
        <div class="card-display-box">
            <a href="/booking">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 icon" align="left">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 inner" align="right">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" align="right">
                        <h3>Booking</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <!-- small box -->
        <div class="card-display-box">
            <a href="/schedule/create">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 icon" align="left">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 inner" align="right">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" align="right">
                        <h3>Add Schedule</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php /*?>
<div class="row">
    <div class="col-md-3">
        <!-- small box -->
        <div class="card-display-box">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 icon" align="left">
                    <i class="fa fa-bed"></i>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 inner" align="right">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" align="right">
                    <h3>Manage Beds</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <!-- small box -->
        <div class="card-display-box">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 icon" align="left">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 inner" align="right">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" align="right">
                    <h3>Our Package</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?php */?>

<style>
    .row {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
</style>

<script>
    $(".hospital_avaiability").on('click', function() {
        var CSRF_TOKEN = $('#CSRF_TOKEN').val();
        var hospital_avaiability = $(this).val();
        var hospital_id = $('#home_hospital_id').val();

        $.ajax({
            url  : _baseURL+'hospital/update_hospital_avaibility/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                hospital_id : hospital_id,
                hospital_avaiability : hospital_avaiability,
            },
            success : function(data) 
            {
                alert('Hospital availability updated successfully.')
                location.replace("/dashboard/home");
            }, 
            error : function()
            {
                
            }
        });
    });
</script>
 