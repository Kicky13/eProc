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
			url: $("#base-url").val() + "Log/get_datatable",
			type: 'POST',
			data: {search: argument}
		},
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
        	{"data" : "NO"},
            {
                mRender : function(data,type,full){
                    // console.log(full);
                    if(full.PTM_SUBPRATENDER != null){
                        a = ''
                        // a += "<div class='col-md-12 text-center'>";
                        a += full.PTM_SUBPRATENDER;
                        // a += "</div>";
                        return a;
                    }else return "";
                }
            },
            {
                mRender : function(data,type,full){
                    if(full.PTM_PRATENDER != null){
                        a = ''
                        // a += "<div class='col-md-12 text-center'>";
                        a += full.PTM_PRATENDER;
                        // a += "</div>";
                        return a;
                    }else return "";

                }
            },
            // {
            //     mRender : function(data,type,full){ 
            //         if(full.PPI_PRNO != null){
            //             a = ''
            //             // a += "<div class='col-md-12 text-center'>";
            //             a += full.PPI_PRNO;
            //             // a += "</div>";
            //             return a;
            //         }else return "";

            //     }
            // },
            {"data" : "PTM_SUBJECT_OF_WORK"},
            {"data" : "PTC_END_DATE"},
            {
                mRender : function(data,type,full){
                    if(full.PTM_PGRP != null){
                        a = "<div class='col-md-12 text-center'>";
                        a += full.PTM_PGRP;
                        a += "</div>";
                        return a;
                    }else return "";

                }
            },
            {
                mRender : function(data,type,full) {
                    if (full.PTM_STATUS > 0){
                        if(full.PTM_STATUS == 8 ){
                            return statusRfq(full.PTP_REG_CLOSING_DATE,full.NAMA_BARU);
                        }
                        if(full.PTM_STATUS == 16 && full.SAMPUL == 3){
                            return statusPenawaranHarga(full.BATAS_VENDOR_HARGA_VER,full.NAMA_BARU);
                        }
                         return full.NAMA_BARU;
                    }
                    else {
                        if (full.PTM_STATUS <= -2 && full.PTM_STATUS >= -7){
                            return 'Reject';
                        }
                        return 'Retender';                        
                    }
                }
            },
            {
                mRender : function(data,type,full){
                    console.log(full);
                    return '<a title="View" href="' + $("#base-url").val() + 'Log/detail/'+full.PTM_NUMBER+'" class="btn btn-default btn-sm glyphicon glyphicon-eye-open"></a>';
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