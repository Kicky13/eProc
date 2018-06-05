var base_url = $('#base-url').val();
table_vendor_performance_freeze = null;

$('.input-group.date').datetimepicker({
	format: 'DD-MMM-YY',
	// format: 'DD-MMM-YY HH:mm',
	// sideBySide: true,
	ignoreReadonly: true
});

$('.input-group.date input').attr("readonly", true);

function populate_table(periode_awal,periode_akhir) {
	if (table_vendor_performance_freeze != null) {
		table_vendor_performance_freeze.destroy();
	}
	
	table_vendor_performance_freeze = $('#vendor_freeze_list').DataTable( {
        "bSort": false,
		"dom": 'rtip',
		// "processing": true,
		"ajax": {
			url: base_url + "Vendor_performance_freeze/get_all_vendor_freeze",
			type: 'POST',
			data: {awal:periode_awal,akhir:periode_akhir}
		},
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
		"columns":[
            {"data" : null},
			{"data" : "VENDOR_NO", "sClass": "text-center"},
			{"data" : "VENDOR_NAME"},
			{"data" : "DATE_CREATED"},
			{"data" : "POIN_CURR", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					return '<form id="detail_freeze" name="detail_freeze[]" action="'+base_url+'Vendor_performance_freeze/detail_vendor_freeze" method="POST"><input type="hidden" name="VENDOR_NO" value="'+full.VENDOR_NO+'"/><input type="hidden" name="START" value="'+periode_awal+'"/><input type="hidden" name="END" value="'+periode_akhir+'"/><button type="submit" class="btn btn-default">Detail</a></form>'
				}, "sClass": "text-center"
			},			
		],
	});

	table_vendor_performance_freeze.on( 'order.dt search.dt', function () {
        table_vendor_performance_freeze.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    table_vendor_performance_freeze.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}

$(document).ready(function(){
	periode_awal = $("#periode_awal").val();
	periode_akhir = $("#periode_akhir").val();		
	populate_table(periode_awal,periode_akhir);
	
	$("#form_filter").submit(function(e) {
		e.preventDefault();
		periode_awal = $("#periode_awal").val();
		periode_akhir = $("#periode_akhir").val();		
		populate_table(periode_awal,periode_akhir);
	});

	 $("#idexcell").click(function(e) {
		e.preventDefault();
        periode_awal = $("#periode_awal").val();
		periode_akhir = $("#periode_akhir").val();

	 	window.open(this.href+"/"+periode_awal+"/"+periode_akhir)

    });  


});