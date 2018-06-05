var base_url = $('#base-url').val();
prod_tbl = null;

function populate_table(fr_prod) {
    if (prod_tbl != null) {
        prod_tbl.destroy();
    }
    
    prod_tbl = $('#tbl_vendor_list').DataTable( {
        "bSort": false,
        "dom": 'rtip',
        "lengthMenu": [10, 25, 50 ],
        // "processing": true,
        "ajax": {
            url: base_url + "Vendor_list/get_vendor",
            type: 'POST',
            data: {item:fr_prod}
        },
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
            var status_per = full.STATUS_PERUBAHAN;
            var status_desc_per = '';
            if (status_per == "8"){
                status_desc_per = 'Persetujuan New Update Profile';
            } else if(status_per == "4") {
                status_desc_per = 'Approve Update Profile Kasi'; 
            } else if(status_per == "5"){
                status_desc_per = 'Approve Update Profile Kabiro';
            } else if(status_per == "9"){
                status_desc_per = 'Update Data Ditolak';
            } else if(status_per == "0"){
                status_desc_per = 'Vendor Updated';
            } else if(status_per == ""){
                status_desc_per = '';
            }
            return status_desc_per
        }},
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
                status_desc = 'Approve Registrasi Kabiro Perencanaan';
            } else if(status == "7"){
                status_desc = 'Approve New Registrasi Ditolak';
            } else if(status == "0"){
                status_desc = 'Registrasi Akun';
            } 
            return status_desc
        }},
        {"data" : "EMAIL_ADDRESS", "sClass": "text-center"},
        {   mRender : function(data,type,full){
            var status = full.STATUS;
            var status_desc = '';
            var next_url = '';
            var vendor_id=full.VENDOR_ID;
            if (status == "1" || status == "2"){
                next_url = 'Vendor_list/new_regisration';
            } else if(status == "3") {
                next_url = 'Vendor_list/vendor_approved'; 
            } else if(status == "-1"){
                next_url = 'Vendor_list/vendor_rejected';
            } else if(status == "99"){
                next_url = 'Vendor_list/road_to_vendor';
            } else if(status == "5"){
                        next_url = 'Vendor_list/approve_regisration'; // perencanaan
                    } else if(status == "6"){
                        next_url = 'Vendor_list/approve_regisration'; // kasi
                    } else if(status == "7"){
                        next_url = 'Vendor_list/approve_regisration';  // kabiro
                    } else if(status == "0"){
                        next_url = 'swal'; 
                    }

                    if (next_url == 'swal') {
                        return '<button class="btn btn-default" onclick="onklik()">Detail</button>'
                    }else{   
                        return '<a class="btn btn-default" href="'+next_url+'/'+vendor_id+'">Detail</a>'
                    }
                }, "sClass": "text-center"},
                ],
            });
    
    prod_tbl.on( 'order.dt search.dt', function () {
        prod_tbl.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    prod_tbl.columns().every( function () {
        var that = this;

        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}

function populate_table_komoditi(fr_prod) {
    if (prod_tbl != null) {
        prod_tbl.destroy();
    }
    
    prod_tbl = $('#tbl_vendor_list_komoditi').DataTable( {
        "bSort": false,
        "dom": 'rtip',
        "lengthMenu": [10, 25, 50 ],
        // "processing": true,
        "ajax": {
            url: base_url + "Vendor_list/get_vendor_komoditi",
            type: 'POST',
            data: {item:fr_prod}
        },
        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
        {"data" : null},
        {"data" : "PRODUCT_NAME"},
        {"data" : "PRODUCT_SUBGROUP_NAME"},
        {"data" : "PRODUCT_DESCRIPTION"},
        {"data" : "BRAND"},
        {"data" : "SOURCE"},
        {"data" : "TYPE"},
        {"data" : "NO"},
        {"data" : "EXPIRED_DATE"},
        {"data" : "VENDOR_NO", "sClass": "text-center"},
        {"data" : "VENDOR_NAME"},
        {   mRender : function(data,type,full){
            var status = full.STATUS;
            var status_desc = '';
            var next_url = '';
            var vendor_id=full.VENDOR_ID;
            if (status == "1" || status == "2"){
                next_url = 'Vendor_list/new_regisration';
            } else if(status == "3") {
                next_url = 'Vendor_list/vendor_approved'; 
            } else if(status == "-1"){
                next_url = 'Vendor_list/vendor_rejected';
            } else if(status == "99"){
                next_url = 'Vendor_list/road_to_vendor';
            } else if(status == "5"){
                        next_url = 'Vendor_list/approve_regisration'; // perencanaan
                    } else if(status == "6"){
                        next_url = 'Vendor_list/approve_regisration'; // kasi
                    } else if(status == "7"){
                        next_url = 'Vendor_list/approve_regisration';  // kabiro
                    } else if(status == "0"){
                        next_url = 'swal'; 
                    }

                    if (next_url == 'swal') {
                        return '<button class="btn btn-default" onclick="onklik()">Detail</button>'
                    }else{   
                        return '<a class="btn btn-default" href="'+next_url+'/'+vendor_id+'">Detail</a>'
                    }
                }, "sClass": "text-center"},
                ],
            });
    
    prod_tbl.on( 'order.dt search.dt', function () {
        prod_tbl.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    prod_tbl.columns().every( function () {
        var that = this;

        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}

function populate_table_komoditi_bahan(fr_prod) {
    if (prod_tbl != null) {
        prod_tbl.destroy();
    }
    
    prod_tbl = $('#tbl_vendor_list_komoditi').DataTable( {
        "bSort": false,
        "dom": 'rtip',
        "lengthMenu": [10, 25, 50 ],
        // "processing": true,
        "ajax": {
            url: base_url + "Vendor_list/get_vendor_komoditi",
            type: 'POST',
            data: {item:fr_prod}
        },
        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
        {"data" : null},
        {"data" : "PRODUCT_NAME"},
        {"data" : "PRODUCT_SUBGROUP_NAME"},
        {"data" : "PRODUCT_DESCRIPTION"},
        {"data" : "SOURCE"},
        {"data" : "TYPE"},
        {"data" : "KLASIFIKASI_NAME"},
        {"data" : "NO"},
        {"data" : "ISSUED_BY"},
        {"data" : "ISSUED_DATE"},
        {"data" : "EXPIRED_DATE"},
        {"data" : "VENDOR_NO", "sClass": "text-center"},
        {"data" : "VENDOR_NAME"},
        {   mRender : function(data,type,full){
            var status = full.STATUS;
            var status_desc = '';
            var next_url = '';
            var vendor_id=full.VENDOR_ID;
            if (status == "1" || status == "2"){
                next_url = 'Vendor_list/new_regisration';
            } else if(status == "3") {
                next_url = 'Vendor_list/vendor_approved'; 
            } else if(status == "-1"){
                next_url = 'Vendor_list/vendor_rejected';
            } else if(status == "99"){
                next_url = 'Vendor_list/road_to_vendor';
            } else if(status == "5"){
                        next_url = 'Vendor_list/approve_regisration'; // perencanaan
                    } else if(status == "6"){
                        next_url = 'Vendor_list/approve_regisration'; // kasi
                    } else if(status == "7"){
                        next_url = 'Vendor_list/approve_regisration';  // kabiro
                    } else if(status == "0"){
                        next_url = 'swal'; 
                    }

                    if (next_url == 'swal') {
                        return '<button class="btn btn-default" onclick="onklik()">Detail</button>'
                    }else{   
                        return '<a class="btn btn-default" href="'+next_url+'/'+vendor_id+'">Detail</a>'
                    }
                }, "sClass": "text-center"},
                ],
            });
    
    prod_tbl.on( 'order.dt search.dt', function () {
        prod_tbl.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    prod_tbl.columns().every( function () {
        var that = this;

        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}

function populate_table_komoditi_jasa(fr_prod) {
    if (prod_tbl != null) {
        prod_tbl.destroy();
    }
    
    prod_tbl = $('#tbl_vendor_list_komoditi').DataTable( {
        "bSort": false,
        "dom": 'rtip',
        "lengthMenu": [10, 25, 50 ],
        // "processing": true,
        "ajax": {
            url: base_url + "Vendor_list/get_vendor_komoditi",
            type: 'POST',
            data: {item:fr_prod}
        },
        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
        {"data" : null},
        {"data" : "PRODUCT_NAME"},
        {"data" : "PRODUCT_SUBGROUP_NAME"},
        {"data" : "KLASIFIKASI_NAME"},
        {"data" : "SUBKUALIFIKASI_NAME"},
        {"data" : "NO"},
        {"data" : "ISSUED_BY"},
        {"data" : "ISSUED_DATE"},
        {"data" : "EXPIRED_DATE"},
        {"data" : "ADDRESS_CITY"},
        {"data" : "VENDOR_NO", "sClass": "text-center"},
        {"data" : "VENDOR_NAME"},
        {   mRender : function(data,type,full){
            var status = full.STATUS;
            var status_desc = '';
            var next_url = '';
            var vendor_id=full.VENDOR_ID;
            if (status == "1" || status == "2"){
                next_url = 'Vendor_list/new_regisration';
            } else if(status == "3") {
                next_url = 'Vendor_list/vendor_approved'; 
            } else if(status == "-1"){
                next_url = 'Vendor_list/vendor_rejected';
            } else if(status == "99"){
                next_url = 'Vendor_list/road_to_vendor';
            } else if(status == "5"){
                        next_url = 'Vendor_list/approve_regisration'; // perencanaan
                    } else if(status == "6"){
                        next_url = 'Vendor_list/approve_regisration'; // kasi
                    } else if(status == "7"){
                        next_url = 'Vendor_list/approve_regisration';  // kabiro
                    } else if(status == "0"){
                        next_url = 'swal'; 
                    }

                    if (next_url == 'swal') {
                        return '<button class="btn btn-default" onclick="onklik()">Detail</button>'
                    }else{   
                        return '<a class="btn btn-default" href="'+next_url+'/'+vendor_id+'">Detail</a>'
                    }
                }, "sClass": "text-center"},
                ],
            });
    
    prod_tbl.on( 'order.dt search.dt', function () {
        prod_tbl.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    prod_tbl.columns().every( function () {
        var that = this;

        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}

function onklik(){
    swal("Perhatian!", "Calon Vendor Belum Submit Data Registrasi !", "warning")
}

function exportKomoditi(){
    location.href = base_url + "Vendor_list/exportKomoditi/"+ $("#list_vendor").val();
}

$(document).ready(function(){
    fr_prod = $("#id_prod").val();      
    list_vendor = $("#list_vendor").val();  
    if(list_vendor=="list_vendor"){
        populate_table(fr_prod);
    } else if(list_vendor=="list_vendor_komoditi"){
        populate_table_komoditi(list_vendor);
    } else if(list_vendor=="list_vendor_komoditi_bahan"){
        populate_table_komoditi_bahan(list_vendor);
    } else if(list_vendor=="list_vendor_komoditi_jasa"){
        populate_table_komoditi_jasa(list_vendor);
    }


    $(".set_product").on('change', function(){
        fr_prod = $("#id_prod").val();      
        if(list_vendor=="list_vendor"){
            populate_table(fr_prod);
        } else {
            populate_table_komoditi(fr_prod);
            
        }
        
    })
    
    $(".select2").select2();

    $("#idexcell").click(function(event ) {
        event.preventDefault();
        var veno = $('#vendorno').val();
        if (veno != '') {
            var no = veno;
        }else{
            var no = '0';
        };
        var vename = $('#vendorname').val();
        if (vename != '') {
            var name = vename;
        }else{
            var name = '0';
        };
        var stupdate = $('#stsupdate').val();
        if (stupdate != '') {
            var update = stupdate;
        }else{
            var update = '0';
        };

        var streg = $('#stsrgs').val();
        if (streg != '') {
            var reg = streg;
        }else{
            var reg = '0';
        };
        var email = $('#email').val();
        if (email != '') {
            var eml = email;
        }else{
            var eml = '0';
        };
        var produk = $("#id_prod").val();
        if (produk != '') {
            var pd = produk;
        }else{
            var pd = '0';
        };

         // alert(this.href); 

         window.open(this.href+"/"+no+"/"+name+"/"+update+"/"+reg+"/"+eml+"/"+pd)

     });    
});