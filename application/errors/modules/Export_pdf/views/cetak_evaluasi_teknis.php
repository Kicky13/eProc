<!DOCTYPE html>
<html>
<head>
    <title>Evaluasi Teknis</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
            font-size: 7pt;
        }
        .container{
            /*margin-right: 2cm;*/
            /*margin-bottom: 1cm;*/
            margin-left: -5mm;
            /*border: 1px solid black;*/
        }
        .judul{
            font-size: 9pt;
            text-align: center;
        }

        th.horizontal{
            width: 3cm;
        }

        th.vertical{
            text-align: center;
        }

        table.atas{
            width: 11cm;
        }

        table.bawah{
            width: 100%;
        }
        .column { 
            float: left; 
            width: 33.3%;
        }

    </style>
</head>
<body>
    <div class="container">
        <table border="0">
          <tr>
            <th colspan="2"><?php echo $company; ?></th>
          </tr>
        </table>
        <div class="judul"><strong>HASIL EVALUASI TEKNIS PENGADAAN BARANG / JASA</strong></div>
        <br/>
        <table border="0">
          <tr>
            <th>LB NO.</th>
            <th>:</th>
            <th><?php echo $ptm[0]['PTM_PRATENDER']; ?></th>
          </tr>
          <tr>
            <th>UNIT KERJA</th>
            <th>:</th>
            <th></th>
          </tr>
        </table>
        <table class="bawah">
            <tr>
                <th rowspan="2" class="vertical" style="width:15px">No</th>
                <th rowspan="2" class="vertical">NO ITEM</th>
                <th rowspan="2" class="vertical">NAMA BARANG/JASA</th>
                <?php foreach ($ptv as $vnd): ?>
                    <th colspan="2" class="vertical"><?php echo $vnd['VENDOR_NAME']; ?></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($ptv as $vnd): ?>
                    <th class="vertical" width="20px" height="15px">Nilai</th>
                    <th class="vertical">Keterangan</th>
                <?php endforeach; ?>
            </tr>
            <?php $no=1; foreach ($pti as $val): ?>
                <tr>
                    <td class="vertical" align="center"><?php echo $no++; ?></td>
                    <td class="vertical"><?php echo $val['PPI_NOMAT']; ?></td>
                    <td class="vertical"><?php echo $val['PPI_DECMAT']; ?></td>
                    <?php foreach ($ptv as $vnd): ?>
                        <?php
                            $nil=''; $note=''; $color='';
                            if(isset($ptv_tit[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']])){
                                $nil = $ptv_tit[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_TECH_VAL'];
                                $note = $ptv_tit[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_NOTE'];
                            }else{
                                $color = "background-color:#E4E2E2";
                            }
                        ?>
                        <td class="vertical" align="center" style="<?php echo $color; ?>" ><?php echo $nil; ?></td>
                        <td class="vertical" style="<?php echo $color; ?>" ><?php echo $note; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
           <!--  <tr>
                <td class="vertical">&nbsp;</td>
                <td class="vertical"></td>
                <td class="vertical"></td>
                <td class="vertical"></td>
                <td class="vertical"></td>
                <td class="vertical"></td>
                <td class="vertical"></td>
            </tr> -->
        </table>
        <table border="0">
            <tr>
                <td width="30px"></td>
                <td>Nilai >= <b><?php echo $evatek_t; ?></b> dinyatakan <font color="red"><b>LULUS</b></font>  Evaluasi Teknis</td>
            </tr>
            <tr>
                <td></td>
                <td>Nilai &lt; <b><?php echo $evatek_t; ?></b> dinyatakan <font color="red"><b>TIDAK LULUS</b></font>  Evaluasi Teknis</td>
            </tr>
        </table>
    </div>
</body>
</html>