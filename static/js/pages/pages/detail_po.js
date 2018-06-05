$(document).ready(function(){
	console.log("tes");
	var total = 0;
    $('.price').each(function(){
    	parent = $(this).parent();
    	satuan = parent.find(".satuan").html();

        price = $(this).html();

        subtotal = Number(satuan) * Number(price);
        parent.find(".subtotal").html(subtotal);
        total = Number(total) + Number(subtotal);
    })

    $('#total').html('<strong>' + total + '</strong>');
})