selectize_vendor = null;


	function pilih() {
		var criteria = $("#criteria option:selected").data('value');	

		inputs = '';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][keterangan]" value="' + criteria.CRITERIA_NAME + ' | ' + criteria.CRITERIA_DETAIL + '">';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][criteria_id]" value="' + criteria.ID_CRITERIA + '">';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][sign]" value="' + criteria.CRITERIA_SCORE_SIGN + '">';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][skor]" value="' + criteria.CRITERIA_SCORE + '">';
		// alert(inputs);

		tbody = $("#kriteria-pilih").find('tbody');
		tr = $('<tr class="criteria_row">')
		.append('<td class="hidden">' + inputs + '</td>')
		.append('<td>' + criteria.CRITERIA_NAME + ' | ' + criteria.CRITERIA_DETAIL + '</td>')
		.append('<td class="text-center">' + criteria.CRITERIA_SCORE_SIGN + criteria.CRITERIA_SCORE + '</td>')
		.append('<td class="text-center"><button type="button" class="btn btn-danger" onclick="$(this).parent().parent().remove()">Hapus</button></td>')
		tbody.append(tr)
	}

	function pilih_vendor() {
		$selected = $("#pilih_vendor option:selected");
		options = selectize_vendor.getOption(selectize_vendor.items);
		console.log(options);

		vendor = options.find('.vendor_no').html();
		po = options.find('.po_no').html();
		console.log(vendor);
		console.log(po);

		$("#vendor_no").val(vendor);
		$("#po_no").val(po);
	}

	$(document).ready(function() {
		/* Activate selectize */
		if ($("#pilih_vendor").length > 0) {
			console.log($("#pilih_vendor"));
			$pilih_vendor = $("#pilih_vendor").selectize({
				render: {
					option: function(item, escape) {
						return '<div>' +
						'<span class="po_no">' + escape(item.PO_NUMBER) + '</span>' +
						'<br><small class="text-muted">' + 
							'<strong>Vendor No</strong> <span class="vendor_no">' + escape(item.VENDOR_NO) + '</span>' +
							'&nbsp;&nbsp;&nbsp;&nbsp;' +
							'<strong>Vendor Name</strong> <span class="vendor_name">' + escape(item.VENDOR_NAME) + '</span>' +
						'</small></div>';
					}
				},
			});
			selectize_vendor = $pilih_vendor[0].selectize;
		}
		//*/

		pilih_vendor();
		$("#pilih_vendor").change(pilih_vendor);

		$("form").submit(function(e) {

			if ($("#eproc").is(":checked") == true) {
				if ($("#vendor_no").val() == '' || $("#po_no").val() == '') {
					swal('Perhatian !', 'Pilih PO yang ingin dinilai.', 'warning')
					e.preventDefault();
                    return false;
				}
			} else {
				if ($("#po_no_man").val() == '') {
					swal('Perhatian !', 'Masukkan Nomor PO', 'warning')
					e.preventDefault();
                    return false;
				}

				if ($("#vendor_no_man").val() == '') {
					swal('Perhatian !', 'Pilih salah satu vendor', 'warning')
					e.preventDefault();
                    return false;
				}
			}

			if ($(".criteria_row").length <= 0) {
				swal('Perhatian !', 'Pilih minimal satu kriteria penilaian.', 'warning')
				e.preventDefault();
                return false;
			}


			var form = this;
            e.preventDefault();
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Pastikan Semua Data Yang Anda Masukkan Sudah Benar!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#92c135',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    cancelButtonText: "Tidak",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        form.submit();
                    } else {
                    }
                }) 
		});
	
	$(".select2").select2();

	$("#eproc").change(function(){
	    $(".sh_eproc").show();
	    $(".sh_non_peroc").hide();
	});

	$("#non_eproc").change(function(){
	    $(".sh_non_peroc").show();
	    $(".sh_eproc").hide();
	});

	$(".sh_non_peroc").hide();

	$("#vendor").change(function(){
		var veno = $("#vendor").val();
		$("#vendor_no_man").val(veno);
		$("#cek_eproc").val(1);
	})

	});