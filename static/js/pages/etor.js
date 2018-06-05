function open_dokumen(e) {
	pr = $("#prno").html();
	ppi = $(e).data('ppi');

	tr = $(e).parent().parent();
	nomat = tr.find(".nomat").html();

    // $("#modal_dokumen").find('.pr').html(pr);
    if ($('#doc_cat').val() == '9') {
    	$.ajax({
    		url: $("#base-url").val() + 'Snippet_ajax/pr_doc_service/' + ppi,
    		type: 'post',
    		dataType: 'html'
    	})
    	.done(function(data) {
    		$("#modal_dokumen").find(".modal_jasa").html(data);
    	})
    	.fail(function() {
    		console.log("error");
    	})
    	.always(function(data) {
    		console.log(data);
    	});
    }

    $("#modal_dokumen").find(".modal_longtext").html('Sedang mengambil data di SAP..');
    $.ajax({
    	url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi + '/' + nomat,
    	type: 'get',
    	dataType: 'html',
    })
    .done(function(data) {
    	$("#modal_dokumen").find(".modal_longtext").html(data);
    })
    .fail(function() {
    	console.log("error");
    	$("#modal_dokumen").find(".modal_longtext").html('Gagal mengambil data di SAP.');
    })
    .always(function(data) {
    	console.log(data);
    });

    $("#modal_dokumen").modal("show");
}
function loadLastUpdate() {
	$.ajax({
		url: base_url + 'Procurement_sap/get_latest_pr_sync',
		type: 'get',
		dataType: 'json',
	})
	.done(function(data) {
        //console.log(data);
        $("#last_update").html(data.DATE);
    })
	.fail(function() {
        //console.log("error");
    })

	$.ajax({
		url: base_url + 'Procurement_sap/sync_contract',
		type: 'get',
		dataType: 'json',
	});
}

function otomatisredirect() {
	var e = document.getElementById("NO_PR");
	var strUser = e.options[e.selectedIndex].value;
	var loaddt = $("#loaddt").val();
	window.location = $("#base-url").val() + 'Etor/'+loaddt+'/'+strUser;
}

function ValidateFileUploadECE() {
	var fuData = document.getElementById('ECE');
	var FileUploadPath = fuData.value;
	if (FileUploadPath == '') {
		alert("Please upload an Document");
	} else {
		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
		}
		else {
			document.getElementById("ECE").value = "";
			alert("Only allows file types of DOC, DOCX and PDF. ");
			return false;
		}
	}
}

function ValidateFileUploadLAIN() {
	var fuData = document.getElementById('LAIN');
	var FileUploadPath = fuData.value;
	if (FileUploadPath == '') {
		alert("Please upload an Document");
	} else {
		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
		}
		else {
			document.getElementById("LAIN").value = "";
			alert("Only allows file types of DOC, DOCX and PDF. ");
			return false;
		}
	}
}

function ValidateFileUploadBQ() {
	var fuData = document.getElementById('BQ');
	var FileUploadPath = fuData.value;
	if (FileUploadPath == '') {
		alert("Please upload an Document");
	} else {
		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
		}
		else {
			document.getElementById("BQ").value = "";
			alert("Only allows file types of DOC, DOCX and PDF. ");
			return false;
		}
	}
}

function ValidateFileUploadGAMBAR() {
	var fuData = document.getElementById('GAMBAR');
	var FileUploadPath = fuData.value;
	if (FileUploadPath == '') {
		alert("Please upload an Document");
	} else {
		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		if (Extension == "jpg" || Extension == "jpeg" || Extension == "png") {
		}
		else {
			document.getElementById("GAMBAR").value = "";
			alert("Only allows file types of JPG, JPEG, PNG. ");
			return false;
		}
	}
}


function loadTable () {
	mytable = $('#tbl_group_akses').DataTable({
		"bSort": false,
		"dom": 'rtip',
		"deferRender": true,

		"ajax" : $("#base-url").val() + 'Etor/get_datatable',

		"columnDefs": [{
			"searchable": false,
			"orderable": false,
			"targets": 0
		}],
		"columns":[
		{"data" : "FULLNAME"},
		{"data" : "ORDER_APPRV"},
		{
			mRender : function(data,type,full){
				button ='<button type="button" title="Item Status" data-id="'+full.ID_APP+'" class="btn btn-default btn-sm glyphicon glyphicon-trash delidapp"></button>';
				return button;
			}
		},
		],
	});

	mytable.columns().every( function () {
		var that = this;

		$( 'input', this.header() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that.search( this.value ).draw();
			}
		});
	});
}


