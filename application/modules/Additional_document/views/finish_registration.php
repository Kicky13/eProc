<?php if ($status != 99) {?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Congratulation!</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Finished Registration</div>
                        <div class="panel-body">
                            <p>
                                Pendaftaran Berhasil!<br> Untuk proses lebih lanjut, Silahkan mengirimkan dokumen berikut ini:
                            </p>
                            <ol style="margin-left: 50px;">
                                <li>Surat pernyatan penyedia barang dan jasa & Pakta integritas yang telah ditandatangani pemimpin atau pengurus perusahaan diatas materai (Asli)</li>
                                <li>Surat pernyataan keaslian dokumen yang telah ditandatangani pemimpin atau pengurus perusahaan diatas materai (Asli)</li>
                                <li>Bentuk dan Nama Badan Usaha (CV, PT, Koperasi) dengan melampirkan AKTA pendirian dan Akte Perubahannya. (Termasuk Pengesahan Menteri Hukum dan HAM dan diumumkan dalam Berita Negara-RI atau sebagaimana ditentukan dalam Dokumen Pengadaan).</li>
                                <li>Surat Ijin Domisili Perusahaan</li>
                                <li>Nomor Pokok Wajib Pajak (NPWP) Perusahaan</li>
                                <li>Pengukuhan Pengusaha Kena Pajak (PPKP)</li>
                                <li>Surat Ijin Usaha Perdagangan (SIUP)</li>
                                <li>Tanda Daftar Perusahaan (TDP)</li>
                                <li>IUJK & SBUJK untuk jasa kontruksi</li>
                                <li>Surat Izin Usaha Lainnya</li>
                                <li>Bukti Setoran Tahun Terakhir (SPT)</li>
                                <li>Surat keagenan / distributor</li>
                                <li>Angka Pengenal Impor (API) untuk importir</li>
                                <li>NPWP dan KTP Pengurus</li>
                                <li>Profil Perusahaan</li>
                                <li>Laporan Keuangan Terakhir yang sudah diaudit ataupun yang belum</li>
                                <li>Surat Referensi Bank</li>
                                <li>Pengalaman Perusahaan (Kontrak/Surat Perjanjian/Perintah Kerja/Order Pembelian)</li>
                                <li>Dokumen-dokumen dan Sertifikat lainnya sebagaimana didaftarkan secara online</li>
                            </ol>
                            <br>

                            <p>Untuk selanjutnya, dimohon untuk mengirimkan dokumen Asli (nomer 1 dan 2) dan mengirimkan copy dokumen dalam bentuk CD ke Alamat:<br><br>
                            <?php echo $alamat; ?></p>
                            <br>

                            <p>Terima kasih.</p>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-right">
                            <a href="<?php echo site_url('Login/loadloginvendor'); ?>" class="main_button color1 small_btn" >Ok</a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
<?php } else { ?>
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
              <p>Anda telah menyelesaikan proses update data registrasi vendor! Saat ini, data anda dalam proses review untuk persetujuan.</p>
              <p>Silahkan hubungi contact person di bawah ini untuk membuat jadwal verifikasi:</p>
              <p>Bagian Perencanaan Pengadaan <?php echo $nama_company; ?>. Atau alamat e-mail <?php echo $email; ?> </p>
              <br>
              <p>Selama data anda belum di setujui, anda tidak bisa mengubah data registrasi.</p>
            </div>
            <div class="lfc_user_row clearfix">
                <a href="<?php echo site_url('Login/loadloginvendor'); ?>" class="main_button color1 small_btn" >Ok</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php } ?>