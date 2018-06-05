<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <form action="#" method="POST">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="<?php echo base_url('Master_PO/add') ?>" class="main_button color1 small_btn tombolsimpan">TAMBAH DATA</a>
                    </div>
                </div> 
                <div class="row"> 
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <table id="mater_po_list" class="table table-striped">
                        <thead>
                            <tr>
                            	<th class="text-center">No</th>
								<th class="text-center">CODE</th>
								<th>Description</th>
								<th class="text-center" width="90px;">ACTION</th>
                            </tr>
                            <tr>
                                <th></th>
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
                </div>  
            <div> 
            </form>
		</div>
	</div>
</section>

