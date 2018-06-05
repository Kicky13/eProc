<?php

// echo "<pre>";
// print_r($ptv);
// print_r($vnd);
// print_r($vendor);
// print_r($ppi);
// print_r($bank);
// print_r($po);
// print_r($item);
// print_r($prc_tender_prep);
// print_r($buyer);
// die;f
?>
<style>
    .kecilkan{
        font-size:6pt;
        font-family: Courier,verdana,arial;
    }

    body,p,table td{
        font-size:8pt;
        font-family: Courier,verdana,arial;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table.bordered tr td, table.bordered th {
        border: 1px solid black;
        font-size:8pt;
    }
    .Kanan{
        border-right:1px solid black;
    }
    .Kiri{
        border-left: 1px solid black;
    }
    .Bawah{
        border-bottom:1px solid black;
    }
    .Atas{
        border-top:1px solid black;
    }
    .border{
        border: 1px solid black;
    }

    .bordered td{
        border: 1px solid black;
        margin-left: 10px;
    }

    .tableheader{
        margin:100px;
    }
    .col-md-3{
        width:25%;
    }
    .vendorsupply{
        width:20%;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }
    .item{
        width:6%;
    }

    .title p{
        font-size: 12pt;
        text-align: center;
    }

    .shorttext{
        width:25%;   
    }
    .text-center, .centered{
        text-align: center;
    }
    .text-top{
        vertical-align: top;
    }

    .text-right{
        text-align: right;
    }

    .text-left{
        text-align: left;
    }

    .side-right{
        margin-left: 500px;
        /*border: solid 1px black;*/
    }

    .side-left{
        margin-left: 0px;
        /*border: solid 1px black;*/
    }

    .middle-right{
        margin-left: 450px;
        /*border: solid 1px black;*/
    }

    .middle-center{
        margin-left: 25%;
        /*border: solid 1px black;*/
    }

    .width-100{
        width: 100px;
    }

    .width-200{
        width: 200px;
    }

    .width-300{
        width: 300px;
    }

    .width-200{
        width: 200px;
    }

    .height-100{
        height: 100px;
    }

    .height-200{
        height: 200px;
    }

    .height-300{
        height: 300px;
    }

    .padding-100{
        padding-left: 100px;
    }

    .padding-200{
        padding-left: 200px;
    }

    .padding-300{
        padding-left: 300px;
    }

    .underline{
        text-decoration: underline;
    }

    .blok{
        display:inline;
    }

    .font16{
        font-size: 16px;
    }

    .font12{
        font-size: 8px;
    }

    .font14{
        font-size: 14px;
    }

    .kecil12{
        font-size: 12px;
    }

    .tebalkepala{
        border: 2px solid black;
    }


    .setting_bold{
        font-weight: bold;
    }

    .footer {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 1rem;
        text-align: center;
    }

    .spasisijisetengah{
        line-height: 1.5em;
    }

    #footer {
        position: relative;
        margin-bottom: 90px;
        /*bottom: 1px !important;*/
        /* negative value of footer height */
        clear: both;
    }

</style>

<head>
    <title><?php echo $title ?></title> 
