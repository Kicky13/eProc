base_url = $("#base-url").val();

function loadTable () {
    // no = 1;
    mytable = $('#tbl_reschedule').DataTable({
        "bSort": false,
        "dom": 'rtip',
        "deferRender": true,
        
        "ajax" : $("#base-url").val() + 'Procurement_reschedule/get_datatable',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
            {
                mRender : function(data,type,full){
                    return '';
                }
            },
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
                }, "sClass": "text-center"
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
            {
                mRender : function(data,type,full){ 
                    if(full.PPI_PRNO != null){
                        a = ''
                        // a += "<div class='col-md-12 text-center'>";
                        a += full.PPI_PRNO;
                        // a += "</div>";
                        return a;
                    }else return "";

                }
            },
            {"data" : "PTM_SUBJECT_OF_WORK"},
            // {"data" : "PTM_SUBPRATENDER"},
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
                    return '<a title="Update tanggal" href="' + $("#base-url").val() + 'Procurement_reschedule/detail/'+full.PTM_NUMBER+'" class="btn btn-default btn-sm glyphicon glyphicon-pencil"></a>'
                }
            },
        ],
    });
    
    // mytable.on( 'order.dt search.dt', function () {
    //     mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //         cell.innerHTML = i+1;
    //     } );
    // } ).draw();

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
    loadTable();
    setTimeout(function(){$(".close").fadeOut('slow');}, 5000);

});


