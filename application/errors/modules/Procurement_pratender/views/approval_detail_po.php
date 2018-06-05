<?php
// echo "<pre>";
// print_r($asli);die;
?>

<thead>
    <tr>
        <th>&nbsp;</th>
        <th colspan="2" class="text-center"><span style="color:black">VENDOR</span></th>
        <?php foreach ($tit as $val) : ?>
            <th colspan="3" class="text-center"><span style="color:black"><?php echo $val['PPI_ID']; ?></span></th>
        <?php endforeach; ?>
    </tr>
    <tr>
        <th></th>
        <th class="text-center">No Vendor</th> <!-- LINFR -->
        <th class="text-center">Nama Vendor</th> <!-- NAME1 -->
        <?php foreach ($tit as $val) : ?>
            <th class="text-center">No PO</th> <!-- EBELN -->
            <th class="text-center">Nilai</th>
            <th class="text-center">Tanggal</th>
        <?php endforeach; ?>
    </tr>
    <!-- <tr>
        <th></th>
        <th><input type="text" class="col-xs-12"></th>
        <th><input type="text" class="col-xs-12"></th>

        <?php foreach ($tit as $val) : ?>
            <th><input type="text" class="col-xs-12"></th>
            <th><input type="text" class="col-xs-12"></th>
            <th><input type="text" class="col-xs-12"></th>
        <?php endforeach; ?>
    </tr> -->
</thead>
<tbody>
    <?php foreach ($asli['IT_DATA'] as $data) : ?>
        <?php
        $chek = '';
        if(isset($vendor[$data['LIFNR']])){
            $chek = 'checked';
        }
        ?>
        <tr class="listpo">
            <td class="text-center"><input type="checkbox" <?php echo $chek ?> class="cekvendor cek_pilih_vendor" name="vendor[]" onchange="terpilih(this)" value="<?php echo $data['LIFNR'] ?>"></td>
            <td class="text-center"><?php echo $data['LIFNR'] ?></td>
            <td class="text-center namavendor"><?php echo $data['NAME1'] ?></td>
            <?php foreach ($tit as $val) : ?>
                <!-- <td class="text-center"><?php echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['EBELN'])?$detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['EBELN'] : ''; ?> -->
                <td class="text-center"><?php echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['EBELN'])?$data['EBELN'] : ''; ?>
                    <!-- <input type="hidden" name="no_po[<?php echo $data['LIFNR'].']['.$val['PPI_ID'] ?>][]" value="<?php echo $detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['EBELN'] ?>"> -->
                    <input type="hidden" name="no_po[<?php echo $data['LIFNR'].']['.$val['PPI_ID'] ?>][]" value="<?php echo $data['EBELN'] ?>">
                </td>
                <!-- <td class="text-center"><?php echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['NETPR'])?number_format(intval($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['NETPR'])*100) : ''; ?> -->
                <td class="text-center"><?php echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['NETPR'])?number_format(intval($data['NETPR'])*100) : ''; ?>
                    <!-- <input type="hidden" name="netpr[<?php echo $data['LIFNR'].']['.$val['PPI_ID'] ?>][]" value="<?php echo $detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['NETPR'] ?>"> -->
                    <input type="hidden" name="netpr[<?php echo $data['LIFNR'].']['.$val['PPI_ID'] ?>][]" value="<?php echo $data['NETPR'] ?>">
                </td>
                <td class="text-center"><?php 
                    // if(!empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['BEDAT'])){
                    //     $date = $detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['BEDAT']; 
                    //     $tgl = substr($date, 6, 2);
                    //     $bln = substr($date, 4, 2);
                    //     $thn = substr($date, 0, 4);
                    //     echo $tgl.'-'.$bln.'-'.$thn;
                    // }

                    if(!empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['BEDAT'])){
                        $date = $data['BEDAT']; 
                        $tgl = substr($date, 6, 2);
                        $bln = substr($date, 4, 2);
                        $thn = substr($date, 0, 4);
                        echo $tgl.'-'.$bln.'-'.$thn;
                    }
                    ?>
                    <input type="hidden" name="tgl[<?php echo $data['LIFNR'].']['.$val['PPI_ID'] ?>][]" value="<?php echo $tgl.'-'.$bln.'-'.$thn ?>">
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</tbody>