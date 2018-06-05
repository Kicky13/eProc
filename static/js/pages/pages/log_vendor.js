mytable = null;

function populate_table(argument) {
	if (mytable != null) {
		mytable.destroy();
	}

     mytable = $('#tbl_log').DataTable({
        "bSort": true,
		"dom": 'rtip',
		"pageLength":10,
		"processing": true,
		"serverSide": true,
		"paging":true,
		
        "ajax": {
			url: $("#base-url").val() + "Log_vendor/get_datatable",
			type: 'POST',
			data: {search: argument}
		},
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
        	{"data" : "RNUM"},
            {"data" : "VENDOR_NO"},
            {"data" : "VENDOR_NAME"},
            { mRender : function(data,type,full){
                    var status = full.STATUS;
                    var status_desc = '';
                    if (status == "1" || status == "2"){
                        status_desc = 'New Registrasi';
                    } else if(status == "3") {
                        status_desc = 'Vendor Aktif'; 
                    } else if(status == "-1"){
                        status_desc = 'Registrasi Ditolak';
                    } else if(status == "99"){
                        status_desc = 'Dikembalikan ke Vendor';
                    } else if(status == "5"){
                        status_desc = 'Approve Registrasi Kasi Perencanaan';
                    } else if(status == "6"){
                        status_desc = 'Approve Registrasi Kasi Kabiro';
                    } else if(status == "7"){
                        status_desc = 'Approve New Registrasi Ditolak';
                    } else if(status == "0"){
                        status_desc = 'Registrasi Akun';
                    } 
                return status_desc
            }},
            {"data" : "EMAIL_ADDRESS"},
            {
                mRender : function(data,type,full){
                    // console.log(full);
                    return '<a title="View" href="' + $("#base-url").val() + 'Log_vendor/detail_vendor/'+full.VENDOR_NO+'" class="btn btn-default btn-sm glyphicon glyphicon-eye-open"></a>';
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

$(document).ready(function(){
	populate_table('');

	$("#form_filter").submit(function(e) {
		e.preventDefault();
		search = $("#filter").val();
		populate_table(search);
	})

});