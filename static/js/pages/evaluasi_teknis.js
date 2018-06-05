function angka(evt) {
	var charCode = (evt.which) ;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	    return false;
	}
	return true;
}
function hitungTotal(e){
	val = Number($(e).val());
	if (val < 0) val = 0
	if (val > 100) val = 100
	$(e).val(val);
	nilai = val;

	/* get DET_TIT */
	tr = $(e).parent();
	deu_tit = tr.find(".deu_tit").val();
	deu_vnd = tr.find(".deu_vnd").val();
	deu_ppd_id = tr.find(".deu_ppd_id").val();
	weight_detail = Number(tr.parent().find(".weight_detail").html());
	deu_id_pptu = tr.find(".deu_id_pptu").val();
	console.log('DEU_TIT = ' + deu_tit)

	det = null;
	$(".det_tit").each(function() {
		det_vnd = $(this).parent().find(".det_vnd").val();
		det_ppd_id = $(this).parent().find(".det_ppd_id").val();
		if ($(this).val() == deu_tit && det_ppd_id==deu_ppd_id && det_vnd==deu_vnd) {
			det = $(this);
			det_tit2 = $(this).val();
			det_ppd_id2 = det.parent().find(".det_ppd_id").val();
			det_vnd2 = det.parent().find(".det_vnd").val();
			det2=$(this).parent();
			return;
		}
	});

	if (det == null) {
		console.log('det_tit = null. why?')
		return;
	}

	/* get trnya DET */
	tddet = det.parent();
	weight = Number(tddet.parent().find('.weight').html());
	
	/* Hitung total deu_val dengan det_id yang sama */
	total = 0;
	count = 0;
	tal = 0;
	deu_tit22 = 0;
	$('.deu_val').each(function() {
		deu_tit2 = $(this).parent().find(".deu_tit").val();
		deu_ppd_id2 = $(this).parent().find(".deu_ppd_id").val();
		deu_vnd2 = $(this).parent().find(".deu_vnd").val();
		if (deu_tit==deu_tit2 && deu_ppd_id==deu_ppd_id2 && deu_vnd==deu_vnd2) {
			total += Number($(this).val());
			deu_tit22=deu_tit2;
			deu_ppd_id22=deu_ppd_id2;
			deu_vnd22=deu_vnd2;

			deu2 = $(this).parent();
			wght_dtl = Number(deu2.parent().find(".weight_detail").html());
			deu_id_pptu22 = deu2.find(".deu_id_pptu").val();
			if(weight_detail != 0 && deu_id_pptu != deu_id_pptu22){
				tal += Number($(this).val()) * wght_dtl / 100; 
			}

			count++;
		}
	});

	/* Masukkan ke tiap parent item evaluasi */
	console.log('Total = ' + total)
	console.log('Count = ' + count)
	console.log('Weight = ' + weight)
	console.log('Weight_detail = ' + weight_detail)

	if(weight_detail != 0){
		wg = weight_detail;
		cn = 1;
		tot = nilai;
	}else{
		wg = weight;
		cn = count;
		tot = total;
	}
	console.log('('+tot+'*'+wg+'/'+cn+'/'+100+')+'+tal);

	tech = (tot * wg / cn / 100)+tal;
	tech = Math.ceil(tech);
	console.log('Tech = ' + tech);

	if (det_tit2 == deu_tit22 && det_ppd_id2==deu_ppd_id22 && det_vnd2==deu_vnd22) {
		det2.find(".det_val").val(tech);
		det2.find(".det_span").html(tech);
	}

	tech = 0
	$(".det_val").each(function() {
		det_tit = $(this).parent().find(".det_tit").val();
		det_vnd = $(this).parent().find(".det_vnd").val();
		console.log('finding det_tit = ' + det_tit);
		console.log('finding det_vnd = ' + det_vnd);

		if (deu_tit == det_tit && deu_vnd == det_vnd) { 
			thisval = Number($(this).val());
			tech += thisval;
			console.log('Jumlahin nilai evatek + ' + thisval);
		}
	});
	console.log("Nilai evateknya = " + tech);

	/* Masukin nilai totalnya */
	$(".inpt_tech").each(function() {
		tech_tit = $(this).parent().find(".tech_tit").val();
		tech_vnd = $(this).parent().find(".tech_vnd").val();

		if (deu_tit == tech_tit && deu_vnd == tech_vnd) {
			console.log('Masukin nilai evatek = ' + tech)
			$(this).val(tech);
			$(this).parent().find('.span_tech').html(tech);
		}
	});
}
function hitung(e) {
	val = Number($(e).val());
	if (val < 0) val = 0
	if (val > 100) val = 100
	$(e).val(val);
	nilai = val;

	/* get DET_ID */
	tr = $(e).parent();
	det_id = tr.find(".det_id_deu").val();
	console.log('DET_ID = ' + det_id)
	deu_id = tr.find(".deu_id").val();
	weight_detail = Number(tr.parent().find(".weight_detail").html());

	det = null;
	$(".det_id").each(function() {
		if ($(this).val() == det_id) {
			det = $(this);
			return;
		}
	});

	if (det == null) {
		console.log('det = null. why?')
		return;
	}

	/* get trnya DET */
	tddet = det.parent();
	weight = Number(tddet.parent().find('.weight').html())

	/* Hitung total deu_val dengan det_id yang sama */
	total = 0;
	count = 0;
	tal = 0;
	$('.deu_val').each(function() {
		det_id_deu = $(this).parent().find(".det_id_deu").val();
		if (det_id_deu == det_id) {
			total += Number($(this).val())

			deu2 = $(this).parent();
			wght_dtl = Number(deu2.parent().find(".weight_detail").html());
			deu_id2 = deu2.find(".deu_id").val();
			if(weight_detail != 0 && deu_id != deu_id2){
				tal += Number($(this).val()) * wght_dtl / 100; 
			}
			console.log('total weight detail = ' + tal);

			count++;
		}
	});

	/* Masukkan ke tiap parent item evaluasi */
	console.log('Total = ' + total)
	console.log('Count = ' + count)
	console.log('Count = ' + count)

	if(weight_detail != 0){
		wg = weight_detail;
		cn = 1;
		tot = nilai;
	}else{
		wg = weight;
		cn = count;
		tot = total;
	}
	console.log('('+tot+'*'+wg+'/'+cn+'/'+100+')+'+tal);

	tech = (tot * wg / cn / 100)+tal;

	//tech = total * weight / count / 100;
	tech = Math.ceil(tech);
	console.log('Tech = ' + tech)
	tddet.find(".det_val").val(tech);
	tddet.find(".det_span").html(tech);

	/* Hitung nilai total evaluasi */
	tit = tddet.find(".det_tit").val();
	vnd = tddet.find(".det_vnd").val();
	console.log('det_tit = ' + tit);
	console.log('det_vnd = ' + vnd);

	tech = 0
	$(".det_val").each(function() {
		det_tit = $(this).parent().find(".det_tit").val();
		det_vnd = $(this).parent().find(".det_vnd").val();
		console.log('finding det_tit = ' + det_tit);
		console.log('finding det_vnd = ' + det_vnd);

		if (tit == det_tit && vnd == det_vnd) {
			thisval = Number($(this).val())
			tech += thisval
			console.log('Jumlahin nilai evatek + ' + thisval)
		}
	});
	console.log("Nilai evateknya = " + tech)

	/* Masukin nilai totalnya */
	$(".inpt_tech").each(function() {
		tech_tit = $(this).parent().find(".tech_tit").val();
		tech_vnd = $(this).parent().find(".tech_vnd").val();

		if (tit == tech_tit && vnd == tech_vnd) {
			console.log('Masukin nilai evatek = ' + tech)
			$(this).val(tech);
			$(this).parent().find('.span_tech').html(tech);
		}
	});
}

