base_url = $("#base-url").val();
//alert(base_url);
var mytable;
var mytable_ ;


function loadTable_(){
	
	 mytable_ = $('#pr-list-table_tmp').DataTable({
        "dom": '<"toolbar">rt',
        "ajax" : {'url':base_url + 'Employee_pg/get_datatable_ub_tmp','type': 'POST',
		'data': function(d){d.idcom=$('#company').val(),d.kode_unit=$('#kode_unit').val()
								
								},
		} ,
        "processing": false,
		"serverSide": false,
		"order": [[ 4, "asc" ]],
		'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox">';
         }
      }],
        
        "columns":[
            {"data" : "ID"},
            {"data" : "DEPT_NAME"},
			{"data" : "POS_NAME"},
			{"data" : "FULLNAME"},
		   	//{"data" : "POS_ID","visible": false,},
			{"data" : "EM_SUB_GROUP","visible": false,},
			
			
		],
		fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
					
							$(nRow).on('click', function() {
							
							 	//$('#nama_proccess').val(aData['NAMA_BARU']);
//								$('#urutan').val(aData['CURRENT_PROCESS']);
//								$('#link_url').val(aData['PROCESS_MASTER_ID']);
//								$('#app_id').val(aData['PROCESS_ID']);
//								$('#simpandataub').val('Ubah');
								
							});
						 
							// Cell click
							
						  }
    });
	
	
	
	
	}

function loadTable () {
	//alert('');
    mytable = $('#pr-list-table').DataTable({
       // "dom": '<"toolbar">rtpf',
        "ajax" : {'url':base_url + 'Employee_pg/get_datatable_ub','type': 'POST',
		'data': function(d){d.idpros=$('#company').val()
								
								},
		} ,
        "processing": true,
		"serverSide": false,
		"columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
       
        "columns":[
           // {"data" : "BARIS"},
            {"data" : "DEPT_NAME"},
			{"data" : "POS_NAME"},
			{"data" : "FULLNAME"},
			{"data" : "COMPANYNAME"},
			{"data" : "PURC_GRP_ID"},
		   	{
                mRender : function(data,type,full){
                //console.log(full);
                return '<a href="' + $("#base-url").val() + 'Employee_pg/hapus_detil_proccess/'+full.ID+'/'+full.PURC_GRP_ID+'/'+full.PURC_COMPANY_ID+'" class="btn btn-default">Delete</a>'
            }},
			{"data" : "PURC_COMPANY_ID","visible": false,},
			{"data" : "ID","visible": false,},
			
		],
		fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
					
							$(nRow).on('click', function() {
							
							 	//$('#idem').val(aData['ID']);
//								$('#urutan').val(aData['CURRENT_PROCESS']);
//								$('#link_url').val(aData['PROCESS_MASTER_ID']);
//								$('#app_id').val(aData['PROCESS_ID']);
//								$('#simpandataub').val('Ubah');
								
							});
						 
							// Cell click
							
						  }
    });
	
	
		 
    // mytable.on( 'order.dt search.dt', function () {
//        mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
//            cell.innerHTML = i+1;
//        } );
//    } ).draw();
}




 //$("input").change(function(){
//				$(this).parent().parent().removeClass('has-error');
//				$(this).next().empty();
//			});
//			$("textarea").change(function(){
//				$(this).parent().parent().removeClass('has-error');
//				$(this).next().empty();
//			});
//			$("select").change(function(){
//				$(this).parent().parent().removeClass('has-error');
//				$(this).next().empty();
//			});
//			
//			var hapus='';
//			$('#batalub').click(function(){
//				$('#simpandataub').val('Simpan');
//				
//				$('#app_grp_id').val('');
//				
//				$('#form_ms_menu_ub').validationEngine('hideAll');
//				hapus='';
//				})
//
//			$("#form_ms_menu_ub").validationEngine({promptPosition : "topRight", scroll: false});
//			
//			 $('#form_ms_menu_ub').submit(function() { 
//		  var act='';
//		  if(hapus==''){act=$('#simpandataub').val();}else{act=hapus;}
//		   $(this).ajaxSubmit({
//			data:{"act":act},
//			beforeSubmit:  function (formData, jqForm, options) { 
//							if($('#form_ms_menu_ub').validationEngine("validate")){
//								var conf = confirm("Yakin Akan "+act+" Data Ini?");
//								if(conf) return true; else return false;
//								
//							}else{
//								return false;
//							}
//						} ,
//			success:       function(data)  { 
//			
//							if(data.dt.status) //if success close modal and reload ajax table
//							{
//								$('#simpandataub').val('Simpan');
//								hapus='';
//								$('#form_ms_menu_ub').resetForm();
//								$('#form_ms_menu_ub').clearForm();
//								alert(data.ket);
//								$('#batalub').trigger('click');
//								mytable.ajax.reload();
//							}
//							else
//							{
//								for (var i = 0; i < data.dt.inputerror.length; i++) 
//								{
//									
//									$('[name="'+data.dt.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
//									$('[name="'+data.dt.inputerror[i]+'"]').next().text(data.dt.error_string[i]); //select span help-block class set text error string
//								}
//							}
//							
//							
//							
//							//$("#batalub").trigger('click');
//							
//						} ,
//	 
//			url:base_url + 'Master_proccess/simdata',
//			type:"post",       
//			dataType:"JSON",   
//			//clearForm: true,   
//			//resetForm: true    
//	 
//			}); 
//	 
//			return false; 
//		}); 
//			
//			
//		
//		$('#hpusub').click(function(){
//			hapus='Hapus';
//			$('#form_ms_menu_ub').trigger('submit');
//							
//				
//			});
//			
//
//

$(document).ready(function(){
  
    loadTable();
	loadTable_();
	$('#company').change(function(){
		mytable.ajax.reload();
		
		//$.ajax({
//				  		type: "post",
//						url:base_url + 'Employee_pg/get_purch_grp',
//						data:{idcompany:$('#company').val()},
//						dataType: "html",
//						cache: true,
//						success: function(hsl) {
//							$("#nama_pg").html(hsl);
//							
//						}
//				  })
	})

	$('#company').change(function(){
		$.ajax({
		  		type: "post",
				url:base_url + 'Employee_pg/get_purch_grp',
				data:{idcompany:$('#company').val()},
				dataType: "html",
				cache: true,
				success: function(hsl) {
					$("#nama_pg").html(hsl);
				}
		  })
	})

	$('#company').each(function(){
		$.ajax({
		  		type: "post",
				url:base_url + 'Employee_pg/get_purch_grp',
				data:{idcompany:$('#company').val()},
				dataType: "html",
				cache: true,
				success: function(hsl) {
					$("#nama_pg").html(hsl);
				}
		  })
	})

	// $('#company').each(function(){
	// 	mytable.ajax.reload();
	// 	$.ajax({
	// 	  		type: "post",
	// 			l:base_url + 'Employee_pg/get_purch_grp',
	// 			data:{id:$('#nama_company').val()},
	// 			dataType: "html",
	// 			cache: true,
	// 			success: function(hsl) {
	// 				$("#nama_pg").html(hsl);
					
	// 			}
	// 	  })
	// })
	
//	$('#sampul').change(function(){
//		mytable.ajax.reload();
//		});
	
	//$('#ub_sel').trigger('click');
})



