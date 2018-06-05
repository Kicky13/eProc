$(document).ready(function() {

	$(":file").filestyle({buttonText: " Find file"});
	$('.startDate').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });
});