function loadTableEdit () {
	var ID_TOR = $("#ID_TOR").val();
	mytable = $('#tbl_group_akses').DataTable({
		"bSort": false,
		"dom": 'rtip',
		"deferRender": true,

		"ajax" : $("#base-url").val() + 'Etor/get_datatable_edit/'+ID_TOR,

		"columnDefs": [{
			"searchable": false,
			"orderable": false,
			"targets": 0
		}],
		"columns":[
		{"data" : "FULLNAME"},
		{"data" : "ORDER_APPRV"},
		{
			mRender : function(data,type,full){
				if(full.IS_SUBMIT==0 || full.IS_SUBMIT=="0"){
					button ='<button type="button" title="Item Status" data-id="'+full.ID_APP+'" class="btn btn-default btn-sm glyphicon glyphicon-trash delidapp"></button>';
				} else {
					button = "-";	
				}
				return button;
			}
		},
		],
	});

	mytable.columns().every( function () {
		var that = this;

		$( 'input', this.header() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that.search( this.value ).draw();
			}
		});
	});
}


function loadTableEditKomen () {
	var ID_TOR = $("#ID_TOR").val();
	mytable = $('#tbl_group_akses_komentar').DataTable({
		"bSort": false,
		"dom": 'rtip',
		"deferRender": true,

		"ajax" : $("#base-url").val() + 'Etor/get_datatable_komen/'+ID_TOR,

		"columnDefs": [{
			"searchable": false,
			"orderable": false,
			"targets": 0
		}],
		"columns":[
		{"data" : "FULLNAME"},
		{"data" : "KOMEN"},
		{
			mRender : function(data,type,full){
				button = "-";	
				return button;
			}
		},
		],
	});

	mytable.columns().every( function () {
		var that = this;

		$( 'input', this.header() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that.search( this.value ).draw();
			}
		});
	});
}

function loadTableMain () {
	mytable = $('#tbl_group_akses').DataTable({
		"bSort": false,
		"dom": 'rtip',
		"deferRender": true,

		"ajax" : $("#base-url").val() + 'Etor/get_datatable_main',

		"columnDefs": [{
			"searchable": false,
			"orderable": false,
			"targets": 0
		}],
		"columns":[
		{"data" : "NO_TOR"},
		{"data" : "JENIS_TOR"},
		{"data" : "FULLNAME"},
		{
			mRender : function(data,type,full){
				if(full.IS_SUBMIT==0 || full.IS_SUBMIT=="0"){
					button = "DRAFT";	
				} else if(full.IS_SUBMIT==1 || full.IS_SUBMIT=="1"){
					button = "SUBMIT";	
				} else {
					button = "-";	
				}
				return button;
			}
		},
		{"data" : "NO_PR"},
		{
			mRender : function(data,type,full){
				if(full.IS_SUBMIT_PR==0 || full.IS_SUBMIT_PR=="0"){
					button = "DRAFT";	
				} else if(full.IS_SUBMIT_PR==1 || full.IS_SUBMIT_PR=="1"){
					button = "SUBMIT";	
				} else {
					button = "-";	
				}
				return button;
			}
		},
		{
			mRender : function(data,type,full){
				if(full.STATUS==0 || full.STATUS=="0"){
					button = 'REJECT <a data-id="'+full.ID_TOR+'" class="btn btn-default btn-sm getrejectreason" title="Current job holder">...</a>';	
				} else {
					button = "-";	
				}
				return button;
			}
		},
		{
			mRender : function(data,type,full){
				button ='<a href="'+$("#base-url").val() + 'Etor/edit/'+full.ID_TOR+'/'+full.NO_PR+'" data-id="'+full.ID_TOR+'" class="btn btn-default btn-sm glyphicon glyphicon-th-list" title="Detail TOR"></a>';
				button +='<a href="'+$("#base-url").val() + 'Etor/printtor/'+full.ID_TOR+'" data-id="'+full.ID_TOR+'" class="btn btn-default btn-sm glyphicon glyphicon-print" title="Print TOR"></a>';
				//button +='<a href="'+$("#base-url").val() + 'Etor/matchingPRTOR/'+full.ID_TOR+'" data-id="'+full.ID_TOR+'" class="btn btn-default btn-sm glyphicon glyphicon-share" title="Matching PR"></a>';
				button +='<a data-id="'+full.ID_TOR+'" class="btn btn-default btn-sm glyphicon glyphicon-user getposisi" title="Current job holder"></a>';
				return button;
			}
		},
		],
	});

	mytable.columns().every( function () {
		var that = this;

		$( 'input', this.header() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that.search( this.value ).draw();
			}
		});
	});
}

