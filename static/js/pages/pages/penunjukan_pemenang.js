function numberWithCommas(x) {
	var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}

$(document).ready(function(){
	$(".winradio").click(function() {
		td = $(this).parent();
		tr = td.parent();
		price = tr.find(".winprice").html()
		// console.log('price = ' + price)
		qty = tr.find(".itemqty").html()
		// console.log('qty = ' + qty)
		itemprice = tr.next();
		while (!itemprice.is('.tritemprice')) {
			itemprice = itemprice.next();
		}
		itemprice.find('.itemprice').html(price * qty);
		itemprice.find('.itempriceshow').html(numberWithCommas(price * qty));

		/* isi harga total */
		total = 0;
		$(".itemprice").each(function() {
			total += Number($(this).html());
		});
		$("#totalprice").html(numberWithCommas(total))
		// console.log('total = ' + total)
	});

	$(".vendorwinradio").click(function(){
		obj = $('.menang_'+$(this).val());
		var total = 0;
		$.each(obj,function(i,val){
			$(this).prop("checked",true);
			td = $(this).parent();
			tr = td.parent();
			price = tr.find(".winprice").html();
			qty = tr.find(".itemqty").html();
			itemprice = tr.next();
			while (!itemprice.is('.tritemprice')) {
				itemprice = itemprice.next();
			}
			itemprice.find('.itemprice').html(price * qty);
			itemprice.find('.itempriceshow').html(numberWithCommas(price * qty));

			/* isi harga total */			
			total += Number(itemprice.find('.itemprice').html());
		});
		$("#totalprice").html(numberWithCommas(total));
	});

	/* prevent submit jika ada material yang ga dipilih */
	$("form.submit").submit(function(e) {
		checked = $(".winradio:checked").length;
		total = Number($("#itemcount").val());
		if($('#next_process').val()==1){
			if (checked < total) {
				alert('Pilih pemenang pada setiap material');
				e.preventDefault();
			}
		}
	});
})