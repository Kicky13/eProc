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
            table.append('<tr><td>' + val.PR_NO + '</td><td>' + val.PR_ITEM + '</td><td>' + val.NOMAT + '</td><td>' + val.NAME + '</td><td>' + val.STATUS + '</td></tr>');
        });  
        $("#modalitemstatus").modal('show');
    })
    .fail(function() {
        console.log("error");
    });
   
}

$(document).ready(function(){
    /*//check for browser support
    if(typeof(EventSource)!=="undefined") {
        // var url=$("#base-url").val()+'Job_list/get_status_uptodate';        
        // var url=$("#base-url").val()+'waktu.php';
        var url='/dev/eproc/Job_list/get_status_uptodate';
        //create an object, passing it the name and location of the server side script
        var eSource = new EventSource(url);
        //detect message receipt
        eSource.onmessage = function(e) {
            //write the received data to the page
            $('.status_uptodate').html(e.data);
        };        
        eSource.onopen = function(e){
            // do something when the connection opens
            console.log('opened');
        };
        eSource.onerror = function(e){
            // do something when there's an error
            console.log(e);
        }
    }
    else {
        $('.status_uptodate').html('none');
    }
    //*/

    cheat = $("#cheat").val();
    cheat = cheat == 'true' ? '/true' : '';

    var table_job_list = $('#job-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Job_list/get_datatable' + cheat,
        "bSort": false,
        "dom": 'rtip',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "columns":[
            {"data" : null},
            {"data" : "PTM_SUBPRATENDER"},
            {"data" : "PTM_PRATENDER"},
			{"data" : "PPI_PRNO"},
            {"data" : "PTM_SUBJECT_OF_WORK"},
            {"data" : "PTM_PGRP", "sClass": "text-center"},
            //{"data" : "PROCESS_NAME"},
            {
                mRender : function(data,type,full) {
                    if (full.PTM_STATUS > 0){
                            if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/index' ){ //UNTUK KONDISI VERIFIKASI PENAWARAN
                                return statusRfq(full.PTP_REG_CLOSING_DATE,full.PROCESS_NAME);
                            }
                            if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/harga' && full.SAMPUL == 3){ //UNTUK KONDISI VERIFIKASI HARGA
                                return statusPenawaranHarga(full.BATAS_VENDOR_HARGA_VER,full.NAMA_BARU);
                            }
                            if(full.PROCESS_MASTER_ID == 'Tahap_negosiasi/index'){
                                return statusNegosiasi(full.TIT_STATUS_GROUP);
                            }
                        return full.PROCESS_NAME;
                    }
                    else {
                        return 'Retender';
                    }
                }
            },
            {"data" : "PTC_END_DATE"},
            {
                mRender : function(data,type,full){
                console.log(full);
                var button = '<a href="' + $("#base-url").val() + 'Job_list/next_process/'+full.PTM_NUMBER+'" class="btn btn-default">Proses</a>'+'<span id="status_'+full.PTM_NUMBER+'" class="status_uptodate"></span>';
                if(full.PROCESS_MASTER_ID=='Tahap_negosiasi/index'){
                    button +='<button title="Item Status" onclick="openitemstatus('+full.PTM_NUMBER+')" class="btn btn-default btn-sm glyphicon glyphicon-tag"></button>';
                }
                return button;
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    table_job_list.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });

    
})