</head>
<body>
    <div style="width:700px;">
        <table style="width:100%;" >
            <tr>
                <th align="center" class="underline"><h2><u>KETENTUAN UMUM</u></h2></th>
            </tr>
            <tr>
                <!-- <td style="padding-top:-20px"><hr></hr></td> -->
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" >
            <tr>
                <td width="50%" style="padding-top:10px" class="kanan kiri bawah atas">
                    <table style="font-size:6pt; font-family:arial;">
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>1. UMUM</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" width="10%" valign="top" border="">a.</td>
                            <td align="justify"><b>PIHAK KESATU</b> adalah PT SEMEN INDONESIA (PERSERO) Tbk, <b>PIHAK KEDUA</b> adalah PEMASOK / REKANAN</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Pihak Kedua di dalam melaksanakan pekerjaan harus memperhatikan masalah Keselamatan & Kesehatan Kerja dan harus dikoordinasikan dengan seksi K3 sebelum pekerjaan dimulai.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">c.</td>
                            <td align="justify">Apabila para pekerja Pihak Kedua mengalami kecelakaan, baik ringan, berat atau sampai meninggal dunia menjadi tanggung jawab Pihak Kedua.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">d.</td>
                            <td align="justify">Dengan ditandatanganinya Perintah Kerja ini Pihak Kedua setuju atas  syarat pengadaan pada halaman ini, dengan diberi materai secukupnya dan menyerahkan kembali kepada Pihak Kesatu.</td>
                        </tr>
                        <tr>
                            <td style="" valign="" colspan="2"><strong>2. JANGKA WAKTU & BIAYA PELAKSANAAN PEKERJAAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top" colspan="2">Jangka waktu dan biaya pelaksanaan pekerjaan tidak dapat diubah, kecuali terjadi :</td>
                            <td align="justify"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top" colspan="2">a. pekerjaan tambahan dan / atau kurangan.</td>
                            <td align="justify"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top" colspan="2">b. penangguhan pekerjaan.</td>
                            <td align="justify"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top" colspan="2">c. force majeure.</td>
                            <td align="justify"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top" colspan="2">d. perselisihan antara kedua belah pihak.</td>
                            <td align="justify"></td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>3. PEKERJAAN  TAMBAHAN DAN ATAU PEKERJAAN KURANGAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Pekerjaan tambahan dan atau kurangan dilaksanakan bila ada perintah secara tertulis dari Pihak Kesatu.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Pelaksanaan dan cara pembayaran yang menyangkut biaya pekerjaan tambahan dan atau pekerjaan kurangan akan diatur dan ditetapkan bersama dalam suatu addendum.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>4. SANKSI KETERLAMBATAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Dalam hal terjadi keterlambatan penyelesaian pekerjaan, maka Pihak Kedua dapat mengajukan permintaan perpanjangan kepada Pihak Kesatu, selambat-lambatnya 7 (tujuh) hari kalender sebelum batas waktu penyerahan berakhir dan dilampiri copy Perintah Kerja (PK). Selanjutnya Pihak Kesatu akan menerbitkan surat ijin perpanjangan atas keterlambatan.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Apabila permintaan perpanjangan Perintah Kerja (PK) disetujui, maka atas keterlambatan penyerahan ini Pihak Kedua dikenakan denda 0,1 % (sepersepuluh persen) tiap hari kalender keterlambatan, dengan maksimum denda 5 % (lima persen) dari harga total, kecuali perpanjangan waktu disebabkan Pihak Kesatu atau Force Majeure.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">c.</td>
                            <td align="justify">Apabila jumlah denda kelambatan telah mencapai 5% (lima persen) dari harga total, maka Pihak Kesatu berhak mengambil alih pekerjaan tanpa memberikan ganti rugi berupa apapun kepada Pihak Kedua.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">d.</td>
                            <td align="justify">Apabila karena sesuatu hal jangka waktu pelaksanaan tidak mungkin diperpanjang, maka Perintah Kerja (PK) tersebut dinyatakan batal tanpa pengganti-rugian berupa apapun dari Pihak Kesatu dan kepada Pihak Kedua akan dikenakan kondite karena tidak dapat menyelesaikan pekerjaan tersebut.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>5. PENERIMAAN PEKERJAAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Laporan kemajuan pekerjaan harus ditandatangani oleh unit kerja peminta dan / atau pengawas (BAKP atau BAPP ).</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Pada saat pekerjaan selesai dinyatakan dengan BAST yang ditanda tangani oleh kedua belah pihak.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>6. DOKUMEN KELENGKAPAN PEMBAYARAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Permintaan pembayaran diajukan dengan sistem E-Invoice dengan melampirkan:</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">
                                <ul>
                                    <li>Kwitansi bermeterai dan Faktur Penjualan serta mencantumkan nomor Perintah Kerja (PK) atau surat perjanjian/Kontrak atau surat ikatan kerja lainnya.</li>
                                    <li>Copy Perintah Kerja (PK) atau surat perjanjian/Kontrak atau surat ikatan kerja lainnya yang masih berlaku atau yang sudah diperpanjang.</li>
                                    <li>Mencantumkan no rekening untuk pembayaran melalui transfer.</li>
                                    <li>Faktur Pajak.</li>
                                    <li>BAPP / BASTP ditebitkan pada waktu tanggal progress atau selesainya Pekerjaan.</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Tagihan harus disertai dengan dokumen lengkap dan diterima PT.Semen Indonesia (Persero) Tbk. paling lambat tanggal 5 bulan berikutnya.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>7. PAJAK</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">PPN menjadi beban dan tanggung jawab Pihak Kesatu</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Seluruh pajak dan biaya materai untuk pelaksanaan Perintah Kerja (PK) ini, kecuali yang tersebut pada butir 7a. diatas menjadi beban dan tanggung jawab Pihak Kedua.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">c.</td>
                            <td align="justify">Faktur Pajak  :</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">1. Harus dibuat sama dengan tanggal progress atau selesainya Pekerjaan yang dituangkan dalam Berita Acara Pemeriksaan Pekerjaan (BAPP) dan atau tanggal Berita Acara Serah Terima (BAST).</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">2. Denda keterlambatan penyerahan Faktur Pajak ke PT Semen Indonesia (Persero) Tbk. sebesar 2% (dua persen) per bulan dari PPN, menjadi beban Vendor.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">3. PembayaranTermin:<br>Pekerjaan telah selesai 100% pembayaran 95% dengan melampirkan Faktur Pajak 100%</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">4. Pekerjaan masa pemeliharaan 5% pembayaran 5% dengan tanpa melampirkan Faktur Pajak</td>
                        </tr>
                    </table>
                </td>
                <td style="padding-top:10px" width="50%" class="kanan kiri bawah atas">
                    <table>
                        <tr>
                            <td style="padding-left:20px" valign="top">d.</td>
                            <td align="justify"><strong>Alamat Faktur Pajak :</strong> PT SEMEN INDONESIA (PERSERO) TBK. JALAN VETERAN KEL. SIDOMORO KEC. KEBOMAS GRESIK 61122, NPWP : 01.001.631.9-051.000.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">e.</td>
                            <td align="justify">Transaksi sama dengan / dibawah Rp 10 juta termasuk PPN yang dibayarkan kepada Rekanan menggunakan kode Faktur Pajak : 010.000-00.00000000</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">f.</td>
                            <td align="justify">Transaksi diatas Rp 10 juta termasuk PPN yang dibayarkan kepada Rekanan menggunakan kode Faktur Pajak : 030.000-00.00000000 akan dibayarkan oleh PT Semen Indonesia (Persero) Tbk dan Rekanan akan diberikan SSP ( Surat Setoran Pajak ).</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">g.</td>
                            <td align="justify">Melampirkan e-nofa yang dikeluarkan oleh Direktorat Jenderal Pajak.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">h.</td>
                            <td align="justify">Faktur Pajak harus dibuat melalui aplikasi e-nofa dan sudah memperolah approval dari Direktorat Jenderal Pajak dengan bukti Faktur Pajak bercode.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">i.</td>
                            <td align="justify">Faktur Pajak Cacat yang disebabkan oleh kesalahan vendor, menjadi tanggung jawab masing-masing vendor dan vendor wajib membuat surat pernyataan bahwa PPN menjadi tanggung jawab vendor.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">j.</td>
                            <td align="justify">Apabila dikemudian hari terdapat pelanggaran perpajakan, maka PT Semen Indonesia (Persero) Tbk. berhak mendapat ganti rugi dari Rekanan</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>8. FORCE MAJEURE</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Yang dimaksud keadaan Force Majeure adalah:</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">
                                <ul>
                                    <li>Bencana alam, yaitu banjir, gempa bumi, badai, kebakaran, tanah longsor dan letusan gunung berapi.</li>
                                    <li>Adanya huru-hara dan atau peperangan.</li>
                                    <li>adanya peraturan pemerintah di bidang moneter atau peraturan lainnya.</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Apabila terjadi force majeure, maka pihak yang terkena force majeure diwajibkan melaporkan kepada pihak lainnya selambat-lambatnya 2 X 24 jam sejak timbulnya force majeure dengan dilengkapi pernyataan dari pejabat instansi yang berwenang dan pihak yang menerima laporan diwajibkan memberi jawaban selambat-lambatnya 2 X 24 jam sejak menerima laporan kejadian force majeure.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Apabila terjadi force majeure, maka pihak yang terkena force majeure diwajibkan melaporkan kepada pihak lainnya selambat-lambatnya 2 X 24 jam sejak timbulnya force majeure dengan dilengkapi pernyataan dari pejabat instansi yang berwenang dan pihak yang menerima laporan diwajibkan memberi jawaban selambat-lambatnya 2 X 24 jam sejak menerima laporan kejadian force majeure.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">c.</td>
                            <td align="justify">Apabila pihak yang terkena force majeure lalai dan atau tidak melaporkan kepada pihak lainnya dalam batas waktu sebagaimana dimaksud dalam ayat (3) Pasal ini, maka kejadian force majeure dianggap tidak ada.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">d.</td>
                            <td align="justify">Apabila pihak yang menerima laporan kejadian force majeure lalai dan / atau tidak memberikan jawaban kepada pihak yang terkena force majeure dalam batas waktu sebagaimana dimaksud dalam ayat (3) Pasal ini, maka pihak yang menerima laporan dianggap telah menyetujui laporan tersebut.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">e.</td>
                            <td align="justify">Semua kerugian dan biaya yang diderita salah satu pihak sebagai akibat terjadinya force majeure bukan merupakan tanggung jawab pihak lainnya.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>9. PEMOTONGAN HARGA</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">Pihak Kesatu berhak melakukan pemotongan harga apabila berdasarkan pemeriksaan pekerjaan yang telah dilakukan kurang memenuhi syarat namun dapat diterima</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>10. PENYELESAIAN PERSELISIHAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Segala perselisihan yang mungkin timbul diantara kedua belah pihak, akan diselesaikan oleh kedua belah pihak dengan cara musyawarah dan mufakat.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Apabila dalam batas waktu 7 (tujuh) hari kalender sejak timbulnya perselisihan tersebut dengan cara musyawarah dan mufakat ternyata kedua belah pihak belum berhasil menyelesaikan dan atau belum dapat mengambil keputusan, maka penyelesaiannya dapat dimintakan Pengadilan Negeri.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>11. PENANGGULANGAN DAMPAK LINGKUNGAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Pihak Kedua wajib memperhatikan dan bertanggungjawab untuk melakukan pencegahan dan atau penanggulangan terhadap kegiatan yang berpotensi / menimbulkan dampak penting terhadap lingkungan sesuai perundangan yang berlaku.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Pihak Kedua harus membersihkan lokasi pekerjaan dari sisa-sisa kotoran & material sesuai tempat yang telah ditentukan.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">c.</td>
                            <td align="justify">Limbah B3 & Barang yang membahayakan lingkungan ( Oli, BBM,dll) harus ditempatkan dilokasi yg memadai dan terpisah.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>12. PENGABAIAN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top"></td>
                            <td align="justify">Apabila terjadi suatu pemutusan / pembatalan terhadap Perintah Kerja ini, maka para pihak sepakat untuk tidak memberlakukan Pasal 1266 dan Pasal 1267 Kitab Undang-undang Hukum Perdata Republik Indonesia.</td>
                        </tr>
                        <tr>
                            <td style="" valign="top" colspan="2"><strong>13. LAIN-LAIN</strong></td>
                            <td align=""></td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">a.</td>
                            <td align="justify">Semua informasi yang timbul karena pekerjaan ini bersifat rahasia & hanya dipergunakan untuk kepentingan pekerjaan ini dan tidak diijinkan untuk dipindah-tangankan.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px" valign="top">b.</td>
                            <td align="justify">Hal-hal yang belum diatur dalam Ketentuan Umum ini akan diatur tersendiri.</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>  
</body>