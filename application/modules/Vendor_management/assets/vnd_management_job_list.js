var base_url = $('#base-url').val();
var panel_title;
$(document).ready(function(){
    var table_new_vendor = $('#new_vendor').DataTable( {
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
            {"data" : "VENDOR_ID"},
            {"data" : "VENDOR_NAME"},
            {"data" : "regcode.REG_STATUS_NAME"},
            {"data" : "UPDATED_AT", "sClass": "text-center"},
            {
                mRender : function(data,type,full){
                    console.log(full);
                    var status = full.STATUS;
                    var next_url = '';
                    if (status == "1" || status == "99") {
                        next_url = 'approve_regisration';
                    }
                    else if (status =="3") {
                        next_url = 'approve_update_profile';
                    };
                return '<a class="btn btn-default" href="'+next_url+'/'+full.VENDOR_ID+'">Process</a>'
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
                alert("Success Saving Data!");
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

    $('.action-button').on('click', function(event) {
        event.preventDefault();
        panel_title = $(this).closest('.enar_occ_container').find('.enar_occ_title');
        console.log(panel_title);
        if (confirm('Are you sure want to submit your action?')) {
            var index = $(this).siblings('.form-group').find(".action-option").prop('selectedIndex');
            var container = $(this).val();
            var reason = $(this).closest('.acc_content').find('.reject-reason').val();
            var vendor_id = $('.vendor_id').val();
            $.ajax({
                url: base_url+'Vendor_management/submit_approval_action',
                type: 'POST',
                dataType: 'json',
                data: {index: index, container: container, reason: reason, vendor_id: vendor_id},
            })
            .done(function(data) {
                console.log(data);
                if (data.index == '1') {
                    console.log('red');
                    $(panel_title).removeClass('green').addClass('red');
                }
                else {
                    console.log('green');
                    $(panel_title).removeClass('red').addClass('green');
                }
            });
        };
    });

    $('#approve-staff').click(function() {
        if (confirm('Are you sure want to approve?')) {
            var form_data = $('#comment').serialize();
            console.log(form_data);
            $.ajax({
                url : '../update_approve_staff',
                method : 'post',
                data : form_data,
                dataType : "json",
                success : function(result) {
                    var url = window.location.href;
                    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    url = url.split('/');
                    url.pop();
                    url.pop();
                    window.location = url.join('/') + '/job_list';
                },
                error: function(result) {
                    console.log(result);
                    // var url = window.location.href;
                    // if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    // url = url.split('/');
                    // url.pop();
                    // url.pop();
                    // window.location = url.join('/') + '/job_list';
                }
            })
        }
    });

    $('#reject').click(function() {
        if (confirm('Are you sure want to reject?')) {
            var form_data = $('#comment').serialize();
            console.log(form_data);
            $.ajax({
                url : '../reject_vendor',
                method : 'post',
                data : form_data,
                dataType : "json",
                success : function(result) {
                    var url = window.location.href;
                    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    url = url.split('/');
                    url.pop();
                    url.pop();
                    window.location = url.join('/') + '/job_list';
                },
                error: function(result) {
                    var url = window.location.href;
                    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    url = url.split('/');
                    url.pop();
                    url.pop();
                    window.location = url.join('/') + '/job_list';
                }
            })
        }
    });

    $('#route-to-vendor').click(function() {
        var vendor_id = $('.vendor_id').val();
        if (confirm('Are you sure want to route to vendor?')) {
            $.ajax({
                url : '../route_to_vendor',
                method : 'POST',
                data : {vendor_id: vendor_id},
                dataType : "json",
                success : function(result) {
                    var url = window.location.href;
                    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    url = url.split('/');
                    url.pop();
                    url.pop();
                    window.location = url.join('/') + '/job_list';
                },
                error: function(result) {
                    var url = window.location.href;
                    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    url = url.split('/');
                    url.pop();
                    url.pop();
                    window.location = url.join('/') + '/job_list';
                }
            })
        }
    });

    $('#approve-vendor-update').click(function() {
        if (confirm('Are you sure want to approve vendor Update?')) {
            var form_data = $('#comment').serialize();
            console.log(form_data);
            $.ajax({
                url : '../accept_vendor_update',
                method : 'post',
                data : form_data,
                dataType : "json",
                success : function(result) {
                    console.log('ok');
                    var url = window.location.href;
                    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    url = url.split('/');
                    url.pop();
                    url.pop();
                    // window.location = url.join('/') + '/job_list';
                },
                error: function(result) {
                    console.log('error');
                    var url = window.location.href;
                    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
                    url = url.split('/');
                    url.pop();
                    url.pop();
                    // window.location = url.join('/') + '/job_list';
                }
            })
        }
    });
})