<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<div class="row">
				Select User Employee<br>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
					<input type="hidden" name="ID_USER" id="ID_USER" value="">
					<input type="text" id="txt_Nama" name="txt_Nama" class="nama" value="" size="30" placeholder="Select User Employee">
				</div>
			</div>
			<br>
			<div class="row">
				Select Akses Category
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
                                
                                 <!--  <table id="list231"  cellpadding="0" cellspacing="0"></table>
                                    <div id="pager231"></div> -->
                
                               <div id="tree03"></div>
                                </div>
				</div>
			<div class="row" style="display: none;">
				<div class="row">
					<div class="col-lg-offset-1 col-lg-3" style="overflow: auto; max-height: 80vh;">
						<ul>
							<a href="javascript:void(0)" onclick="setCode('lvl0',this)" class="lvl0">/ROOT</a>
						</ul>
						<ul id="tree1"> 
						</ul> 
					</div>
					<div class="col-lg-8">
					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Tambah Baru</a></li>
					    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Edit Data</a></li>
					  </ul>
					
					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="home"><br />
							<?php echo form_open_multipart('EC_Master_category/baru/', array('method' => 'POST', 'class' => 'form-horizontal formBaru')); ?>
								<div class="form-group">
									<label for="parent" class="col-sm-2 control-label">Parent</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="parent" id="parent" required readonly="">
									</div>
								</div>
								<div class="form-group">
									<label for="kode" class="col-sm-2 control-label">Kode</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="kode" id="kode" required readonly="">
									</div>
								</div>
								<div class="form-group">
									<label for="desc" class="col-sm-2 control-label">Deskripsi</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="desc" id="desc" placeholder="Deskripsi" required="">
									</div>
								</div> 
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" id="btn-smpn" class="btn btn-default">
											Tambah
										</button>
									</div>
								</div>
							</form>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="profile"><br />
							<?php echo form_open_multipart('EC_Master_category/edit/', array('method' => 'POST', 'class' => 'form-horizontal formEdit')); ?>
								<div class="form-group">
									<label for="parentEdit" class="col-sm-2 control-label">Kode Category</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="parent" id="kodeEdit" required readonly="">
										<input type="hidden" name="idEdit" id="idEdit" />
									</div>
								</div>
								<!-- <div class="form-group">
									<label for="kodeEdit" class="col-sm-2 control-label">Kode</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="kode" id="kodeEdit" required readonly="">
									</div>
								</div> -->
								<div class="form-group">
									<label for="descEdit" class="col-sm-2 control-label">Deskripsi</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="descEdit" id="descEdit" placeholder="Deskripsi" required="">
									</div>
								</div> 
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="button" id="btnEdit" value="ubah" name="submit" class="btn btn-info">
											Ubah
										</button>
										<button type="button" value="hapus" id="btnDelete" name="submit" class="btn btn-danger">
											Hapus
										</button>
									</div>
								</div>
							</form>					    	
					    </div>
					  </div>

					</div>
				</div>
			</div>
		</div >
	</div >
</section>

<script>
			
			 $(document).ready(function () {
			
			$("#fk_ms_group_id03").change(function(){
	 				$.ajax({
					url: "<?php echo base_url() ?>index.php/EC_Master_user_category/getTree",
					 data: {
                      user_id : $("#fk_ms_group_id03").val()
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
				initAjax: {url: "<?php echo base_url() ?>index.php/EC_Master_user_category/getTree", 
               	data: {
                      user_id : '0'
                      },type : 'POST'
               	},
               	checkbox : true,
               	// selectMode: 3,
			   	//children: treeData,
				onSelect: function(select, node) {
				console.log(node.data.id)
               	if($("#ID_USER").val()==''){
               		alert("Pilih nama Employee terlebih dahulu");
               		$("#tree03").dynatree("getTree").reload();
               		$("#txt_Nama").val('');
               	}else{
               	 	$.ajax({
						url : "<?=base_url()?>index.php/EC_Master_user_category/crud",
						data : {
							action : (select)?'Simpan':'Hapus',
							id_user : $('#ID_USER').val(),
							id_cat : node.data.id,
						},
						type : 'POST',
						dataType :'JSON',
						beforeSend:function(){             
						},
						success : function(data){
								// alert(data.done);
							
						 }
					});
               	 }

               	},
               	onDblClick: function(node, event) {
					node.toggleSelect();
				},
    });
 })
		
$(function(){  
            $('.nama').autocomplete({
                    // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo base_url();?>EC_Master_user_category/search_nama',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $("#txt_Nama").val(suggestion.value);
                    $("#ID_USER").val(suggestion.ID_USER);
                    // if(suggestion.kd_bagian != null){$("#kd_bagian").val(suggestion.kd_bagian); $('#kd_bagian').data('combobox').refresh();}else{$('#kd_bagian').data('combobox').clear();}
                    $.ajax({
					url: "<?php echo base_url() ?>index.php/EC_Master_user_category/getTree",
					 data: {
                      user_id : $("#ID_USER").val()
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
                }
            });
        });


			 		
			</script>