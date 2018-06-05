<table style="border:1px solid black">
    <tr>
        <td rowspan="6">
            <img src="<?php echo base_url().'static/logo.png' ?>">
        </td>
    </tr>
    <tr>
        <td>
            Nomor PO
        </td>
        <td>
            <?php echo $po['PO_NUMBER'] ?>
        </td>
    </tr>
    <tr>
        <td>
            Nama Vendor
        </td>
        <td>
            <?php echo $ptv['PTV_VENDOR_CODE'] ?> - <?php echo $ptv['VENDOR_NAME'] ?>
        </td>
    </tr>
    <tr>
        <td>
            Total
        </td>
        <td>
            <?php echo number_format($total) ?>.00
        </td>
    </tr>
    <tr>
        <td>
            Pejabat
        </td>
        <td>
            <?php echo $approval['NAMA'] ?> - <?php echo $approval['JABATAN'] ?> <br>
        </td>
    </tr>
    <tr>
        <td>
            Time
        </td>
        <td>
            <?php echo Date('d-M-Y H:i:s', oraclestrtotime($approval['CREATED_DATE'])); ?>
        </td>
    </tr>
</table>
