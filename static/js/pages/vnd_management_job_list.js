var base_url = $('#base-url').val();
var panel_title;
var table_new_vendor = null;

$(document).ready(function(){
    if (table_new_vendor != null) {
        table_new_vendor.destroy();
    }
    table_new_vendor = $('#new_vendor').DataTable( {
        "info": false,
        "lengthMenu": [ 5, 10, 25, 50 ],
        "ajax": {
            url: "get_new_vendor_need_approval",
            type: 'POST'
        },
        "columnDefs": [{
            "targets": 0
        }],
        "columns":[
            {"data" : null},
            {"data" : "VENDOR_NAME"},
            {
                
                mRender : function(data,type,full){
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
                    } else if(status == "SANCTION APPROVAL"){
                        status_desc = 'Persetujuan Pembebasan Sanksi vendor';
                    }
                return status_desc
            }},
            {
                mRender : function(data,type,full){
                    var product = full.PRODUCT_TYPE_PROC;
                    var product_desc = '';
                    if (product == "1"){
                        product_desc = 'BARANG';
                    } else if(product == "2") {
                        product_desc = 'JASA'; 
                    } else if(product == "3"){
                        product_desc = 'BAHAN';
                    } else if(product == "4"){
                        product_desc = 'BARANG DAN JASA';
                    } else if(product == "5"){
                        product_desc = 'BARANG DAN BAHAN';
                    } else if(product == "6"){
                        product_desc = 'BAHAN DAN JASA';
                    } else if(product == "7"){
                        product_desc = 'BARANG, BAHAN DAN JASA';
                    }
                return product_desc
            }},
            {"data" : "UPDATED_AT", "sClass": "text-center"},
            {
                mRender : function(data,type,full){
                    var status = full.STATUS;
                    var status_prb = full.STATUS_PERUBAHAN;
                    var next_url = '';
                    var vendor_id=full.VENDOR_ID;
                    if (status == "1" || status == "2") {
                        next_url = 'approve_regisration';
                    } else if (status =="3") {
                        next_url = 'approve_update_profile';
                    } else if (status =="0") {
                        next_url = 'approve_performance';
                    } else if(status == "5"){
                        next_url = 'approve_regisration';
                    } else if(status == "6"){
                        next_url = 'approve_regisration';
                    } else if(status == "7"){
                        next_url = 'approve_regisration';
                    } else if(status == "SANCTION APPROVAL"){
                        next_url = 'approve_sanction';
                    };
                    return '<a class="btn btn-default" href="'+next_url+'/'+vendor_id+'">Process</a>'
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

    $('#saveChecklistDocument').click(function(){
        var form_data = $('.save_checklist_document').serialize();
        console.log(form_data);
        $.ajax({
            url : '../save_checklist_document',
            method : 'post',
            data : form_data,
            dataType : "json",
            success : function(result)
            {
                swal("Sukses", "Sukses menyimpan data!", "success")
                console.log(result);
                // location.reload();
            }
        })  
    });

    $('.action-option').on('change', function(event) {
        var index = $(this).prop('selectedIndex');
        console.log(index);
        if (index == 1) {
            $(this).closest('.acc_content').find('.reject-reason').css({visibility: 'visible'}).focus();
        }
        else {
            $(this).closest('.acc_content').find('.reject-reason').css({visibility: 'hidden'});
        }
    });

    $('.action-option').trigger('change');

    $('.action-button').on('click', function(e) {
        e.preventDefault();
        panel_title = $(this).closest('.enar_occ_container').find('.enar_occ_title');

        var index = $(this).siblings('.form-group').find(".action-option").prop('selectedIndex');
        var container = $(this).val();
        var reason = $(this).closest('.acc_content').find('.reject-reason').val();
        var vendor_id = $('.vendor_id').val();

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
                    $.ajax({
                        url: base_url+'Vendor_management/submit_approval_action',
                        type: 'POST',
                        dataType: 'json',
                        data: {index: index, container: container, reason: reason, vendor_id: vendor_id},
                    })
                    .done(function(data) {
                        console.log(data);
                        if (data.index == '1') {
                            container = container.replace(/\s/g, '')
                            container = container.toLowerCase();
                            $('#'+container).val("false");
                            $(panel_title).removeClass('green').addClass('red');
                            $(panel_title).removeClass('blue').addClass('red');
                        } else if (data.index == '0') {
                            container = container.replace(/\s/g, '')
                            container = container.toLowerCase();
                            $('#'+container).val("true");
                            $(panel_title).removeClass('blue').addClass('green');
                            $(panel_title).removeClass('red').addClass('green');
                        } else {
                            container = container.replace(/\s/g, '')
                            container = container.toLowerCase();
                            $('#'+container).val("true");
                            $(panel_title).removeClass('red').addClass('green');
                        }
                    }).always(function(data){
                        console.log(data);
                    });
                } else {
                }
            })

    });

    $('.action-button-update').on('click', function(e) {
        e.preventDefault();
        panel_title = $(this).closest('.enar_occ_container').find('.enar_occ_title');
        console.log(panel_title);

        var index = $(this).siblings('.form-group').find(".action-option").prop('selectedIndex');
        var container = $(this).val();
        var reason = $(this).closest('.acc_content').find('.reject-reason').val();
        var vendor_id = $('.vendor_id').val();

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
                    $.ajax({
                        url: base_url+'Vendor_management/submit_approval_update',
                        type: 'POST',
                        dataType: 'json',
                        data: {index: index, container: container, reason: reason, vendor_id: vendor_id},
                    })
                    .done(function(data) {
                        console.log(data);
                        if (data.index == '1') {
                            container = container.replace(/\s/g, '')
                            container = container.toLowerCase();
                            $('#'+container).val("false");
                            $(panel_title).removeClass('green').addClass('red');
                            $(panel_title).removeClass('blue').addClass('red');
                        } else if (data.index == '0') {
                            container = container.replace(/\s/g, '')
                            container = container.toLowerCase();
                            $('#'+container).val("true");
                            $(panel_title).removeClass('blue').addClass('green');
                            $(panel_title).removeClass('red').addClass('green');
                        } else {
                            container = container.replace(/\s/g, '')
                            container = container.toLowerCase();
                            $('#'+container).val("true");
                            $(panel_title).removeClass('red').addClass('green');
                        }
                    }).always(function(data){
                        console.log(data);
                    });
                } else {
                }
            }) 

    });

    $("#bank_country_key").change(function() {
        swift = $(this).find('option:selected').data('swift');
        $("#bank_key").val(swift);
    })

    $('#approve-staff').click(function(e) { //approve untuk create vendor
        var flag = true;
        $('.flag_panel').each(function() {
            value = $(this).val();
            if(value == "false" || value == "empty"){
                flag = false;
            }
        });
        if(flag){
                var form_data = $('#term_payment').val();
                var vendor = $('.vendor_id').val();
                var data_comment = $('#vnd_comment').val();

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
                        if ($("#level").val() == 1 || $("#level").val() == 2) { 
                                urlnya = '../do_approve_regis'; 

                        } else if ($("#level").val() == 3) { 

                                urlnya = '../update_approve_staff'; 

                        } else {
                            swal("Warning", "Anda Tidak Punya Akses Untuk Melakukan Action !", "warning")
                            e.preventDefault();
                            return false;
                        }

                        $.ajax({
                            url : urlnya,
                            method : 'post',
                            data : { vendor_id : vendor, term : form_data, comment : data_comment},
                            dataType : "json"
                        })
                        .done(function(result) {
                            swal("Berhasil!", "Approve berhasil!", "success") 
                            var url = window.location.href;
                            if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                            url = url.split('/');
                            url.pop();
                            url.pop();
                            window.location = url.join('/') + '/job_list';
                        })
                        .fail(function(result) {
                            swal("Gagal!", "Gagal create vendor, cek kelengkapan data vendor!", "error") 
                        }).always(function(data) {
                            console.log(data);
                        }) 
                    } else {
                    }
                }) 
        } else {
            swal("Warning!", "Persetujuan tidak dapat dilakukan, semua data vendor harus disetujui", "warning")
        }
    });

    $('#approve-vendor').click(function(e) { //update profil
        var flag = true;
        $('.flag_panel').each(function() {
            value = $(this).val();
            if(value == "false"){
                flag = false;
            }
        });        

        if(flag){
            var form_data = $('#form_akuntansi').serialize();
            var vendor = $('.vendor_id').val();
            var data_comment = $('#vnd_comment').val();

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
                    if ($("#level").val() == 1 || $("#level").val() == 2) { // konfigurasi dan kasi

                            urlnya = '../do_approve_update';

                    } else if ($("#level").val() == 3) { // kabiro

                            urlnya = '../accept_vendor_update';

                    } else {
                        swal("Warning!", "Anda Tidak Punya Akses Untuk Melakukan Action !", "warning")
                        e.preventDefault();
                        return false;
                    }

                    $.ajax({
                        url : urlnya,
                        method : 'post',
                        data : { vendor_id : vendor, comment : data_comment}, 
                        dataType : "json"
                    })
                    .done(function(result) {
                        swal("Berhasil!", "Approve berhasil!", "success")
                        var url = window.location.href;
                        if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                        url = url.split('/');
                        url.pop();
                        url.pop();
                        window.location = url.join('/') + '/job_list';
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
        } else {
            swal("Warning!", "Persetujuan tidak dapat dilakukan, semua data vendor harus disetujui", "warning")
        }
    });

    $('#reject-update').click(function(e) { 
        var form_data = $('#comment').val();
        var data_comment = $('#vnd_comment').val();

        e.preventDefault();
            swal({
                title: "Apakah Anda Yakin?",
                text: "Apakah anda yakin akan melakukan reject data vendor!",
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
                    console.log(form_data);
                    urlnya = '../reject_update_profil_vendor';
                    $.ajax({
                        url : urlnya,
                        method : 'post',
                        data : { vendor_id : form_data, comment : data_comment},
                        dataType : "json"
                    })
                    .done(function(result) {
                        swal("Berhasil!", "Reject berhasil!", "success") 
                        var url = window.location.href;
                        if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                        url = url.split('/');
                        url.pop();
                        url.pop();
                        window.location = url.join('/') + '/job_list';
                    })
                    .fail(function(result) {
                        swal("Gagal!", "Reject error!", "error") 
                    }).always(function(data) {
                        console.log(data);
                    })
                    console.log("direject");
                } else {
                }
            }) 
    });

    $('#reject').click(function(e) {
            var form_data = $('#term_payment').val();
            var vendor = $('.vendor_id').val();
            var data_comment = $('#vnd_comment').val();

            if ($("#level").val() == 1) { // konfigurasi
                if (data_comment == '') {
                    swal("Warning!", "Komentar reject tidak boleh kosong !", "warning")
                    return false;
                }
            }

                e.preventDefault();
                    swal({
                        title: "Apakah Anda Yakin?",
                        text: "Apakah anda yakin akan melakukan reject data vendor!",
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
                            console.log(form_data);

                            if ($("#level").val() == 1) { // konfigurasi

                                        urlnya = '../reject_vendor';

                            } else if ($("#level").val() == 2 || $("#level").val() == 3) { // kasi dan kabiro

                                    urlnya = '../reject_vendor_registrasi';

                            } else {
                                swal("Warning!", "Anda Tidak Punya Akses Untuk Melakukan Action !", "warning")
                                e.preventDefault();
                                return false;
                            }

                            $.ajax({
                                url : urlnya,
                                method : 'post',
                                data : { vendor_id : vendor, term : form_data, comment : data_comment},
                                dataType : "json"
                            })
                            .done(function(result) {
                                swal("Berhasil!", "Reject berhasil!", "success")
                                var url = window.location.href;
                                if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                                url = url.split('/');
                                url.pop();
                                url.pop();
                                window.location = url.join('/') + '/job_list';
                            })
                            .fail(function(result) {
                                swal("Gagal!", "Reject error!", "error")
                            }).always(function(data) {
                                console.log(data);
                            })
                            console.log("direject");
                        } else {
                        }
                    }) 
            
    });

    $('#route-to-vendor').click(function(e) {
        var flag = true;
        $('.flag_panel').each(function() {
            value = $(this).val();
            if(value == "empty"){
                flag = false;
            }
        });
        if (!flag) {
            swal("Warning!", "Silakan cek semua panel isian vendor!", "warning")
        } else {
            var vendor_id = $('.vendor_id').val();
            var data_comment = $('#vnd_comment').val(); 
            var vendor_comment = $('#vendor_comment').val();
            
                e.preventDefault();
                    swal({
                        title: "Apakah Anda Yakin?",
                        text: "Apakah anda yakin untuk mengembalikan data ke vendor!",
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
                                url : '../route_to_vendor',
                                method : 'post',
                                data : { vendor_id : vendor_id, comment : data_comment, vendor : vendor_comment},
                                dataType : "json"
                            })
                            .done(function(result) {
                                swal("Berhasil!", "Road to vendor berhasil!", "success")
                                var url = window.location.href;
                                if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                                url = url.split('/');
                                url.pop();
                                url.pop();
                                window.location = url.join('/') + '/job_list';
                            })
                            .fail(function(result) {
                                swal("Gagal!", "Road to vendor error!", "error")
                            }).always(function(data) {
                                console.log(data);
                            })
                            console.log("rtv");
                        } else {
                        }
                    })
        }
    });

    $('#route-to-vendor-update').click(function(e) {
        var flag = true;
        $('.flag_panel').each(function() {
            value = $(this).val();
            if(value == ""){
                flag = false;
            }
        });
        if (!flag) {
            swal("Warning!", "Silakan cek semua panel isian vendor!", "warning")
        } else {
            var vendor_id = $('.vendor_id').val();
            var data_comment = $('#vnd_comment').val();
            var vendor_comment = $('#vendor_comment').val();

                e.preventDefault();
                    swal({
                        title: "Apakah Anda Yakin?",
                        text: "Apakah anda yakin untuk mengembalikan data ke vendor!",
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
                                url : '../route_to_vendor_update',
                                method : 'post',
                                data : { vendor_id : vendor_id, comment : data_comment, vendor : vendor_comment},
                                dataType : "json"
                            })
                            .done(function(result) {
                                swal("Berhasil!", "Road to vendor berhasil!", "success")
                                var url = window.location.href;
                                if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                                url = url.split('/');
                                url.pop();
                                url.pop();
                                window.location = url.join('/') + '/job_list';
                            })
                            .fail(function(result) {
                                swal("Gagal!", "Road to vendor error!", "error")
                            }).always(function(data) {
                                console.log(data);
                            })  
                        } else {
                        }
                    }) 
        }
    });

$('#cobabutton').click(function(){
    swal("Gagal","Button coba coba!", "error")
})
$('#cobabuttonwar').click(function(){
    swal("warning","Button coba coba!", "warning")
})
$('#cobabuttonsuk').click(function(){
    swal("sukses","Button coba coba!", "success")
})

})