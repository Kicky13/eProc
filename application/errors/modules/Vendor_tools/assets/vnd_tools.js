$(document).ready(function(){
    var url = window.location.href;
    if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
    url = url.split('/');
    url.pop();
    var location = url.join('/');
    var table_new_vendor = $('#new_vendor').DataTable( {
        "dom": 'rtip',
        "searching": true,
        "processing": true,
        "ordering": true,
        "lengthMenu": [ 10, 25, 50 ],
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

    $('#saveChecklistDocument').click(function(){
        // var form = $('.save_checklist_document');
        // $.each(form, function() {
        //     console.log($(this).closest("tr").children('status'));
        // });
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
                // location.reload();
            }
        })  
    });

    var table_vendor_registration_date = $('#vendor_registration_date_list').DataTable( {
        "dom": 'rtip',
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ 5, 10, 25, 50 ],
        "ajax": {
            url: location + "/get_vendor_registration_date",
            type: 'POST'
        },
        "columnDefs": [{
            "targets": 0
        }],
        "columns":[
            {"data" : null},
            {"data" : "COMPANYNAME"},
            {"data" : "OPEN_REG"},
            {"data" : "CLOSE_REG"},
            {
                mRender : function(data,type,full){
                return '<a class="btn btn-default" href="'+location+'/../update_vendor_registration_date/'+full.COMPANYID+'">Edit</a>'
            }, "sClass": "text-center"},
        ],
    } );

    table_vendor_registration_date.on( 'order.dt search.dt', function () {
        table_vendor_registration_date.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    table_vendor_registration_date.on('draw', function () {
        table_vendor_registration_date.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            console.log(cell);
        } );
    } ).draw();
})