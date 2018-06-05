$(document).ready(function(){
    base_url = $("#base-url").val();
    var mytable;

    mytable = $('#grid_vendor').DataTable({

        "bSort": false,
        "dom": 'rtip',
        "ajax" : {'url':base_url + 'Update_dirven/get_vendor'},

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "VENDOR_NO", "sClass": "text-center"},
            {"data" : "VENDOR_NAME"},
           	{
				mRender : function(data,type,full){
					alamat = '';
					if (full.ADDRESS_STREET != null) {
						alamat += full.ADDRESS_STREET+', ';
					}
					if (full.ADDRESS_CITY != null) {
						alamat += full.ADDRESS_CITY+', ';
					} 
					if (full.ADDRESS_PROP != null) {
						alamat += full.ADDRES_PROP;
					} 
				return alamat;
				},
			},	
			{"data" : "ADDRESS_PHONE_NO"},
            {
                mRender : function(data,type,full){
                
                    ans = '<a title="Update Dirven" href="' + base_url + 'Update_dirven/detail/'+full.VENDOR_ID+'" class="btn btn-default btn-sm glyphicon glyphicon-pencil"></a>';
                    return ans;
            }, "sClass": "text-center"},
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
})
// var base_url = $('#base-url').val();

// $(document).ready(function(){

//     var table = $('#grid_vendor').DataTable( {
//         "bSort": false,
//         "dom": 'rtip',
//         "pageLength":10,
//         "deferRender": true,
//         "serverSide":true,
//         "processing":true,
//         "paging":true,
// 		"ajax": {
// 			url : base_url + "Update_dirven/get_datatable",
// 			type: 'POST',
// 		},
// 		"columnDefs": [{
// 			"searchable": false,
//             "orderable": false,
// 			"targets": 0
// 		}],
// 		"columns":[
// 			{"data" : null},
// 			{"data" : "VENDOR_NO"},
// 			{"data" : "VENDOR_NAME"},
// 			{
// 				mRender : function(data,type,full){
// 					alamat = '';
// 					if (full.ADDRESS_STREET != null) {
// 						alamat += full.ADDRESS_STREET+', ';
// 					}
// 					if (full.ADDRESS_CITY != null) {
// 						alamat += full.ADDRESS_CITY+', ';
// 					} 
// 					if (full.ADDRESS_PROP != null) {
// 						alamat += full.ADDRESS_PROP;
// 					} 
// 				return alamat;
// 				},
// 			},	
// 			{"data" : "ADDRESS_PHONE_NO"},	
// 			{
//                 mRender : function(data,type,full){
//                     console.log(full);
//                     return '<a title="Update Dirven" href="' + base_url + 'Update_dirven/detail/'+full.VENDOR_ID+'" class="btn btn-default btn-sm glyphicon glyphicon-pencil"></a>';
//                 }
//             },
// 		],
// 	} );

// 	table.on('draw', function () {
// 		table.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
// 			cell.innerHTML = i+1;
// 		} );
// 	} ).draw();
// 	table.columns().every( function () {
//         var that = this;
    
//         $( 'input', this.header() ).on( 'keyup change', function () {
//             if ( that.search() !== this.value ) {
//                 that.search( this.value ).draw();
//             }
//         });
//     });

// });