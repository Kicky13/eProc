
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
      	<br/> 
      	<div class="row">
      		<ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a class="tab1" href="#pajak" aria-controls="pajak" role="tab" data-toggle="tab">Master Pajak</a></li>
			    <li role="presentation"><a class="tab2" href="#denda" aria-controls="denda" role="tab" data-toggle="tab">Master Denda</a></li>
			    <li role="presentation"><a class="tab2" href="#dokumen" aria-controls="dokumen" role="tab" data-toggle="tab">Master Dokumen Tambahan</a></li>
			    <li role="presentation"><a class="tab2" href="#doctype" aria-controls="doctype" role="tab" data-toggle="tab">Master Doc. Type</a></li>
			    <li role="presentation"><a class="tab2" href="#payblock" aria-controls="payblock" role="tab" data-toggle="tab">Master Payment Block</a></li>
			    <li role="presentation"><a class="tab2" href="#paymeth" aria-controls="paymeth" role="tab" data-toggle="tab">Master Payment Method</a></li>
			    <li role="presentation"><a class="tab2" href="#payterm" aria-controls="payterm" role="tab" data-toggle="tab">Master Payment Term</a></li>			    
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="pajak">
			    	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			            	<div class="row" style="border-bottom: 1px solid #ccc;">
			            		<br>
			            		<a href="<?php echo base_url('EC_Master_invoice/sapTax') ?>" type="button" style="margin-right: 20px" class="btn btn-info pjk btn-sm pull-right">
								Sync SAP
								</a>
			            		<br>
			            		<br>

			            	</div>
			            	<div class="row">
			            		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            		<table id="tableMT" class="table table-striped nowrap" width="100%">
	        		                <thead>
	        		                  <tr>
	        		                  	<th class="text-center ts0"><strong>Kode Tax</strong></th>
	        		                    <th class="text-center ts0"><strong>Deskripsi</strong></th>
	        		                    <th class="text-center ts1"><strong>Publish</strong></th> 
	        		                    <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th> --> 
	        		                  </tr> 
	        		                </thead>
	        		                <tbody> 
	        		                <?php for ($i=0; $i <sizeof($pajak) ; $i++) { 
	        		                	 ?>
	        		                	 <tr>
	        		                	 	<td class="text-center"><?php  echo $pajak[$i]['ID_JENIS']?></td>
	        		                	 	<td class="text-center"><?php  echo $pajak[$i]['JENIS']?></td>
	        		                	 	<td class="text-center"><input type="checkbox" <?php  echo $pajak[$i]['STATUS']=="1"?"checked":""?> onclick="setPublished(this,'<?php  echo $pajak[$i]['ID_JENIS']?>','EC_M_PAJAK_INV')" /></td>                                                                
	        		                	 	<!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
	        		                	 </tr>
	        		                	 <?php
	        		                }?>
	        		                </tbody>
	        		            </table>
					            </div>
			            	</div>
			            </div>
			          </div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="denda">
			    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			            <div class="row" style="border-bottom: 1px solid #ccc;">
			            		<br>
			            		<button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#dendaBaru"  class="btn btn-success btn-sm pull-right">
								Tambah
							</button>
			            		<br>
			            		<br>

			            	</div>
			                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            		<table id="tableMT" class="table table-striped nowrap" width="100%">
	        		                <thead>
	        		                  <tr>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Jenis</a></th>
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">GL Account</a></th> 
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Direct Action</a></th> 
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Publish</a></th> 
	        		                    <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th> 
	        		                  </tr> 
	        		                </thead>
	        		                <tbody> 
	        		                <?php for ($i=0; $i <sizeof($denda) ; $i++) { 
	        		                	 ?>
	        		                	 <tr>
	        		                	 	<td class="text-center"><?php  echo $denda[$i]['JENIS']?></td>
	        		                	 	<td class="text-center"><?php  echo $denda[$i]['GL_ACCOUNT']?></td>
	        		                	 	<td class="text-center"><?php  echo $denda[$i]['DIRECT_ACTION']?></td>
	        		                	 	<td class="text-center"><input onclick="setPublished(this,'<?php  echo $denda[$i]['ID_JENIS']?>','EC_M_DENDA_INV')" type="checkbox" <?php  echo $denda[$i]['STATUS']=="1"?"checked":""?> /></td>
	        		                	 	<td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#EditdendaBaru" data-jenis="<?php  echo $denda[$i]['JENIS']?>" data-gl="<?php  echo $denda[$i]['GL_ACCOUNT']?>" data-direct="<?php  echo $denda[$i]['DIRECT_ACTION']?>" data-iddenda="<?php  echo $denda[$i]['ID_JENIS']?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
	        		                	 </tr>
	        		                	 <?php
	        		                }?>
	        		                </tbody>
	        		            </table>
					            </div>			              
			            </div>
			        </div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="dokumen">
			    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			            <div class="row" style="border-bottom: 1px solid #ccc;">
			            		<br>
			            		<button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#docBaru" class="btn btn-success btn-sm pull-right">
								Tambah
								</button>
			            		<br>
			            		<br>

			            	</div>
			                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            		<table id="tableMT" class="table table-striped nowrap" width="100%">
	        		                <thead>
	        		                  <tr>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Jenis</a></th>
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Publish</a></th> 
	        		                    <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th> 
	        		                  </tr> 
	        		                </thead>
	        		                <tbody> 
	        		                <?php for ($i=0; $i <sizeof($doc) ; $i++) { 
	        		                	 ?>
	        		                	 <tr>
	        		                	 	<td class="text-center"><?php  echo $doc[$i]['JENIS']?></td>
	        		                	 	<td class="text-center"><input onclick="setPublished(this,'<?php  echo $doc[$i]['ID_JENIS']?>','EC_M_DOC_INV')" type="checkbox" <?php  echo $doc[$i]['STATUS']=="1"?"checked":""?> /></td>
	        		                	 	<td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#editdocBaru" data-jenis="<?php  echo $doc[$i]['JENIS']?>" data-docid="<?php  echo $doc[$i]['ID_JENIS']?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
	        		                	 </tr>
	        		                	 <?php
	        		                }?>
	        		                </tbody>
	        		            </table>
					            </div>			              
			            </div>
			        </div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="doctype">
			    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			            <div class="row" style="border-bottom: 1px solid #ccc;">
			            		<br>
			            		<a href="<?php echo base_url('EC_Master_invoice/sapDoctype') ?>" type="button" style="margin-right: 20px" class="btn btn-info pjk btn-sm pull-right">
								Sync SAP
								</a>
			            		<br>
			            		<br>

			            	</div>
			                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            		<table id="tableMT" class="table table-striped nowrap" width="100%">
	        		                <thead>
	        		                  <tr>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Jenis</a></th>
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Deskripsi</a></th> 
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Publish</a></th> 
	        		                    <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
	        		                  </tr> 
	        		                </thead>
	        		                <tbody> 
	        		                <?php for ($i=0; $i <sizeof($doctype) ; $i++) { 
	        		                	 ?>
	        		                	 <tr>
	        		                	 	<td class="text-center"><?php  echo $doctype[$i]['DOC_TYPE']?></td>
	        		                	 	<td class="text-center"><?php  echo $doctype[$i]['DOC_DESC']?></td>
	        		                	 	<td class="text-center"><input onclick="setPublished(this,'<?php  echo $doctype[$i]['ID_DOCTYPE']?>','EC_M_DOC_TYPE')" type="checkbox" <?php  echo $doctype[$i]['STATUS']=="1"?"checked":""?> /></td>
	        		                	 	<!-- <td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#editdocBaru" data-jenis="<?php  echo $doc[$i]['JENIS']?>" data-docid="<?php  echo $doc[$i]['ID_JENIS']?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
	        		                	 </tr>
	        		                	 <?php
	        		                }?>
	        		                </tbody>
	        		            </table>
					            </div>			              
			            </div>
			        </div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="payblock">
			    	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			            	<div class="row" style="border-bottom: 1px solid #ccc;">
			            		<br>
			            		<a href="<?php echo base_url('EC_Master_invoice/sapPayblock') ?>" type="button" style="margin-right: 20px" class="btn btn-info pjk btn-sm pull-right">
								Sync SAP
								</a>
			            		<br>
			            		<br>

			            	</div>
			            	<div class="row">
			            		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            		<table id="tableMT" class="table table-striped nowrap" width="100%">
	        		                <thead>
	        		                  <tr>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Kode</a></th>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Deskripsi</a></th>
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Publish</a></th> 
	        		                    <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th> 
	        		                  </tr> 
	        		                </thead>
	        		                <tbody> 
	        		                	 <tr>
	        		                	 	<td class="text-center"></td>
	        		                	 	<td class="text-center"></td>
	        		                	 	<td class="text-center"><input type="checkbox"></td>
	        		                	 	<td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
	        		                	 </tr>
	        		                </tbody>
	        		            </table>
					            </div>
			            	</div>
			            </div>
			          </div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="paymeth">
			    	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			            	<div class="row" style="border-bottom: 1px solid #ccc;">
			            		<br>
			            		<button type="button"style="margin-right: 20px"  class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#tbh-item">
								Sync SAP
								</button>
			            		<br>
			            		<br>

			            	</div>
			            	<div class="row">
			            		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            		<table id="tableMT" class="table table-striped nowrap" width="100%">
	        		                <thead>
	        		                  <tr>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Kode</a></th>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Deskripsi</a></th>
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Publish</a></th> 
	        		                    <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th> 
	        		                  </tr> 
	        		                </thead>
	        		                <tbody> 
	        		                	 <tr>
	        		                	 	<td class="text-center"></td>
	        		                	 	<td class="text-center"></td>
	        		                	 	<td class="text-center"><input type="checkbox"></td>
	        		                	 	<td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
	        		                	 </tr>
	        		                </tbody>
	        		            </table>
					            </div>
			            	</div>
			            </div>
			          </div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="payterm">
			    	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			            	<div class="row" style="border-bottom: 1px solid #ccc;">
			            		<br>
			            		<button type="button"style="margin-right: 20px"  class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#tbh-item">
								Sync SAP
								</button>
			            		<br>
			            		<br>

			            	</div>
			            	<div class="row">
			            		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            		<table id="tableMT" class="table table-striped nowrap" width="100%">
	        		                <thead>
	        		                  <tr>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Kode</a></th>
	        		                    <th class="text-center ts0"><a href="javascript:void(0)">Deskripsi</a></th>
	        		                    <th class="text-center ts1"><a href="javascript:void(0)">Publish</a></th> 
	        		                    <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th> 
	        		                  </tr> 
	        		                </thead>
	        		                <tbody> 
	        		                	 <tr>
	        		                	 	<td class="text-center"></td>
	        		                	 	<td class="text-center"></td>
	        		                	 	<td class="text-center"><input type="checkbox"></td>
	        		                	 	<td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
	        		                	 </tr>
	        		                </tbody>
	        		            </table>
					            </div>
			            	</div>
			            </div>
			          </div>
			    </div>

			</div>
      	</div>
      	<br><br>
      </div> 
    </div >
  </div >
