$(document).ready(function(){
    base_url = $("#base-url").val();
    var mytable;

    mytable = $('#tbl_vendor_reject').DataTable({

        "bSort": false,
        "dom": 'rtip',
        "ajax" : {'url':base_url + 'Vendor_reject/get_vendor'},

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "VENDOR_NO","sClass": "text-center"},
            {"data" : "VENDOR_NAME"},
            {"data" : "ADDRESS_CITY","sClass": "text-center"},
            {"data" : "VENDOR_TYPE","sClass": "text-center"},
            {
                mRender : function(data,type,full){
                    ans = '<a href="'+base_url+'Vendor_reject/detail/'+full.VENDOR_ID+'" class="main_button color1 small_btn">Detail</a> ';
                    return ans;
                }
            },
        ],
    });

    
    mytable.on( 'order.dt search.dt', function () {
        mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    

    $("#activ").on('click', function(e){
            var vendor = $('.vendor_id').val();

            e.preventDefault();
            swal({
                title: "Apakah Anda Yakin?",
                text: "Pastikan semua data yang sudah di submit sudah benar!",
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
                        url : '../do_update_activation_data',
                        method : 'post',
                        data : { vendor_id : vendor}, 
                        dataType : "json"
                    })
                    .done(function(result) {
                        swal("Berhasil!", "Approve berhasil!", "success")
                        var url = window.location.href;
                        if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                        url = url.split('/');
                        url.pop();
                        url.pop();
                        window.location = url.join('/') + '/Vendor_reject';
                    })
                    .fail(function(result) {
                        swal("Gagal!", "Approve error!", "error")
                    }).always(function(data) {
                        console.log(data);
                    })
                    console.log("aprv");
                    }  else {
                    }
            }) 
    })
})