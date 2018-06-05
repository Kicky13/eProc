base_url = $("#base-url").val();
var mytable;
function detail(pr) {
   // console.log(pr);
    $.ajax({
        url: base_url + 'Procurement_sap/get_detail/' + pr,
        type: 'GET',
        dataType: 'json',
    })
    .done(function(data) {
        /* populate material table */
        $table = $("#items_table");
        $table.html("");
        for (var i = 0; i < data.length; i++) {
            item = data[i];
            $tr = $("<tr>");
            $tr.append('<td class="text-center">' + (i+1-0) + '</td>');
            $tr.append('<td class="text-center">' + item.PRITEM + '</td>');
            $tr.append('<td class="text-center">' + item.NOMAT + '</td>');
            $tr.append('<td>' + item.DECMAT + '</td>');
            $tr.append('<td class="text-center">' + item.UOM + '</td>');
            $tr.append('<td class="text-center">' + item.QUANTOPEN + '</td>');
            $tr.append('<td class="text-center">' + item.POQUANTITY + '</td>');
            $tr.append('<td class="text-center">' + item.PRQUANTITY + '</td>');
            $tr.append('<td class="text-center">' + item.HANDQUANTITY + '</td>');
            $tr.append('<td class="text-center">' + item.NETPRICE + '</td>');
            $tr.append('<td class="text-center">' + item.MATGROUP + '</td>');
            $tr.append('<td class="text-center">' + item.RATAGI + '</td>');
            $tr.append('<td class="text-center">' + item.MAXGI + '</td>');
            $tr.append('<td class="text-center">' + item.LASTGI + '</td>');
            $tr.append('<td class="text-center">' + item.REALDATE + '</td>');
            $tr.append('<td class="text-center">' + item.POSTDATE + '</td>');
            $tr.append('<td class="text-center">' + item.MAX_GI_YEAR + '</td>');
            $tr.append('<td class="text-center">' + item.MAX_YEAR_GI + '</td>');
            $table.append($tr);
           // console.log($tr.html())
        };

        /* populate PR table */
        $("#prno").html(data[0].PRNO);
        $("#doctype").html(data[0].DOCTYPE);
        $("#doc_cat").html(data[0].DOC_CAT);
        $("#plant").html(data[0].PLANT);
        $("#porg").html(data[0].PORG);

        /* show modal */
        $("#modal-detail").modal('show');
    })
    .fail(function() {
        //console.log("error");
    })
    .always(function(data) {
        //console.log(data);
    });
}

function loadTable() {
    mytable = $('#pr-list-table').DataTable({

        "bSort": false,
        "dom": 'rtip',
        "ajax" : {'url':base_url + 'Monitoring_pr/get_datatable' + ($("#istor").html() == "true" ?  '/false' : '')},

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "PPR_PRNO"},
            {"data" : "PPR_DOCTYPE"},
            {"data" : "PPR_PLANT"},
            // {"data" : "PPR_REQUESTIONER"},
            {"data" : "PPR_DATE_RELEASE"},
            {
                mRender : function(data,type,full){
                            var str = full.DOC_UPLOAD_DATE;
                            str1 = str.substr(0,18);
                            str2 = str.substr(26,27);
                            return full.DOC_UPLOAD_DATE;
                        }
            },
            // {
            //     mRender : function(data,type,full){
            //         now = moment().format('YYYY-MM-DD');
            //         console.log(now);
            //         that = moment(full.DOC_UPLOAD_DATE, 'DD-MMM-YY hh.mm.ss').format('YYYY-MM-DD');
            //         console.log(that);
            //         diff = moment(now).diff(moment(that), "days");
            //         console.log(diff);
            //         return diff;
            // }},
            {
                mRender : function(data,type,full){
                //console.log(full);
                var ans = "";
                // if ($("#istor").html() == "true") {
                //     ans += '<a href="'+base_url+'Procurement_sap/store_tor/'+full.PPR_PRNO+'" class="main_button color1 small_btn '+full.PPR_STTVER+' '+full.PPR_STT_TOR+'">Unggah</a> ';
                // } else {
                //     ans += '<a href="'+base_url+'Procurement_sap/detail_pr/'+full.PPR_PRNO+'" class="main_button color1 small_btn '+full.PPR_STTVER+' '+full.PPR_STT_TOR+'">Proses</a> ';
                // }
                // ans += '<button type="button" class="btn btn-default" onclick="detail(\'' + full.PRNO +'\')">Detail</button> ';

                if(full.PPR_STTVER == "0" && full.PPR_STT_TOR == "1"){
                    ans += 'Verifikasi PR';
                } else if(full.PPR_STTVER == "1" && full.PPR_STT_TOR == "1"){
                    ans += 'Konfigurasi Perencanaan';
                } else if(full.PPR_STTVER == "2" && full.PPR_STT_TOR == "1"){
                    ans += 'Reject PR';
                }
                return ans;
                // return '<a href="../'+targetUrl[full.PPM_APPROVED_STATUS]+'/'+full.PPM_ID+'" class="btn btn-default">Proses</a>';
            }},
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
}

function loadLastUpdate() {
    $.ajax({
        url: base_url + 'Procurement_sap/get_latest_pr_sync',
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) {
        //console.log(data);
        $("#last_update").html(data.DATE);
    })
    .fail(function() {
        //console.log("error");
    })
}

$(document).ready(function(){
    loadLastUpdate();
    loadTable();
    // $("#filter").hide();
    $("#berdasarkan").change(function() {
        if ($(this).val() != "all") {
            $("#filter").show();
        } else {
            $("#filter").hide();
        }
    });
	$('.caridata').keyup(function(event){
		  if ( event.which == 13 ) {
				mytable.ajax.reload();
			  }
		
		
		})
	
})
$('#renewPR').on("click",function() {
    mytable.destroy();
    $('#curtain').css({ display: "block" });
    $.post(base_url+"Procurement_sap/sync_pr", {filter: $("#filter").val(), by: $("#berdasarkan").val()})
    .done(function() {
        loadLastUpdate();
        loadTable();
        $('#curtain').css({ display: "none" });
        $("#modal-renew").modal("hide");
    });
})
$("#tombolfilter").click(function() {
    var field = $('#fieldlook').val();
    var filter_method = $('#filtermethod').val();
    var filter_val = $('#searchfilter').val();
    
});