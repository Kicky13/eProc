	
base_url = $("#base-url").val();
//alert(base_url);
var mytable;

function loadTable () {
	//alert('');
    mytable = $('#pr-list-table').DataTable({
        "dom": '<"toolbar">rtp',
        "ajax" : {'url':base_url + 'Master_proccess/get_datatable_ub',
        'type': 'POST',
		'data': function(d) {
			d.nama_company=$('#nama_company').val(),
			d.sampul=$('#sampul').val(),
			d.just=$('#just').val()
			},
		},
        "processing": true,
		"serverSide": true,
		"orderMulti": true,
		"columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        },
		],
        
        "columns":[
            {"data" : "BARIS"},
            {"data" : "CURRENT_PROCESS"},
			{"data" : "NAMA_BARU"},
		   	{"data" : "COMPANYNAME"},
		  	{"data" : "PRC_SAMPUL_NAME"},
			{"data" : "PROCESS_MASTER_ID"},
			 {
                mRender : function(data,type,full){
                console.log(full);
                return '<a href="' + $("#base-url").val() + 'Master_proccess/akses_proccess/'+full.PROCESS_ID+'/'+full.KEL_PLANT_PRO+'" class="btn btn-default">Proses</a>'
            }},
			{"data" : "ASSIGNMENT","visible": false,},
			{"data" : "COMPANYID","visible": false,},
			{"data" : "TIPE_SAMPUL","visible": false,},
			{"data" : "PROCESS_ID","visible": false,},
			{"data" : "IDENTITAS_PROCCESS","visible": false,},
			{"data" : "KEL_PLANT_PRO","visible": false,},
			{"data" : "IS_ASSIGN","visible": false,},
			
			
			
			
		],
		fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
					
							$(nRow).on('click', function() {
								//alert(aData['ASSIGNMENT']);
								$('#assignment_').val(aData['ASSIGNMENT']);
							 	$('#nama_proccess').val(aData['NAMA_BARU']);
								$('#urutan').val(aData['CURRENT_PROCESS']);
								$('#link_url').val(aData['PROCESS_MASTER_ID']);
								$('#app_id').val(aData['PROCESS_ID']);
								$('#assign_to').val(aData['IS_ASSIGN']);
								$('#identitas_proccess').val(aData['IDENTITAS_PROCCESS']);
								$('#simpandataub').val('Ubah');
								
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

 $("input").change(function(){
		$(this).parent().parent().removeClass('has-error');
		$(this).next().empty();
	});
	$("textarea").change(function(){
		$(this).parent().parent().removeClass('has-error');
		$(this).next().empty();
	});
	$("select").change(function(){
		$(this).parent().parent().removeClass('has-error');
		$(this).next().empty();
	});
	
	var hapus='';
	$('#batalub').click(function(){
		$('#simpandataub').val('Simpan');
		$('#app_id').val('');
		$('#nama_proccess').val('');
		$('#urutan').val('');
		
		
		$('#app_grp_id').val('');
		
		$('#form_ms_menu_ub').validationEngine('hideAll');
		hapus='';
		})

	$("#form_ms_menu_ub").validationEngine({promptPosition : "topRight", scroll: false});
	
	$('#form_ms_menu_ub').submit(function() { 
		var act='';
		if(hapus==''){
			act=$('#simpandataub').val();
		} else {
			act=hapus;
		}

	    $(this).ajaxSubmit({
			data: {
				"act": act
			},
			beforeSubmit:  function (formData, jqForm, options) { 
				if($('#form_ms_menu_ub').validationEngine("validate")){
					var conf = confirm("Yakin Akan "+act+" Data Ini?");
					if(conf) return true; else return false;
				} else {
					return false;
				}
			} ,
			success: function(data)  {
				// if success close modal and reload ajax table 
				if(data.dt.status) {
					$('#simpandataub').val('Simpan');
					hapus='';
					//$('#form_ms_menu_ub').resetForm();
					//$('#form_ms_menu_ub').clearForm();
					alert(data.ket);
					$('#batalub').trigger('click');
					mytable.ajax.reload();
				} else {
					for (var i = 0; i < data.dt.inputerror.length; i++) {
						$('[name="'+data.dt.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
						$('[name="'+data.dt.inputerror[i]+'"]').next().text(data.dt.error_string[i]); //select span help-block class set text error string
					}
				}
				//$("#batalub").trigger('click');
				
			} ,

			url:base_url + 'Master_proccess/simdata',
			type:"post",       
			dataType:"JSON",   
			//clearForm: true,   
			//resetForm: true    

		}); 

		return false; 
	}); 
	
	

$('#hpusub').click(function(){
	hapus='Hapus';
	$('#form_ms_menu_ub').trigger('submit');
					
		
	});
	



$(document).ready(function(){
  	
    loadTable();
	$('#company').change(function(){
	
		mytable.ajax.reload();		
		});

	$('#nama_company').each(function(){
		mytable.ajax.reload();
		$.ajax({
		  		type: "post",
				url:base_url + 'Master_proccess/get_company',
				data:{id:$('#nama_company').val()},
				dataType: "html",
				cache: true,
				success: function(hsl) {
					$("#company").html(hsl);
					
				}
		  })
	})
		
	$('#nama_company').change(function(){
		mytable.ajax.reload();
		$.ajax({
				  		type: "post",
						url:base_url + 'Master_proccess/get_company',
						data:{id:$('#nama_company').val()},
						dataType: "html",
						cache: true,
						success: function(hsl) {
							$("#company").html(hsl);
							
						}
				  })
		})
	$('#sampul').change(function(){
		mytable.ajax.reload();
		});
	$('#just').change(function(){
		mytable.ajax.reload();
		});
	$('#form_ms_menu_ub').dblclick(function(){
			if($('#gendataub').attr('ub')==''){
				$('#gendataub').css('display','');
				$('#gendataub').attr('ub','1');
				}else{
					$('#gendataub').css('display','none');
					$('#gendataub').attr('ub','');
					}
			
		})
	
	$('#gendataub').click(function(){
		//if($('#nama_company').val()!='2'){
		//	return false;
		//	}
		//if($('#company').val()!='7000'){
		//	return false;
		//	}
		
		$.ajax({
			  type: "post",
			  url:base_url + 'Master_proccess/generate_data',
			  data:{company:$('#company').val(),nama_company:$('#nama_company').val(),sampul:$('#sampul').val(),just:$('#just').val()},
			  dataType: "JSON",
			  cache: true,
			  success: function(hsl) {
				  
				 //alert(hsl.ket);
				 mytable.ajax.reload();
				  
			  }
		})
		
	});		

})