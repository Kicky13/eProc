<div class="row">
    <div class="col-md-12">
        <?php 
        if($proses == "terima_retur" && isset($alasan_reject)){
            ?>
            <div class="alert alert-danger">
                <?php echo $alasan_reject;?>
            </div>

        <?php } ?>

        <?php 
        if($proses != "terima_retur" && $status != "kirimUlang" && isset($catatan_vendor)){
            ?>
            <div class="alert alert-danger">
                <?php echo $catatan_vendor;?>
            </div>

        <?php } ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jenis Dokumen</th>
                    <th>No. Dokumen / Nilai</th>
                    <th class="text-center">Check List <?php echo $proses == 'terima' ? ' &ensp;<input type="checkbox" onclick="Select(this)">':''?></th>
                </tr>            
            </thead>
            <tbody>
                <?php             
                foreach($listDoc as $ld){
                    echo '<tr>';
                    echo '<td>'.$ld['JENIS'].'</td>';
                    if($ld['ID']==1) $datanya = $Doc['FAKTUR_PJK'];
                    else if($ld['ID']==2) $datanya = $Doc['NO_SP_PO'];
                    else if($ld['ID']==3) $datanya = $Doc['NO_KWITANSI'];
                    else if($ld['ID']==4) $datanya = $Doc['LPB'];
                    echo '<td>'.$datanya.'</td>';
                    $checked = $proses == 'terima_retur' ? 'checked' : '';
                    echo '<td class="text-center"><input class="item-cb" type="checkbox" '.$checked.'></td>';
                    echo '</tr>';
                }            
                if($proses == "terima_returs"){
                    ?>
                    <tr>
                        <td>Alasan Reject</td>
                        <td  class="text-center" colspan="3">
                            <div class="alert alert-danger">
                                <?php echo $alasan_reject;?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                
                <tr>
                    <td  class="text-center" colspan="3">
                        <?php echo $tombol ?>
                    </td>
                </tr>            
            </tbody>
            
        </table>    
    </div>    
</div>