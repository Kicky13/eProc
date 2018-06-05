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

        var mytable = $('#datatable_ajax').DataTable({
      		"dom" : 'rtpli',
      		"pageLength" : 15,
      		"lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
      		"language" : {
      			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
      		},
          "sort" : true,
      		"ajax" : {
              url :urlTables ,
              type : 'POST',
              data : function(data){
                $.each(ajaxParams, function(key, value) {
                    data[key] = value;
                });
              }
          },
          "columnDefs" : [
            { "searchable" : false,
      			  "orderable" : false,
      			  "targets" : [0,1,2,3,4,5,6]},

          ],
          "order": [[ 2, "desc" ]],
          "serverSide": true,
          "drawCallback" : function(settings){
            var info = mytable.page.info();
            var start = info.page * info.length;
            if(info.recordsTotal){
              $('#datatable_ajax tbody tr').each(function(i) {
        				$(this).find('td:eq(0)').html( start + (i + 1) );
        			});
            }
          }
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
              if($(this).val().length >= 3){
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
