
<section class="content_section">
<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Group Akses</h2>
					</div>
<div class="row">


			
			<!-- Tabs Container -->
			<div class="hm-tabs tabs1">
				<nav>
					<ul class="tabs-navi">
						<li ><a data-content="inbox" id="ub_sel" class="selected" href="#"><span></span>Group Akses</a></li>
						<li><a data-content="new" href="#"><span></span>Mapping Group Akses</a></li>
						
					</ul>
					
				</nav>
			
				<ul class="tabs-body">
					<li data-content="inbox" style="height:400px" class="selected">
                    
                    
                    
				<div class="col-md-10 ">
                <form id="form_ms_menu_ub" name="form_ms_menu_ub" class="form-group">
                	<div class="row">
							 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">  
					 
                                    <label>Nama Group</label>
                                    <div class="field">
										 										
                                        <input name="namagroup" id="namagroup" type="text"  class=" form-control validate[required]" placeholder="Nama Group" value=""  />
										 <span class="help-block"></span>
                                    </div>

                             </div>
                             <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7" style="padding-top:2%">
             	<input type="hidden" id="app_grp_id" name="app_grp_id"  />
            	 <input type="submit" id="simpandataub" class="btn btn-success" value="Simpan">&nbsp;&nbsp;
                 <input  type="reset"  id="batalub" class="btn btn-info" value="Batal">&nbsp;&nbsp;
                 <input  type="button" id="hpusub" class="btn btn-danger" value="Hapus">&nbsp;&nbsp;
				
                
                
                         
          </div>
        </div>
        </form>
					<table id="pr-list-table" class="table table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Group</th>
								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
					</li>
				
					<li data-content="new">
					 <!--  <div class="panel panel-default">
                  <div class="panel-heading  ">Form Master Menu</div>
                  <div class="panel-body">-->

					<div class="col-md-10 ">
                    
								<form id="form_ms_menu31" name="form_ms_menu31" class="form-group">
                                   
                                   <input name="id31" id="id31" type="hidden" value="" />
								      
                                   <input name="parent_id31" id="parent_id31" type="hidden" value="0" />
								      
                               
								   						   
		<!--<div class="row">
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
        </div>-->
        <div class="row">					      
					 
					 
					 
					 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">  
					 
                                    <label>Group Akses</label>
                                    <div class="field">
										 										
                                      <?=form_dropdown('fk_ms_group_id03',$fk_ms_group_id03,'','id="fk_ms_group_id03"  class="form-control"')?>
										 <span class="help-block"></span>
                                    </div>
                             </div>   
		 </div>
       <!-- <div class="row">			 
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
                             </div></div> -->  
                                          
                                            <br />
         <div class="row">                            
            			
			<!--<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
             	
            	 <input type="submit" id="simpandata31" class="btn btn-success" value="Simpan">&nbsp;&nbsp;
                 <input  type="reset"  id="batal31" class="btn btn-info" value="Batal">&nbsp;&nbsp;
                 <input  type="button" id="hpus31" class="btn btn-danger" value="Hapus">&nbsp;&nbsp;
				
                
                
                         
          </div>-->
			
		</div>
           </form>
           
           
            
           <!-- </div>
            </div>-->
            
            			<div class="row ">   
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
                                
                                 <!--  <table id="list231"  cellpadding="0" cellspacing="0"></table>
                                    <div id="pager231"></div> -->
                
                               <div id="tree03"></div>
                                </div>
                        </div>
                        
                       </div>
					</li>
				
					
				</ul>
			</div>




		
		 


    
</div> 
</div >
</div >
</section >
			

 <!-- <div class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
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
                </div>-->

		
		 <script>
			
			 $(document).ready(function () {
			
			$("#fk_ms_group_id03").change(function(){
	 $.ajax({
					url: "<?php echo base_url() ?>index.php/Group_akses/getTree",
					 data: {
                      fk_ms_group_id : $("#fk_ms_group_id03").val()
                      }, 
					type : 'POST',
					dataType :'json',
					beforeSend:function(){                
					},
					success : function(data){
						$("#tree03").dynatree({children:data});
						$("#tree03").dynatree("getTree").reload();
					 }
					});
});

	
	$("#tree03").dynatree({
					 initAjax: {url: "<?php echo base_url() ?>index.php/Group_akses/getTree", 
               data: {
                      fk_ms_group_id : $("#fk_ms_group_id03").val()
                      },type : 'POST'
               },
               checkbox : true,
				onSelect: function(select, node) {
               	if($("#fk_ms_group_id03").val()==''){
               		alert("Pilih Group terlebih dahulu");
               		 return false;

               	}else{
               	 	$.ajax({
						url : "<?=base_url()?>index.php/Group_akses/crud",
						data : {
							action : (select)?'Simpan':'Hapus',
							fk_ms_group_id : $('#fk_ms_group_id03').val(),
							fk_ms_menu_id : node.data.id,
						},
						type : 'POST',
						dataType :'JSON',
						beforeSend:function(){             
						},
						success : function(data){
								alert(data.ket);
							
						 }
					});
               	 }

               }
      			});
 })
		



			 		
			</script>
		
		
		
		


