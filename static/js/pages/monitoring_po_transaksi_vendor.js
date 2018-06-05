function loadData() {
    var strUser = $('#opco').val();

    $.ajax({
        url: $("#base-url").val() + 'Monitoring_po_import_vendor/getPoImportDB',
        data: {
            company: strUser
        },
        type: "post",
        dataType: "html",
        success: function (data) {
            $('#example1').dataTable().fnClearTable();
            $('#example1').dataTable().fnDestroy();

            $('#resultPO').html('');
            $('#resultPO').html(data);

            var table = $('#example1').DataTable({
                "columnDefs": [
                { "visible": false, "targets": 1 }
                ],
                "order": [[ 1, 'asc' ]],
                "displayLength": 25,
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="9">'+group+'</td></tr>'
                                );

                            last = group;
                        }
                    } );
                }
            });

            $('#example1 tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === 1 && currentOrder[1] === 'asc' ) {
                    table.order( [ 1, 'desc' ] ).draw();
                }
                else {
                    table.order( [ 1, 'asc' ] ).draw();
                }
            });

        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
        }
    });
}


$(document).ready(function(){
    loadData();
})