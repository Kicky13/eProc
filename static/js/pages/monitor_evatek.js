base_url = $("#base-url").val();

function openmodal (ptm) {
    $.ajax({
        url: $("#base-url").val() + 'Job_list/get_holder/' + ptm,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) {
        table = $("#tableholder");
        table.html('');
        for (var i = 0; i < data.emp.length; i++) {
            emp = data.emp[i];
            table.append('<tr><td>' + emp.ID + '</td><td>' + emp.FULLNAME + '</td><td>' + emp.EMAIL + '</td></tr>');
        };
        $("#modalholder").modal('show')
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
}

function openitemstatus(ptm){
    $.ajax({
        url: $("#base-url").val() + 'Job_list/get_item_status/' + ptm,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) {
        table = $("#tableitemstatus");
        table.html('');
        $.each(data,function(key,val){        
            table.append('<tr><td>' + val.NAME + '</td><td>' + val.STATUS + '</td></tr>');
        });  
        $("#modalitemstatus").modal('show');
    })
    .fail(function() {
        console.log("error");
    });
   
}

function loadTable () {
    // no = 1;
    mytable = $('#tbl_monitoring_evatek').DataTable({
        "bSort": false,
        "dom": 'rtip',
        "deferRender": true,
        
        "ajax" : $("#base-url").val() + 'Monitoring_evatek/get_datatable',
        
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
                        if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/index' ){
                            return statusRfq(full.PTP_REG_CLOSING_DATE,full.NAMA_BARU);
                        }
                        if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/harga' && full.SAMPUL == 3){
                            return statusPenawaranHarga(full.BATAS_VENDOR_HARGA_VER,full.NAMA_BARU);
                        }
                        if(full.PROCESS_MASTER_ID == 'Tahap_negosiasi/index'){
                            return statusNegosiasi(full.TIT_STATUS_GROUP);
                        }
                         return full.NAMA_BARU;
                    }
                    else {
                        if (full.PTM_COMPANY_ID == '4000') { //Sementara Hardcode untuk kodisi tonasa
                            if (full.PTM_STATUS <= -2 && full.PTM_STATUS >= -8) {
                                return 'Reject';
                            }
                            return 'Retender';
                        } else {
                            if (full.PTM_STATUS <= -2 && full.PTM_STATUS >= -7) {
                                return 'Reject';
                            } 
                            return 'Retender';                        
                        } 

                    }
                }
            },
            {
                mRender : function(data,type,full){
                    console.log(full);
                    var button = '<a title="Monitoring Evatek" href="' + $("#base-url").val() + 'Monitoring_evatek/detail/'+full.PTM_NUMBER+'" class="btn btn-default btn-sm glyphicon glyphicon-th-list"></a> ' + '<button title="Current job holder" onclick="openmodal('+full.PTM_NUMBER+')" class="btn btn-default btn-sm glyphicon glyphicon-user"></button>';
                    if(full.PROCESS_MASTER_ID=='Tahap_negosiasi/index'){
                        button +='<button title="Item Status" onclick="openitemstatus('+full.PTM_NUMBER+')" class="btn btn-default btn-sm glyphicon glyphicon-tag"></button>';
                    }
                    return button;
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

});