function loadTableMainApproval () {
	mytable = $('#tbl_group_akses').DataTable({
		"bSort": false,
		"dom": 'rtip',
		"deferRender": true,

		"ajax" : $("#base-url").val() + 'Etor/get_datatable_approval',

		"columnDefs": [{
			"searchable": false,
			"orderable": false,
			"targets": 0
		}],
		"columns":[
		{"data" : "NO_TOR"},
		{"data" : "JENIS_TOR"},
		{"data" : "NO_PR"},
		{"data" : "FULLNAME"},
		{
			mRender : function(data,type,full){
				button ='<a href="'+$("#base-url").val() + 'Etor/approve/'+full.ID_TOR+'/'+full.NO_PR+'" title="Item Status" data-id="'+full.ID_TOR+'" class="btn btn-default btn-sm">Proses</a>';
				return button;
			}
		},
		],
	});

	mytable.columns().every( function () {
		var that = this;

		$( 'input', this.header() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that.search( this.value ).draw();
			}
		});
	});
}


function loadTableGambar () {
	mytable = $('#tbl_group_akses').DataTable({
		"bSort": false,
		"dom": 'rtip',
		"deferRender": true,

		"ajax" : $("#base-url").val() + 'Etor/get_datatable_gambar',

		"columnDefs": [{
			"searchable": false,
			"orderable": false,
			"targets": 0
		}],
		"columns":[
		{
			mRender : function(data,type,full){
				button ='<a target="_blank" href="'+$("#base-url").val()+'upload/etor/'+full.GAMBAR+'"><img src="'+$("#base-url").val()+'upload/etor/'+full.GAMBAR+'" width="50" height="50"></a>';
				return button;
			}
		},
		{
			mRender : function(data,type,full){
				button =$("#base-url").val()+'upload/etor/'+full.GAMBAR;
				return button;
			}
		},
		{
			mRender : function(data,type,full){
				button ='-';
				return button;
			}
		},
		],
	});

	mytable.columns().every( function () {
		var that = this;

		$( 'input', this.header() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that.search( this.value ).draw();
			}
		});
	});
}

