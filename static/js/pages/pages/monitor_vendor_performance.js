var base_url = $('#base-url').val();
table_vendor_performance_monitor = null;

$('.input-group.date').datetimepicker({
	format: 'DD-MMM-YY HH:mm',
	// sideBySide: true,
	ignoreReadonly: true
});

$('.input-group.date input').attr("readonly", true);

function populate_table() {
	if (table_vendor_performance_monitor != null) {
		table_vendor_performance_monitor.destroy();
	}
	
	table_vendor_performance_monitor = $('#vendor_monitor_list').DataTable( {
  		"bSort": false,
		"dom": 'rtip',
		"pageLength":10,
		// "processing": true,
		// "serverSide": true,
		"paging":true,
		// "pagingType": "full_numbers",
		"ajax": {
			url: base_url + "Vendor_performance_management/get_monitor_vendor",
			type: 'POST',
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
					if(full.REKAP_ID!=null){
						if(full.STATUS_APPROVAL=='1'){
							if(full.IS_DONE=='1'){
								return 'Rekap disetujui Kabiro'
							}else{
								return 'Rekap disetujui Kasi'
							}
						}else{
							return 'Rekap Menunggu Persetujuan'
						}
					}else{
						return 'Belum Rekap'
					}
				}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					return '<form id="detail_monitor" name="detail_monitor[]" action="'+base_url+'Vendor_performance_management/detail_monitor" method="POST"><input type="hidden" name="VENDOR_NO" value="'+full.VENDOR_NO+'"/><button type="submit" class="btn btn-default">Detail</a></form>'
				}, "sClass": "text-center"
			},			
		],
	});

	table_vendor_performance_monitor.on( 'order.dt search.dt', function () {
        table_vendor_performance_monitor.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    table_vendor_performance_monitor.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}

$(document).ready(function(){		
	populate_table();
});