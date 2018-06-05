base_url = $("#base-url").val();

$('#modalholder').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var recipient = button.data('whatever')
	var modal = $(this)
	if (recipient == "new") {
		// modal.find('#PC_CODE').val('');
	}
});
$('#modaladdpartner').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var nama = button.data('nama')
	var id = button.data('id')
	var modal = $(this)
	modal.find('#principal').text(nama);
	loadTableBPA(id);
});

$('#modaledit').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var PC_CODE = button.data('pccode')
	var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Principal_manufacturer/getDetail/' + PC_CODE,
		type : 'get',
		dataType : 'json',
	}).done(function(data) {
		console.log(data.PC[0]);
		dt = data.PC[0];

		if (dt != null) {
			// $("#formUp").attr("action", "EC_Principal_manufacturer/upload/" + dt.PC_CODE);
			$("#PC_CODE_edit").val(dt.PC_CODE);
			$("#PC_NAME_edit").val(dt.PC_NAME);
			$("#CREATED_edit").val(dt.CREATEDBY + ", " + dt.CREATEDON);
			$("#LASTCHG_edit").val(dt.CHANGEDBY + ", " + dt.CHANGEDON);
			$("#COUNTRY_edit").val(dt.COUNTRY);
			$("#ADDRESS_edit").val(dt.ADDRESS);
			$("#PHONE_edit").val(dt.PHONE);
			$("#FAX_edit").val(dt.FAX);
			$("#WEBSITE_edit").val(dt.WEBSITE);
			$("#MAIL_edit").val(dt.MAIL);
			if (dt.LOGO != null) {
				$("#LOGO_edit").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_principal_manufacturer/" + dt.LOGO);
			} else {
				$("#LOGO_edit").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_principal_manufacturer/default_post_img.png");
			}
		}
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		// console.log(MATNR);
	});
	// loadTableDetail(PC_CODE);
	// $('#tableDetail').attr('style', '');
});

$('#modaldetail').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var PC_CODE = button.data('pccode')
	var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Principal_manufacturer/getDetail/' + PC_CODE,
		type : 'get',
		dataType : 'json',
	}).done(function(data) {
		console.log(data.PC[0]);
		dt = data.PC[0];

		if (dt != null) {
			$("#formUp").attr("action", "EC_Principal_manufacturer/upload/" + dt.PC_CODE);
			$("#PC_CODE_detail").val(dt.PC_CODE);
			$("#PC_NAME_detail").val(dt.PC_NAME);
			$("#CREATED_detail").val(dt.CREATEDBY + ", " + dt.CREATEDON);
			$("#LASTCHG_detail").val(dt.CHANGEDBY + ", " + dt.CHANGEDON);
			$("#COUNTRY_detail").val(dt.COUNTRY);
			$("#ADDRESS_detail").val(dt.ADDRESS);
			$("#PHONE_detail").val(dt.PHONE);
			$("#FAX_detail").val(dt.FAX);
			$("#WEBSITE_detail").val(dt.WEBSITE);
			$("#MAIL_detail").val(dt.MAIL);
			if (dt.LOGO != null) {
				$("#LOGO_detail").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_principal_manufacturer/" + dt.LOGO);
			} else {
				$("#LOGO_detail").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_principal_manufacturer/default_post_img.png");
			}
		}
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		// console.log(MATNR);
	});
	loadTableDetail(PC_CODE);
	// $('#tableDetail').attr('style', '');
});

function loadTableDetail(PC_CODE) {
	// no = 1;
	$('#tableDetail').DataTable().destroy();
	$('#tableDetail tbody').empty();
	mytable = $('#tableDetail').DataTable({
		"bSort" : true,
		"dom" : 'lrtip',
		"bAutoWidth" : false,
		"deferRender" : true,
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data Principal Manufacturer...</b></center>"
		},
		// "paging": true,
		// "lengthChange": true,
		// "lengthMenu": [ 10, 25, 50, 75, 100 ],
		//"scrollY": $( window ).height()/2,
		//"pagingType": "scrolling",

		"ajax" : $("#base-url").val() + 'EC_Principal_manufacturer/getTblDetail/' + PC_CODE,

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		"columns" : [{
			mRender : function(data, type, full) {
				// console.log(full);
				if (full[3] != null || full[4] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += '<a href="' + base_url + 'Vendor_list/detail/' + full[2] + ' " target="_blank">' + full[3] + "  " + full[4]
					"</a>";
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
				if (full[7] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += full[7];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[8] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[8];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[6] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[6];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}],
	});
}

var t0 = true,
    t1 = true,
    t2 = true,
    t3 = true,
    t4 = true,
    t5 = true,
    t6 = true,
    pccode;
function loadTable() {
	// no = 1;
	$('#tableMT').DataTable().destroy();
	$('#tableMT tbody').empty();
	mytable = $('#tableMT').DataTable({
		"bSort" : true,
		"dom" : 'lrtip',
		"deferRender" : true,
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data Item...</b></center>"
		},
		// "paging": true,
		// "lengthChange": true,
		// "lengthMenu": [ 10, 25, 50, 75, 100 ],
		//"scrollY": $( window ).height()/2,
		//"pagingType": "scrolling",

		"ajax" : $("#base-url").val() + 'EC_Principal_manufacturer/get_data',

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
					a += '<a href="javascript:void(0)" data-toggle="modal" data-target="#modaldetail" data-pccode="' + full[1] + '" >' + full[1] + '</a>';
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
		},{
			mRender : function(data, type, full) {
				// if(full[6] != null){
				a = ''
				a += "<div class='col-md-12 text-center'>";
				a += '<a href="javascript:void(0)" data-toggle="modal" data-target="#modaledit" data-pccode="' + full[1] + '"><span title="Edit" class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
				a += "</div>";
				return a;
				// }else return "";
			}
		}, {
			mRender : function(data, type, full) {
				//console.log(full[6]);
				return '<button type="button" class="btn btn-default" data-backdrop="true" data-toggle="modal" data-target="#modaladdpartner" data-nama="' + full[2] + '" data-id="' + full[1] + '">' + $("#btn2").val() + '</button>';
			}
		}],
	});
	/*
	 tolilul
	 */
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

