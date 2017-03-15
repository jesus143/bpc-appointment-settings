schedule                 = new Object();
urlNow                   = new Object();
schedule.bgRowColorClose = '#fba2a2';
schedule.bgRowColorOpen  = 'white';  

urlNow.local_url         = $("#bpc_as_rool_url").val(); 
/** when break dropdown is changed, then capture this area and allow everytime changed need to update database for settings  */
function bpc_change_break(day) 
{ 
    $('#break-time-update-loader-'+day).css('display', 'block');  
    url = urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/standard/standard-update-break.php";   
    $.post( url,  $( "."+ day + "_form_class" ).serialize() ) 
    .done(function( data ) {
        console.log( "Data Loaded: " + data );
        $('#break-time-update-loader-'+day).css('display', 'none'); 
    });  
}

/**
 *  Set schedule close status 
 */
function bpc_as_schedule_close(petsa)
{ 
    attr_id           = "#bpc-as-row-schedule-"+petsa;
    attr_select_id    = "#bpc-as-row-schedule-"+petsa+ " select";
    attr_input_id     = "#bpc-as-row-schedule-"+petsa+ " input[type='button']";
    attr_checkbox_id  = "#bpc-as-row-schedule-"+petsa+ " .agenda-event input";
    attr_message_id   = "#bpc-as-row-schedule-"+petsa+ " message";
    attr_table_id     = "#bpc-as-row-schedule-"+petsa+ " table"; 
    var bg = $(attr_id).css('background-color');
    console.log(bg);
    if(bg == 'rgb(251, 162, 162)') {
        // white bg color
        $(attr_id).css({'background-color':schedule.bgRowColorOpen});
        // disable select dropdown
        $(attr_select_id).prop("disabled", false);
        $(attr_checkbox_id).prop("disabled", false);
        $(attr_input_id).prop("disabled", false);
        // change css select dropdown
        $(attr_select_id).css({'cursor': 'pointer', 'background-color':'white'});
        $(attr_input_id).css({'cursor': 'pointer', 'background-color':'white'});
        $(attr_table_id).css({'background-color':'white'});
        // change).css({'background-color':'white'});
        // set close message empty
        $(attr_message_id).html("");
    } else {
        // red bg color
        $(attr_id).css({'background-color':schedule.bgRowColorClose});
        // disable select dropdown
        $(attr_select_id).prop("disabled", true);
        $(attr_checkbox_id).prop("disabled", true);
        $(attr_input_id).prop("disabled", true);
        // change css select dropdown
        $(attr_select_id).css({'cursor': 'not-allowed', 'background-color':schedule.bgRowColorClose});
        $(attr_input_id).css({'cursor': 'not-allowed', 'background-color':schedule.bgRowColorClose});
        $(attr_table_id).css({'background-color':schedule.bgRowColorClose}); 
        // set close message not empty
        $(attr_message_id).html("<em>Close All Day</em>");
    }
}

/**
 * Initialized data schedule load when page is loaded. 
 */
function bpc_init() {  
    // alert("Nice test"); 
    console.log("loaded data"); 
    show_save_button();  
    var date = $("#bpc-as-datepicker").val(); 
    var option = $("#bpc-as-bookTimeSorting:checked").val();  //'book exact time'; 
    // console.log(" booking type value " + option);  
    $("#bpc-as-schedule-loader").css({'display':'block'}); 
    // set url based on the page type
    var page = $("#bpc_kind_of_page").val(); 
    console.log( " current page " + page)
    var url = '';
    if(page == 'standard') { 
        $("#standard-settings-loader").css('display', 'block');      
        url = urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/standard/standard-load-schedule.php?date="+date+"&option=&base=date_picker";
    } else {
        url = urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/load-schedule.php?date="+date+"&option=&base=date_picker";
    } 
    console.log(" url " + url); 
    $.get( url, function( data ) { 
        $( "#bpc-as-schedule-settings-content-and-type" ).html(data);  
        $("#bpc-as-schedule-loader").css({'display':'none'}); 
        $("#standard-settings-loader").css('display', 'none');      
    });
}
/**
 * load schedule, select date
 */
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
/**
 * Load schedule
 */
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

/**
 * save and update schedule
 */
function bpc_as_save_schedule(type)
{

    var url = '';

    if(type == 'standard') {
        url = urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/standard/standard-save-schedule.php"
    } else {
        url = urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/save-schedule.php"
    }

    $("#bpc-as-schedule-update-loader").attr('style', 'display:inline; visibility: visible;');

    $("#bpc-as-schedule-update-loader-message").html('loading..').attr('style', 'visibility:visible'); 

     var formValues = $( "#testform" ).serialize();

     console.log(formValues);


    console.log(" url " + url );

    $.post( url, formValues )
        .done(function( data ) {
            $("#bpc-as-schedule-update-loader").attr('style', 'display:inline; visibility: hidden;');
            $("#bpc-as-schedule-update-loader-message").html("<span style='color:green'>updated..</span>").attr('style', 'visibility:visible');  
            console.log( "Data Loaded: " + data );
        });
}

