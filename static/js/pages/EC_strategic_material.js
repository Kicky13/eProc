base_url = $("#base-url").val();

/*
 MATNR(Material number),
 MAKTX(shortext),
 MTART(material type),
 MEINS(uom),
 MATKL(material group),
 ERNAM (creator),
 ERSDA(create on),
 AENAM(changed by),
 LAEDA(last change);
 NO (longtext item ke ...),
 TDLINE (Long Text)
 *
 */
function openmodal(MATNR) {
	// MATNR='341-107-0083';//341-107-0083  301-200410
	$.ajax({
		url : $("#base-url").val() + 'EC_Strategic_material/getDetail/' + MATNR,
		type : 'get',
		dataType : 'json',
	}).done(function(data) {
		console.log(data.MATNR[0]);
		dt = data.MATNR[0];
		if (dt != null) {
			$("#formUp").attr("action", "EC_Strategic_material/upload/" + dt.MATNR);
			$("#MATNR").val(dt.MATNR);
			$("#MAKTX").val(dt.MAKTX);
			$("#MTART").val(dt.MTART);
			$("#MEINS").val(dt.MEINS);
			$("#MATKL").val(dt.MATKL);
			$("#TAG").val(dt.TAG);
			$("#created").val(dt.ERNAM + ", " + dt.ERSDA.substring(6) + "-" + dt.ERSDA.substring(4, 6) + "-" + dt.ERSDA.substring(0, 4));
			$("#lastChg").val(dt.AENAM + ", " + dt.LAEDA.substring(6) + "-" + dt.LAEDA.substring(4, 6) + "-" + dt.LAEDA.substring(0, 4));
			if (dt.PICTURE != null || dt.DRAWING != null) {
				$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + dt.PICTURE);
				$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + dt.DRAWING);
			} else {
				$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
				$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
			}
			if (dt.LNGTX != null) {
				$("#TDLINE").val(dt.LNGTX);
			} else
				$("#TDLINE").val("");
			$("#modalholder").modal('show')
		}
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		// console.log(MATNR);
	});
}

function SAPsUpdate() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Strategic_material/sapUpdate/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$('#tableMT').DataTable().destroy();
		$('#tableMT tbody').empty();
		loadTable();
	});
}

var t0 = true,
    t1 = true,
    t2 = true,
    t3 = true,
    t4 = true,
    t5 = true,
    t6 = true;
