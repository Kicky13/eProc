var ajaxParams = {};
var setAjaxParam = function(){
  var _nama, _val;
  ajaxParams = {};
  $('tr.sear>th>input').each(function(){
    _nama = $(this).data('column');
    _val = $.trim($(this).val());
    if(_val != ''){
      ajaxParams[_nama] = _val;
    }
  });
};
var TableDatatablesAjax = function () {
    var handle = function () {
        var urlTables = $("#datatable_ajax").data('urlsource');
        var urlForm = $("#datatable_ajax").data('urlform');
        var urlDelete = $("#datatable_ajax").data('urldelete');
        var _urlCetak = $("#base-url").val() + 'EC_Invoice_Management/showDocument';
        var mytable = $('#datatable_ajax').DataTable({
      		"dom" : 'rtpli',
      		"pageLength" : 15,
      		"lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
      		"language" : {
      			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
      		},
          "sort" : true,
      		"ajax" :urlTables,
          // "serverSide": true,
          "fnInitComplete" : function() {
            $('#datatable_ajax tbody tr').each(function() {
              $(this).find('td').attr('nowrap', 'nowrap');
            });
          },
          "fnCreatedRow": function (row, data, index) {
              $('td', row).eq(0).html(index + 1);
          },
          "drawCallback" : function(settings) {
            $('#datatable_ajax tbody tr').each(function() {
              $(this).find('td').attr('nowrap', 'nowrap');
            });
          },
          "columns" : [
            {	mRender : function(data, type, full) {
      				    return full.PO_NO;;
              }
      			},
            {	mRender : function(data, type, full) {
      				    return full.PO_NO;
              }
            },
            {	mRender : function(data, type, full) {
        			    return full.PO_ITEM_NO;
              }
            },
            {	mRender : function(data, type, full) {
                  return full.NO_RR;
              }
      			},
            {	mRender : function(data, type, full) {
                  return full.GR_YEAR;
              }
      			},
            {	mRender : function(data, type, full) {
                  return full.TXZ01;
              }
      			},
            {	mRender : function(data, type, full) {
                  return full.NAME1;
              }
      			},
            {	mRender : function(data, type, full) {
                  return full.STATUS;
              }
      			},
            {	mRender : function(data, type, full) {
                  return '<a href="#" class="btn btn-primary" data-nopo="'+full.PO_NO+'" data-tipe="RR" data-iddokumen="'+full.NO_RR+'" data-url="'+_urlCetak+'" onclick="return showDocument(this)">Cetak RR</a>';
              }
      			},
      		]
        });
        /* sorting ketika doble click */
        mytable.on('dblclick','thead>tr>th.ts' ,function() {
          var _index = $(this).index();
          var _sort = $(this).data('sorting') || 'asc';
          var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
          $(this).data('sorting',_nextSort);
          mytable.order([_index, _sort]).draw();
      	});
        var clicks = 0;
        mytable.on("click",'thead>tr>th.ts' ,function(e) {
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

        mytable.columns().every(function() {
      		var that = this;
      		$('.srch', this.header()).on('change', function() {
            setAjaxParam();
      			if (that.search() !== this.value) {
              if($(this).val().length >= 2){
                that.search(this.value).draw();
              }
      			}
      		});
      	});

        /* handle edit button */
        mytable.on('click', '.btn-rowedit', function (e) {
          e.preventDefault();
          var _idekspedisi = $(this).data('idekspedisi');
          var _url = $(this).data('url');

          var _data = {
            data : _idekspedisi
          };
          $.redirect(_url,_data,'POST','_blank');
        });

    }


    return {
        //main function to initiate the module
        init: function () {
            handle();
        }

    };

}();

$(document).ready(function() {
    TableDatatablesAjax.init();
    $(".sear").hide();
});
