<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <form action="<?php echo base_url()?>Vendor_profile/reminder" method="POST">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="row"> 
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <table id="vendor_profile_list" class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">No Vendor</th>
                                <th class="text-center">Nama Vendor</th>
                                <th class="text-center">Vendor Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                            <tr>
                                <th></th>
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
                </div>  
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <button id="submit-form" type="submit" class="main_button color1 small_btn tombolsimpan">Peringatkan</button>
                    </div>
                </div> 
            <div> 
            </form>
		</div>
	</div>
</section>