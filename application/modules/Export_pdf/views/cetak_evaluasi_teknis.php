<?php
// echo "<pre>";
// print_r($pti);
// print_r($ptv);
// print_r($ptv_tit);
// die;
$this->load->model('adm_employee');

?>
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
            <th><?php echo $logo; ?></th>
            <th><?php echo $company; ?></th>
        </tr>
    </table>
    <div class="judul"><strong>HASIL EVALUASI TEKNIS PENGADAAN BARANG / JASA <br>NAMA PENGADAAN : <?php echo $ptm[0]['PTM_SUBJECT_OF_WORK']; ?></strong></div>
    <br/>
    <table border="0">
      <tr>
        <th>LB NO.</th>
        <th>:</th>
        <th><?php echo $ptm[0]['PTM_PRATENDER']; ?></th>
    </tr>
    <tr>
        <th>REQUESTIONER</th>
        <th>:</th>
        <th><?php echo $ppr['PPR_REQUESTIONER']; ?> / <?php echo $ppr['LONG_DESC']; ?></th>
    </tr>
    <tr>
        <th>PR Number</th>
        <th>:</th>
        <th><?php echo $ppr['PPR_PRNO']; ?></th>
    </tr>
</table>

<?php
if ($this->session->userdata('COMPANYID') == '7000' || $this->session->userdata('COMPANYID') == '5000') {
    ?>
    <table class="bawah">
        <tr>
            <th class="vertical">NAMA BARANG/JASA</th>
            <th class="vertical" height="15px">Vendor</th>
            <th class="vertical" width="20px" height="15px">Nilai Teknis</th>
            <th class="vertical" width="20px" height="15px">Pass Grade</th>
            <th class="vertical" width="50px" height="15px">Lulus Teknis</th>
            <th class="vertical" width="20px">Peringkat</th>
        </tr>
        <?php
        $no=1;
        foreach ($pti as $val){
            $i = 0;
            foreach ($ptv_tit[$val['TIT_ID']] as $vnd){

                $kode_vendor = $vnd['PTV_VENDOR_CODE'];
                ?>
                <tr>
                    <?php
                    if($i==0){
                        ?>
                        <td class="vertical" rowspan="<?php echo count($ptv_tit[$val['TIT_ID']]); ?>"><?php echo $val['PPI_DECMAT']; ?></td>
                        <?php
                    }
                    ?>
                    
                    <td class="vertical"><?php echo $ptv_vendor_data[$kode_vendor]['VENDOR_NAME']; ?></td>
                    <?php
                    ?>
                    <?php
                    $nil=''; $note=''; $color='';
                    if(isset($kode_vendor)){
                        $nil = $vnd['PQI_TECH_VAL'];
                        $note = $vnd['PQI_NOTE'];
                    }else{
                        $color = "background-color:#E4E2E2";
                    }
                    ?>
                    <td class="vertical" align="center" style="<?php echo $color; ?>" ><?php echo $nil; ?></td>
                    <td class="vertical" align="center"><?php echo $evatek_t; ?></td>
                    <td class="vertical">
                        <?php 
                        if($nil>=$evatek_t){
                            echo "Lulus";
                        } else {
                            echo "Tidak";
                        }
                        ?>
                    </td>
                    <td class="vertical"><?php echo ($i+1); ?></td>
                    <?php
                    ?>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
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

    <br>
    <hr>
    <b>Detail Penilaian</b>
    <div id="template_detail bawah">
        <?php
        if($ppd){
            echo $template_update;
        }
        ?>
    </div>
    <br>
    <b>Komentar Evaluator</b>
    <br>
    <center>
        <table class="bawah">
            <tr>
                <td class="vertical" width="250px">Evaluator</td>
                <td>Komentar</td>
            </tr>
            <?php
            $usernya = "";
            $komennya = 0;
            foreach ($v_log_main as $val){
                if( $val['PROCESS']=='Evatek'){
                    $ptc_comment='';$assgn='';$pesan='';$usr_klrfksi='';$arr_quo_itm=array();$arr_quo_itm2=array();$arr_quo_main2=array();$filePesan='';$dokEvatk=array();
                    foreach ($detail[$val['LM_ID']] as $dtl){
                        $encd = json_decode($dtl['DATA']);
                        if(isset($enc->EVT_ID) && !empty($enc->EVT_ID)){
                            $tmplte[]=$enc->EVT_ID;
                        }
                        if($dtl['TABLE_AFFECTED']=='prc_evaluator' && $dtl['LD_ACTION']=='insert'){ 
                            $as = $this->adm_employee->get(array('ID'=>$encd->EMP_ID));
                            $assgn=$as[0]['FULLNAME'];
                        }
                        if($dtl['TABLE_AFFECTED']=='prc_add_item_evaluasi'){
                            $dokEvatk[$val['LM_ID']][]=$encd->FILE;
                        }
                        if($dtl['TABLE_AFFECTED']=='prc_chat' && $dtl['LD_ACTION']=='insert'){
                            if($encd->STATUS == 'SENT'){
                                $us = $this->vnd_header->get(array('VENDOR_NO'=>$encd->VENDOR_NO));
                                $usr_klrfksi=$us['VENDOR_NAME'];
                            }else if($encd->STATUS == 'REPLAY'){
                                $us = $this->adm_employee->get(array('ID'=>$encd->USER_ID));
                                $usr_klrfksi=$us[0]['FULLNAME'];
                            }
                            $pesan = $encd->PESAN;
                            $filePesan=$encd->FILE_UPLOAD;
                        }

                        $encd2 = json_decode($dtl['CONDITION']);
                        if($dtl['TABLE_AFFECTED']=='prc_tender_quo_item' && !empty($encd->PQI_TECH_VAL)){
                            $this->prc_tender_quo_item->join_pqm();
                            $qiu=$this->prc_tender_quo_item->get(array('PQI_ID'=>$encd2->PQI_ID), false);
                            $arr_quo_itm[$encd2->PQI_ID][$qiu[0]['TIT_ID']][$qiu[0]['PTV_VENDOR_CODE']] = $encd->PQI_TECH_VAL;
                        }
                        if($dtl['TABLE_AFFECTED']=='prc_tender_quo_item' && !empty($encd->PQI_PRICE_VAL)){
                            if(!empty($encd2->PQI_ID)){ 
                                                    //Itemize
                                $this->prc_tender_quo_item->join_pqm();
                                $qiu2=$this->prc_tender_quo_item->get(array('PQI_ID'=>$encd2->PQI_ID), false);
                                $arr_quo_itm2[$encd2->PQI_ID][$qiu2[0]['TIT_ID']][$qiu2[0]['PTV_VENDOR_CODE']] = $encd->PQI_PRICE_VAL;

                            }else if(!empty($encd2->PQM_ID)){ 
                                                    //Paket
                                $this->prc_tender_quo_item->join_pqm();
                                $qiu2=$this->prc_tender_quo_item->get(array('PRC_TENDER_QUO_MAIN.PQM_ID'=>$encd2->PQM_ID), false);
                                                        //if(!empty($qiu2[0]['TIT_ID'])){
                                $arr_quo_main2[$encd2->PQM_ID][$qiu2[0]['PTV_VENDOR_CODE']] = $encd->PQI_PRICE_VAL;
                                                        //}
                            }
                        }
                        if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
                            $ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
                        }
                    }
                    $usernya = $val['USER']; 
                    if(!empty($ptc_comment)){  
                        $komennya++; 
                        ?>
                        <tr>
                            <td><?php echo $val['USER'];?></td>
                            <td><?php echo $ptc_comment; ?></td>
                        </tr>
                        <?php
                    }
                }
            }

            if($komennya==0){  
                ?>
                <tr>
                    <td><?php echo $usernya;?></td>
                    <td><?php echo ""; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </center>

    <br>
    <center>
        <table class="bawah" border="0">
            <!-- <tr>
                <?php
                $i = 1;
                foreach ($v_log_main as $val){
                    if($i == 1){
                        $ket = 'Disiapkan';
                    } else if($i == 2){
                        $ket = 'Diperiksa';
                    } else if($i == 3){
                        $ket = 'Disetujui';
                    } else if($i == 4){
                        $ket = 'Diketahui';
                    } else if($i == 5){
                        break;
                    } 
                    if( $val['PROCESS']=='Evatek' || $val['PROCESS']=='Approval Evatek'){
                        if($val['PTM_NUMBER']==74 && $val['USER_ID']==1454){
                            continue;
                        } else {
                        }
                        ?>
                        <td>
                            <?php echo $ket;?><br>
                            <?php echo $val['USER_POSITION'];?>
                            <br>    
                            <br>    
                            <br>    
                            <br>    
                            <?php
                            if($val['LM_ACTION']=="OK"){
                                echo "Approved";
                            } else {
                                echo "Rejected";
                            }
                            ?>
                            <br>    
                            <br>    
                            <br>    
                            <br>
                            <?php echo $val['USER'];?>
                        </td>
                        <?php
                        $i++; 
                    }
                }
                ?>
            </tr> -->
            <tr>
                <td>
                    Disiapkan<br>
                    <?php echo $posisi[0]['POS_NAME']; ?>
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    Approved
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    <?php echo $emp[0]['FULLNAME']; ?>
                </td>
                <td>
                    Diperiksa<br>
                    <?php echo $hasil_atasan[0]['posisi_atasan']; ?>
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    Approved
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    <?php echo $hasil_atasan[0]['nama_atasan']; ?>
                </td>
                <td>
                    Disetujui<br>
                    <?php echo $hasil_atasan[1]['posisi_atasan']; ?>
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    Approved
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    <?php echo $hasil_atasan[1]['nama_atasan']; ?>
                </td>
                <td>
                    Diketahui<br>
                    <?php echo $hasil_atasan[2]['posisi_atasan']; ?>
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    Approved
                    <br>    
                    <br>    
                    <br>    
                    <br>
                    <?php echo $hasil_atasan[2]['nama_atasan']; ?>
                </td>
            </tr>
        </table>
    </center>
    <br>
    <span style="font-size: 9px;">
        Note : Sesuai dengan ketentuan yang berlaku, PT Semen Indonesia (Persero) Tbk. mengatur bahwa Hasil Evaluasi Teknis ini telah ditandatangani secara elektronik sehingga tidak diperlukan tanda tangan basah pada Hasil Evaluasi Teknis ini.
    </span>
    <?php
} else {
    ?>
    <table class="bawah">
        <tr>
            <th rowspan="2" class="vertical" style="width:15px">No</th>
            <th rowspan="2" class="vertical">NO ITEM</th>
            <th rowspan="2" class="vertical">NAMA BARANG/JASA</th>
            <?php
            foreach ($ptv as $vnd){
                ?>
                <th colspan="2" class="vertical"><?php echo $vnd['VENDOR_NAME']; ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($ptv as $vnd){
                ?>
                <th class="vertical" width="20px" height="15px">Nilai</th>
                <th class="vertical">Keterangan</th>
                <?php
            }
            ?>
        </tr>
        <?php
        $no=1;
        foreach ($pti as $val){
            ?>
            <tr>
                <td class="vertical" align="center"><?php echo $no++; ?></td>
                <td class="vertical"><?php echo $val['PPI_NOMAT']; ?></td>
                <td class="vertical"><?php echo $val['PPI_DECMAT']; ?></td>
                <?php
                foreach ($ptv as $vnd){
                    ?>
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
                    <?php
                }
                ?>
            </tr>
            <?php
        }
        ?>
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
    <?php
}
?>
</div>
</body>
</html>