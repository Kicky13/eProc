$(document).ready(function(){
	/* pas buka modal, kan ngambil data dari qqt gitu. skalian setting buat form ntar.  */
	$(".vendor-modal").click(function(id) {
		param = $(this).attr("ptm") + "/" + $(this).attr("vnd");
		vnd = $(this).attr("vnd");
		vnd_name = $(this).children('u').html();
		$("#vendor_name").html(vnd_name);
		$.ajax({
			url: $("#base-url").val() + 'Penawaran/qqt_ajax/' + param,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(data) {
			console.log("success");
			$table = $("#item-table");
			$table.html("");
			for (var i = 0; i < data.length; i++) {
				x = data[i];
				var checked = '';
				if (x.QQT_CHECK == 1) {
					checked = 'checked';
				}
				$table.append($("<tr>").append(
					$("<td>").html(Number(i) + 1),
					$("<td>").html(x.QQT_ITEM + '<input type="hidden" name="qqt['+i+'][id]" value="'+x.QQT_ID+'">'),
					$('<td class="text-center">').html('<input type="checkbox" checked disabled>'),
					$('<td class="text-center">').html('<input type="checkbox" '+checked+' name="qqt['+i+'][check]">')
				))
			}
			$("#ptv_code").val(vnd);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
		
		$("#vendor-administration").modal('show');
	});

	$("#save_bidding").click(function(id) {
		$.ajax({
			url: $("#base-url").val() + 'Penawaran/save_admin_ajax',
			type: 'POST',
			dataType: 'json',
			data: $("#verification-form").serialize(),
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
		
		alert('Success');
		$("#vendor-administration").modal('hide');
	});

	$("#close_bidding").click(function(id) {
		$("#vendor-administration").modal('hide');
	});
	
	
})