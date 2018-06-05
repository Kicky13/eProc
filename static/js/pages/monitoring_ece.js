$(document).ready(function(){
    var table_job_list = $('#ece-list-monitoring').DataTable({
        "ajax" : $("#base-url").val() + 'Monitoring_ece/get_datatable',
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 0, "desc" ]],
        
        "columns":[
            {"data" : null},
            {"data"  :"PTM_PRATENDER"},
            {"data"  :"PTM_SUBJECT_OF_WORK"},
            {"data" : "FULLNAME"},
            {
                mRender : function(data,type,full){
                    if(full.STATUS_APPROVAL == 0){
                        status = '<td>Evaluasi ECE</td>';
                    }else if(full.STATUS_APPROVAL == 1){
                        status = '<td>Approval Evaluasi ECE</td>';
                    }else if(full.STATUS_APPROVAL == 2){
                        status = '<td>Release Evaluasi ECE</td>';
                    }else if(full.STATUS_APPROVAL == -1){
                        status = '<td>Reject Evaluasi ECE</td>';
                    }else{
                        status = '<td>Not set</td>';
                    }
                    return status;
            }},
            {
                mRender : function(data,type,full){
                    console.log(full);
                    var button = '<a title="Monitoring ECE" href="' + $("#base-url").val() + 'Monitoring_ece/detail/'+full.PTM_NUMBER+'/'+full.EC_ID_GROUP+'" class="btn btn-default btn-sm glyphicon glyphicon-th-list"></a> ' + '<button title="Current job holder" onclick="openmodal('+full.EC_ID+')" class="btn btn-default btn-sm glyphicon glyphicon-user"></button>';
                    
                    return button;
                }
            },
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

});

function openmodal (id) {
    $.ajax({
        url: $("#base-url").val() + 'Monitoring_ece/get_holder/' + id,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) {
        table = $("#tableholder");
        table.html('');
        for (var i = 0; i < data.emp.length; i++) {
            emp = data.emp[i];
            table.append('<tr><td>' + emp.ID + '</td><td>' + emp.FULLNAME + '</td><td>' + emp.EMAIL + '</td></tr>');
        };
        $("#modalholder").modal('show')
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
}