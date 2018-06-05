$('#setuju').change(function() {
	$(".stj").prop('disabled', true);
	if ($(this).is(":checked")) {
		$(".stj").prop('disabled', false);
	}
});
