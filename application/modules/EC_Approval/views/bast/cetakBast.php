<!DOCTYPE html>
<html>
<head>
  <style>
    body{
      font-size: 13;
      text-align: justify;
    }
    .title{
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
  <title>Cetak BAST</title>
</head>
<body>
  <div style="position:relative;padding-left:600px;">
    <img class="logo_dark" src="<?php echo site_url('static/images/logo/'.$logo[$data['COMPANY']]) ?>" alt="Logo Perusahaan">
  </div>
  <div>
    <div class="title">
      <div><strong><u>BERITA ACARA SERAH TERIMA PEKERJAAN</u></strong></div>
      <div>Nomor : <?php echo $data['NO_BAPP'] ?></div>
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
              <td valign="top" width="200px">Eko Wicaksono</td>
              <td>: Direktur Utama <br /> &nbsp;&nbsp;PT. Swadaya</td>
            </tr>
          </table>
        </div>
        <br />
        <div>Yang selanjutnya disebut <strong>PIHAK PERTAMA</strong></div>
        <br />
        <div>
          <table>
            <tr>
              <td valign="top" width="200px">Junaidi Nur</td>
              <td>: Direktur Utama <br />&nbsp;&nbsp;PT. Sinergi Informatika</td>
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
          <td style="width:350px"></td>
          <td>PIHAK KEDUA</td>
        </tr>
        <tr>
          <td>Yang Menerima</td>
          <td style="width:350px"></td>
          <td>Yang Menyerahkan</td>
        </tr>
        <tr>
          <td>PT. ABC</td>
          <td style="width:350px"></td>
          <td>PT.XYZ</td>
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
          <td style="width:350px"></td>
          <td>Namanya</td>
        </tr>
        <tr>
          <td><?php echo $data['JABATAN'] ?></td>
          <td style="width:350px"></td>
          <td>Direktur Utama</td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>
