<section class="content_section">
  	<div class="content_spacer">
    	<div class="content">
	    	<!-- <h4><strong>E-KATALOG</strong></h4> -->
	    	<div class="row">
		        <div class="col-lg-2">
		          
		        </div>
		        <div class="col-lg-8">
		          <form method="post" action="<?php echo base_url(); ?>EC_Ecatalog/listCatalog" >
			          <div class="input-group">
				         <input type="text" class="form-control" name="tagsearch" placeholder="Cari produk, kategori, merk atau vendor...">
				           <div class="input-group-btn">
				            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				         </div>
			          </div>
		          </form>
		        </div>
		        <div class="col-lg-2">
		          
		        </div>
	      </div>
	      <br>	    		 
	    	<div class="row">
	    		<div class="col-lg-10 col-lg-offset-1" >
	    			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	    			<?php
	    				$enter = 0;  
	    				for($i=0;$i<sizeof($kategori);$i++){
	    					if($kategori[$i]['KODE_PARENT']==0){
	    						$size = 16;
	    						
		    					if ($enter%3==0) {
		    						echo '<div class="row"><p></p></div>';	    					
		    					} 
		    					if(strlen($kategori[$i]['DESC'])>28){
		    						$size = 15;
		    					}
		    					$enter++;
	    						echo '<div class="col-lg-4 col-md-4" style="margin-bottom: 20px;">
				    				<div class="panel panel-default" style="box-shadow: 1px 1px 1px #ccc">
							    <div class="panel-heading" role="tab" id="headingThree">
							      <h4 class="panel-title">
							        <a href="'.base_url().'EC_Ecatalog/listCatalog/'.$kategori[$i]['KODE_USER'].'" onclick="getCategory(\''.$kategori[$i]['KODE_USER'].'\')" style="font-size:'.$size.'px">
							          <center><strong>'.$kategori[$i]['DESC'].'</strong></center>
							        </a> 
							        <p></p>
							        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#ac'.$i.'" aria-expanded="true" aria-controls="ac'.$i.'">
							        <img src="'.base_url(UPLOAD_PATH).'/EC_homepage/'.$kategori[$i]['PICTURE_CAT'].'" class="img-responsive img-thumbnail">
							        </a>
							      </h4>
							    </div>
							    <div id="ac'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							      <div class="panel-body">
							        <div class="list-group">';
							        for($j=0;$j<sizeof($kategori);$j++){
							        	if($kategori[$i]['ID_CAT']==$kategori[$j]['KODE_PARENT']){
							        		echo '<a href="'.base_url().'EC_Ecatalog/listCatalog/'.$kategori[$j]['KODE_USER'].'" onclick="getCategory(\''.$kategori[$j]['KODE_USER'].'\')" class="list-group-item size-list-item">'.$kategori[$j]['DESC'].'</a>';	
							        	}							        	
							        }	
									echo '</div>
							      </div>
							    </div>
							  </div>
				    			</div>';
	    					}
	    				}
	    			?> 
				</div>   
				</div>
	    	</div>	  
	    	<br>    	
   	 	</div >
  	</div >
</section>