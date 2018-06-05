var base_url = $('#base-url').val();
table_master_sanction_list = null;

function populate_table(fr_prod) {
	if (table_master_sanction_list != null) {
		table_master_sanction_list.destroy();
	}
	
	table_master_sanction_list = $('#vendor_sanction_list').DataTable( {
        "bSort": false,
		"dom": 'rtip',
        "lengthMenu": [10, 25, 50 ],
		"ajax": {
			url: base_url + "Vendor_sanction_management/get_vendor_sanction",
			type: 'POST',
			data: {item: fr_prod}
		},
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
		"columns":[
			{"data" : null},
			{"data" : "VENDOR_NO", "sClass": "text-center"},
			{"data" : "VENDOR_NAME", "sClass": "text-center"},
			{"data" : "SANCTION_NAME", "sClass": "text-center"},
			{"data" : "START_DATE", "sClass": "text-center"},
			{"data" : "END_DATE", "sClass": "text-center"},
			{"data" : "DURATION", "sClass": "text-center"},
			{
				mRender:function(data,type,full){
					return (full.STATUS==1?'A':'N');
				}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					return '<a class="btn btn-info" href="'+base_url+'Vendor_sanction_management/detail_sanction/'+full.VENDOR_NO+'">Detail</a>'
				}, "sClass": "text-center"
			
			},
		],
	});

	table_master_sanction_list.on( 'order.dt search.dt', function () {
        table_master_sanction_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    table_master_sanction_list.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}


$(document).ready(function(){
	populate_table('');
	$('#status').bind('change',function(){
		if($(this).val()==0){
			$(this).val(1);
		}else{
			$(this).val(0);
		}
	});

	$(".set_product").on('change', function(){
        fr_prod = $("#id_prod").val();      
        populate_table(fr_prod);
        
    })
    
    $(".select2").select2();
	
});