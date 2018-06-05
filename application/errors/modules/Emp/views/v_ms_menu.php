
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span>Master Data Employee</h2>
      </div>
      <div class="row">
        <div class="row ">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

               <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading1">
                      <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">Update</a></h4>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
                      <table class="table table-hover">
                            <tr>
                                <td class="col-md-1"></td>
                                <td class="col-md-1"><span class="badge btn-success">1</span></td>
                                <td class="col-md-2">Update Departemen</td>
                                <td class="col-md-4">
                                    <button type="button" id="btn_departemen" class="main_button color6 small_btn">Update</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-1"></td>
                                <td class="col-md-1"><span class="badge btn-success">2</span></td>
                                <td class="col-md-2">Update Jabatan</td>
                                <td class="col-md-4">
                                    <button type="button" id="btn_jabatan" class="main_button color6 small_btn">Update</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-1"></td>
                                <td class="col-md-1"><span class="badge btn-success">3</span></td>
                                <td class="col-md-2">Update Employee</td>
                                <td class="col-md-4">
                                    <button type="button" id="btn_employee" class="main_button color6 small_btn">Update</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-1"></td>
                                <td class="col-md-1"><span class="badge btn-success">4</span></td>
                                <td class="col-md-2">Update Atasan</td>
                                <td class="col-md-4">
                                    <button type="button" id="btn_atasan" class="main_button color6 small_btn">Update</button>
                                </td>
                            </tr>
                        </div>
                      </table>
                  </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title"><a id="data_col" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Custom Search</a></h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">

                  <div class="panel-body">

                    <div class="row">
                      <div class="col-md-2">
                        <div class="field">

                          <input type="text" value="" class="caridata form-control" id="nama_company_f" placeholder="Nama Company" />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="field">

                          <input type="text" value="" id="nama_unit_f" class="caridata form-control" placeholder="Nama Unit" />
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="field">

                          <input type="text" value="" id="kode_mkcctr" class="caridata form-control" placeholder="Kode MKCCTR" />
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="field filterub0">

                          <input type="text" value="" id="nama_jabatan_f" class="caridata form-control" placeholder="Nama Posisi" />
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="field filterub0">

                          <input type="text" value="" id="fullname_f" class="caridata form-control" placeholder="Nama Pegawai" />
                        </div>
                      </div>


                    </div>

                  </div>
                </div>
              </div>
              <hr>

              <div class="panel panel-default">
                <div class="table-responsive">
                  <table id="tbl_group_akses" class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>EMP ID</th>
                        <th>MKCCTR</th>
                        <th>Company</th>
                        <th>Unit</th>
                        <th>Posisi</th>
                        <th>Email</th>
                        <th>Employee</th>

                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>



        </div> 
      </div >
    </div >
  </div>
</section >
			

  <div class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tree Unit</h4>
                      </div>
                      <div class="modal-body">
                      	<div class="container-fluid">
                      		<div id="tampilbody"></div>
                        </div>
                      </div>
                       
                      </div>
                    </div>
                  </div>

		
		 <script>
			
		//	 $(document).ready(function () {
//			
//			$("#getParent31").click(function(){
//			 
//			  $.ajax({
//				  		type: "post",
//						url:"<?php echo base_url() ?>index.php/Mapping_menupos/load_data_tree",
//						dataType: "html",
//						cache: true,
//						success: function(hsl) {
//							$("#tampilbody").html(hsl);
//							$(".bs-example-modal-lg").modal("show");
//						}
//				  })
//			})
//			
//			
//			 $("input").change(function(){
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
//			$('#batal31').click(function(){
//				$('#simpandata31').val('Simpan');
//				$('#parent_id31').val('0');
//				$('#id31').val('');
//				
//				$('#form_ms_menu31').validationEngine('hideAll');
//				hapus='';
//				})
//			//$("#tree_menu").dynatree({
////				initAjax: {url: "<?php echo base_url() ?>index.php/Menu/getTree", 
////               	},
////				   onActivate: function(node) {
////				   	$('#simpandata31').val('Ubah');
////					$('#parent_kode31').val(node.data.parent_kode);
////					$('#parent_id31').val(node.data.parent_id);
////					$('#kode31').val(node.data.kode);
////					$('#url31').val(node.data.url);
////					$('#aktif31').val(node.data.aktif);
////					$('#id31').val(node.data.id);
////					$('#nama31').val(node.data.nama);
////				  },
////      			});
//			
//			
//			$("#form_ms_menu31").validationEngine({promptPosition : "topRight", scroll: false});
//			
//			 $('#form_ms_menu31').submit(function() { 
//		  var act='';
//		  if(hapus==''){act=$('#simpandata31').val();}else{act=hapus;}
//		   $(this).ajaxSubmit({
//			data:{"act":act},
//			beforeSubmit:  function (formData, jqForm, options) { 
//							if($('#form_ms_menu31').validationEngine("validate")){
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
//								$('#simpandata31').val('Simpan');
//								hapus='';
//								$("#tree_menu").dynatree("getTree").reload();
//								$('#form_ms_menu31').resetForm();
//								$('#form_ms_menu31').clearForm();
//								alert(data.ket);
//								$('#batal31').trigger('click');
//								
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
//							//$("#batal31").trigger('click');
//							
//						} ,
//	 
//			url:"<?php echo base_url()?>index.php/Mapping_menupos/crud",
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
//		$('#hpus31').click(function(){
//			hapus='Hapus';
//			$('#form_ms_menu31').trigger('submit');
//							
//				
//			});
//			
//			
//			
//			 })



			 		
			</script>
		
		
		
		


