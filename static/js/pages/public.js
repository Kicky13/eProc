$(document).ready(function(){
	$(".harusmilih_publicjs").change(function(){
		val = $(this).val();
		if(val != "false_public"){
			$(".milihtombol_publicjs").removeAttr('disabled');
			$(".milihtombol_publicjs").removeClass('color7');
			$(".milihtombol_publicjs").addClass('color6');
		} else {
			$(".milihtombol_publicjs").attr('disabled','disabled');
			$(".milihtombol_publicjs").removeClass('color6');
			$(".milihtombol_publicjs").addClass('color7');
		}
	});

	 //hanya angka yang dapat dientry
	$(".r_number").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
		{
			return false;
		}
	});

});