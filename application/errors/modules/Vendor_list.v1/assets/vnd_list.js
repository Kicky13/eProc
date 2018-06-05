$(document).ready(function(){
    base_url = $("#base-url").val();
    var mytable;

    mytable = $('#tbl_vendor_list').DataTable({

        "bSort": false,
        "dom": 'rtip',
        "ajax" : {'url':base_url + 'Vendor_list/get_vendor'},

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "VENDOR_NO", "sClass": "text-center"},
            {"data" : "VENDOR_NAME"},
            { mRender : function(data,type,full){
                    var status = full.STATUS;
                    var status_prb = full.STATUS_PERUBAHAN;
                    var status_desc = '';
                    if (status == "1" || status == "2"){
                        status_desc = 'Persetujuan New Registrasi';
                    } else if(status == "3") {
                        status_desc = 'Persetujuan Update Profil'; 
                    } else if(status == "0"){
                        status_desc = 'Persetujuan Penilaian Vendor';
                    } else if(status == "5"){
                        status_desc = 'Approve Registrasi Kasi Perencanaan';
                    } else if(status == "6"){
                        status_desc = 'Approve Registrasi Kabiro Perencanaan';
                    } else if(status == "7"){
                        status_desc = 'Approve New Registrasi Ditolak';
                    } 
                return status_desc
            }},
            {"data" : "VENDOR_TYPE", "sClass": "text-center"},
            {
                mRender : function(data,type,full){
                
                    ans = '<a href="'+base_url+'Vendor_list/detail/'+full.VENDOR_ID+'" class="main_button color1 small_btn">Detail</a> ';
                    return ans;
            }, "sClass": "text-center"},
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

    var table_new_vendor = $('#new_vendor').DataTable( {
        "info": false,
        "lengthMenu": [ 5, 10, 25, 50 ],
        "ajax": {
            url: location + "/get_vendor",
            type: 'POST'
        },
        "columnDefs": [{
            "targets": 0
        }],
        "columns":[
            {"data" : null},
            {"data" : "VENDOR_ID"},
            {"data" : "VENDOR_NAME"},
            {"data" : "CREATION_DATE"},
            {
                mRender : function(data,type,full){
                    console.log(full);
                    var status = full.REG_ISACTIVATE;
                    var text = '';
                    if (status == "Y") {
                        text = 'Active';
                    }
                    else if (status == "N") {
                        text = 'Not Active';
                    };
                return text
            }},
            {
                mRender : function(data,type,full){
                return '<a class="btn btn-default" href="'+location+'/activate_vendor/'+full.VENDOR_ID+'">Process</a>'
            }},
        ],
    } );

    table_new_vendor.on( 'order.dt search.dt', function () {
        table_new_vendor.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    table_new_vendor.on('draw', function () {
        table_new_vendor.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            console.log(cell);
        } );
    } ).draw();
})