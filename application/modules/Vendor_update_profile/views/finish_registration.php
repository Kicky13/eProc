  <section class="content_section">
    <div class="content row_spacer clearfix" style="padding-top: 40px">
      <div class="rows_container clearfix">
        <div class="col-md-12">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Success Update</h2>
            </div>
        </div>
      </div>
      <div class="rows_container clearfix">
        <div class="col-md-6 col-md-offset-3">
          <form class="login_form_colored">
            <div class="lfc_user_row">
              <span class="lfc_header">Finished Update</span>
            </div>
            <div class="lfc_user_row">
              <p><strong>Mitra Kerja yang terhormat,</strong></p>
              <p>Anda telah menyelesaikan proses update data profil! Saat ini, data profil anda dalam proses Review untuk persetujuan.</p>
              <p>Silahkan hubungi contact person di bawah ini untuk membuat jadwal verifikasi:</p>
        <?php if($opco == '7000' || $opco == '2000' || $opco == '5000'){ ?>
              <p>Bagian Perencanaan Pengadaan PT. Semen Indonesia (Persero) Tbk. Atau alamat e-mail pengadaan@semenindonesia.com</p>
        <?php } else if($opco == "3000"){ ?>
              <p>Bagian Perencanaan Pengadaan PT. Semen Padang. Atau alamat e-mail eproc.sp@semenindonesia.com</p>
        <?php } else if($opco == "4000"){ ?>
              <p>Bagian Perencanaan Pengadaan PT. Semen Tonasa. Atau alamat e-mail pengadaan@st.sggrp.com</p>
        <?php } ?>
              <br>
              <p>Selama data belum di setujui anda tidak bisa mengubah data profil.</p>
            </div>
            <div class="lfc_user_row clearfix">
              <a href="<?php echo base_url(); ?>" class="send_button f_right upper">OK</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
