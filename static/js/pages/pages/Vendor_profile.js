var base_url = $('#base-url').val();

$(document).ready(function(){

    $('form').submit(function(e){
        var form = this;
            e.preventDefault();
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Semua vendor akan diperingatkan, apakah anda setuju ?",
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
        //}
    });
    table_new_vendor = $('#vendor_profile_list').DataTable({
        "bSort": false,
        "dom": 'rtip',
        "deferRender": true,

        "ajax": {
            url: base_url+"Vendor_profile/get_new_vendor_need_update"
        },

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
            {   "sClass": "text-center",
                mRender : function(data,type,full){
                return  String(full.VENDOR_NO)
            }},
            {"data" : "VENDOR_NAME"},
            {"data" : "VENDOR_TYPE","sClass": "text-center"},
            {
                mRender : function(data,type,full){
                return '<a class="btn btn-default" target="_blank" href="'+base_url+'Vendor_profile/vnd_document_update/'+full.VENDOR_ID+'">Detail</a>'
            }},
        ],
    });

    table_new_vendor.columns().every( function () {
        var that = this;
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
});