$(document).ready(function() {
	// $('.itemName').select2({
	// 	placeholder: '--- Select Item ---',
	// 	ajax: {
	// 		url: $("#base-url").val() + 'Etor/ambilDataSelect2',
	// 		dataType: 'json',
	// 		delay: 250,
	// 		processResults: function (data) {
	// 			return {
	// 				results: data
	// 			};
	// 		},
	// 		cache: true
	// 	}
	// });

	$('#checkAll').click(function(){
		chk = $(this).is(':checked');
		if(chk){
			$('.chek_all').prop('checked', true);
		}else{
			$('.chek_all').prop('checked', false);
		}
	});
	$('#renewPR').on("click",function() {
		mytable.destroy();
		if ($("#berdasarkan").val() == "mrp") {
			mrp = [];
			$(".cekmrp:checked").each(function() {
				mrp.push({mrp: $(this).data('mrp'),plant: $(this).data('plant')})
			});
			post = {
				filter: mrp, 
				by: $("#berdasarkan").val()
			};
		} else {
			post = {
				filter: $("#filter").val(), 
				by: $("#berdasarkan").val()
			};
		}
		console.log(post);
		$.post(base_url+"Procurement_sap/sync_pr_etor", post)
		.done(function() {
			loadLastUpdate();
			$("#modal-renew").modal("hide");
			location.reload(); 
		});
	})

	// alert($("#base-url").val()+'static/js/plugins/filemanager/index.html');
	var loaddt = $("#loaddt").val();
	if(loaddt=="create"){
		loadTable();
	} else if (loaddt=="main"){
		loadTableMain();
	} else if (loaddt=="edit"){
		loadTableEdit();
		loadTableEditKomen();
	} else if (loaddt=="mainapproval"){
		loadTableMainApproval();
	} else if (loaddt=="listgambar"){
		loadTableGambar();
	}

	if(loaddt=="create" || loaddt=="edit"){
		loadLastUpdate();
	}

	if(loaddt=="create" || loaddt=="edit"){
		// var editor_style = "replace";
		// CKEDITOR.replace( 'LATAR_BELAKANG' );
		// CKEDITOR.replace( 'MAKSUD_TUJUAN' );
		// CKEDITOR.replace( 'PENJELASAN_APP' );
		// // CKEDITOR.replace( 'PENJELASAN_APP', {
		// // 	// extraPlugins: 'imageuploader'
		// // 	filebrowserImageBrowseUrl : $("#base-url").val()+'static/js/plugins/filemanager/index.html'
		// // 	// filebrowserUploadUrl: $("#base-url").val() + "Etor/uploadgambarCKEeditor" 
		// // } );

		// CKEDITOR.replace( 'RUANG_LINGKUP' );
		// CKEDITOR.replace( 'PRODUK' );
		// CKEDITOR.replace( 'KUALIFIKASI' );
		// CKEDITOR.replace( 'TIME_FRAME' );
		// CKEDITOR.replace( 'PROSES_BAYAR' );
		// CKEDITOR.replace( 'KOMEN' );
		//$(".select2").select2();

		$('.pegawai').select2({
			minimumInputLength: 3,
			allowClear: true,
			placeholder: 'masukkan nama pegawai',
			ajax: {
				dataType: 'json',
				url: $("#base-url").val() + 'Etor/ambilDataSelect2',
				delay: 200,
				data: function(params) {
					return {
						search: params.term
					}
				},
				processResults: function (data, page) {
					return {
						results: data
					};
				},
			}
		}).on('select2:select', function (evt) {
			var data = $(".select2 option:selected").text();
			//alert("Data yang dipilih adalah "+data);
		});
	} 

	if(loaddt=="createprtor"){
		$(".select2").select2();
	}

	$("#vendor").change(function(){
		var veno = $("#vendor").val();
		$("#kd_vnd").val(veno);

		$.ajax({
			url:base_url+'Etor/getEmpname',
			method : 'post',
			data : "veno="+veno,
			dataType: 'json',
			success: function(data){
			}
		});
	})

	$('body').on('click', '.tambah_approval', function(){
		var id_emp = $("#kd_vnd").val();
		var ID_TOR = $("#ID_TOR").val();

		$.ajax({
			url:base_url+'Etor/doInsertEmp',
			method : 'post',
			// data : "id_emp="+id_emp,
			data: {id_emp: id_emp, ID_TOR: ID_TOR},
			dataType: 'json',
			success: function(data){
				$('#tbl_group_akses').DataTable().ajax.reload();
			}
		});
	})


	$('.gantievaluatorselect').hide();
	$('body').on('click', '.gantievaluator', function(){
		$('.gantievaluatorselect').show();
	})

	$('body').on('click', '.delidapp', function(){
		var id_emp = $(this).attr('data-id');
		$.ajax({
			url:base_url+'Etor/doDeleteEmp',
			method : 'post',
			data : "id_emp="+id_emp,
			dataType: 'json',
			success: function(data){
				$('#tbl_group_akses').DataTable().ajax.reload();
			}
		});
	})

	$('body').on('click', '.getposisi', function(){
		var ID_TOR = $(this).attr('data-id');
		$.ajax({
			url:base_url+'Etor/getHolder',
			method : 'post',
			data : "ID_TOR="+ID_TOR,
			dataType: 'json',
			success: function(data){
				$("#myModal").modal();
				$(".id_peg").html(data.ID);
				$(".nama_peg").html(data.FULLNAME);
				$(".email_peg").html(data.EMAIL);
			}
		});
	})

	$('body').on('click', '.getrejectreason', function(){
		var ID_TOR = $(this).attr('data-id');
		$.ajax({
			url:base_url+'Etor/getRejectReason',
			method : 'post',
			data : "ID_TOR="+ID_TOR,
			dataType: 'json',
			success: function(data){
				$("#myModalReject").modal();
				$(".reject_reason").html(data.REJECT_REASON);
			}
		});
	})
})