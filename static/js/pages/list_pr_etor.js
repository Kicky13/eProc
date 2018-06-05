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
		"processing": true,
        //"serverSide": true,
        "bSort": false,
        "dom": 'rtip',
        "ajax" : {'url':base_url + 'Procurement_sap/get_datatable' + ($("#istor").html() == "true" ?  '/false' : '')},

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
		"columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 8,
			"width": "120px"
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "PPR_PRNO"},
            // {"data" : "HEADER_TEXT"},
            {"data" : "PPR_DOCTYPE"},
            {"data" : "PPR_PLANT"},
            {"data" : "PPR_REQUESTIONER"},
            {"data" : "PPR_CREATED_BY"},
            {"data" : "PPR_DATE_RELEASE"},
            // {"data" : "DOC_UPLOAD_COUNTER"},
            {
                mRender : function(data,type,full){
                    if(full.DOC_UPLOAD_COUNTER == 0){
                        return 'Release';
                    }
                    if(full.PPR_STTVER == 0) {
                        return 'Reject Doc';
                    }else{
                        return 0;
                    }
            }},
            {
                mRender : function(data,type,full){
                //console.log(full);
                var ans = "";
                if ($("#istor").html() == "true") {
                    ans += '<a href="'+base_url+'Procurement_sap/store_tor/'+full.PPR_PRNO+'" data-toggle="tooltip" title="Upload Document" class="btn btn-info my-link"><i class="glyphicon glyphicon-upload red"></i></a>&nbsp;<a href="javascript:void(0)" onclick="nodoc(\''+full.PPR_PRNO+'\')" data-toggle="tooltip" title="PR Tanpa Document" class="btn btn-info"><span class="glyphicon glyphicon-ok"></span></a>';
					
                } else {
                    ans += '<a href="'+base_url+'Procurement_sap/detail_pr/'+full.PPR_PRNO+'" class="main_button color1 small_btn">Proses</a> ';
                }
                // ans += '<button type="button" class="btn btn-default" onclick="detail(\'' + full.PRNO +'\')">Detail</button> ';

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

   // $("div.toolbar").html('');

    //$('#search_no_pr').on( 'keyup', function () {
//        mytable
//            .columns( 1 )
//            .search( this.value )
//            .draw();
//    } );

    //$('#search_doc_type').on( 'keyup', function () {
//        mytable
//            .columns( 2 )
//            .search( this.value )
//            .draw();
//    } );
//
//    $('#search_plant').on( 'keyup', function () {
//        mytable
//            .columns( 3 )
//            .search( this.value )
//            .draw();
//    } );

    //mytable.on( 'order.dt search.dt', function () {
//        mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
//            cell.innerHTML = i+1;
//        } );
//    } ).draw();
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

    $.ajax({
        url: base_url + 'Procurement_sap/sync_contract',
        type: 'get',
        dataType: 'json',
    });
}

$(document).ready(function(){
	
	
    loadLastUpdate();
    loadTable();
    // $("#filter").hide();
    $("#berdasarkan").change(function() {
        if ($(this).val() == "pr") {
            $("#filter").attr('maxlength','10');
            $("#filter").val('');
            $("#filter").removeClass('hidden');
            $("#select_mrp").addClass('hidden');
        } else if ($(this).val() == "request") {
            $("#filter").attr('maxlength','10');
            $("#filter").val('');
            $("#filter").removeClass('hidden');
            $("#select_mrp").addClass('hidden');
        } else if ($(this).val() == "mrp") {
            $("#filter").addClass('hidden');
            $("#select_mrp").removeClass('hidden');
        } else {
            $("#filter").attr('maxlength','10');
            $("#filter").val($("#request").val());
        }
    });
	$('.caridata').keyup(function(event){
		  if ( event.which == 13 ) {
				mytable.ajax.reload();
			  }
		
		
		})
	$('.my-link').tooltip({placement: function(tip){
          $(tip).css('z-index',999999);
          return 'bottom';
}});
})
$('#renewPR').on("click",function() {
    mytable.destroy();
    // $('#curtain').css({ display: "block" });
    if ($("#berdasarkan").val() == "mrp") {
        mrp = [];
        $(".cekmrp:checked").each(function() {
            mrp.push({mrp: $(this).data('mrp'),plant: $(this).data('plant')})
        });
        post = {
                filter: mrp, 
                by: $("#berdasarkan").val()
            };
    } else {
        post = {
                filter: $("#filter").val(), 
                by: $("#berdasarkan").val()
            };
    }
    console.log(post);
    $.post(base_url+"Procurement_sap/sync_pr_etor", post)
    .done(function() {
        loadLastUpdate();
        loadTable();
        // $('#curtain').css({ display: "none" });
        $("#modal-renew").modal("hide");
        location.reload(); 
    });
})
$("#tombolfilter").click(function() {
    var field = $('#fieldlook').val();
    var filter_method = $('#filtermethod').val();
    var filter_val = $('#searchfilter').val();
    
});

function nodoc(dtid_pr){
	
	swal({
	  title: 'Apakah Anda Yakin?',
	  text: "Submit PRNO "+dtid_pr+" Tanpa Upload Document?",
	  type: 'warning',
	  
	  cancelButtonColor: '#d33',
      confirmButtonColor: '#92c135',
	  confirmButtonText: 'OK',
	  cancelButtonText: 'Tidak',
	  //cancelButtonClass: 'btn btn-danger',
      //confirmButtonClass: 'btn btn-success',
	  closeOnConfirm: true,
      closeOnCancel: true,
	  showCancelButton: true,
	  
		}).then(function(isConfirm) {
		  if (isConfirm) {
			
			$.ajax({
			url:base_url+'Procurement_sap/nodoc_upload/'+dtid_pr,
			type:"post",
			dataType:"JSON",
			success:function(data){
				
				mytable.ajax.reload();
				}
			})
		  }
	})
	
	
	}