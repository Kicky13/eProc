function ikut(e){
	console.log("ea");
	if($(e).prop("checked",true)){
		$(".alasan").attr("disabled", true);
		$(".alasan").removeAttr("placeholder");
	}
}

function tidakikut(e){
	console.log("ea");
	if($(e).prop("checked",true)){
		$(".alasan").removeAttr("disabled");
		$(".alasan").attr("placeholder", "Alasan Tidak Ikut");
	}
}
