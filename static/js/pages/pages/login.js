$(document).ready(function() {
	$('#password').tooltip({placement: 'right', title:'Capslock is On'});
	$('#password').hover(function(){
		$('#password').tooltip('hide');
	}, function() {
		$('#password').tooltip('hide');
	});
	$('#password').focus(function(event) {
		if ($(window).capslockstate("state") === true) {
            $('#password').tooltip('show');
        }
        else {
        	$('#password').tooltip('hide');
        }
	});

	$(window).bind("capsOn", function(event) {
        if ($("#password:focus").length > 0) {
            $('#password').tooltip('show');
        }
        else {
        	$('#password').tooltip('hide');
        }
    });
    $(window).bind("capsOff capsUnknown", function(event) {
        $('#password').tooltip('hide');
    });
    $("#password").bind("focusout", function(event) {
        $('#password').tooltip('hide');
    });
    $("#password").bind("focusin", function(event) {
    	if ($("#password:focus").length < 0) {
    		$('#password').tooltip('hide');
    	}
        if ($(window).capslockstate("state") === true) {
            $('#password').tooltip('show');
        }
    });

    /* 
    * Initialize the capslockstate plugin.
    * Monitoring is happening at the window level.
    */
    $(window).capslockstate();
});