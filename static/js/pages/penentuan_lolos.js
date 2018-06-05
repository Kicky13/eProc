$(document).ready(function(){
	$(".cek_vendor").each(function(){
		
		var status_lulus = $(this).parent().parent().nextUntil(".vendor").find('.lulus_tech');
		var pqi_tec_val = $(this).parent().parent().nextUntil(".vendor").find('.pqi_tech_val_n');
		var state = false;
		status_lulus.each(function(){
			if($(this).text()=='Tidak'){
				state = true;
			}
		});
		pqi_tec_val.each(function(){
			if($(this).text() <= 0){
				state = true;
			}
		})
		$(this).prop('disabled',state);
    	
	});

	function nilai_total () {
		$(".nili_total").each(function(){
			$parent = $(this).parent();
			pqm = $(this).attr('pqm');
			tech = Number($("#tech-value" + pqm).html()) * $parent.children('.techweight').html();
			price = Number($("#price-value" + pqm).html()) * $parent.children('.priceweight').html();
			tot = tech + price;
			tot = tot/100;
			$(this).html(tot);
			if ($parent.children('.passing_grade').html() > tot) {
				lulus = 'Tidak';
				$parent.removeClass('success');
			} else {
				lulus = 'Lulus';
				$parent.addClass('success');
			}
			$parent.children('.lulus').html(lulus);
		})
	}

	nilai_total();

	$("form").submit(function(e) {
		// next = $("#next_process").val();
		// count = $(".checkvnd:checked").length;
		// // alert(next);
		// // alert(count);
		// if (next != 0 && count == 0) {
		// 	alert('Silahkan pilih vendor untuk melanjutkan proses.')
		// 	e.preventDefault(); // ini buat menggagalkan submit
		// } else if (count < 2 && !confirm('Jumlah vendor yang lolos kurang dari 2. Apakah anda yakin akan melanjutkan?')) {
		// 	e.preventDefault();
		// }
	});

	$(".close_bidding").click(function(id) {
		$(".modal").modal('hide');
	});
})