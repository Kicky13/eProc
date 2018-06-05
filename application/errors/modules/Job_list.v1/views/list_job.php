<?php if (isset($cheat)): ?>
	<input type="hidden" id="cheat" value="true">
<?php else: ?>
	<input type="hidden" id="cheat" value="false">
<?php endif ?>
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Daftar Pekerjaan</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="hidden"><?php var_dump(compact('data')); ?></div>
                        	<?php if ($success): ?>
                        		<div class="alert alert-success alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<strong>Success!</strong> Data berhasil disimpan. <?php echo $tambahaninfo ?>
								</div>
                        	<?php elseif ($fail): ?>
                        		<div class="alert alert-warning alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<strong>Warning!</strong> Data gagal disimpan.
								</div>
                        	<?php elseif ($reject): ?>
                        		<div class="alert alert-success alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<strong>Rejected!</strong> Data berhasil direject.
								</div>
							<?php endif?>
							<?php if ($retender): ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Item berhasil di retender.</strong>
							</div>
							<?php endif ?> 
							<div class="panel panel-default">
							<div class="panel-body" style="overflow: auto;" >
								<table id="job-list-table" class="table table-striped" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th class="col-md-2">Usulan Pratender</th>
											<th class="col-md-2">Pratender</th>
											<th>Deskripsi</th>
											<th class="text-center">PGRP</th>
											<th>Status</th>
											<th>Tanggal Aktivitas</th>
											<th class="text-center">Action</th>
										</tr>
										<tr>
						                  <th></th>
						                  <th><input type="text" class="col-xs-12"></th>
						                  <th><input type="text" class="col-xs-12"></th>
						                  <th><input type="text" class="col-xs-12"></th>
						                  <th><input type="text" class="col-xs-12"></th>
						                  <th><input type="text" class="col-xs-12"></th>
						                  <th><input type="text" class="col-xs-12"></th>
						                  <th></th>
						                </tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							</div>
							<br/><br/><br/>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="modal fade" id="modalitemstatus">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span></button>
		          <h4 class="modal-title">Item Status</h4>
		        </div>
		        <div class="modal-body">
		          <div class="panel panel-default">
		            <table class="table table-striped">
		              <thead>
		                <th>PR No</th>
		                <th>PR Item</th>
		                <th>Nomor Material</th>
		                <th>Item Material</th>
		                <th>Status</th>
		              </thead>
		              <tbody id="tableitemstatus">
		              </tbody>
		            </table>
		          </div>
		          <div class="text-right">
		            
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>