  <section class="content_section">
    <div class="content row_spacer clearfix" style="padding-top: 40px">
      <div class="rows_container clearfix">
        <div class="col-md-12">
          <div class="main_title centered upper">
            <h2>
              <span class="line"><i class="ico-user3"></i></span>
              Sign
              <span class="main_title_c1"> in</span>
            </h2>
          </div>
        </div>
      </div>
      <div class="rows_container clearfix">
        <div class="col-md-6 col-md-offset-3">
          <form class="login_form_colored">
            <div class="lfc_user_row">
              <span class="lfc_header">Login E-Procurement</span>
            </div>
            <div class="lfc_user_row">
              <?php if($status_vnd =='1'){ ?>
              <p><strong>Mitra Kerja yang terhormat,</strong></p>
              <p>Anda telah menyelesaikan proses pendaftaran online sebagai Vendor! Saat ini, perusahaan anda dalam proses Review untuk persetujuan.</p>
              <p>Silahkan hubungi contact person di bawah ini untuk membuat jadwal verifikasi:</p>
              <p><a href="mailto:tes@gmail.com">Bagian Perencanaan Pengadaan PT. Semen Indonesia (Persero) Tbk</a>. atau alamat e-mail <a href="mailto:tes@gmail.com">pengadaan@semenindonesia.com</a></p>
              <?php } else { ?>
              <p><strong>Mitra Kerja yang terhormat,</strong></p>
              <p>Anda telah menyelesaikan proses perbaikan data registrasi Vendor! Saat ini, perusahaan anda dalam proses Review untuk persetujuan.</p>
              <p>Silahkan hubungi contact person di bawah ini untuk membuat jadwal verifikasi:</p>
              <p><a href="mailto:tes@gmail.com">Bagian Perencanaan Pengadaan PT. Semen Indonesia (Persero) Tbk</a>. atau alamat e-mail <a href="mailto:tes@gmail.com">pengadaan@semenindonesia.com</a></p>
              <?php } ?>
            </div>
            <div class="lfc_user_row clearfix">
              <a href="<?php echo site_url('Login/loadloginvendor'); ?>" class="send_button f_right upper">OK</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>