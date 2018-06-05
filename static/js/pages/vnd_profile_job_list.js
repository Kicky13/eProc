var base_url = $('#base-url').val();
var panel_title;
$(document).ready(function(){
    var table_new_vendor = $('#new_vendor').DataTable( {
        "info": false,
        "lengthMenu": [ 5, 10, 25, 50 ],
        "ajax": {
            url: base_url+"Vendor_profile/get_new_vendor_need_update",
            type: 'POST'
        },
        "columnDefs": [{
            "targets": 0
        }],
        "columns":[
            {"data" : null},
            {"data" : "VENDOR_ID"},
            {"data" : "VENDOR_NAME"},
            {
                mRender : function(data,type,full){
                return '<a class="btn btn-default" href="vnd_document_update/'+full.VENDOR_ID+'">Detail</a>'
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