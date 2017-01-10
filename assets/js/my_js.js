
schedule                 = new Object();
urlNow                   = new Object();
schedule.bgRowColorClose = '#fba2a2';
schedule.bgRowColorOpen  = 'white';
urlNow.local_url         = 'http://localhost/practice/wordpress';



function bpc_as_schedule_close(petsa)
{

    attr_id           = "#bpc-as-row-schedule-"+petsa;
    attr_select_id    = "#bpc-as-row-schedule-"+petsa+ " select";
    attr_checkbox_id  = "#bpc-as-row-schedule-"+petsa+ " .agenda-event input";
    attr_message_id   = "#bpc-as-row-schedule-"+petsa+ " message";

    // set open or close shedule
    var bg = $(attr_id).css('background-color');
    console.log(bg);
    if(bg == 'rgb(251, 162, 162)') {
        // white bg color
        $(attr_id).css({'background-color':schedule.bgRowColorOpen});
        // disable select dropdown
        $(attr_select_id).prop("disabled", false);
        $(attr_checkbox_id).prop("disabled", false);
        // change css select dropdown
        $(attr_select_id).css({'cursor': 'pointer', 'background-color':'white'});
        // set close message empty
        $(attr_message_id).html("");
    } else {
        // red bg color
        $(attr_id).css({'background-color':schedule.bgRowColorClose});
        // disable select dropdown
        $(attr_select_id).prop("disabled", true);
        $(attr_checkbox_id).prop("disabled", true);
        // change css select dropdown
        $(attr_select_id).css({'cursor': 'not-allowed', 'background-color':schedule.bgRowColorClose});
        // set close message not empty
        $(attr_message_id).html("<em>Colosed All Day</em>");
    }
}

function bpc_init() {

    show_save_button(); 

    var date = $("#bpc-as-datepicker").val();

    var option = $("#bpc-as-bookTimeSorting:checked").val();  //'book exact time';

    // console.log(" booking type value " + option); 

    $("#bpc-as-schedule-loader").css({'display':'block'});
    $.get( urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/load-schedule.php?date="+date+"&option=&base=date_picker", function( data ) {

        $('#bpc-as-schedule-settings-content-and-type').html(data);

        $("#bpc-as-schedule-loader").css({'display':'none'});
    });
}

function bpc_as_schedule_change_date(e)
{
    show_save_button(); 

    var option = $("#bpc-as-bookTimeSorting:checked").val();  //'book exact time';

    console.log(" booking type value " + option); 

    $("#bpc-as-schedule-loader").css({'display':'block'});
    $.get( urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/load-schedule.php?date="+e.value+"&option="+option+"&base=date_picker", function( data ) {

        $('#bpc-as-schedule-settings-content-and-type').html(data);

        $("#bpc-as-schedule-loader").css({'display':'none'});
    });
}
function bpc_as_schedule_type(option)
{
    show_save_button(); 
    
    var date = $("#bpc-as-datepicker").val();
    $("#bpc-as-schedule-loader").css({'display':'block'});
    $.get( urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/load-schedule.php?date="+date+"&option="+option+"&base=schedule_type", function( data ) {

        $('#bpc-as-schedule-settings-content').html(data);

        $("#bpc-as-schedule-loader").css({'display':'none'});
    });
}
function bpc_as_save_schedule()
{

    $("#bpc-as-schedule-update-loader").attr('style', 'display:inline; visibility: visible;');
    $("#bpc-as-schedule-update-loader-message").html('loading..').attr('style', 'visibility:visible'); 
    
    

    $.post( urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/save-schedule.php", $( "#testform" ).serialize() )
        .done(function( data ) {
            $("#bpc-as-schedule-update-loader").attr('style', 'display:inline; visibility: hidden;');
            $("#bpc-as-schedule-update-loader-message").html("<span style='color:green'>updated..</span>").attr('style', 'visibility:visible');  
            console.log( "Data Loaded: " + data );
        });
}


function show_save_button()
{
    $("#bpc-as-save-schedule-container").css('display', 'block');
}


