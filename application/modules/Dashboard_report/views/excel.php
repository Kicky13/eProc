<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=List_user.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table class="table table-striped table-bordered table-condensed" id="pr">
    <tr>
        <td class="text-center">No</td>                             
        <td class="text-center">Company</td>                     <!-- [COMPANY]         -->
        <td class="text-center">PGRP</td>                        <!-- [PPR_PGRP]        -->
        <td class="text-center">No PR</td>                       <!-- [PPR_PRNO]        PRC_PURCHASE_REQUISITION-->
        <td class="text-center">PR Item</td>                     <!-- [PPI_PRITEM]      PRC_PURCHASE_REQUISITION-->
        <td class="text-center">No Mat</td>                      <!-- [PPI_NOMAT]       PRC_PR_ITEM-->
        <td class="text-center">Desc</td>                        <!-- [PPI_DECMAT]      PRC_PR_ITEM-->
        <td class="text-center">Approval Date</td>               <!-- [APPROVAL]        PRC_PR_ITEM-->
        <td class="text-center">Doc Submit Date</td>             <!-- [SUBMIT_DOC]      PRC_PR_ITEM-->
        <td class="text-center">No Usulan Pratender</td>         <!-- [SUBPRATENDER]    PRC_TENDER_MAIN-->
        <td class="text-center">Usulan Pratender</td>            <!-- [KONFIGURASI]     PRC_TENDER_COMMENT-->
        <td class="text-center">No Pratender</td>                <!-- [PRATENDER]       PRC_TENDER_MAIN-->
        <td class="text-center">Pratender/RFQ doc date</td>      <!-- [OPENING]         PRC_TENDER_PREP-->
        <td class="text-center">Pratender/RFQ created date</td>  <!-- [RFQ_CREATED]     PRC_TENDER_COMMENT-->
        <td class="text-center">Quot Deadline</td>               <!-- [CLOSING]         PRC_TENDER_PREP-->
        <td class="text-center">Persetujuan Evatek</td>          <!-- [EVATEK_APPROVE]  PRC_TENDER_COMMENT-->
        <td class="text-center">Evatek</td>                      <!-- [EVATEK]          PRC_TENDER_COMMENT-->
        <td class="text-center">Nego</td>                        <!-- [WIN_AT]          PRC_TENDER_ITEM-->
        <td class="text-center">PO Created</td>                  <!-- [PO_CREATED]      PO_HEADER-->
        <td class="text-center">PO Released</td>                 <!-- [PO_RELASED]      PO_HEADER-->
    </tr>

    <?php

    echo $data;
    ?>
</table>