function cekaktifdeufunction(e) {
	$tr = $(e).parent().parent();
	deuval = null;
	if ($(e).is(':checked')) {
		deuval = $tr.find('.deu_valse');
		deuval.prop('disabled', false);
		deuval.addClass('deu_val');
		deuval.removeClass('deu_valse');
		$tr.removeClass('danger');
	} else {
		deuval = $tr.find('.deu_val');
		deuval.prop('disabled', 'disabled');
		deuval.val(0);
		deuval.addClass('deu_valse');
		$tr.addClass('danger');
		deuval.removeClass('deu_val');
	}	
	deuval.each(function() {
		hitungTotal(this);
	});
}

$(document).ready(function(){

	$('#bayangan').hide()
	$(window).scroll(function() {
		if ($(this).scrollTop() > 127) {
			$('#bayangan').show()
			$('#bayangan').css('height', $('.fixed-compare-gbr').height())
			$('#bayangan').css('width', $('.fixed-compare-gbr').width())
			$('.fixed-compare').addClass('fixed');
			$('.fixed-compare-gbr').addClass('fixed-gbr');
			$('#gbr').css('width', $('#isi').width())
			$('.fixed-compare-gbr').css('width', $('#konten').width())
			$('#headh').css('width', $('#konten').width())
		} else {
			$('#bayangan').hide()
			$('.fixed-compare').removeClass('fixed');
			$('.fixed-compare-gbr').removeClass('fixed-gbr');

		}
	});
	$('#isi').scroll(function() {
		$('#label').scrollTop($(this).scrollTop());
	});
	$('#isi').scroll(function() {
		$('#gbr').scrollLeft($(this).scrollLeft());
	});

	$(".tambahfile").click(function(event){
        count = $(".numberfiles").val();
        console.log(count);
        count = Number(count) + Number(1);
        $(".divfiles").append("<div class='row'><div class='col-md-5'><input name='add_doc"+count+"' type='file' class='form-control' style='margin-top:1%;'></div><div class='col-md-7'><input name='name_doc"+count+"' type='text' class='form-control' placeholder='Keterangan'></div></div>");
        $(".numberfiles").val(count);
        event.preventDefault();
    });

	if ($("#deptselect").length > 0) {
		$selectdept = $("#deptselect").selectize();
		$selectuser = $("#user").selectize();
		selectizeuser = $selectuser[0].selectize;
	}

	$(".cekaktifdeu").each(function() {
		cekaktifdeufunction(this);
	});
	
	$(".deu_val").change(function() {
		hitung(this);
	});

	$(".deu_val").each(function() {
		hitung(this);
	});

	$("#deptselect").change(function() {
		deptval = $("#deptselect").val();
		if (deptval == '' || deptval == null) {
			return;
		}
		$.ajax({
			url: $("#base-url").val() + 'Evaluasi_penawaran/get_emp/' + deptval,
			type: 'get',
			dataType: 'json',
		})
		.done(function(data) {
			if (data.emps == null) {
				alert('Tidak ditemukan user dengan departmen ini.');
				return;
			}
			userselect = $("#user");
			selectizeuser.clear();
			selectizeuser.clearOptions();
			userselect.html('<option value="">Pilih User</option>');
			// selectizeuser.addOption({value: emp.ID, text: emp.FULLNAME});
			for (var i = 0; i < data.emps.length; i++) {
				emp = data.emps[i];
				userselect.append('<option value="'+emp.ID+'">'+emp.FULLNAME+'</option>')
				selectizeuser.addOption({value: emp.ID, text: emp.FULLNAME});
			};
			selectizeuser.refreshOptions()
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
		
	});

	$(".cekaktifdeu").change(function() {
		cekaktifdeufunction(this);
	});

	$(".close_bidding").click(function(id) {
		$(".modal").modal('hide');
	});

	$('#selectIdTemplate').click(function() {
        $('#templateModal').modal('show');
        id = $('#id_company').val();
        if(id=='2000' || id=='5000' || id=='7000'){
        	id='2000';
        }
        $('#companyId').val(id);
        populateTable(id);
    });

    $("#companyId").change(function() {
		populateTable($('#companyId').val());
		$('#detailTemplt').hide();
        $('#detail-tmp1').hide();
	});

    var template_table = null;
    function populateTable(id) {
        /* Populating the  table */
        if (template_table != null) {
            template_table.destroy();
        }
        i = 1;
        template_table = $('#template-table').DataTable( {
            "ajax": $("#base-url").val() + 'Procurement_pengadaan/get_all_template/'+id,
            "columnDefs": [{
                "searchable": true,
                "orderable": false,
                "targets": 0
            }],
            "dom": 'rtip',
            "order": [[ 1, 'asc' ]],
            "columns": [
                { "data": null },
                { "data": "EVT_NAME" },
                { "data": "EVT_TYPE_NAME" },
                { "data": "COMPANY" },
                {
                    mRender : function(data,type,full){
                    return '<button type="button" class="btn btn-default btn-xs pull-right">Detail</button>'
                }}
            ],
        });
        template_table.on('draw', function () {
            template_table.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        $("#template-table").removeAttr('style');
    }

    base_url = $("#base-url").val();
    $('#template-table tbody').on( 'click', 'tr', function () {
        $("#template-table tbody tr").removeClass('success');
        $(this).addClass('success');
        var data = template_table.row($(this)).data();
        var elem = template_table.row($(this));
        // console.log(elem);
        // console.log(data);
        $('#eval_id').val(data.EVT_NAME);
        $('#evt_id').val(data.EVT_ID);

        id = data.EVT_ID;
		id_ptm = $('#ptm_number').val();
        var html = '';
        //var html2 = '';
        $.ajax({
            url : $("#base-url").val() + 'Evaluasi_penawaran/get_evaluasi_detail/',
            dataType : 'html',
            method : 'post',
            data : {id, id_ptm},
            success : function(results){
	            $('#template_detail').html(results);
	            $('.new_temp').click(function(){
			        $(this).toggleClass('ex_temp').nextUntil('tr.new_temp').slideToggle(0);
			    });
	        },
	        fail : function(results){
                console.log(results);
            }
        });

    });
    $('#template-table tbody').on( 'click', 'button', function () {
        var data = template_table.row($(this).parents('tr')).data();
        var html = '';
        var judul = $('#detail-template-judul');
        var elem = $('#detail-template-table tbody');
        $.ajax({
            url : $("#base-url").val() + 'Procurement_template/get_template_detail/' + data.EVT_ID,
            dataType : 'json',
            success : function(results){
                if(results) {
                    eval = results['eval'];
                    result = results['detail'];
                    //console.log(result);
                    if(result.length > 1) {
                        html += '<tr><td><strong>ID</strong></td><td>:</td><td>'+ eval.EVT_ID + '</td></tr>';
                        html += '<tr><td><strong>Tipe</strong></td><td>:</td><td>' + eval.EVT_TYPE_NAME + '</td></tr>';
                        html += '<tr><td><strong>Nama</strong></td><td>:</td><td>' + eval.EVT_NAME + '</td></tr>';
                        html += '<tr><td><strong>Passing Grade</strong></td><td>:</td><td>' + eval.EVT_PASSING_GRADE + '</td></tr>';
                        html += '<tr><td><strong>Bobot Teknis</strong></td><td>:</td><td>' + eval.EVT_TECH_WEIGHT + '</td></tr>';
                        html += '<tr><td><strong>Bobot Harga</strong></td><td>:</td><td>' + eval.EVT_PRICE_WEIGHT + '</td></tr>';
                        judul.empty();
                        judul.append(html);
                        html = '';
                        count = 1;
                        for(var key in result) {
                            var obj = result[key];
                            var mode = '';
                            var weight = '';
                            if(obj.PPD_MODE == '1')
                            {
                                mode = 'Fix';
                                bbt = ' &nbsp;&nbsp;&nbsp;&nbsp; Bobot = ';

                            } else {
                                mode = 'Dinamis';
                                bbt = '';
                            }   

                            html += '<tr><td class="text-center">'+count+'</td><td><strong>'+obj.PPD_ITEM+'</strong><ul class="listnya col-md-offset-1 list-circle"><ul>';
                            for(var key2 in obj.uraian) {
                                obj2 = obj.uraian[key2];
                                if(obj2.PPTU_WEIGHT){
                                	weight_pptu = obj2.PPTU_WEIGHT;
                                }else{
                                	weight_pptu = '';
                                }
                                html += '<li>' + obj2.PPTU_ITEM + bbt + weight_pptu +'</li>';
                            }
                            html += '</ul></td><td class="text-center">'+mode+'</td><td class="text-center">'+obj.PPD_WEIGHT+'</td></tr>';      
                            count++;
                            // console.log(html);   
                        }
                    } else {
                        $('#detail-tmp1').hide();
                        for(var key in result) {
                            var obj = result[key];
                            var mode = '';
                            var weight = '';
                            if(obj.PPD_MODE == '1')
                            {
                                mode = 'Fix';
                                weight = '-';
                            } else {
                                mode = 'Dinamis';
                                weight = obj.PPD_WEIGHT;
                            }

                            html += '<tr><td>'+1+'</td><td>'+obj.PPD_ITEM+'</td><td>'+mode+'</td><td>'+weight+'</td></tr>';
                            //console.log(result);
                        }
                    }
                    elem.empty();
                    elem.append(html);
                } else {
                    $('#detailTemplt').hide();
                    $('#detail-tmp1').hide();
                }
            }
        });

        //console.log(html);
        $('#detailTemplt').hide();
        $('#detailTemplt').show();
        $('#detail-tmp1').hide();
        $('#detail-tmp1').show();
    });

	var progressBar = $('.progress-bar'),
        progressOuter = $('.progress-striped');
    $('.uploadAttachment').each(function(event) {
        var btn     = $(this),
            msgBox  = $($(btn).siblings('span.messageUpload')[0]);
        var uploader = new ss.SimpleUpload({
            button: btn,
            url: $("#base-url").val() + 'Evaluasi_penawaran/uploadAttachment',
            name: 'uploadfile',
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'html', 'zip'],
            maxSize: 2048,
            multipart: true,
            hoverClass: 'hover',
            focusClass: 'focus',
            responseType: 'json',
            startXHR: function() {
                progressOuter.css('display','block'); // make progress bar visible
                this.setProgressBar( progressBar );
            },
            onSubmit: function() {
                console.log($(this));
                msgBox.html(''); // empty the message box
                btn.html('Uploading...'); // change button text to "Uploading..."
            },
            onSizeError: function() {
                $.magnificPopup.open({
                    items: {
                        src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>File size exceeds limit.</p></div>',
                        type: 'inline'
                    },
                    mainClass:'my-mfp-zoom-in',
                    preloader:false,
                    midClick:true,
                    removalDelay:300,
                });
            },
            onExtError: function() {
                $.magnificPopup.open({
                    items: {
                        src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>Invalid file type.</p></div>',
                        type: 'inline'
                    },
                    mainClass:'my-mfp-zoom-in',
                    preloader:false,
                    midClick:true,
                    removalDelay:300,
                });
                // $.magnificPopup.close();
            },
            onComplete: function( filename, response ) {
                progressOuter.css('display','none'); // hide progress bar when upload is completed
                msgBox.css('display','inline');
                if ( !response ) {
                    $.magnificPopup.open({
                        items: {
                            src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>Unable to upload file.</p></div>',
                            type: 'inline'
                        },
                        mainClass:'my-mfp-zoom-in',
                        preloader:false,
                        midClick:true,
                        removalDelay:300,
                    });
                    return;
                }

                if ( response.success === true ) {
                    console.log($(btn).siblings('input')[0]);
                    $($(btn).siblings('input')[0]).val(response.newFileName);
                    btn.html('Change File');
                    btn.css('color','black');

                    btn.parent().find('.filenamespan').html(' &nbsp; File Uploaded');
                    btn.data('uploaded', true);
                    msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_file">Delete</a><script>$(".delete_upload_file").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (2MB Max)");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

                } else {
                    if ( response.msg )  {
                        msgBox.html(escapeTags( response.msg ));

                    } else {
                        $.magnificPopup.open({
                            items: {
                                src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>An error occurred and the upload failed.</p></div>',
                                type: 'inline'
                            },
                            mainClass:'my-mfp-zoom-in',
                            preloader:false,
                            midClick:true,
                            removalDelay:300,
                        });
                    }
                }
            },
            onError: function(filename, type, status, statusText, response, uploadBtn, size) {
                console.log(filename, type, status, statusText, response, uploadBtn, size);
                progressOuter.css('display','none');
                $.magnificPopup.open({
                    items: {
                        src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>Unable to upload file.</p></div>',
                        type: 'inline',
                        preloader:false,
                        midClick:true,
                        removalDelay:300,
                    }
                });
            }
        });
    });

    $('.del_upload_file').click(function(){
        $.ajax({
            url: $("#base-url").val() + 'Evaluasi_penawaran/deleteFile/'+$("#file_pesan").val(),
            type: 'POST',
            data: {},
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');
            $(".uploadAttachment").html('Upload File');
            $('.filenamespan').html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });

    $('#save_chat').click(function(){
    	vendor = $('#vendor_pesan').val();
    	isi_pesan = $('#isi_pesan').val();
    	file_pesan = $('#file_pesan').val();
    	ptm_number = $('#ptm_number').val();
    	ptm_status = $('#ptm_status').val();

    	if(vendor=='' || isi_pesan==''){
    		swal("Error!", "Pilih Vendor dan Isi Klarifikasi tidak boleh kosong.", "error");
			return;
    	}

        $.ajax({
            url : $("#base-url").val() + 'Evaluasi_penawaran/save_pesan/',
            dataType : 'html',
            method : 'post',
            data : {ptm_number, ptm_status, vendor, isi_pesan, file_pesan},
            beforeSend: function() {
                progressOuter.css('display','block');
            },
            success : function(data){
	            progressOuter.css('display','none');
	            $(".uploadAttachment").html('Upload File');
	            $('.filenamespan').html('');
	            $('.kosong').val('');
	            swal("Berhasil", "Pesan Berhasil dikirim.", "success");
	            $('#history_pesan').html(data);
	        },
	        fail : function(data){
                progressOuter.css('display','none');
	            console.log("error");
	            console.log(data);
            }
        });

    });

	$("#vendor_pesan").change(function(){
		vendor_no = $(this).val();
		ptm_number = $('#ptm_number').val();
		$.ajax({
            url : $("#base-url").val() + 'Evaluasi_penawaran/filter_chat_vendor/',
            dataType : 'html',
            method : 'post',
            data : {vendor_no, ptm_number},
            beforeSend: function() {
                progressOuter.css('display','block');
            },
            success : function(data){
	            progressOuter.css('display','none');
	            $('#history_pesan').html(data);
	        },
	        fail : function(data){
                progressOuter.css('display','none');
	            console.log("error");
	            console.log(data);
            }
        });
	});

	$("#search").click(function(){
		
		disable_from_assign_search();

		company = $('#nama_company').val();
		unit = $('#nama_unit').val();
		posisi = $('#nama_posisi').val();
		pegawai = $('#nama_pegawai').val();

		$.ajax({
            url : $("#base-url").val() + 'Evaluasi_penawaran/search_assign/',
            dataType : 'html',
            method : 'post',
            data : {company, unit, posisi, pegawai},
            beforeSend: function() {
            	$('#data_assign').html('proses..');
                progressOuter.css('display','block');
            },
            success : function(data){
	            progressOuter.css('display','none');
	            $('#data_assign').html(data);
	        },
	        fail : function(data){
                progressOuter.css('display','none');
	            console.log("error");
	            console.log(data);
            }
        });
	});

	$('.eva_col').click(function(){
	    $(this).toggleClass('ex_eva').nextUntil('tr.eva_col').slideToggle(0);
	});

	$('.eva_col').each(function(){
	    $(this).toggleClass('ex_eva').nextUntil('tr.eva_col').slideToggle(0);
	});

});

progressOuter = $('.progress-striped');
function replay(id){
	$.ajax({
        url : $("#base-url").val() + 'Evaluasi_penawaran/replay_pesan/',
        dataType : 'json',
        method : 'post',
        data : {id},
        beforeSend: function() {
            progressOuter.css('display','block');
        },
        success : function(data){
            progressOuter.css('display','none');
            $('#vendor_pesan').val(data.VENDOR_NO);
			$('#isi_pesan').focus();
        },
        fail : function(data){
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        }
    });

}

function disable_from_assign_search(){
	$('#form_assign input[type="text"]').on('keyup keypress',function(e){
		var keyCode = e.keyCode || e.which;
		  if (keyCode === 13) { 
		    e.preventDefault();
		    return false;
		  }
	})
}
