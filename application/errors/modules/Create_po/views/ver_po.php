
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Detil Item PO</h2>
                    </div>
                    
                    
              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <table class="table table-hover">
                            <tr>
                                <td><strong>No Tender</strong></td>
                                <td>:</td>
                                <td><?php echo $data[0]['PTM_NUMBER']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>No RFQ</strong></td>
                                <td>:</td>
                                <td>
                                <?php echo $data[0]['RFQ']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kode Vendor</strong></td>
                                <td>:</td>
                                <td><?php echo $data[0]['KODE_VENDOR']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Vendor</strong></td>
                                <td>:</td>
                                <td><?php echo $data[0]['NAMA_VENDOR']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Haraga Terakhir</strong></td>
                                <td>:</td>
                                <td><?php echo $data[0]['HARGA_TERAKHIR']; ?></td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
               
            </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                        	<form action="<?php echo base_url('Create_po/update_status') ?>" method="post" >
                            <input type="hidden" id="id_pemenang" name="id_pemenang" value="<?php echo $data[0]['ID_PEMENANG']; ?>" />
                            
                            
                            <div class="panel panel-default">
                              <div class="panel-heading centered"><input type="submit" name="submit" id="submit" class="btn btn-success " value="Create PO" /></div>
                              <div class="panel-body">
                              
                              <table id="job-list-table" class="table table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th class="col-md-2">Nama Material</th>
                                        <th class="col-md-2">Harga TerAkhir</th>
                                        
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
                              
                              
                              
                              </div>
                               <div class="panel-footer centered"><a href="<?php echo base_url('Create_po');?>"  id="batal" name="batal"  class="btn btn-info " >Batal </a></div>
                            </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>