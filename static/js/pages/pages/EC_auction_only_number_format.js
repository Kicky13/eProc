function numberWithCommas(x) {
	if (isNaN(x))
		return x;
	var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}

function numberWithDot(x) {
	return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function removeCommas(x) {
	return x.replace(/,/g, "");
}
function removeDot(x) {
	return x.replace(/\./g, "");
}



$(document).ready(function() {
	$(".format-koma").keyup(function() {
		if ($(this).val() < 0 || $(this).val().search(/[A-Za-z]/g) != -1)
			$(this).val(1)
		else
			$(this).val(numberWithDot(removeDot($(this).val())))
	})

})
