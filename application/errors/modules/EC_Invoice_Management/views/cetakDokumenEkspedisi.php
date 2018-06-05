<style>
    body{
        margin-top : 30px;
        font-size: 8pt;
    }
</style>
<?php
  $kodebarcode = $id_invoice.'#'.$no_ekspedisi.'#'.$tahun.'#'.$accounting_invoice;
?>
<div style="text-align: center;margin-top:-30px"><h3>TANDA TERIMA DOKUMEN</h3></div>
<div style="position:relative;margin-left:610px;margin-top:-40px">
    <barcode code="<?php echo $kodebarcode ?>" size="0.5" type="QR" error="M" class="barcode" />
</div>
<div>
    <table style="width:90%">
        <tr>
            <td>NO EKSPEDISI</td>
            <td> : <?php echo $no_ekspedisi ?></td>
            <td>TANGGAL KIRIM</td>
            <td> : <?php echo $tgl_ekspedisi ?></td>
        </tr>
        <tr>
            <td style="width:150px">NO PK / PO</td>
            <td style="width:250px"> : <?php echo $po ?></td>
            <td style="width:100px">TANGGAL TERIMA</td>
            <td> :</td>
        </tr>
        <tr>
            <td>NAMA VENDOR</td>
            <td> : <?php echo $vendorName ?></td>
            <td>PENERIMA</td>
            <td> :</td>
        </tr>
        <tr>
            <td>PENGIRIM & NO HP</td>
            <td> :</td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>

<div style="margin-top: 10px">
    <div class="col-md-12">
        <table align=center style="width:90%">
            <tbody>
                <?php
                $no = 1;
                foreach($listDoc as $key => $ld){
                    echo '<tr>';
                    echo '<td style="width:20px">'.$no++.'</td>';
                    echo '<td style="width:250px">'.strtoupper($key).'</td>';
                    echo '<td style="width:200px">'.$ld.'</td>';
                    echo '<td><div style="width:100px;padding:10px;border:1px solid gray;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>

        </table>
        <div style="margin:10px;height:30px;width:650px;padding:5px;border:1px solid gray;">&nbsp;
        <?php
            if(!empty($catatan_vendor)){
                echo $catatan_vendor;
                echo "<br><br><br><br>";
            }
        ?>
        </div>
    </div>
</div>
<div style="margin-bottom:-15px;margin-left:612px">potong disini</div>
<hr style="width:78%;" id="garisBatas">
<div style="margin-top:-17px">potong disini</div>
<div style="margin-top: 20px">&nbsp;</div>
<div style="text-align: center"><h3>TANDA TERIMA DOKUMEN</h3></div>
<div style="position:relative;margin-left:610px;margin-top:-40px">
    <barcode code="<?php echo $kodebarcode ?>" size="0.5" type="QR" error="M" class="barcode" />
</div>
<div>
    <table style="width:90%">
        <tr>
            <td>NO EKSPEDISI</td>
            <td> : <?php echo $no_ekspedisi ?></td>
            <td>TANGGAL KIRIM</td>
            <td> : <?php echo $tgl_ekspedisi ?></td>
        </tr>
        <tr>
            <td style="width:150px">NO PK / OP</td>
            <td style="width:250px"> : <?php echo $po ?></td>
            <td style="width:100px">TANGGAL TERIMA</td>
            <td> :</td>
        </tr>
        <tr>
            <td>NAMA VENDOR</td>
            <td> : <?php echo $vendorName ?></td>
            <td>PENERIMA</td>
            <td> :</td>
        </tr>
        <tr>
            <td>PENGIRIM & NO HP</td>
            <td> :</td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>

<div style="margin-top: 30px">
    <div class="col-md-12">
        <table align=center style="width:90%">
            <tbody>
                <?php
                $no = 1;
                foreach($listDoc as $key => $ld){
                    echo '<tr>';
                    echo '<td style="width:20px">'.$no++.'</td>';
                    echo '<td style="width:250px">'.strtoupper($key).'</td>';
                    echo '<td style="width:200px">'.$ld.'</td>';
                    echo '<td><div style="width:100px;padding:10px;border:1px solid gray;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>

        </table>
        <div style="margin:10px;height:30px;width:650px;padding:5px;border:1px solid gray;">&nbsp;
        <?php
            if(!empty($catatan_vendor)){
                echo $catatan_vendor;
                echo "<br><br><br><br>";
            }
        ?>
        
        </div>
    </div>
</div>
