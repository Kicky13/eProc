<?php
// echo "<pre>";
// print_r($asli['IT_DATA']);
// die;
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
    <?php //foreach ($it_data as $data) : ?>
    <?php foreach ($asli['IT_DATA'] as $data) : ?>
        <tr class="listpo">
            <td class="text-center"><input type="checkbox" class="cekvendor vendors" name="vendor[]" onchange="terpilih(this)" value="<?php echo $data['LIFNR'] ?>"></td>
            <td class="text-center"><?php echo $data['LIFNR'] ?></td>
            <td class="text-center namavendor"><?php echo $data['NAME1'] ?></td>
            
            <!-- <td class="text-center">
                <?php
                echo $data['EBELN'];
                ?>
            </td>
            <td class="text-center">
                <?php
                echo !empty(number_format(intval($data['NETPR']*100),0,",","."));
                ?>
            </td>

            <td class="text-center">
                <?php
                if(!empty($data['BEDAT'])){
                    $date = $data['BEDAT']; 
                    $tgl = substr($date, 6, 2);
                    $bln = substr($date, 4, 2);
                    $thn = substr($date, 0, 4);
                    echo $tgl.'-'.$bln.'-'.$thn;
                }
                ?>
            </td> -->

            <td class="text-center"><?php echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['EBELN'])?$data['EBELN'] : ''; ?></td>
            <td class="text-center"><?php echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['NETPR'])?number_format(intval($data['NETPR']*100)) : ''; ?></td>
            <td class="text-center"><?php 
                if(!empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['BEDAT'])){
                    $date = $data['BEDAT']; 
                    $tgl = substr($date, 6, 2);
                    $bln = substr($date, 4, 2);
                    $thn = substr($date, 0, 4);
                    echo $tgl.'-'.$bln.'-'.$thn;
                }
                ?>

            </td>
            <?php //foreach ($tit as $val) : ?>
            <!-- baru ditambahkan tanggal 12 oktober 2017 -->
            <!-- <td class="text-center"> -->
            <?php
                    //echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['EBELN'])?$detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['EBELN'] : '';
            ?>

            <!-- </td> -->
            <!-- <td class="text-center"> -->
            <?php //echo !empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['NETPR'])?number_format(intval($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['NETPR'])*100) : ''; ?>
            <!-- </td> -->

            <!-- <td class="text-center"> -->
            <?php 
                    // if(!empty($detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['BEDAT'])){
                    //     $date = $detail[$val['PPI_NOMAT']][$data['LIFNR']][0]['BEDAT']; 
                    //     $tgl = substr($date, 6, 2);
                    //     $bln = substr($date, 4, 2);
                    //     $thn = substr($date, 0, 4);
                    //     echo $tgl.'-'.$bln.'-'.$thn;
                    // }
            ?>

            <!-- </td> -->
            <?php //endforeach; ?>
        </tr>
    <?php endforeach; ?>
</tbody>