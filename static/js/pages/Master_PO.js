
//     var base_url = "http://10.15.5.150/dev/eproc/";
//     // var base_url = $('#base-url').val();


// $(document).ready(function(){
//     $('form').submit(function(e){
//         var form = this;
//             e.preventDefault();
//                 swal({
//                     title: "Apakah Anda Yakin?",
//                     text: "Semua vendor akan diperingatkan, apakah anda setuju ?",
//                     type: "warning",
//                     showCancelButton: true,
//                     confirmButtonColor: '#92c135',
//                     cancelButtonColor: '#d33',
//                     confirmButtonText: 'Ya',
//                     confirmButtonClass: 'btn btn-success',
//                     cancelButtonClass: 'btn btn-danger',
//                     cancelButtonText: "Tidak",
//                     closeOnConfirm: true,
//                     closeOnCancel: true
//                 },
//                 function(isConfirm) {
//                     if (isConfirm) {
//                         form.submit();
//                     } else {
//                     }
//                 })
//         if (confirm("Semua vendor akan diperingatkan, apakah anda setuju ?")) {
//             console.log("sukses");
//         } else {
//             event.preventDefault();
//             console.log("tidak");
//         }
//     });
//     table_new_vendor = $('#master_po_list').DataTable({
//         "bSort": false,
//         "dom": 'rtip',
//         "deferRender": true,

//         "ajax": {
//             url: base_url+"Master_PO/get_new_master_po"
//         },

//         "columnDefs": [{
//             "searchable": false,
//             "orderable": false,
//             "targets": 0
//         }],

//         "columns":[
//             {
//                 mRender : function(data,type,full){
//                     return '';
//                 }
//             },
//             {   "sClass": "text-center",
//                 mRender : function(data,type,full){
//                 return  String(full.ID)
//             }},
//             {"data" : "CODE"},
//             {"data" : "DESC","sClass": "text-center"},
//             {
//                 mRender : function(data,type,full){
//                 return '<a>Detail</a>'
//             }},
//         ],
//     });

//     table_new_vendor.columns().every( function () {
//         var that = this;
//         $( 'input', this.header() ).on( 'keyup change', function () {
//             if ( that.search() !== this.value ) {
//                 that.search( this.value ).draw();
//             }
//         });
//     });
// });


var base_url = $('#base-url').val();
    // var base_url = "http://10.15.5.150/dev/eproc/";

// function tes(){
//     var base_url = $('#base-url').val();
//     alert(base_url);
// }
// tes();
$(document).ready(function(){
    $('form').submit(function(e){
        var form = this;
            e.preventDefault();
                swal({
                    title: "Apakah Anda Yakin?", 
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
        // if (confirm("Semua vendor akan diperingatkan, apakah anda setuju ?")) {
        //     console.log("sukses");
        // } else {
        //     event.preventDefault();
        //     console.log("tidak");
        // }
    });
    mytable = $('#mater_po_list').DataTable({
        "bSort": false,
        "dom": 'rtip',
        "deferRender": true,

        "ajax": {
            url: base_url+"Master_PO/get_new_master_po"
        },

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],

        "columns":[ 
            {"data" : "URUT"},
            {"data" : "CODE"},
            {"data" : "DESC","sClass": "text-left"},
            {
                mRender : function(data,type,full){

                    ans = '<a title="Edit" href="' + base_url + 'Master_PO/edit/'+full.ID+'" class="btn btn-default btn-sm glyphicon glyphicon-pencil"></a><a title="Hapus" href="#" onclick="hapus_data('+full.ID+')" class="btn btn-default btn-sm glyphicon glyphicon-trash"></a>';
                    return ans;
            }},
        ],
    });

    mytable.on( 'order.dt search.dt', function () {
        mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    mytable.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}); 

function hapus_data(id){
   
    url = base_url + 'Master_PO/hapus/'; 
       swal({ 
            text: "Apa anda yakin ingin hapus data ini?", 
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            confirmButtonColor: "#ec6c62"
        }, function() {
            $.ajax(
            {
                type: "post",
                url: url,
                data: "id="+id,
                success: function(data){
                // alert(data);
                }
            }
        )
        .done(function(data) {
            window.location = 'Master_PO/view';
            // alert('data');
            // swal("Canceled!", "Your order was successfully canceled!", "success");
            // $('#orders-history').load(document.URL +  ' #orders-history');
        })
            .error(function(data) {
                swal("Oops", "We couldn't connect to the server!", "error");
            });
        });
};