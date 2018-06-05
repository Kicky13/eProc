<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="alert alert-info" role="alert">Petunjuk Penggunaan digunakan untuk memudahkan user dalam menggunakan aplikasi e-procurement. <?php foreach ($manual_book as $val) { ?><a href="<?php echo base_url('Panduan_vendor') ?>/viewDok/<?php echo $val['NAMA_FILE']; ?>" target="_blank" class="button-warning">Lihat File</a><?php  } ?></div>


            </div>
          </div> 
        </div>   
      </div> 
    </div >
  </div >
</section>
