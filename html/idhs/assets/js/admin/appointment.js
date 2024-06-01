$(document).ready(function() {
    "use strict";

    var CSRF_TOKEN = $('#CSRF_TOKEN').val();
    
    /*
    //check patient id
    $('#patient_id').on('keyup', function(){
        var pid = $(this);

        $.ajax({
            url  : _baseURL+'appointment/check_patient/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                patient_id : pid.val()
            },
            success : function(data) 
            {
                if (data.status == true) {
                    pid.next().text(data.message).addClass('text-success').removeClass('text-danger');
                } else if (data.status == false) {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });
 
    //department_id
    $("#department_id").on('change', function(){
        var output = $('.doctor_error'); 
        var doctor_list = $('#doctor_id');
        var available_day = $('#available_day');

        $.ajax({
            url  : _baseURL+'appointment/doctor_by_department/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                department_id : $(this).val()
            },
            success : function(data) 
            {
                if (data.status == true) {
                    doctor_list.html(data.message);
                    available_day.html(data.available_days);
                    output.html('');
                } else if (data.status == false) {
                    doctor_list.html('');
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    doctor_list.html('');
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    }); 


    //doctor_id
    $("#doctor_id").on('change', function(){
        var doctor_id = $('#doctor_id'); 
        var output = $('#available_days'); 

        $.ajax({
            url  : _baseURL+'appointment/schedule_day_by_doctor/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                doctor_id : $(this).val()
            },
            success : function(data) 
            {
                if (data.status == true) {
                    output.html(data.message).addClass('text-success').removeClass('text-danger');
                } else if (data.status == false) {
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });


    //date
    $("#date").on('change', function(){
        var date        = $('#date'); 
        var serial_preview   = $('#serial_preview'); 
        var doctor_id   = $('#doctor_id'); 
        var schedule_id = $("#schedule_id"); 
        var patient_id  = $("#patient_id"); 
 
        $.ajax({
            url  : _baseURL+'appointment/serial_by_date/',
            type : 'post',
            dataType : 'JSON',
            data : {
                'csrf_stream_token' : CSRF_TOKEN,
                doctor_id  : doctor_id.val(),
                patient_id : patient_id.val(), 
                date : $(this).val()
            },
            success : function(data) 
            { 
                if (data.status == true) {
                    //set schedule id
                    schedule_id.val(data.schedule_id); 
                    serial_preview.html(data.message);
                } else if (data.status == false) {
                    schedule_id.val('');
                    serial_preview.html(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    schedule_id.val('');
                    serial_preview.html(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });

    //serial_no 
    $("body").on('click','.serial_no',function(){
        var serial_no = $(this).attr('data-item');
        $("#serial_no").val(serial_no);
        $('.serial_no').removeClass('btn-danger').addClass('btn-success').not(".disabled");
        $(this).removeClass('btn-success').addClass('btn-danger').not(".disabled");
    });*/

    $( ".datepicker-avaiable-days" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        minDate: 0,   
    });

    /*$('#off_duty_days').on('select2:select', function (e) {
        var selectedValues = $("#off_duty_days").select2("val");
        $( "#leave_days" ).datepicker( "option", "addDates", function(date) { return ['05-02-2024'] } );
    });*/
});

//Add schedule functioality
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('#add_more_slots'); //Add button selector
    var wrapper = $('#more_slots_container'); //Input field wrapper
    var fieldHTML = '<div class="row" style="margin-top:10px;"><div class="col-xs-5"><input name="start_time[]" autocomplete="off" class="timepicker form-control" type="time" placeholder="Start time"></div><div class="col-xs-5"><input name="end_time[]" autocomplete="off" class="timepicker form-control" type="time" placeholder="Finish time"></div><div class="col-xs-2"><a href="javascript:void(0);" class="remove_button" style="color: red; font-size: 23px;"><i class="fa fa-minus-circle"></i></a></div></div>'; //New input field html 
    var slotsIncrementer = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(slotsIncrementer < maxField){ 
            slotsIncrementer++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
            /*$('.timepicker').timepicker({
                timeFormat: 'HH:mm:ss',
                stepMinute: 5,
                stepSecond: 15
            });*/
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        //$(this).parent('div').remove(); //Remove field html
        $(this).closest('.row').remove(); //Remove field html
        slotsIncrementer--; //Decrease field counter
    });
});

