$(document).ready(function(){
    status = $("#status").val();
    var table_job_list = $('#auction-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Auction/get_datatable/'+ status,
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 4, "desc" ]],
        
        "columns":[
            {"data" : null},
            {"data" : "PTM_SUBPRATENDER"},
            {"data"  :"PTM_PRATENDER"},
            {"data"  :"PTM_SUBJECT_OF_WORK"},
            // {"data" : "PAQH_OPEN_STATUS"},
            {
                mRender : function(data,type,full){
                    var datenow = new Date();

                    if(full.PAQH_AUC_START == null){
                        return '<td>Belum setup</td>';
                    }
                    else {
                        var endDate = full.strPAQH_AUC_END;
                        endDate = endDate.split(' ');
                        var date = endDate[0];
                        date = date.split('-');
                        date = date[1]+' '+date[0]+' 20'+date[2];
                        var time = endDate[1];
                        var deadline = date+' '+time;

                        var startDate = full.strPAQH_AUC_START;
                        startDate = startDate.split(' ');
                        var date = startDate[0];
                        date = date.split('-');
                        date = date[1]+' '+date[0]+' 20'+date[2];
                        var time = startDate[1];
                        var startline = date+' '+time;

                        var strPAQH_AUC_END = new Date(deadline);
                        var strPAQH_AUC_START = new Date(startline);

                        if(full.PAQH_OPEN_STATUS == 1 && datenow > strPAQH_AUC_START && datenow < strPAQH_AUC_END){
                            return '<td>Proses Auction</td>';
                        }
                        else if(full.PAQH_OPEN_STATUS == 1 && datenow > strPAQH_AUC_END){
                            return '<td>Selesai</td>';
                        }
                        else if(full.PAQH_OPEN_STATUS == 0){
                            return '<td>Telah Setup</td>';
                        } else if(full.PAQH_OPEN_STATUS == 1 && datenow < strPAQH_AUC_START){
                            return '<td>Persiapan Auction</td>';
                        } else{
                            if(full.BREAKDOWN_TYPE=='S'){
                                return '<td>Breakdown Sendiri</td>';
                            }else{
                                return '<td>Breakdown Vendor</td>';
                            }
                            
                        }
                    }
            }},
            {
                mRender : function(data,type,full){
                    if(full.PAQH_AUC_START == null){
                        return '<td>-</td>';
                    }
                    else {
                        var startDate = full.strPAQH_AUC_START;
                        startDate = startDate.split(' ');
                        var date = startDate[0];
                        date = date.split('-');
                        date = date[0]+' '+date[1]+' 20'+date[2];
                        var time = startDate[1];
                        var startline = date+' '+time;

                        return '<td>' + startline + '</td>';
                    }
            }},
            {
                mRender : function(data,type,full){
                    if(full.PAQH_AUC_END == null){
                        return '<td>-</td>';
                    }
                    else {
                        var endDate = full.strPAQH_AUC_END;
                        endDate = endDate.split(' ');
                        var date = endDate[0];
                        date = date.split('-');
                        date = date[0]+' '+date[1]+' 20'+date[2];
                        var time = endDate[1];
                        var deadline = date+' '+time;

                        return '<td>' + deadline + '</td>';
                    }
            }},
            {
                mRender : function(data,type,full){
                    var now = new Date();
                    if(full.PAQH_AUC_START == null){
                        return '<a href="' + $("#base-url").val() + 'Auction/create/'+full.PTM_NUMBER+'" class="btn btn-default">Setup</a>'
                    }
                    else {
                        var startDate = full.strPAQH_AUC_START;
                        startDate = startDate.split(' ');
                        var date = startDate[0];
                        date = date.split('-');
                        date = date[0]+' '+date[1]+' 20'+date[2];
                        var time = startDate[1];
                        var startline = date+' '+time;
                        startline = new Date(startline);

                        var endDate = full.strPAQH_AUC_END;
                        endDate = endDate.split(' ');
                        var date = endDate[0];
                        date = date.split('-');
                        date = date[0]+' '+date[1]+' 20'+date[2];
                        var time = endDate[1];
                        var deadline = date+' '+time;
                        deadline = new Date(deadline);

                        if(full.PAQH_OPEN_STATUS == 0){
                            return '<a href="' + $("#base-url").val() + 'Auction/edit_konfig/'+full.PAQH_ID+'" class="btn btn-default">Edit</a> <a href="' + $("#base-url").val() + 'Auction/show/'+full.PAQH_ID+'" class="btn btn-default">Proses</a>'
                        } else if(full.PAQH_OPEN_STATUS == 1){
                            return '<a href="' + $("#base-url").val() + 'Auction/edit_konfig/'+full.PAQH_ID+'" class="btn btn-default">Edit</a> <a href="' + $("#base-url").val() + 'Auction/show/'+full.PAQH_ID+'" class="btn btn-default">Proses</a>'
                        } else {
                            return '<a href="' + $("#base-url").val() + 'Auction/monitor/'+full.PAQH_ID+'" class="btn btn-default">Proses</a>'
                        }
                    }
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

})