/**
 * Show buttons 
 */
function show_save_button()
{ 
    $("#bpc-as-save-schedule-container").css('display', 'block');
}

/**
 * Append time to breaks
 */
function bpc_as_add_time_break(strDate, type, day)
{ 
    /** loader */
    $("#break-time-update-loader-"+day).css("display", "block"); 

    /**
    *  initialized data  
    */
    var url = ''; 
 
    /**
    * Set url for standard schedule and non standard schedule
    */
    if(type == "standard") {  
        url = urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/standard/standard-load-break-design.php?strDate="+strDate+"&day="+day;
    } else {
        url = urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/load-break-design.php?strDate="+strDate; 
    }  

    /**
    *  Print status in console
    */
    console.log("clicked add break time url = " + url); 
  
    /**
    * Send get request to generate the ui for break, 
    * it must be saved automatically to database together with ui generate 
    */
    $.get( url ) 
    .done(function( data ) {
        $('#bpc-as-break-time-container-'+strDate).append(data);
        console.log("add new break time design");
        $("#break-time-update-loader-"+day).css("display", "none"); 
    });  
}

/**
 * delete standard break, allow delete break standard
 */
function bpc_as_delete_time_standard_break(breakId, strDate, day)
{
    if(confirm("Are you sure you want to delete this break?")) { 
        console.log( "#bpc-as-break-time-content-container-"+breakId+"-"+strDate); 
        $('#bpc-as-break-time-content-container-'+breakId+'-'+strDate).remove();  
        bpc_change_break(day)   
    }
}

/**
 * Allow for custom break
 */
function bpc_as_delete_time_break(breakId, strDate)
{
    //$('#bpc-as-break-time-content-container-'+strDate).remove();
    if(confirm("Are you sure you want to delete this break?")) { 
        console.log( "#bpc-as-break-time-content-container-"+breakId+"-"+strDate); 
        $('#bpc-as-break-time-content-container-'+breakId+'-'+strDate).remove(); 

        bpc_change_break(day)
        
         /*
         var breakTime = $( "#bpc-as-break-time-container-form-"+strDate ).serialize();
         // remove from database
         $.post( urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/load-delete-break-time.php", breakTime) 
         .done(function( data ) { 
             if(data == true) {
                 // remove li element
                 $('#bpc-as-break-time-content-container-'+strDate).remove();
                 console.log("Break successfully deleted");
             } else {
                 console.log("something wrong, failed to delete break");
             }
         })
        .fail(function() {
             alert( "Error something wrong." );
        })
         */
     }
}

/**
 * custom update break
 */
function bpc_as_update_time_break(strDate)
{   
    //if(confirm("Are you sure you want to update this break?")) {
        // get all the breaks
        $("#bpc-loader-break-time-"+strDate).css('display', 'block');
        var breakTime = $( "#bpc-as-break-time-container-form-"+strDate ).serialize();
        console.log( " id " + "#bpc-as-break-time-container-"+strDate + " = " + breakTime);
        // remove from database
        $.post( urlNow.local_url + "/wp-content/plugins/bpc-appointment-settings/includes/ajax/load-update-break-time.php",
            breakTime)
            .done(function( data ) {
                $("#bpc-message-break-time-"+strDate).html("<small>Updated..</small>");
                console.log("Updated..");
                $("#bpc-loader-break-time-"+strDate).css('display', 'none');
            })    
            .fail(function() {
                $("#bpc-message-break-time-"+strDate).html("Error something wrong.");
                $("#bpc-loader-break-time-"+strDate).css('display', 'none');
                alert( "Error something wrong." );
            });

    //}
}

/**
 * open window when page loaded, this will allow generate the google calendar
 */
function openWindowAndCloseAfterPageLoaded(link){
    console.log("open popup");
    var temp = window.open(link, "mywindow","menubar=1,resizable=1,width=350,height=250");
    temp[temp.addEventListener ? 'addEventListener' : 'attachEvent']( (temp.attachEvent ? 'on' : '') + 'load', function() {
        console.log("reload page now");
        window.location.reload();
        temp.close();
    }, false );
} 

/** 
 * Initialized data, show calendar when page is loaded
 */
$(document).ready(function(){

     bpc_init();
}); 