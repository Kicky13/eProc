base_url = $("#base-url").val();
var mytable;
$('.caridata').keyup(function(event){
				  if ( event.which == 13 ) {
						mytable.ajax.reload();
					  }
				
				})
function loadTable () {
    mytable = $('#tbl_group_akses').DataTable({
        "dom": '<"toolbar">rtp',
        "ajax" : {'url':base_url + 'Mapping_menupos/get_datatable_ub','type': 'POST',
		data: function(d){d.nama_company_f=$('#nama_company_f').val(),d.nama_unit_f=$('#nama_unit_f').val()
								,d.nama_jabatan_f=$('#nama_jabatan_f').val(),d.nama_posisi_f=$('#nama_posisi_f').val(),d.group_menu_f=$('#group_menu_f').val(),d.fullname_f=$('#fullname_f').val(), d.email_f=$('#email_f').val()
								},
		
		} ,
        "processing": true,
		"serverSide": true,
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
      
        "columns":[
            {"data" : "BARIS"},
            {"data" : "COMPANYNAME"},
			 {"data" : "DEPT_NAME"},
			  {"data" : "POS_NAME"},
			  {"data" : "FULLNAME"},
			  {"data" : "EMAIL"},
			   {"data" : "NAMA_GRP"},
			{"data" : "POS_ID","visible": false,},
			{"data" : "GROUP_MENU","visible": false,},
           
        ],
		fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
					
							$(nRow).on('click', function() {
							
							 	$('#fk_ms_group_id03').val(aData['GROUP_MENU']);
								$('#nama_jabatan').val(aData['POS_NAME']);
								$('#nama_unit').val(aData['DEPT_NAME']);
								$('#pos_id').val(aData['POS_ID']);
								
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
				$('#simpandataub').val('Ubah');
				$('#fk_ms_group_id03').val(1);
				$('#nama_jabatan').val('');
				$('#nama_unit').val('');
				$('#pos').val('0');
				
				$('#form_ms_menu_ub').validationEngine('hideAll');
				hapus='';
				})

			$("#form_ms_menu_ub").validationEngine({promptPosition : "topRight", scroll: false});
			
			 $('#form_ms_menu_ub').submit(function() { 
		  var act='';
		  if(hapus==''){act=$('#simpandataub').val();}else{act=hapus;}
		   $(this).ajaxSubmit({
			data:{"act":act},
			beforeSubmit:  function (formData, jqForm, options) { 
							if($('#form_ms_menu_ub').validationEngine("validate")){
								var conf = confirm("Yakin Akan "+act+" Data Ini?");
								if(conf) return true; else return false;
								
							}else{
								return false;
							}
						} ,
			success:       function(data)  { 
			
							if(data.dt.status) //if success close modal and reload ajax table
							{
								$('#simpandataub').val('Ubah');
								hapus='';
								$('#form_ms_menu_ub').resetForm();
								$('#form_ms_menu_ub').clearForm();
								alert(data.ket);
								$('#batalub').trigger('click');
								mytable.ajax.reload();
							}
							else
							{
								for (var i = 0; i < data.dt.inputerror.length; i++) 
								{
									
									$('[name="'+data.dt.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
									$('[name="'+data.dt.inputerror[i]+'"]').next().text(data.dt.error_string[i]); //select span help-block class set text error string
								}
							}
							
							
							
							//$("#batalub").trigger('click');
							
						} ,
	 
			url:base_url + 'Mapping_menupos/simdata',
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
	
	//$('#ub_sel').trigger('click');
})



