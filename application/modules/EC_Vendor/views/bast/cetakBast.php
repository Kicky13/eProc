<!DOCTYPE html>
<html>
<head>
  <style>
    body{
      font-size: 12;
      text-align: justify;
    }
    .title{
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
  <title>Cetak BAPP</title>
</head>
<body>
  <div style="position:relative;padding-left:600px;">
    <img class="logo_dark" src="<?php echo site_url('static/images/logo/'.$company_data['logo']) ?>" alt="Logo Perusahaan">
  </div>
  <div>
    <div class="title">
      <div><strong><u>BERITA ACARA SERAH TERIMA PEKERJAAN</u></strong></div>
      <div>Nomor : <?php echo $data['NO_BAST'] ?></div>
    </div>
    <div class="content">
      <div>
        <?php

          $_tgl = new Datetime($approve['UPDATE_AT']);
          $tahun = $_tgl->format('Y');
          $bulan = $_tgl->format('m');
          $tgl = $_tgl->format('d');
        ?>
        Pada hari ini <strong><?php echo hariIndonesia($approve['UPDATE_AT']) ?></strong> tanggal <strong><?php echo terbilang($tgl) ?></strong> bulan <strong><?php echo namaBulan($bulan) ?></strong>
        tahun <strong><?php echo terbilang($tahun,3) ?></strong> (<?php echo $_tgl->format('d-m-Y') ?>) kedua belah pihak yang bertanda tangan dibawah ini :
        <br />
        <br />
        <div>
          <table>
            <tr>
              <td valign="top" width="300px"><?php echo $data['PENGAWAS'] ?></td>
              <td>: <?php echo $data['JABATAN'] ?></td>
            </tr>
          </table>
        </div>
        <br />
        <div>Yang selanjutnya disebut <strong>PIHAK PERTAMA</strong></div>
        <br />
        <div>
          <table>
            <tr>
              <td valign="top" width="300px"><?php echo $vendor['CONTACT_NAME'] ?></td>
              <td>: <?php echo $vendor['CONTACT_POS'] ?></td>
            </tr>
          </table>
        </div>
        <br />
        <div>Yang selanjutnya disebut <strong>PIHAK KEDUA</strong></div>
      </div>
      <br />
      <br />
      <div>
        Dengan berdasarkan : <br />
        Surat Perintah Kerja No. <?php echo $data['NO_PO'] ?> untuk pekerjaan berupa <?php echo $data['SHORT_TEXT'] ?>
      </div>
      <br />
      <div>Kedua belah pihak secara bersama - sama sepakat bahwa :</div>
      <div style="padding-left:20px"><?php echo $data['DESCRIPTION'] ?></div>
      <br />
      <div>Demikian Berita Acara Pemeriksaan Pekerjaan ini dibuat dalam rangkap dua (2) untuk dipergunakan sebagaimana mestinya.</div>
    </div>
    <div style="margin-top:60px">
      <table>
        <tr>
          <td>PIHAK PERTAMA</td>
          <td style="width:250px"></td>
          <td>PIHAK KEDUA</td>
        </tr>
        <tr>
          <td>Yang Menerima</td>
          <td style="width:250px"></td>
          <td>Yang Menyerahkan</td>
        </tr>
        <tr>
          <td><?php echo $company[$data['COMPANY']] ?></td>
          <td style="width:250px"></td>
          <td><?php echo $vendor['PREFIX']. ' ' .$vendor['VENDOR_NAME'] ?></td>
        </tr>
        <tr>
          <?php
          $kodebarcode = <<<SSS
          Sudah diapprove lagi a.n. Direktur
SSS;
?>

          <td><barcode code="<?php echo $kodebarcode ?>" size="0.6" type="QR" error="M" class="barcode" /></td>
          <td style="width:350px"></td>
          <td><barcode code="<?php echo $kodebarcode ?>" size="0.6" type="QR" error="M" class="barcode" /></td>
        </tr>
        <tr>
          <td><?php echo $data['PENGAWAS'] ?></td>
          <td style="width:250px"></td>
          <td><?php echo $vendor['CONTACT_NAME'] ?></td>
        </tr>
        <tr>
          <td><?php echo $data['JABATAN'] ?></td>
          <td style="width:250px"></td>
          <td><?php echo $vendor['CONTACT_POS'] ?></td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>
