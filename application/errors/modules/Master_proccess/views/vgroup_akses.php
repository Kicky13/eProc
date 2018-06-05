
<section class="content_section">
<div class="content_spacer">
				<div class="content">
					<!--<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Administrasi Kantor</h2>
					</div>-->
<div class="row">

<div class="panel panel-default">
                  <div class="panel-heading  ">Form Master Menu</div>
                  <div class="panel-body">

					
                    
								<form id="form_ms_menu31" name="form_ms_menu31" class="form-group">
                                   
                                   <input name="id31" id="id31" type="hidden" value="" />
								      
                                   <input name="parent_id31" id="parent_id31" type="hidden" value="0" />
								      
                               
								   						   
		<div class="row">
							 <div class="col-xs-8 col-sm-2 col-md-2 col-lg-2">  
					 
                                    <label>Parent kode</label>
                                    <div class="field">
										 										
                                        <input name="parent_kode31" id="parent_kode31" type="text"  class=" form-control" placeholder="Parent kode" value="" disabled />
										 
                                    </div>

                             </div>
                             <div class="col-xs-8 col-sm-2 col-md-2 col-lg-2">
                             <label>&nbsp;</label>
                             <div class="field">
                             	<button id="getParent31" type="button" class="btn btn-primary">Kode</button>
                             	</div>
                             </div>  
        </div>
        <div class="row">					      
					 
					 <div class="col-xs-8 col-sm-2 col-md-2 col-lg-2">  
					 
                                    <label>Kode</label>
                                    <div class="field">
										 										
                                        <input name="kode31" id="kode31" type="text"  class="form-control  validate[required]" placeholder="Kode" value="" />
										 <span class="help-block"></span>
                                    </div>
                             </div>   
					 
					 <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">  
					 
                                    <label>Nama</label>
                                    <div class="field">
										 										
                                        <input name="nama31" id="nama31" type="text"  class="xxwide text input validate[required] form-control" placeholder="Nama" value="" />
										 <span class="help-block"></span>
                                    </div>
                             </div>   
		 </div>
        <div class="row">			 
					 <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">  
					 
                                    <label>Url</label>
                                    <div class="field">
										 										
                                        <input name="url31" id="url31" type="text"  class="xxwide text input validate[required] form-control" placeholder="Url" value="" />
										 <span class="help-block"></span>
                                    </div>
                             </div>   
					 

					 
					 <div class="col-xs-8 col-sm-2 col-md-2 col-lg-2">  
					 
                                    <label>Status</label>
                                    <div class="field">
                                    	<select class="form-control" id="aktif31" name="aktif31">
                                    	<option value="1" >Aktif</option>
                                    	<option value="0" >Tidak</option>
                                    </select>
										
										<span class="help-block"></span>
 
                                    </div>
                             </div></div>   
                                          
                                            <br />
         <div class="row">                            
            			
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
             	
            	 <input type="submit" id="simpandata31" class="btn btn-success" value="Simpan">&nbsp;&nbsp;
                 <input  type="reset"  id="batal31" class="btn btn-info" value="Batal">&nbsp;&nbsp;
                 <input  type="button" id="hpus31" class="btn btn-danger" value="Hapus">&nbsp;&nbsp;
				
                
                
                         
          </div>
			
		</div>
           </form>
            
            </div>
            </div>
		
		 <div class="row ">   
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
             	
            	 <!--  <table id="list231"  cellpadding="0" cellspacing="0"></table>
                	<div id="pager231"></div> -->

               <div id="tree_menu"></div>
          		</div>
        </div>


    
</div> 
</div >
</div >
</section >
			

  <div class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tree Menu</h4>
                      </div>
                      <div class="modal-body">
                      	<div class="container-fluid">
                      		<div id="tampilbody"></div>
                        </div>
                      </div>
                       
                      </div>
                    </div>
                  </div>
                </div>

		
		 <script>
			
			 $(document).ready(function () {
			
			$("#getParent31").click(function(){
			 
			  $.ajax({
				  		type: "post",
						url:"<?php echo base_url() ?>index.php/Menu/load_data_tree",
						dataType: "html",
						cache: true,
						success: function(hsl) {
							$("#tampilbody").html(hsl);
							$(".bs-example-modal-lg").modal("show");
						}
				  })
			})
			
			
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
			$('#batal31').click(function(){
				$('#simpandata31').val('Simpan');
				$('#parent_id31').val('0');
				$('#id31').val('');
				
				$('#form_ms_menu31').validationEngine('hideAll');
				hapus='';
				})
			$("#tree_menu").dynatree({
				initAjax: {url: "<?php echo base_url() ?>index.php/Menu/getTree", 
               	},
				   onActivate: function(node) {
				   	$('#simpandata31').val('Ubah');
					$('#parent_kode31').val(node.data.parent_kode);
					$('#parent_id31').val(node.data.parent_id);
					$('#kode31').val(node.data.kode);
					$('#url31').val(node.data.url);
					$('#aktif31').val(node.data.aktif);
					$('#id31').val(node.data.id);
					$('#nama31').val(node.data.nama);
				  },
      			});
			
			
			$("#form_ms_menu31").validationEngine({promptPosition : "topRight", scroll: false});
			
			 $('#form_ms_menu31').submit(function() { 
		  var act='';
		  if(hapus==''){act=$('#simpandata31').val();}else{act=hapus;}
		   $(this).ajaxSubmit({
			data:{"act":act},
			beforeSubmit:  function (formData, jqForm, options) { 
							if($('#form_ms_menu31').validationEngine("validate")){
								var conf = confirm("Yakin Akan "+act+" Data Ini?");
								if(conf) return true; else return false;
								
							}else{
								return false;
							}
						} ,
			success:       function(data)  { 
			
							if(data.dt.status) //if success close modal and reload ajax table
							{
								$('#simpandata31').val('Simpan');
								hapus='';
								$("#tree_menu").dynatree("getTree").reload();
								$('#form_ms_menu31').resetForm();
								$('#form_ms_menu31').clearForm();
								alert(data.ket);
								$('#batal31').trigger('click');
								
							}
							else
							{
								for (var i = 0; i < data.dt.inputerror.length; i++) 
								{
									
									$('[name="'+data.dt.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
									$('[name="'+data.dt.inputerror[i]+'"]').next().text(data.dt.error_string[i]); //select span help-block class set text error string
								}
							}
							
							
							
							//$("#batal31").trigger('click');
							
						} ,
	 
			url:"<?php echo base_url()?>index.php/Menu/crud",
			type:"post",       
			dataType:"JSON",   
			//clearForm: true,   
			//resetForm: true    
	 
			}); 
	 
			return false; 
		}); 
			
			
		
		$('#hpus31').click(function(){
			hapus='Hapus';
			$('#form_ms_menu31').trigger('submit');
							
				
			});
			
			
			
			 })



			 		
			</script>
		
		
		
		


