<input type="hidden" id="ptm_number_vendor_ptm_snippet" value="<?php echo $ptm_number ?>">
<input type="hidden" id="show_harga_vendor_ptm_snippet" value="<?php echo $show_harga ? '1' : '0' ?>">
<?php if ($ptv != null): ?>
<div class="panel panel-default">
    <div class="panel-heading">Vendor</div>
    <table class="table table-hover">
        <thead>
            <th class="text-center col-md-1">No</th>
            <th>Kode Vendor</th>
            <th>Nama</th>
            <th class="col-md-3">No RFQ</th>
            <th>Status</th>
        </thead>
        <tbody id="items_table">
            <?php
                function status($x) { 
                    $stts = array(
                            ''=>'Belum merespon',
                            '-1'=>'Tidak lolos verifikasi',
                            '0'=>'Merespon tidak ikut',
                            '1'=>'Merespon Ikut',
                            '2'=>'Sudah memasukkan penawaran',
                    );
                    return $stts[$x];
                }
                function status2($x) { 
                    $stts = array(
                            ''=>'Tidak Lolos Evatek',
                            '-1'=>'Tidak Diundang Harga',
                            '0'=>'Merespon tidak ikut',
                            '1'=>'Belum Memasukkan Penawaran Harga',
                            '2'=>'Sudah memasukkan penawaran Harga',
                    );
                    return $stts[$x];
                }
            ?>
            <?php $no = 0; foreach ($ptv as $val): ?>
            <tr>
                <td class="text-center"><?php echo ($no + 1) ?></td>
                <td><?php echo $val['PTV_VENDOR_CODE'] ?></td>
                <td><?php echo $val['VENDOR_NAME'] ?></td>
                <td><?php echo $val['PTV_RFQ_NO'] ?></td>
                <td><?php echo ($ptp['PTP_EVALUATION_METHOD_ORI']==3 && $ptm[0]['PTM_STATUS'] >= 16 && $val['PTV_STATUS']==2)?status2($val['PTV_STATUS_EVAL']) : status($val['PTV_STATUS']); ?>
                    <?php if ($val['PTV_STATUS'] == '2') { ?>
                        <?php if ($show_detail): ?>
                            &nbsp;&nbsp;&nbsp;<button type="button" class="snippet_detail_vendor btn btn-info btn-sm" ptv="<?php echo $val['PTV_ID'] ?>">Lihat penawaran</button>
                        <?php endif ?>
                    <?php } ?>
                </td>
            </tr>
            <?php $no++; endforeach ?>
        </tbody>
    </table>
</div>
<?php endif ?>

<?php if ($show_detail): ?>
<div class="modal fade" id="modal_detail_vendor_snippet">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penawaran Vendor</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $modal_vendor = $("#modal_detail_vendor_snippet");
    $modal_vendor.detach();
    $modal_vendor.appendTo('body');

    $(".snippet_detail_vendor").click(function() {
        ptv = $(this).attr('ptv');
        ptm = $("#ptm_number_vendor_ptm_snippet").val();
        show_harga = $("#show_harga_vendor_ptm_snippet").val();
        $.ajax({
            url: $("#base-url").val() + 'Snippet_ajax/tender_vendor',
            type: 'POST',
            dataType: 'html',
            data: {
                ptm: ptm,
                ptv: ptv,
                show_harga: show_harga
            },
        })
        .done(function(data) {
            // console.log(data)
            $("#modal_detail_vendor_snippet").find(".modal-body").html(data);
            $("#modal_detail_vendor_snippet").modal("show");
        })
        .fail(function(data) {
            console.log("error");
            console.log(data);
        });
    });
});
</script>
<?php endif ?>