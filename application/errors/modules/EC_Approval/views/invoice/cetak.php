<!DOCTYPE html>
<html>
<head>
	<title>Cetak Lembar Verifikasi</title>
</head>
<style type="text/css">

	td {padding: 3px;}
	span{margin: 30px;}

	tr.all-border td{
		border-top:2 solid black;
	}

	.border {width: 100%; border: 1; border-spacing: 7px;}
	.c{text-align: center;}
	.l{text-align: left;}
	.r{text-align: right;}
	.xsmall{font-size: 8px;}
	.small{font-size: 10px;}
	.medium{font-size: 12px;}
	.big{font-size: 18px;}
	.bold{font-weight: bold;}

</style>
<body>
<?php
	$re = array('(',')');
	$rep = array('','');
	$rep2 = array('','-');
?>
<table border="0" width="100%">
	<tr>
		<td class="l small"><?php echo $company_data['nama']?><td>
		<td class="r small">
			Tanggal Cetak : <?php echo date("Y-m-d H:i:s")?><br>
			<!--Hal : {literal}{PAGENO}{/literal} dari {nbpg}-->
		<td>
	</tr>
</table>
<?php $mnt = $bulan[date('n')-1]?>
<table border="0" width="100%">	
	<tr>
		<td width="100%" class="c">
			<span class="bold big">Lembar Verifikasi</span><br><span class="small">No. <?php echo $invoice['FI_NUMBER_SAP'].'/'.$invoice['DOC_TYPE'].'/'.date('m').'/'.date('Y')?></span>
		<td>
	</tr>
</table>

<span class="small">Lokasi : </span>

<table class="border">
	<tr>
		<td class="small">Jenis Permintaan : LANGSUNG</td>
	</tr>
</table>
<table class="border">
	<tr>
		<td class="c small">DATA ANGGARAN</td>
	</tr>
</table>
<table class="l small border">
	<tr>
		<td width="40%">Tahun : <?php echo date('Y');?></td>
		<td width="60%">
			<span>Bulan : <?php echo $mnt;?> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Rp. </span><br><br>
			<span>Koordinator Anggaran (KA) : </span> 
		</td>
	</tr>
</table>
<table class="l small border">
	<tr>
		<td width="17%">No. Vendor</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $invoice['VENDOR_NO']?></td>
		<td width="17%">Dibayarkan Kepada</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $invoice['VENDOR_NO']?></td>
		</td>
	</tr>
	<tr>
		<td width="17%">Nama Vendor</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $vendor['PREFIX'].' '.$vendor['VENDOR_NAME']?></td>
		<td width="17%"></td>
		<td width="3%"></td>
		<td width="30%"><?php echo $vendor['PREFIX'].' '.$vendor['VENDOR_NAME']?></td>
		</td>
	</tr>
	<tr>
		<td width="17%">No. Kontrak</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $invoice['NO_SP_PO']?></td>
		<td width="17%"></td>
		<td width="3%"></td>
		<td width="30%"><?php echo $vendor['ADDRESS_STREET']?></td>
		</td>
	</tr>
	<tr>
		<td width="17%">No. Invoice</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $invoice['NO_INVOICE']?></td>
		<td width="17%"></td>
		<td width="3%"></td>
		<td width="30%"><?php echo $vendor['detail']['CITY'].' '.$vendor['detail']['POSTAL_CODE']?></td>
		</td>
	</tr>
	<tr>
		<td width="17%">Doc Date</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $invoice['INVOICE_DATE2']?></td>
		<td width="17%">No. Rekening</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $vendor['NO_REK']?></td>
		</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="3%"></td>
		<td width="30%"></td>
		<td width="17%"></td>
		<td width="3%"></td>
		<td width="30%"><?php echo $vendor['BANK_NAME']?></td>
		</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="3%"></td>
		<td width="30%"></td>
		<td width="17%"></td>
		<td width="3%"></td>
		<td width="30%"></td>
		</td>
	</tr>
	<br>
	<tr>
		<td width="17%">Reference</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo clean($invoice['FAKTUR_PJK'])?></td>
		<td width="17%">Alat Pembayaran</td>
		<td width="3%">:</td>
		<td width="30%"><?php echo $invoice['PAYMENT_METHOD']?></td>
		</td>
	</tr>
