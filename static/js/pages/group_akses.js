base_url = $("#base-url").val();
var mytable;

function loadTable () {
    mytable = $('#pr-list-table').DataTable({
        "dom": '<"toolbar">rtp',
        "ajax" : {'url':base_url + 'Group_akses/get_datatable_ub','type': 'POST'} ,
        "processing": true,
		"serverSide": true,
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : "BARIS"},
            {"data" : "NAMA_GRP"},
			{"data" : "APP_GRP_ID","visible": false,},
           
        ],
		fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
					
							$(nRow).on('click', function() {
							
							 	$('#namagroup').val(aData['NAMA_GRP']);
								$('#app_grp_id').val(aData['APP_GRP_ID']);
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
				
				$('#app_grp_id').val('');
				
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
								$('#simpandataub').val('Simpan');
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
	 
			url:base_url + 'Group_akses/simdata',
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



