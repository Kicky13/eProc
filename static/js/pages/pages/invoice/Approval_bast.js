var TableDatatablesAjax = function () {
    var handle = function () {
        var urlTables = $("#datatable_ajax").data('urlsource');
        var urlForm = $("#datatable_ajax").data('urlform');
        var urlDelete = $("#datatable_ajax").data('urldelete');
        var mytable = $('#datatable_ajax').DataTable({
      		"bSort" : true,
      		"dom" : 'rtpli',
      		"deferRender" : true,
      		"colReorder" : true,
      		"pageLength" : 15,
      		"lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
      		"language" : {
      			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
      		},
      		"ajax" : urlTables,

        //  "serverSide": true,
        "columnDefs" : [{
          "searchable" : false,
          "orderable" : true,
          "targets" : 0
        }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete" : function() {
          $('#datatable_ajax tbody tr').each(function() {
            $(this).find('td').attr('nowrap', 'nowrap');
          });
        },
        "fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },

        "columns" : [
          {	mRender : function(data, type, full) {
    				    return full.NO_PO;;
            }
    			},
          {	mRender : function(data, type, full) {
    				    return full.NO_PO;
            }
          },
          {	mRender : function(data, type, full) {
      			    return full.PO_ITEM;
            }
          },
          {	mRender : function(data, type, full) {
                return full.CREATE_AT;
            }
    			},
          {	mRender : function(data, type, full) {
                return full.SHORT_TEXT;
            }
    			},
          {	mRender : function(data, type, full) {
                return full.VENDOR_NAME;
            }
    			},
          {	mRender : function(data, type, full) {
                return '<button class="btn btn-sm btn-success btn-rowedit" data-item='+full.ID+'>\
                                  <i class="fa fa-edit"></i> View\
                              </button>';
            }
    			},
    		]

        });

        /* handle edit button */
        mytable.on('click', '.btn-rowedit', function (e) {
          e.preventDefault();
          var _item = $(this).data('item');

          var _data = {
              id : _item
          };
          $.redirect(urlForm,_data,'POST');
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
});
