$(document).ready(function(){
    var table_job_list = $('#tender-update-table').DataTable({
        "ajax" : $("#base-url").val() + 'Update_qty_tender/get_datatable',
        "bSort": false,
        "dom": 'rtip',

        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 0, "desc" ]],
        
        "columns":[
            {"data" : null},
            {"data" : "PTM_SUBPRATENDER"},
            {"data" : "PTM_PRATENDER"},
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
                var button = '<a href="' + $("#base-url").val() + 'Update_qty_tender/detail/'+full.PTM_NUMBER+'" class="btn btn-default">Proses</a></span>';
                
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

    $("form").submit(function(e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "Apakah Anda Yakin?",
            text: "Pastikan Semua Data Yang Anda Masukkan Sudah Benar!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#92c135',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            cancelButtonText: "Tidak",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                form.submit();
            } else {
            }
        }) 
    });

});

function hapus(ID){
    swal({
        title: "Apakah Anda Yakin?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#92c135',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: "Tidak",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "post",
                url : base_url + 'Update_qty_tender/delete',
                data : "id="+ID,
                //dataType: "json",
                success: function(data) {
                    if(data == 'ok'){
                        swal("Berhasil!", "Data berhasil dihapus", "success")
                        location.reload();
                    }else{
                        swal("Error!", "Data gagal dihapus", "error")
                    }
                }
          });
        } else {
        }
    })
    
}