</table>
<table class="border small">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. Akun</th>
			<th>No. RR</th>
			<th>Cost Center</th>
			<th>Keterangan</th>
			<th>Jumlah FC</th>
			<th>Mta Uang FC</th>
			<th>Jumlah LC</th>
			<th>Mta Uang LC</th>
		</tr>
	</thead>
	<tbody>
	<?php
		for ($i=1; $i < count($accDoc); $i++) { 
	?>
		<tr class="last">
			<td class="c"><?php echo $i;?></td>
			<td class="c"><?php echo $accDoc[$i]['ACCOUNT']?></td>
			<td class="c"><?php echo $accDoc[$i]['NO_RR']?></td>
			<td class="c"><?php echo $accDoc[$i]['COST_CENTER']?></td>
			<td><?php echo $accDoc[$i]['DESCRIPTION']?></td>
			<td><?php echo str_replace($re,$rep2,$accDoc[$i]['AMOUNT'])?></td>
			<td class="c"><?php echo $accDoc[$i]['CURRENCY']?></td>
			<td><?php echo str_replace($re,$rep2,$accDoc[$i]['AMOUNT_IN_LOCAL'])?></td>
			<td class="c"><?php echo $accDoc[$i]['CURRENCY']?></td>
		</tr>
	<?php
		}
	?>
		<tr><td></td><td colspan="4"><hr></td><td colspan="4"></td></tr>
		<tr><td></td><td colspan="8"><?php echo $invoice['NOTE']?></td></tr>
		<tr class="all-border">
			<td colspan="5" class="r">Jumlah : &emsp;&emsp;&emsp;&emsp;</td>
			<td><?php echo str_replace($re,$rep,$accDoc[0]['AMOUNT'])?></td>
			<td class="c"><?php echo $accDoc[0]['CURRENCY']?></td>
			<td><?php echo str_replace($re,$rep,$accDoc[0]['AMOUNT_IN_LOCAL'])?></td>
			<td class="c"><?php echo $accDoc[0]['CURRENCY']?></td>
		</tr>
	</tbody>
</table>
<table class="border small">
	<tr>
		<td width="50%"></td>

	<?php 
		if(isset($approval['detail']['APPROVAL_1'])) {
			$temp1 = explode(',', $approval['detail']['APPROVAL_1']['FULLNAME']);
			$temp2 = explode(',', $approval['detail']['APPROVAL_2']['FULLNAME']);

			$appr1 = strtoupper($temp1[0]);
			$appr2 = strtoupper($temp2[0]);

			$jab1 = $approval['detail']['APPROVAL_1']['POS_NAME'];
			$jab2 = $approval['detail']['APPROVAL_2']['POS_NAME'];
		}else{
			$temp1 = explode(',', $approval['detail']['APPROVAL_2']['FULLNAME']);
			$temp2 = explode(',', $approval['detail']['APPROVAL_3']['FULLNAME']);
			
			$appr1 = strtoupper($temp1[0]);
			$appr2 = strtoupper($temp2[0]);

			$jab1 = $approval['detail']['APPROVAL_2']['POS_NAME'];
			$jab2 = $approval['detail']['APPROVAL_3']['POS_NAME'];
		}
	?>

		<td width="25%" class="c"><?php echo strtoupper($jab2);?></td>
		<td width="25%" class="c"><?php echo strtoupper($jab1);?></td>

	</tr>
	<tr>
		<td width="50%"></td>
		<td width="25%"></td>
		<td width="25%"></td>
	</tr>
	<tr>
		<td width="50%"></td>
		<td width="25%"></td>
		<td width="25%"></td>
	</tr>
	<tr>
		<td width="50%"></td>
		<td width="25%" class="c">TTD</td>
		<td width="25%" class="c">TTD</td>
	</tr>
	<tr>

		<td width="50%"></td>
		<td width="25%" class="c">[<?php echo $appr2;?>]</td>
		<td width="25%" class="c">[<?php echo $appr1;?>]</td>
	</tr>
</table>

<div class='small bold' style="margin-top:50px;"><strong>Lembar Verifikasi ini telah disetujui secara sistem atau elektronik sehingga tidak diperlukan tanda tangan basah sebagai pengesahan</strong></div>
</body>
</html>