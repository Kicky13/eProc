<section class="content_section">
  	<div class="content_spacer">
    	<div class="content">
	    	<div class="row" style="border-bottom: 2px solid #ccc;">
	    		<div class="col-lg-4">
	          		<h5>Comparing Product</h5>
	        	</div>
	    		<div class="col-lg-8 pull-right">
				        	<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
				        		<input type="hidden" id="arr" name="arr[]" />
				        		<a href="<?php echo base_url();?>EC_Ecatalog/listCatalog" type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
				        		<a href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">4000</span></a>
				        		<button type="submit"  style="display: none"  class="btn btn-default">Histori</button>
				        		<a href="<?php echo base_url();?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Chart &nbsp;&nbsp;&nbsp;<span class="badge jml"></span></a>	
				        		<!-- <button type="submit" id="compare" class="btn btn-default">Perbandingan</button>				        		 -->
				        	</form>
	        	</div>
	    	</div>
	    	<br>
	    	<div class="row">
	        	<div class="col-lg-10 col-lg-offset-2">
	        		<div class="row" style="padding-bottom: 20px">
	        			<?php 
	        				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				}        				
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){//' + base_url + 'EC_Ecatalog/detail_prod/' + data.data[i][5] + '
								//<a href="#"><i class="glyphicon glyphicon-remove pull-right"></i></a>
								echo '<div class="col-lg-'.floor($b).'" style=" padding-left:20px; padding-right:20px">
									<a href="'.base_url().'EC_Ecatalog/detail_prod/'.$data_compare[$i]['contract_no'].'"><span class="glyphicon glyphicon-usd" style="color:#337ab7;"  aria-hidden="true"></span>&nbsp;<span class="add"></span></a>
									<a href="javascript:void(0)" onclick="addCart(this,\'' .$data_compare[$i]['MATNR']. '\',\'' .$data_compare[$i]['contract_no']. '\')"   ><span class="glyphicon glyphicon-shopping-cart" style="color:#5bc0de;" aria-hidden="true"></span>&nbsp;<span class="add"></span></a>
									<a href="#"><i class="glyphicon glyphicon-remove pull-right"></i></a>
					          		<img src="'.base_url(UPLOAD_PATH).'/EC_material_strategis/'.$data_compare[$i]['PICTURE'].'" class="img-responsive">					     
					        	</div>';
							}
						?>
	        		</div>
	        		<div class="row" style="padding-left: 10px">
	        			<?php 
							if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style=" padding-left:20px; padding-right:20px">
									  <p></p><div class="row"><a href="javascript:void(0)" class="text-center"  style="margin: 0;font-size:16px;" ><strong>'.$data_compare[$i]['MAKTX'].'</strong></a></div>				     
					        	</div>';
							}
						?>
	        		</div>
	        		<div class="row" style="padding-left: 10px">
	        			<?php 
							if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								// echo '<div class="col-lg-'.floor($b).'" style=" padding-left:20px; padding-right:20px">
					          		// <div class="row"><p style="margin: 0"><a>'.$data_compare[$i]['MATNR'].'</a></p></div>
					        	// </div>';
							}
						?>
	        		</div> 
				</div>
	    	</div>
	    	<!-- <br> -->
	    	<br>
	    	<div class="row" style="border-top: 1px solid #ccc;">
	    		
	    	</div>

	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Long Teks</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">&nbsp&nbsp'.$longteks[$i].'</div>
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>

	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Base Unit Measure</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['MEINS'].'</div>
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>

	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Material Group</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['MATKL'].'</div>
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>

	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Material Type</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['MTART'].'</div>
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div> 
	    	<!-- Deskripsi Produk -->
	    	<div class="row" style="background-color: #e3e9f2; padding-top: 5px; padding-left: 5px; border-bottom: 1px solid #ccc;">
	    		<h6>Contract Description</h6>
	    	</div>
	    	
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Vendor</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['vendorname'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>

	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Principal</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);//'..'
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['PC_NAME'].' ('.$data_compare[$i]['PC_CODE'].')</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Nomor Kontrak</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['contract_no'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Valid Price</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.substr($data_compare[0]['validstart'], 6, 2).'/'.substr($data_compare[0]['validstart'], 4, 2).'/'.substr($data_compare[0]['validstart'], 0, 4).' - '.substr($data_compare[0]['validend'], 6, 2).'/'.substr($data_compare[0]['validend'], 4, 2).'/'.substr($data_compare[0]['validend'], 0, 4).'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Purchasing Organisasi</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['porg'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">No Plant</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['plant'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Contract Quantity</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['t_qty'].' '.$data_compare[$i]['uom'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	 
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Unit Price</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['netprice'].' per '.$data_compare[$i]['per'].' '.$data_compare[$i]['uom'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Gross Price</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['grossprice'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Currency</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">'.$data_compare[$i]['curr'].'</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Term of Delivery</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">...</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="row" style="border-bottom: 1px solid #ccc;">
	    		<div class="row">
	    			<div class="col-lg-2">
	    				<div class="row" style="margin-left: 10px;">Term of Payment</div>
		    		</div>
		    		<div class="col-lg-10">
		    			<?php 
		    				if (sizeof($data_compare)==2) {
	        					$a = 6;
	        				} else if(sizeof($data_compare)==3){
	        					$a = 9;     					
	        				}else {
	        					$a = 12;
	        				} 
							$b = 0;
							$b = $a / sizeof($data_compare);
							for($i=0;$i<sizeof($data_compare);$i++){
								echo '<div class="col-lg-'.floor($b).'" style="border-left: 1px solid #ccc; padding-left:20px; padding-right:20px">
					          		<div class="row">...</div>					          		
					        	</div>';
							}
						?>
		    		</div>
	    		</div>
	    	</div>
   	 	</div >
  	</div >
</section>

<link rel="stylesheet" href="<?php echo base_url()."static/css/pages/EC_miniTable.css"?>" />
<div class="modal fade" id="modalbudget">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI DETAIL BUDGET</u></strong></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover" >
					<thead>
						<tr>
							<th>Cost Center</th>
							<th>Desc</th>
							<th>GL Account</th>
							<th>GL Desc</th>
							<th>Current</th>
							<th>Commit</th>
							<th>Actual</th>
							<th>Available</th>
							<th>Cart</th>
						</tr>						
					</thead>
					<tbody id="tbody">
						<tr>
							<td>s</td>
							<td>s</td>
							<td></td>
							<td></td>
							<td>s</td>
							<td>s</td>
							<td>s</td>
							<td>s</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>s</td>
							<td>s</td>
							<td>s</td>
							<td>s</td>
							<td>s</td>
							<td>s</td>
						</tr>
					</tbody>
				</table>				
			</div>
		</div>
	</div>
</div>