function loadTable() {
	// no = 1;
	mytable = $('#tableMT').DataTable({
		"bSort" : true,
		"dom" : 'lrtip',
		"deferRender" : true,
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data Strategic Material Assignment...</b></center>"
		},
		// "paging": true,
		// "lengthChange": true,
		// "lengthMenu": [ 10, 25, 50, 75, 100 ],
		//"scrollY": $( window ).height()/2,
		//"pagingType": "scrolling",

		"ajax" : $("#base-url").val() + 'EC_Strategic_material/get_data',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		"columns" : [{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full[0];
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				// console.log(full);
				if (full[1] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += '<a href="javascript:void(0)" onclick="openmodal(\'' + full[1] + '\')" >' + full[1] + '</a>';//.replace(/^0+/g,"")
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[2] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += full[2];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[3] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[3];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[4] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += full[4];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[5] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[5];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				// if(full[6] != null){
				a = ''
				a += "<div class='col-md-12 text-center'>";
				a += full[6];
				a += "</div>";
				return a;
				// }else return "";
			}
		}, {
			mRender : function(data, type, full) {
				//console.log(full[6]);
				if (full[10] == ("") || full[10] == ("0")){
                    return '<input value="' + full[1] + '" class="chk col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-matnr="' + full[1] + '" onclick="chk(this)" type="checkbox">'
				} else {
                    return '<input type="checkbox" value="' + full[1] + '" class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-matnr="' + full[1] + '" onclick="chk(this)"  checked>' + full[10]
				}
				// if (full[7] != ("0"))
				// 	return '<input type="checkbox" value="' + full[1] + '" class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-matnr="' + full[1] + '" onclick="chk(this)"  checked>'
				// else
				// 	return '<input value="' + full[1] + '" class="chk col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-matnr="' + full[1] + '" onclick="chk(this)" type="checkbox">'
			}
		},{
			mRender : function(data, type, full) {
				// if(full[6] != null){
				a = ''
				a += "<div class='col-md-12 text-center'>";
				a += full[8];
				a += "</div>";
				return a;
				// }else return "";
			}
		},{
			mRender : function(data, type, full) {
				//console.log(full[6]);
				return '<button type="button" class="btn btn-default" data-backdrop="true" data-toggle="modal" data-target="#modalkategori" data-nama="' + full[2] + '" data-id="' + full[1] + '">' + 'Pilih Kategori'/*$("#btn2").val()*/ + '</button>';
			}
		}],
	});
	/*
	 class="btn btn-default btn-sm glyphicon glyphicon-check"
	 */
	mytable.columns().every(function() {
		var that = this;

		$('.srch', this.header()).on('keyup change', function() {
			if (that.search() !== this.value) {
				that.search(this.value).draw();
			}
		});
		$('input:checkbox', this.header()).on('keyup change', function() {
			var a = [];
			if ($('#checkAll:checked').length === 1) {
				$('input:checkbox', mytable.table().body()).prop('checked', true);
				$('input:checkbox', mytable.table().body()).each(function() {
					a.push(this.value);
					chk2("1", this.value);
				});
			} else if ($('#checkAll:checked').length === 0) {
				$('input:checkbox', mytable.table().body()).prop('checked', false);
				$('input:checkbox', mytable.table().body()).each(function() {
					a.push(this.value);
					chk2("0", this.value);
				});
			}

			console.log(a);
		});
	});

	$('#tableMT').find("th").off("click.DT");

	$('.ts0').on('click', function() {
		if (t0) {
			mytable.order([0, 'asc']).draw();
			t0 = false;
		} else {
			mytable.order([0, 'desc']).draw();
			t0 = true;
		}
	});
	$('.ts1').on('click', function() {
		if (t1) {
			mytable.order([1, 'asc']).draw();
			t1 = false;
		} else {
			mytable.order([1, 'desc']).draw();
			t1 = true;
		}
	});
	$('.ts2').on('click', function() {
		if (t2) {
			mytable.order([2, 'asc']).draw();
			t2 = false;
		} else {
			mytable.order([2, 'desc']).draw();
			t2 = true;
		}
	});
	$('.ts3').on('click', function() {
		if (t3) {
			mytable.order([3, 'asc']).draw();
			t3 = false;
		} else {
			mytable.order([3, 'desc']).draw();
			t3 = true;
		}
	});
	$('.ts4').on('click', function() {
		if (t4) {
			mytable.order([4, 'asc']).draw();
			t4 = false;
		} else {
			mytable.order([4, 'desc']).draw();
			t4 = true;
		}
	});
	$('.ts5').on('click', function() {
		if (t5) {
			mytable.order([5, 'asc']).draw();
			t5 = false;
		} else {
			mytable.order([5, 'desc']).draw();
			t5 = true;
		}
	});
	$('.ts6').on('click', function() {
		if (t6) {
			mytable.order([6, 'asc']).draw();
			t6 = false;
		} else {
			mytable.order([6, 'desc']).draw();
			t6 = true;
		}
	});
}

function chk(ck) {
	var button = $(ck);
	var recipient = button.data('matnr');
	var stat = "0";
	if (button.is(":checked")) {
		stat = "1";
	}
	$.ajax({
		url : $("#base-url").val() + 'EC_Strategic_material/ubahStat/' + recipient,
		data : {
			"checked" : stat
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$('#tableMT').DataTable().destroy();
		$('#tableMT tbody').empty();
		loadTable();
	});

}

function chk2(stat, recipient) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Strategic_material/ubahStat/' + recipient,
		data : {
			"checked" : stat
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$('#tableMT').DataTable().destroy();
		$('#tableMT tbody').empty();
		loadTable();
	});

}

$('#modalkategori').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var nama = button.data('nama')
	var id = button.data('id')
	var modal = $(this)
	modal.find('#nama_material').val(nama);
	modal.find('#CODE_M').val(id);
	$("#Category").val('');
	$("#CODE_Category").val('');
	console.log('nama: ', nama);
	//loadTableBPA(id);
});

$(document).ready(function() {
	loadTable();
	$('input:file').bind('change', function() {
		if (this.files[0].size > 500000) {
			alert('Ukuran file maksimum 500KB.');
			this.value = '';
		} else {
			var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext) {
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
				break;
			default: {
				//$('#uploadButton').attr('disabled', true);
				alert('Kesalahan tipe file.');
				this.value = '';
			}
			}
		}

	});

});

