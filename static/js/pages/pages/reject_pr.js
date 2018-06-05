$(document).ready(function(){
    base_url = $("#base-url").val();
    var table_job_list = $('#pr-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Procurement_sap/get_datatablereject/',
        
        // "columnDefs": [{
        //     "searchable": false,
        //     "orderable": false,
        //     "targets": 0
        // }],

        "order": [[ 3, "asc" ]],
        
        "columns":[
            {"data" : "PPV_PRNO"},
            {"data" : "PPV_USER"},
            {
            mRender : function(data,type,full){
                        var str = full.PPV_DATE;
                        str1 = str.substr(0,18);
                        str2 = str.substr(26,27);
                        return str1 + ' ' + str2;
                    }
            },
            {
                mRender : function(data,type,full){
                    ans = '<a href="'+base_url+'Procurement_sap/rejectPR/'+full.PPV_ID+'" class="main_button color1 small_btn">Detail</a> ';
                return ans;
            }},
        ],
    });

})