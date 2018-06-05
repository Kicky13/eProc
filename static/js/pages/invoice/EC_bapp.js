function loadtable_bapp(status,target) {

	$(target +' .table_bapp').DataTable().destroy();
	$(target +' .table_bapp tbody').empty();
	mytable = $(target +' .table_bapp').DataTable({
		"bSort" : true,
		"dom" : 'rtpli',
		"deferRender" : true,
		"colReorder" : true,
		"pageLength" : 15,
		// "fixedHeader" : true,
		// "scrollX" : true,
		"lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_Vendor/Bapp/getAllBapp/'+status,

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		// "order": [[ 1, 'asc' ]],
		"fnInitComplete" : function() {
			/* $('#table_bapp tbody tr').each(function() {
				 $(this).find('td').attr('nowrap', 'nowrap');
			});
			*/
		},
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
		"drawCallback" : function(settings) {
		/*	$('#table_bapp tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
			*/
		},
		"columns" : [
                 {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.NO_PO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.NO_BAPP;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.CREATE_AT;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12' style='max-width:350px'>";
				a += full.DESCRIPTION;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				if (full.STATUS == '1') {
					status = "Draft";
				} else if (full.STATUS == '2') {
					status = "Submited";
				} else if (full.STATUS == '3') {
					status = "Approved";
				} else if (full.STATUS == '4') {
					status = "Rejected";
				}
				a = "<div class='col-md-12 text-center'>";
				a += status;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 '>";
				a += "<a href='"+$('#base-url').val()+"EC_Vendor/Bapp/form/"+full.ID+"/' title='Detail BAPP'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				if(full.STATUS == '1' || full.STATUS == '4'){
					// a += "<a href='"+$('#base-url').val()+"EC_Vendor/Bapp/submitBapp/"+full.ID+"' title='Submit BAPP'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;";
					 a += "<a onclick=\"bootbox.confirm('Apakah anda yakin ?',function(r){ if(r){ window.location.href = '"+$('#base-url').val()+"EC_Vendor/Bapp/submitBapp/"+full.ID+"'}  })\" href='javascript:void()' title='Hapus BAPP'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;"
					 a += "<a onclick=\"bootbox.confirm('Apakah anda yakin ?',function(r){ if(r){ window.location.href = '"+$('#base-url').val()+"EC_Vendor/Bapp/delete/"+full.ID+"'}  })\" href='javascript:void()' title='Hapus BAPP'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>&nbsp;&nbsp;"
				}
				a += "<a href='"+$('#base-url').val()+"EC_Vendor/Bapp/cetak/"+full.ID+"' target='_blank' title='Cetak BAPP'><span class='glyphicon glyphicon-print' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "<a href='javascript:void(0)' onclick='showHistory("+full.ID+")'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>";
				a += "</div>";
				return a;
			}
		}],

	});

	mytable.columns().every(function() {
		var that = this;
		$('.srch', this.header()).on('keyup change', function() {
			if (that.search() !== this.value) {
				that.search(this.value).draw();
			}
		});
	});

	$(target +' .table_bapp').find("th").off("click.DT");
	mytable.on('dblclick','thead>tr>th.ts' ,function() {
		var _index = $(this).index();
		var _sort = $(this).data('sorting') || 'asc';
		var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
		$(this).data('sorting',_nextSort);
		mytable.order([_index, _sort]).draw();
	});

}

function showHistory(id){
	var _url = $("#base-url").val() + 'EC_Vendor/Bapp/history';
	$.get(_url,{id : id},function(data){
		bootbox.dialog({
			title : 'History BAPP',
			message : data
		})
	},'html');
}

var t0 = true,
    t1 = true,
    t2 = true,
    t3 = true,
    t4 = true,
    t5 = true,
    clicks = 0,
    timer = null;
var t = [t0, t1, t2, t3, t4, t5];

$(document).ready(function() {
	$('[data-toggle="tab"]').click(function (e) {
    var $this = $(this),
        target = $this.attr('href');

    //Add the selector of the element you want to fetch from the external page to the url (with a blank space in between)
		var _tbody = $(target).find('table tbody');

		if(_tbody.find('tr').length){
			$this.tab('show');
		}else{
			if(target == '#request'){
				loadtable_bapp('request',target);
			}
			if(target == '#approved'){
				loadtable_bapp('approved',target);
			}
			$this.tab('show');
		}
    return false;
});
	$('[data-toggle="tab"]').eq(0).click();
  $(".sear").hide();
	//for (var i = 0; i < t.length; i++) {
		$(".ts").on("click", function(e) {
			clicks++;
			if (clicks === 1) {
				timer = setTimeout(function() {
					$(".sear").toggle();
					clicks = 0;
				}, 300);
			} else {
				clearTimeout(timer);
				$(".sear").hide();
				clicks = 0;
			}
		}).on("dblclick", function(e) {
			e.preventDefault();
		});
	//};
});
