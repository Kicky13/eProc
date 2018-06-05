<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
        <div class="row"> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="alert alert-warning" role="alert">Petunjuk Penggunaan digunakan untuk memudahkan user dalam menggunakan aplikasi e-procurement.</div>

            </div>
          </div> 
        </div> 

        <div class="row">
          <div class="col-md-5">
              <div class="panel panel-default">
              <table class="table table-hover" >
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-left">FILE</th>
                    </tr>
                </thead>
                  
                  <tbody id="tableItem">
                      <?php if (empty($manual_book)) { ?>
                      <tr id="empty_row">
                          <td colspan="2" class="text-left">- Belum ada data -</td>
                      </tr>
                      <?php } else { $no = 1; 
                        foreach ($manual_book as $key => $file) { ?>

                      <tr id="<?php echo $file['ID_MANUAL']; ?>">
                          <td class="text-center"></td>
                          <td class="text-left"><?php if (!empty($file['NAMA_FILE'])){ ?><a href="<?php echo base_url('Panduan_vendor') ?>/viewDok/<?php echo $file['NAMA_FILE']; ?>" target="_blank" class="button-warning"><?php echo $file['NAMA']; ?></a><?php  } ?></td>
                      </tr>
                          <?php } } ?>
                  </tbody>
              </table>    
            </div>
          </div> 
        </div> 
<!-- end panel -->
      </div> 
    </div >
  </div >
</section>
