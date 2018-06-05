<!DOCTYPE html>
<html>
<head>
	<title>Template Evaluasi Teknis</title>
	<style>
		body{
			font-family: Arial, Helvetica, sans-serif;
		}
		table{
			width: 100%;
		    border: 1px solid black;
		    border-collapse: collapse;
		    margin-top: 7px;
		    margin-bottom: 7px;
		}
		th{
			font-weight: bold;
			font-size: 9pt;
			text-align: center;
		}

		td {
		    padding: 3px;
		    font-size: 9pt;
		}
		table, th, td{
			border-bottom: 1px solid black;
			border-top: 1px solid black;
			border-right: 1px solid black;
			border-left: 1px solid black;
		    border-collapse: collapse;
		}
		.judul{
			font-size: 12pt;
			font-weight: bold;
			text-align: center;
		}
		.table.no-border{
			display: table;
			margin-top: 10px;
			margin-bottom: 10px;
			width: 100%;
		}
		.table-row{
			display: table-row;
			
		}
		.cell{
			display: table-cell;
			font-size: 10pt;
		}
		.cell.head{
			background-color:#000000;
			color:#ffffff;
			text-align: center;
		}

		.cell.border: {
			border: 1px solid black;
			padding: 15px;
		}

	</style>
</head>
<body>
	<div class="container">
		<div class="judul"><strong>HASIL EVALUASI TEKNIS PENGADAAN BARANG/JASA</strong></div>
		<br/>
		<div class="table no-border">
			<div class="table-row">
				<div class="cell" style="width: 150px;"><strong>No Pratender</strong></div>
				<div class="cell">: <?php echo $ptm_pratender; ?></div>
			</div>
			<div class="table-row">
				<div class="cell" style="width: 150px;"><strong>Evaluator</strong></div>
				<div class="cell">: <?php echo $evaluator['FULLNAME']; ?></div>
			</div>
			<div class="table-row">
				<div class="cell" style="width: 150px;"><strong>Unit Kerja</strong></div>
				<div class="cell">: <?php echo $evaluator['DEPT_NAME'].' ('.$evaluator['POS_NAME'].')' ?></div>
			</div>
		</div>
		<br/>
		<table>
			<tr>
			    <th>NO</th>
			    <th>NO ITEM</th>
			    <th>NAMA BARANG/JASA</th>
			    <th>PARAMETER</th>
			    <?php foreach ($ptv as $vnd): ?>
                    <th><?php echo $vnd['VENDOR_NAME'] ?></th>
                <?php endforeach; ?>
			</tr>
			<?php $no=1; foreach ($tit as $item): ?>
				<tr>
					<td rowspan="4" valign="top" align="center"><?php echo $no++; ?></td>
					<td rowspan="4" valign="top"><?php echo $item['PPI_NOMAT'] ?></td>
					<td rowspan="4" valign="top"><b><?php echo $item['PPI_DECMAT'] ?></b></td>				
					<td>
						<?php $n=1; foreach ($ptd as $val): ?>
								<?php 
		                        	if (isset($ppd2[$val['PPD_ID']][$item['TIT_ID']])){
		                        		$item_prnt = $ppd2[$val['PPD_ID']][$item['TIT_ID']]['ET_NAME'];
		                        		$wg_prnt = $ppd2[$val['PPD_ID']][$item['TIT_ID']]['ET_WEIGHT'];
		                        		$et_id = $ppd2[$val['PPD_ID']][$item['TIT_ID']]['ET_ID'];
		                        	}else{
		                        		$item_prnt = $val['PPD_ITEM'] ;
		                        		$wg_prnt = $val['PPD_WEIGHT'];
		                        		$et_id = 0;
		                        	}
		                        ?>     
								<div>
			                        <b><?php echo $item_prnt.' ('.$wg_prnt.'%)';?></b>
								</div>
		                        <?php $m=1; foreach ($uraian[$val['PPD_ID']] as $pptu): ?>
									<?php 
										$dtl = false;
										if (isset($peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']])){
		                                    $item_child = $peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']]['EU_NAME'];
		                                    $eu_weight_dtl = $peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']]['EU_WEIGHT'];

		                                    if(!empty($pptu['PPTU_WEIGHT']) && $val['PPD_MODE']==1) {          
					                            $pptu_weight = '&nbsp;&nbsp;('.$eu_weight_dtl.'%)';
					                        } 
					                        	else{ $pptu_weight = '<span></span>';
					                        } 
					                        $dtl=true;
					                    }
		                            ?>                            
				                    <?php if($dtl): ?>
				                        <div style="<?php echo $m==count($uraian[$val['PPD_ID']]) && $n!=count($ptd)?'border-bottom: 1px solid black':'';?>">
				                        	<?php echo '- '.$item_child.$pptu_weight; ?>
				                        	<!-- <?php echo $m.'- '.count($uraian[$val['PPD_ID']]); ?> -->
				                        </div>
				                    <?php else: ?>
				                    	<div style="<?php echo $m==count($uraian[$val['PPD_ID']]) && $n!=count($ptd)?'border-bottom: 1px solid black':'';?>"></div>
				                    <?php endif; ?>
								<?php $m++; endforeach; ?>
						<?php $n++; endforeach; ?>
					</td>
					<?php foreach ($ptv as $vnd): ?>
						<td>
                        <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): 
                        	$n=1; 
							foreach ($ptd as $val){
								if (isset($ppd2[$val['PPD_ID']][$item['TIT_ID']])){
									$et_id = $ppd2[$val['PPD_ID']][$item['TIT_ID']]['ET_ID'];
								}else{
									$et_id=0;
								}
	                    		$valPrnt = 0;
	                    		if (isset($det[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']])){
	                    			$valPrnt = $det[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']]['DET_TECH_VAL'];
	                    		}
                    	?>
							
	                    		<div align="center" style="font-size: 10pt">
	                    			<b><?php echo $valPrnt ?></b>
	                    		</div>
	                    		<?php $m=1; foreach ($uraian[$val['PPD_ID']] as $pptu): ?>
									<?php
										$dtl = false; 
										if (isset($peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']])){
		                                    $item_child = $peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']]['EU_NAME'];
		                                    $eu_weight_dtl = $peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']]['EU_WEIGHT'];
		                                    $val_det = 0;
		                                    foreach ($peu2[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']] as $v) {
                                                if(isset($deu[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']][$v['EU_ID']])){
                                                    $va = $deu[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']][$v['EU_ID']]; 
                                                    $val_det = $va['DEU_TECH_VAL'];
                                                }
                                            }  
                                            $dtl=true;
                                        }                             
		                            ?>  
		                            <?php if($dtl): ?>                          
				                        <div align="center" style="<?php echo $m==count($uraian[$val['PPD_ID']]) && $n!=count($ptd)?'border-bottom: 1px solid black':'';?>">
				                        	<?php echo $val_det; ?>
				                        </div>
				                    <?php else: ?>
				                    	<div style="<?php echo $m==count($uraian[$val['PPD_ID']]) && $n!=count($ptd)?'border-bottom: 1px solid black':'';?>"></div>
				                    <?php endif; ?>
								<?php $m++; endforeach; ?>
							<?php $n++; } ?>	
                    	<?php endif; ?>
						</td>
                    <?php endforeach; ?>
				</tr>
				<tr>
					<td><b>TOTAL</b></td>
					<?php foreach ($ptv as $vnd): ?>
                        <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                        	<th>
                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                    <?php $pqii = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                    <?php echo $pqii['PQI_TECH_VAL']; ?>
                                <?php endif ?>
                            </th>
                        <?php else: ?>
                            <td></td>
                        <?php endif ?>
                    <?php endforeach ?>
				</tr>
				<tr>
					<td><b>PASS GRADE</b></td>
					<?php foreach ($vendor_data as $vnd): ?>
                        <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                            <th>
                                <?php echo $vnd['EVT_PASSING_GRADE'] ?>
                            </th>
                        <?php else: ?>
                            <td></td>
                        <?php endif ?>
                    <?php endforeach ?>
				</tr>
				<tr>
					<td><b>CATATAN</b></td>
					<?php foreach ($ptv as $vnd): ?>
                        <td>
                            <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                <?php $pqii = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                <b><?php echo $pqii['PQI_NOTE']; ?></b>
                            <?php endif ?>
                        </td>
                    <?php endforeach ?>
				</tr>
			<?php endforeach; ?>
		</table>

</body>
</html>