</section>

<div class="modal fade" id="pajakBaru">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>Tambah Master Pajak Baru</u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<form class="form-horizontal" action="<?php echo base_url()?>/EC_Master_invoice/pajakBaru" method="post">
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
						    <div class="col-sm-8 upl">
						      <input type="text" class="form-control" required="" name="jenis" id="inputEmail3" placeholder="VZ (PPN masukan 0%)">
						    </div>
						  </div> 
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary">Tambah</button>
						    </div>
						  </div>
						</form>
					</div>						 
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="dendaBaru">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>Tambah Master Danda</u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<form class="form-horizontal" action="<?php echo base_url()?>/EC_Master_invoice/dendaBaru" method="post">
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="jenis" required="" id="inputEmail3" placeholder="">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-3 control-label">GL Account</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="glacc" required="" id="inputGl" placeholder="97000012">
						    </div>
						   </div>
						  <div class="form-group">
						    <div class="col-sm-offset-3 col-sm-10">
						      <div class="checkbox">
						        <label>
						          <input name="direct" onclick="setDirect(this)" type="checkbox"> Direct Amount
						        </label>
						      </div>
						    </div>
						  </div>
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary">Tambah</button>
						    </div>
						  </div>
						</form>
					</div>						 
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="EditdendaBaru">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>Edit Master Denda</u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<form class="form-horizontal" action="<?php echo base_url()?>/EC_Master_invoice/EditdendaBaru" method="post" onsubmit="return false">
						  <div class="form-group">
						  	<input type="hidden" id="ID_JENIS" name="ID_JENIS" />
						    <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="jenis" required="" id="inputjenis" placeholder="">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-3 control-label">GL Account</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="glacc" required="" id="glAccount" placeholder="97000012">
						    </div>
						   </div>
						  <div class="form-group">
						    <div class="col-sm-offset-3 col-sm-10">
						      <div class="checkbox">
						        <label>
						          <input name="direct" onclick="setDirect2(this)" id="checkboxdenda" type="checkbox"> Direct Amount
						        </label>
						      </div>
						    </div>
						  </div>
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <span class="btn btn-primary" onclick="updateDenda(this)">Simpan</span>
						    </div>
						  </div>
						</form>
					</div>						 
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="docBaru">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>Tambah Jenis Dokumen Baru</u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<form class="form-horizontal" action="<?php echo base_url()?>/EC_Master_invoice/docBaru" method="post">
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="jenis" required="" id="inputEmail3" placeholder="">
						    </div>
						  </div>  
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary">Tambah</button>
						    </div>
						  </div>
						</form>
					</div>						 
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editdocBaru">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>Edit Jenis Dokumen</u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<form class="form-horizontal" action="<?php echo base_url()?>/EC_Master_invoice/EditdocBaru" method="post">
						  <div class="form-group">
						  <input type="hidden" id="ID_DOC" name="ID_DOC" />
						    <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="jenis" required="" id="DokumenType" placeholder="">
						    </div>
						  </div>  
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary">Tambah</button>
						    </div>
						  </div>
						</form>
					</div>						 
				</div>
			</div>
		</div>
	</div>
</div>
