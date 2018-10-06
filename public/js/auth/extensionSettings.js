/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#extensionSettings').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#settings_submit').click(function() {

var background = $('#background').val();

var username = $('#session_identifier').val();
var password = $('#session_token').val();

if(background == 1) {
    $('#backgrounddiv').removeClass("bg1");
    $('#backgrounddiv').removeClass("bg2");
} else if (background == 2) {
    $('#backgrounddiv').removeClass("bg2");
    $('#backgrounddiv').addClass("bg1");
} else if (background == 3) {
    $('#backgrounddiv').removeClass("bg1");
    $('#backgrounddiv').addClass("bg2");
}

$.ajax({
    url: baseUrl + 'settings/extension-settings',
    type: 'post',
    data: {
        background: background
    },
    headers: {
        Authorization: "Basic " + btoa(username + ":" + password)
    },
    dataType: 'json',
    success: function (feedback) {
        $('#feedback_message').html(feedback.messages.join('<br />'));

        // display error messages properly through our alert div
        if( feedback.success == false) {
            $('#alert_div').removeClass('is-success'); 
            $('#alert_div').addClass('is-error'); 
            $('#alert_title').html('Whoops, error o.O');
        } else if(feedback.success == true) {
            $('#alert_div').removeClass('is-error');
            $('#alert_div').addClass('is-success'); 
            $('#alert_title').html('Wohoo, success!');

            setTimeout(function(){
                $('#alert_div').removeClass('is-success');
            }, 2000);
        }

        if(feedback.success == true) {
            document.getElementById("securitySettings").reset();
            $('#settings_submit').prop('disabled', true);

            setTimeout(function() {
                $('#settings_submit').prop('disabled', false);
            }, 3000);
        }
    }
});
    
});