var st0 = true,
    st1 = true,
    st2 = true,
    st3 = true,
    st4 = true,
    st5 = true,
    st6 = true;
function loadTableBPA(PC_CODE) {
	// no = 1;
	$('#tableBPA').DataTable().destroy();
	$('#tableBPA tbody').empty();
	mytable = $('#tableBPA').DataTable({
		"bSort" : true,
		"dom" : 'lrtip',
		"deferRender" : true,
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data Business Partner Assignment...</b></center>"
		},
		// "paging": true,
		// "lengthChange": true,
		// "lengthMenu": [ 10, 25, 50, 75, 100 ],
		//"scrollY": $( window ).height()/2,
		//"pagingType": "scrolling",

		"ajax" : $("#base-url").val() + 'EC_Principal_manufacturer/get_dataBPA/' + PC_CODE,

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
				if (full[6] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += full[6];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[7] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[7];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[8] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[8];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				//console.log(full[6]);
				if (full[9] != ("0"))
					return '<input type="checkbox" value="' + full[2] + '" class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-vndid="' + full[3] + '" data-r1id="' + full[10] + '" data-pccode="' + PC_CODE + '" onclick="chk(this)"  checked>'
				else
					return '<input value="' + full[2] + '" class="chk col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-vndid="' + full[3] + '" data-pccode="' + PC_CODE + '" onclick="chk(this)" type="checkbox">'
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

	$('#tableBPA').find("th").off("click.DT");

	$('.sts0').on('click', function() {
		if (st0) {
			mytable.order([0, 'asc']).draw();
			st0 = false;
		} else {
			mytable.order([0, 'desc']).draw();
			st0 = true;
		}
	});
	$('.sts1').on('click', function() {
		if (st1) {
			mytable.order([1, 'asc']).draw();
			st1 = false;
		} else {
			mytable.order([1, 'desc']).draw();
			st1 = true;
		}
	});
	$('.sts2').on('click', function() {
		if (st2) {
			mytable.order([2, 'asc']).draw();
			st2 = false;
		} else {
			mytable.order([2, 'desc']).draw();
			st2 = true;
		}
	});
	$('.sts3').on('click', function() {
		if (st3) {
			mytable.order([3, 'asc']).draw();
			st3 = false;
		} else {
			mytable.order([3, 'desc']).draw();
			st3 = true;
		}
	});
	$('.sts4').on('click', function() {
		if (st4) {
			mytable.order([4, 'asc']).draw();
			st4 = false;
		} else {
			mytable.order([4, 'desc']).draw();
			st4 = true;
		}
	});
	$('.sts5').on('click', function() {
		if (st5) {
			mytable.order([5, 'asc']).draw();
			st5 = false;
		} else {
			mytable.order([5, 'desc']).draw();
			st5 = true;
		}
	});
	$('.sts6').on('click', function() {
		if (st6) {
			mytable.order([6, 'asc']).draw();
			st6 = false;
		} else {
			mytable.order([6, 'desc']).draw();
			st6 = true;
		}
	});
}

function chk(ck) {
	var button = $(ck);
	var vndid = button.data('vndid');
	var pccode = button.data('pccode');
	var r1id = "-";
	if (button.data('r1id') != null) {
		r1id = button.data('r1id');
	};
	var stat = "0";
	if (button.is(":checked")) {
		stat = "1";
	}
	$.ajax({
		url : $("#base-url").val() + 'EC_Principal_manufacturer/ubahStat/' + pccode,
		data : {
			"checked" : stat,
			"VENDOR_ID" : vndid,
			"ID_R1" : r1id
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		loadTableBPA(pccode);
	});

}

function chk2(stat, recipient) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Principal_manufacturer/ubahStat/' + recipient,
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
		loadTableBPA();
	});

}


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

