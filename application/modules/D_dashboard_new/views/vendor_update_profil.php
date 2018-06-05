  <section class="content_section">
    <div class="content row_spacer clearfix" style="padding-top: 40px">
      <div class="rows_container clearfix">
        <div class="col-md-12">
          <div class="main_title centered upper">
            <h2>
              <span class="line"><i class="ico-user3"></i></span>
              Selamat Datang
            </h2>
          </div>
        </div>
      </div>
      <div class="rows_container clearfix">
        <div class="col-md-12">
          <form class="login_form_colored">
            <div class="lfc_user_row">
              <span class="lfc_header">List yang Perlu Diperbaiki</span>
            </div>
            <div class="lfc_user_row">
              <table class="table table-hover margin-bottom-20" id="ref_doc">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-left">Persyaratan Administrasi</th>
                    <th class="text-center" style="width: 300px">Status</th>
                    <th class="text-left" style="width: 300px">Keterangan</th>
                  </tr>
                </thead>
                <tbody id="tableItem">
                  <?php if (empty($ref_doc)) { ?>
                  <tr id="empty_row">
                    <td colspan="4" class="text-center">- Belum ada data -</td>
                  </tr>
                  <?php } else {
                    $no = 1;
                    foreach ($ref_doc as $key => $doc) { ?>
                    <tr class="<?php echo $doc['STATUS'] == 'Rejected' ? 'danger' : '' ?>">
                      <td class="text-center"><?php echo $no++; ?></td>
                      <td><?php echo $doc['CONTAINER']; ?></td>
                      <td class="text-center"><?php echo $doc['STATUS']; ?></td>
                      <td><?php echo $doc['STATUS'] == 'Rejected' ? $doc['REASON'] : '' ?></td>
                    </tr>
                  <?php } ?>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="lfc_user_row clearfix text-center">
              <a href="<?php echo base_url(); ?>Administrative_document/general_data" class="send_button upper">Continue Edit Profile</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>