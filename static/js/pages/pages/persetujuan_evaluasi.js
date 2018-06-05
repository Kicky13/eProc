$(document).ready(function(){
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
	$(".vendor-modal").click(function(id) {
		pqm_id = $(this).attr('value');
		$.ajax({
			url: $("#base-url").val() + "Persetujuan_evaluasi/modal_teknis_ajax/" + pqm_id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(data) {
			console.log("success");

			$("#bobot_teknis").html(data.ptp.EVT_TECH_WEIGHT);
			$("#passing_grade").html(data.ptp.EVT_PASSING_GRADE);

			$tabel = $("#tabel_evaluasi_teknis");
			$tabel.html("");
			for (var i = 0; i < data.ppd.length; i++) {
				x = data.ppd[i];
				val = x.QQT_VALUE == null ? '0' : x.QQT_VALUE;
				desc = x.QQT_VENDOR_DESC == null ? '' : x.QQT_VENDOR_DESC;
				$tabel.append($("<tr>").append(
						$("<td class=\"text-center\">").html(i-0+1),
						$("<td>").html(x.PPD_ITEM),
						$("<td class=\"text-center\">").html(x.PPD_WEIGHT),
						$("<td class=\"hidden\">").html('<input name="qqt['+i+'][id]" value="'+x.PPD_ID+'">'),
						$("<td class=\"text-center\">").html(desc),
						$("<td class=\"text-center\">").html(val)
					));
			};
			
			$("#nilai_teknis").val(data.pqe.PQE_TECHNICAL_VALUE);
			$("#remark").val(data.pqe.PQE_TECHNICAL_REMARK);
			$(".vendor_name").html(data.pqm[0].VENDOR_NAME);
			$(".vendor_code").val(data.pqm[0].PTV_VENDOR_CODE);

			/* eval file */
			$table = $("#evalfile");
            $table.html("");
            pqf = data.pqf;
            for (var i = 0; i < pqf.length; i++) {
                // console.log(pqf[i]);
                tr = '<tr>' +
                        '<td class="col-md-3">'+ pqf[i].PQF_DESC+'</td>' +
                        '<td class="col-md-1 text-right">:</td>' +
                        '<td><a href="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + 'quo_file/' + pqf[i].PQM_ID + '/' + pqf[i].PQF_FILE + '" download>Download</a></td>' +
                    '</tr>'
                $table.append(tr);
            };
            //*/
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
			$("#technical-grade").modal('show');
		});
		
	});
	$("#deptselect").change(function() {
		$.ajax({
			url: $("#base-url").val() + 'Persetujuan_evaluasi/get_emp/' + $("#deptselect").val(),
			type: 'get',
			dataType: 'json',
		})
		.done(function(data) {
			userselect = $("#user");
			userselect.html('<option value="">Pilih User</option>');
			for (var i = 0; i < data.emps.length; i++) {
				emp = data.emps[i];
				userselect.append('<option value="'+emp.ID+'">'+emp.FULLNAME+'</option>')
			};
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
		
	});
	$(".comparison-modal").click(function(id) {
		pqm_id = $(this).attr('value');
		$.ajax({
			url: $("#base-url").val() + "Persetujuan_evaluasi/modal_ajax/" + pqm_id,
			type: 'GET',
			dataType: 'json'
		})
		.done(function(data) {
			pqi = data.pqi;
			pqm = data.pqm[0];
			pte = data.pte;
			$body = $("#item-body").html('');
			total = 0;
			totalv = 0;
			for (var i = 0; i < pqi.length; i++) {
				item = pqi[i];
				total += item.TIT_PRICE * item.TIT_QUANTITY - 0;
				totalv += item.PQI_PRICE * item.TIT_QUANTITY - 0;

				$tr = $("<tr>").append(
					$('<td class="text-center">').append(Number(i + 1)),
					$('<td>').append(item.PPI_DECMAT),
					$('<td>').append(item.TIT_PRICE * item.TIT_QUANTITY),
					$('<td>').append(item.PQI_PRICE * item.TIT_QUANTITY)
				);
				$body.append($tr);
			}
			$("#total").html(total);
			$("#totalv").html(totalv);
			ppn = total*10/100;
			ppnv = totalv*10/100;
			$("#ppn").html(ppn);
			$("#ppnv").html(ppnv);
			totalppn = total - ppn;
			totalppnv = totalv - ppnv;
			$("#totalppn").html(totalppn);
			$("#totalppnv").html(totalppnv);
			$("#bidbondv").html(pqm.PQM_BID_BOND_VALUE);
			$(".vendor_name").html(pqm.VENDOR_NAME);
			$(".vendor_code").val(pqm.PTV_VENDOR_CODE);
			if (pte != null) {
				pte = pte[0];
				console.log(pte);
				$("#price-value").val(pte.PTE_PRICE_VALUE);
				$("#price-remark").val(pte.PTE_PRICE_REMARK);
				if (pte.PTE_VALIDITY_OFFER == 1) {
					$("#validity-offer").attr('checked', true);
				}
				if (pte.PTE_VALIDITY_BID_BOND == 1) {
					$("#validity-bid-bond").attr('checked', true);
				}
			} else {
				$("#price-value").val('');
				$("#price-remark").val('');
				$("#validity-offer").attr('checked', false);
				$("#validity-bid-bond").attr('checked', false);
			}
		})
		.fail(function(data) {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
		
		$("#cost-comparison").modal('show');
	});

	$("#save-price").click(function() {
		$.ajax({
			url: $("#base-url").val() + 'Persetujuan_evaluasi/save_evaluation',
			type: 'POST',
			dataType: 'json',
			data: $("#form-nilai-harga").serialize(),
		})
		.done(function() {
			alert("Berhasil.");
			selector = "#price-value" + pqm_id;
			value = $("#price-value").val();
			$(selector).html(value);
			nilai_total();
			$(".modal").modal('hide');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
		
	});

	$("#save-tech").click(function() {
		$.ajax({
			url: $("#base-url").val() + 'Persetujuan_evaluasi/save_tech',
			type: 'POST',
			dataType: 'json',
			data: $("#form-nilai-teknis").serialize(),
		})
		.done(function() {
			alert("Berhasil.");
			selector = "#tech-value" + pqm_id;
			value = $("#nilai_teknis").val();
			$(selector).html(value);
			nilai_total();
			$(".modal").modal('hide');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
	});

	$(".close_bidding").click(function(id) {
		$(".modal").modal('hide');
	});
})