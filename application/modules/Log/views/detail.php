<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                	<div class="panel panel-default" style="overflow: auto;">
					    <div class="panel-heading"><strong>Data Pengadaan</strong></div>
					    <table class="table table-hover">
					        <tr>
					            <td class="col-md-4"><strong>Creator</strong></td>
					            <td><?php echo $ptm_detail['PTM_REQUESTER_NAME'];?></td>
					        </tr>
					        <tr>
					            <td class="col-md-4"><strong>No Usulan Pratender</strong></td>
					            <td><?php echo $ptm_detail['PTM_SUBPRATENDER'] ?></td>
					        </tr>
					        <tr>
					            <td class="col-md-4"><strong>No Pratender</strong></td>
					            <td><?php echo $ptm_detail['PTM_PRATENDER'] ?></td>
					        </tr>
					        <tr>
					            <td class="col-md-4"><strong>Nama Pengadaan</strong></td>
					            <td><?php echo $ptm_detail['PTM_SUBJECT_OF_WORK'] ?></td>
					        </tr>
					        <tr>
					            <td class="col-md-4"><strong>Jenis Pengadaan</strong></td>
					            <td><?php echo $ptm_detail['IS_JASA'] == 0 ? 'Barang' : 'Jasa' ?></td>
					        </tr>
					        <tr>
					            <td class="col-md-4"><strong>Mekanisme Pengadaan</strong></td>
					            <td><?php echo $ptp['PTP_JUSTIFICATION']; ?></td>
					        </tr>
					    </table>
					</div>
	                <div class="panel panel-default">
					    <div class="panel-heading"><strong>Konfigurasi</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td rowspan="2"><strong>Proses</strong></td>
						    		<td rowspan="2" align="center"><strong>Action</strong></td>
						    		<td rowspan="2"><strong>User</strong></td>
						    		<td rowspan="2"><strong>Vendor Terpilih</strong></td>
						    		<td rowspan="2"><strong>Assign to</strong></td>
						    		<td rowspan="2"><strong>Dokumen PR</strong></td>
						    		<td colspan="9"><strong><center>Metode Pengadaan</center></strong></td>
						    		<td colspan="8"><strong><center>Jadwal Pengadaan</center></strong></td>
						    		<td colspan="3"><strong><center>Jaminan</center></strong></td>
						    		<td rowspan="2"><strong>Catatan Utk Vendor</strong></td>
						    		<td rowspan="2"><strong>Komentar</strong></td>
						    		<td rowspan="2"><strong>IP Address</strong></td>
						    		<td rowspan="2"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<td><strong>Metode Penawaran</strong></td>
						    		<td><strong>Sampul</strong></td>						    		
						    		<td align="center"><strong>Peringatan Penawaran</strong></td>
						    		<td align="center"><strong>BA (%)</strong></td>
						    		<td align="center"><strong>BB (%)</strong></td>
						    		<td><strong>Peringatan Nego</strong></td>
						    		<td><strong>BA Nego</strong></td>
						    		<td><strong>Tipe RFQ</strong></td>
						    		<td><strong>Curr</strong></td>
						    		<td><strong>RFQ Date</strong></td>
						    		<td><strong>Quo Deadline</strong></td>
						    		<td><strong>Delivery Date</strong></td>
						    		<td><strong>Tgl Aanwijing</strong></td>
						    		<td><strong>Lokasi Aanwijing</strong></td>
						    		<td><strong>Term of delivery</strong></td>
						    		<td><strong>Term of Payment</strong></td>
						    		<td><strong>Tgl Validity Harga</strong></td>
						    		<td><strong>Penawaran (%)</strong></td>
						    		<td><strong>Pelaksanaan (%)</strong></td>
						    		<td><strong>Pemeliharaan (%)</strong></td>
						    	</tr>
						    	<?php
					                function warning($x) { 
					                    $stts = array(
					                            '1'=>'Tidak ada pesan',
					                            '2'=>'Warning',
					                            '3'=>'Error',
					                    );
					                    return $stts[$x];
					                }
					                ?>
	                			<?php foreach ($v_log_main as $val) : ?>
	                				<?php 
	                					if(preg_match('/Konfigurasi Staf Perencanaan|Approval Kasi Perencanaan|Approval Kabiro Perencanaan|Approve Kabiro Perencanaan|Approval Kadep Pengadaan|Assign Kasi Pengadaan|Konfigurasi Staf Pengadaan|Approve Kasi Pengadaan|Approve Kabiro Pengadaan/', $val['PROCESS'])):
	                				?>
								    	<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<?php 
								    			$peng_pesan='';$bts_atas='';$bts_bawah='';$vendor=array();$assign='';$t_comment='';
								    			$itemize='';$method='';$share_doc='';$peng_pesan_nego='';$bts_atas_nego='';$tipe_rfq='';$curr='';
								    			$regOpenDate='';$regClosingDate='';$deliveryDate='';$prebidDate='';$prebidLocation='';$termDelivery='';
								    			$termDeliveryNote='';$termPayment='';$termPaymentNote='';$validityHarga='';$ptpPenawaran='';
								    			$ptpPelaksanaan='';$ptpPemeliharaan='';$ptpVndNote='';
								    			foreach ($detail[$val['LM_ID']] as $dtl){
								    				$encd = json_decode($dtl['DATA']);
								    				if(isset($encd->PTP_WARNING) && !empty($encd->PTP_WARNING)){
								    					$peng_pesan = warning($encd->PTP_WARNING);
								    				}
								    				if(isset($encd->PTP_BATAS_PENAWARAN) && !empty($encd->PTP_BATAS_PENAWARAN)){
		    											$bts_atas = $encd->PTP_BATAS_PENAWARAN;
								    				} 
								    				if(isset($encd->PTP_BAWAH_PENAWARAN) && !empty($encd->PTP_BAWAH_PENAWARAN)){
		    											$bts_bawah = $encd->PTP_BAWAH_PENAWARAN;
								    				} 
								    				if(isset($encd->PTV_VENDOR_CODE) && !empty($encd->PTV_VENDOR_CODE)){
		    											$vendor[$encd->PTV_VENDOR_CODE] = $encd->PTV_VENDOR_CODE;
								    				}
								    				if(isset($encd->PTM_ASSIGNMENT) && !empty($encd->PTM_ASSIGNMENT)){
		    											$assign = $encd->PTM_ASSIGNMENT;
								    				}
								    				if(isset($encd->IS_SHARE)){
		    											$shr = $encd->IS_SHARE;
		    											$share_doc = ($shr==0)?'Not Share':'Share';
								    				}							    				
								    				if(isset($encd->PTP_IS_ITEMIZE)){
		    											$mize = $encd->PTP_IS_ITEMIZE;
		    											$itemize = ($mize==0)?'Paket':'Itemize';
								    				}
								    				if(isset($encd->PTP_EVALUATION_METHOD) && !empty($encd->PTP_EVALUATION_METHOD)){
		    											$mt = $encd->PTP_EVALUATION_METHOD;
		    											if($mt==1){
		    												$method = '1 Tahap 1 Sampul';
		    											}else if($mt==2){
		    												$method = '2 Tahap 1 Sampul';
		    											}else{
		    												$method = '2 Tahap 2 Sampul';
		    											}
								    				}
								    				if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
								    					$t_comment = str_replace("'", "", $encd->PTC_COMMENT);
								    				}
								    				if(isset($encd->PTP_WARNING_NEGO) && !empty($encd->PTP_WARNING_NEGO)){
								    					$peng_pesan_nego = warning($encd->PTP_WARNING_NEGO);
								    				}
								    				if(isset($encd->PTP_BATAS_NEGO) && !empty($encd->PTP_BATAS_NEGO)){
								    					$bts_atas_nego = $encd->PTP_BATAS_NEGO;
								    				}
								    				if(isset($encd->PTM_RFQ_TYPE) && !empty($encd->PTM_RFQ_TYPE)){
								    					$tipe_rfq = $encd->PTM_RFQ_TYPE;
								    				}
								    				if(isset($encd->PTM_CURR) && !empty($encd->PTM_CURR)){
								    					$curr = $encd->PTM_CURR;
								    				}
								    				if(isset($encd->PTP_REG_OPENING_DATE) && !empty($encd->PTP_REG_OPENING_DATE)){
								    					$regOpenDate = $encd->PTP_REG_OPENING_DATE;
								    				}
								    				if(isset($encd->PTP_REG_CLOSING_DATE) && !empty($encd->PTP_REG_CLOSING_DATE)){
								    					$regClosingDate = $encd->PTP_REG_CLOSING_DATE;
								    				}
								    				if(isset($encd->PTP_DELIVERY_DATE) && !empty($encd->PTP_DELIVERY_DATE)){
								    					$deliveryDate = $encd->PTP_DELIVERY_DATE;
								    				}
								    				if(isset($encd->PTP_PREBID_DATE) && !empty($encd->PTP_PREBID_DATE)){
								    					$prebidDate = $encd->PTP_PREBID_DATE;
								    				}
								    				if(isset($encd->PTP_PREBID_LOCATION) && !empty($encd->PTP_PREBID_LOCATION)){
								    					$prebidLocation = $encd->PTP_PREBID_LOCATION;
								    				}
								    				if(isset($encd->PTP_TERM_DELIVERY) && !empty($encd->PTP_TERM_DELIVERY)){
								    					$termDelivery = $encd->PTP_TERM_DELIVERY;
								    				}
								    				if(isset($encd->PTP_DELIVERY_NOTE) && !empty($encd->PTP_DELIVERY_NOTE)){
								    					$termDeliveryNote = '('.$encd->PTP_DELIVERY_NOTE.')';
								    				}
								    				if(isset($encd->PTP_TERM_PAYMENT) && !empty($encd->PTP_TERM_PAYMENT)){
								    					$termPayment = $encd->PTP_TERM_PAYMENT;
								    				}
								    				if(isset($encd->PTP_PAYMENT_NOTE) && !empty($encd->PTP_PAYMENT_NOTE)){
								    					$termPaymentNote = '('.$encd->PTP_PAYMENT_NOTE.')';
								    				}
								    				if(isset($encd->PTP_VALIDITY_HARGA) && !empty($encd->PTP_VALIDITY_HARGA)){
								    					$validityHarga = $encd->PTP_VALIDITY_HARGA;
								    				}
								    				if(isset($encd->PTP_PERSEN_PENAWARAN) && !empty($encd->PTP_PERSEN_PENAWARAN)){
								    					$ptpPenawaran = $encd->PTP_PERSEN_PENAWARAN;
								    				}
								    				if(isset($encd->PTP_PERSEN_PELAKSANAAN) && !empty($encd->PTP_PERSEN_PELAKSANAAN)){
								    					$ptpPelaksanaan = $encd->PTP_PERSEN_PELAKSANAAN;
								    				}
								    				if(isset($encd->PTP_PERSEN_PEMELIHARAAN) && !empty($encd->PTP_PERSEN_PEMELIHARAAN)){
								    					$ptpPemeliharaan = $encd->PTP_PERSEN_PEMELIHARAAN;
								    				}
								    				if(isset($encd->PTP_VENDOR_NOTE) && !empty($encd->PTP_VENDOR_NOTE)){
								    					$ptpVndNote = $encd->PTP_VENDOR_NOTE;
								    				}
								    			} 
								    		?>						    		
								    		<td><?php $no=1;
								    			foreach ($vendor as $key => $val2) {
								    				if($key){
								    					$n=' || ';
								    					if(count($vendor)==$no){ $n='';}
								    					echo $vendors[$key].$n;
								    					$no++;
								    				}
								    			}
								    		?></td>
								    		<td><?php if(isset($assigns[$assign])){echo $assigns[$assign];} ?></td>
								    		<td><?php echo $share_doc; ?></td>
								    		<td><?php echo $itemize; ?></td>
								    		<td><?php echo $method; ?></td>								    		
								    		<td align="center"><?php echo $peng_pesan; ?></td>
								    		<td align="center"><?php echo $bts_atas; ?></td>
								    		<td align="center"><?php echo $bts_bawah; ?></td>
								    		<td align="center"><?php echo $peng_pesan_nego; ?></td>
								    		<td align="center"><?php echo $bts_atas_nego; ?></td>
								    		<td align="center"><?php echo $tipe_rfq; ?></td>
								    		<td align="center"><?php echo $curr; ?></td>
								    		<td align="center"><?php echo $regOpenDate; ?></td>
								    		<td align="center"><?php echo $regClosingDate; ?></td>
								    		<td align="center"><?php echo $deliveryDate; ?></td>
								    		<td><?php echo $prebidDate; ?></td>
								    		<td><?php echo $prebidLocation; ?></td>
								    		<td><?php echo $termDelivery.' '.$termDeliveryNote; ?></td>
								    		<td><?php echo $termPayment.' '.$termPaymentNote; ?></td>
								    		<td><?php echo $validityHarga; ?></td>
								    		<td align="center"><?php echo $ptpPenawaran; ?></td>
								    		<td align="center"><?php echo $ptpPelaksanaan; ?></td>
								    		<td align="center"><?php echo $ptpPemeliharaan; ?></td>
								    		<td><?php echo $ptpVndNote; ?></td>
								    		<td><?php echo $t_comment; ?></td>
								    		<td><?php echo $val['IP_ADDRESS']; ?></td>
								    		<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
							    	<?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<?php 
						if($ptp['PTP_EVALUATION_METHOD_ORI']==3){ //2 tahap 2 sampul
							$mthd=0;
							$hdr =1;
						}else{
							$mthd=3;
							$hdr =3;
						}
					?>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Penawaran</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td rowspan="3"><strong>Proses</strong></td>
						    		<td rowspan="3"><strong>Action</strong></td>
						    		<td rowspan="3"><strong>Vendor</strong></td>
						    		<td rowspan="3"><strong>Partisipasi</strong></td>
						    		<td rowspan="3"><strong>Alasan</strong></td>
						    		<td colspan="8" align="center"><strong>Penawaran</strong></td>
						    		<td colspan="<?php echo (count($pr_item)*(2+intval($mthd))); ?>" align="center"><strong>Masukkan Penawaran Item Komersial</strong></td>
						    		<td rowspan="3"><strong>IP Address</strong></td>
						    		<td rowspan="3"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<td rowspan="2"><strong>Surat</strong></td>
						    		<td rowspan="2" width="50px"><strong>Jaminan Penawaran (%)</strong></td>
						    		<td rowspan="2" width="50px"><strong>Jaminan Pelaksanaan (%)</strong></td> 
						    		<td rowspan="2" width="50px"><strong>Jaminan Pemeliharaan (%)</strong></td> 
						    		<td rowspan="2" width="50px"><strong>Kandungan Lokal</strong></td> 
						    		<td rowspan="2"><strong>Waktu Pengiriman</strong></td> 
						    		<td rowspan="2"><strong>Validity Harga Penawaran</strong></td>
						    		<td rowspan="2"><strong>Catatan</strong></td>
						    		<?php foreach ($pr_item as $itm) : ?>
						    			<td colspan="<?php echo 2+intval($mthd); ?>" align="center"><strong><?php echo $itm['PPI_DECMAT']; ?></strong></td>
						    		<?php endforeach; ?>
						    	</tr>
						    	<tr>
						    		<?php foreach ($pr_item as $itm) : ?>
						    			<td><strong>Jumlah</strong></td>
						    			<td><strong>Spesifikasi Penawaran</strong></td>
						    			<?php if($mthd==3): ?>
						    				<td><strong>Harga Satuan</strong></td>
						    				<td><strong>Sub Total</strong></td>
						    				<td><strong>Currency</strong></td>
						    			<?php endif; ?>
						    		<?php endforeach; ?>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
						    		<?php if(preg_match('/Respon Penawaran|Input Penawaran/', $val['PROCESS'])): ?>
	                					<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER_ID'].' - '.$val['USER']; ?></td>
								    		<?php
								    			$partisipasi='';$alasan='';$surat='';$file_surat='';$jaminan='';$file_penawaran='';
								    			$file_pelaksanaan='';$file_pemeliharaan='';$lcl_content='';$dlvry_time='';$valid_thru='';
								    			$notes='';$itm_jml=array();
								    			foreach ($detail[$val['LM_ID']] as $dtl){
								    				$encd = json_decode($dtl['DATA']);
								    				if(isset($encd->PTV_STATUS) && ($encd->PTV_STATUS=="0" || $encd->PTV_STATUS=="1")){
								    					$partisipasi = $encd->PTV_STATUS=="1"?'Ikut':'Tidak Ikut';
								    					$alasan = $encd->ALASAN;
								    				}else{
								    					$jaminan='ada';
								    				}
								    				if(isset($encd->PQM_NUMBER) && !empty($encd->PQM_NUMBER)){
								    					$surat=$encd->PQM_NUMBER;
								    				}
								    				if(isset($encd->FILE_SURAT) && !empty($encd->FILE_SURAT)){
								    					$file_surat=$encd->FILE_SURAT;
								    				}
								    				if(isset($encd->PQM_FILE_PENAWARAN) && !empty($encd->PQM_FILE_PENAWARAN)){
								    					$file_penawaran=$encd->PQM_FILE_PENAWARAN;
								    				}
								    				if(isset($encd->PQM_FILE_PELAKSANAAN) && !empty($encd->PQM_FILE_PELAKSANAAN)){
								    					$file_pelaksanaan=$encd->PQM_FILE_PELAKSANAAN;
								    				}
								    				if(isset($encd->PQM_FILE_PEMELIHARAAN) && !empty($encd->PQM_FILE_PEMELIHARAAN)){
								    					$file_pemeliharaan=$encd->PQM_FILE_PEMELIHARAAN;
								    				}
								    				if(isset($encd->PQM_LOCAL_CONTENT) && !empty($encd->PQM_LOCAL_CONTENT)){
								    					$lcl_content=$encd->PQM_LOCAL_CONTENT;
								    				}
								    				if(isset($encd->PQM_DELIVERY_TIME) && !empty($encd->PQM_DELIVERY_TIME)){
								    					if($encd->PQM_DELIVERY_UNIT==1){
								    						$un = ' Hari';
								    					}else if($encd->PQM_DELIVERY_UNIT==2){
								    						$un = ' Bulan';
								    					}else{
								    						$un = ' Minggu';
								    					}
								    					$dlvry_time=$encd->PQM_DELIVERY_TIME.$un;
								    				}
								    				if(isset($encd->PQM_VALID_THRU) && !empty($encd->PQM_VALID_THRU)){
								    					$valid_thru=$encd->PQM_VALID_THRU;
								    				}
								    				if(isset($encd->PQM_NOTES) && !empty($encd->PQM_NOTES)){
								    					$notes=$encd->PQM_NOTES;
								    				}
								    			}
								    		?>
								    		<td><?php echo $partisipasi; ?></td>
								    		<td><?php echo $alasan;?></td>
								    		<td>
								    			<?php if ($file_surat == ''): ?>
								    				<?php echo $surat;?>
								    			<?php else: ?>
									                <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $file_surat; ?>" target="_blank">
									                    <?php echo $surat;?>
									                </a>
								                <?php endif ?>
								    		</td>
								    		<td>
								    			<?php if ($jaminan != ''): ?>
								    				<?php if ($file_penawaran != ''): ?>
								    					<a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $file_penawaran; ?>" target="_blank">
										                    Ya
										                </a>
								    				<?php else: ?>
								    					Tidak										                
								                	<?php endif; ?>
								                <?php endif; ?>
								    		</td>
								    		<td>
								    			<?php if ($jaminan != ''): ?>
								    				<?php if ($file_pelaksanaan != ''): ?>
								    					<a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $file_pelaksanaan; ?>" target="_blank">
										                    Ya
										                </a>
								    				<?php else: ?>
								    					Tidak										                
								                	<?php endif; ?>
								                <?php endif; ?>
								    		</td>
								    		<td>
								    			<?php if ($jaminan != ''): ?>
								    				<?php if ($file_pemeliharaan != ''): ?>
								    					<a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $file_pemeliharaan; ?>" target="_blank">
										                    Ya
										                </a>
								    				<?php else: ?>
								    					Tidak										                
								                	<?php endif; ?>
								                <?php endif; ?>
								    		</td>
								    		<td><?php echo $lcl_content;?></td>
								    		<td><?php echo $dlvry_time;?></td>
								    		<td><?php echo $valid_thru;?></td>
								    		<td><?php echo $notes;?></td>
								    		<?php 
								    		if(isset($pr_ppi_item[$val['LM_ID']])){
								    			foreach ($pr_item as $itm){
								    				if(isset($pr_ppi_item[$val['LM_ID']][$itm['PPI_ID']])){
								    					$hsl = $pr_ppi_item[$val['LM_ID']][$itm['PPI_ID']][0][0];
								    					echo '<td align="center">'.$hsl->PQI_QTY.'</td>';
								    					echo '<td>'.$hsl->PQI_DESCRIPTION;
								    					if(isset($fileVendor[$val['USER_ID']][$hsl->TIT_ID])){
								    						echo '<a href="'.base_url('Quotation').'/viewDok/'.$fileVendor[$val['USER_ID']][$hsl->TIT_ID][0].'" target="_blank" title="File per Item">
					                                            <i class="glyphicon glyphicon-file"></i>
					                                        </a>';
								    					}
								    					echo '</td>';
								    					if($mthd==3){
								    						echo '<td align="right">'.number_format($hsl->PQI_PRICE).'</td>';
								    						echo '<td align="right">'.number_format($hsl->PQI_QTY * $hsl->PQI_PRICE) .'</td>';
								    						echo '<td align="center">'.$hsl->PQI_CURRENCY.'</td>';
								    					}
								    				}else{
								    					echo '<td></td><td></td>';
								    					if($mthd==3){
								    						echo '<td></td><td></td><td></td>';
								    					}
								    				}
								    			}
								    		}else{
								    			for ($i=0; $i < count($pr_item)*(2+intval($mthd)); $i++) { 
								    				echo '<td></td>';
								    			}					    					
						    				}
								    		?>
								    		<td><?php echo $val['IP_ADDRESS']; ?></td>
								    		<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>	
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Verifikasi</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td rowspan="2" align="center"><strong>Proses</strong></td>
						    		<td rowspan="2" align="center"><strong>Action</strong></td>
						    		<td rowspan="2" align="center"><strong>User</strong></td>
						    		<td colspan="2" align="center"><strong>Verifikasi</strong></td>
						    		<td rowspan="2" align="center"><strong>Retender</strong></td>
						    		<td rowspan="2" align="center"><strong>Komentar</strong></td>
						    		<td rowspan="2" align="center"><strong>IP Address</strong></td>
						    		<td rowspan="2" align="center"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<td align="center"><strong>Sesuai</strong></td>
						    		<td align="center"><strong>Tidak</strong></td>		
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if(preg_match('/Verifikasi Penawaran/', $val['PROCESS'])): ?>
	                					<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<?php
								    			$ptc_comment='';
								    			foreach ($detail[$val['LM_ID']] as $dtl){
								    				$encd = json_decode($dtl['DATA']);
								    				if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
								    					$ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
								    				}
								    			}
								    		?>
								    		<?php if($val['LM_ACTION']=='OK'): ?>
								    			<td><?php $no=1;
								    				if(isset($verVndLolos)){
										    			foreach ($verVndLolos as $v1) {
									    					$n=' || ';
									    					if(count($verVndLolos)==$no){ $n='';}
									    					echo $v1['PTV_VENDOR_CODE'].' - '.$v1['VENDOR_NAME'].$n;
									    					$no++;
										    			}
										    		}else{
										    			echo "";
										    		}
								    			?></td>
								    			<td><?php $no=1;
								    				if(isset($verVndTidak)){
										    			foreach ($verVndTidak as $v1) {
									    					$n=' || ';
									    					if(count($verVndTidak)==$no){ $n='';}
									    					echo $v1['PTV_VENDOR_CODE'].' - '.$v1['VENDOR_NAME'].$n;
									    					$no++;
										    			}
										    		}else{
										    			echo "";
										    		}
								    			?></td>
								    			<td></td>
								    		<?php endif; ?>
								    		<?php if($val['LM_ACTION']=='RETENDER'): ?>
								    			<td></td><td></td>
								    			<td><?php $no=1;
								    			foreach ($retenderItem as $valu) {
							    					$n=' || ';
							    					if(count($retenderItem)==$no){ $n='';}
							    					echo $valu['PPI_ID'].' - '.$valu['PPI_DECMAT'].$n;
							    					$no++;
								    			}
								    			?></td>
								    		<?php endif; ?>
							    			<td><?php echo $ptc_comment; ?></td>
							    			<td><?php echo $val['IP_ADDRESS']; ?></td>
							    			<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Pengajuan Evatek</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center"><strong>Proses</strong></td>
						    		<td align="center"><strong>Action</strong></td>
						    		<td align="center"><strong>User</strong></td>
						    		<td align="center"><strong>Evaluator</strong></td>
						    		<td align="center"><strong>Komentar</strong></td>
						    		<td align="center"><strong>IP Address</strong></td>
						    		<td align="center"><strong>Time Action</strong></td>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if(preg_match('/Pengajuan Evatek|Approval Pengajuan Evatek/', $val['PROCESS'])): ?>
	                					<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<?php
								    			$ptc_comment='';$evltr='';
								    			foreach ($detail[$val['LM_ID']] as $dtl){
								    				$encd = json_decode($dtl['DATA']);
								    				if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
								    					$ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
								    				}
								    				if($dtl['TABLE_AFFECTED']=='prc_evaluator' && $dtl['LD_ACTION']=='insert'){
								    					$ev = $this->adm_employee->get(array('ID'=>$encd->EMP_ID));
								    					$evltr=$ev[0]['FULLNAME'];
								    				}
								    			}
								    		?>
								    		<td><?php echo $evltr; ?></td>
								    		<td><?php echo $ptc_comment; ?></td>
							    			<td><?php echo $val['IP_ADDRESS']; ?></td>
							    			<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Evaluasi</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center" rowspan="3"><strong>Proses</strong></td>
						    		<td align="center" rowspan="3"><strong>Action</strong></td>
						    		<td align="center" rowspan="3"><strong>User</strong></td>
						    		<td align="center" rowspan="3"><strong>Assign To</strong></td>
						    		<td align="center" rowspan="3"><strong>Template</strong></td>
						    		<td align="center" colspan="<?php echo count($ppii)*count($verVndLolos); ?>"><strong>Evaluasi atas material</strong></td>
						    		<td align="center" rowspan="3"><strong>Dokumen Evatek</strong></td>
						    		<td align="center" colspan="2"><strong>Klarifikasi Teknis</strong></td>
						    		<td align="center" rowspan="3"><strong>Komentar</strong></td>
						    		<td align="center" rowspan="3"><strong>IP Address</strong></td>
						    		<td align="center" rowspan="3"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<?php
						    			if($ppii){
							    			foreach ($ppii as $val) {
							    				echo "<td align='center' colspan='".count($verVndLolos)."'><strong>".$val[0]['PPI_DECMAT']."</strong></td>";
							    			}
							    		}else{
							    			echo "<td></td>";
							    		}
						    		?>
						    		<td align="center" rowspan="2"><strong>Vendor/User</strong></td>
						    		<td align="center" rowspan="2"><strong>Isi Klarifikasi</strong></td>
						    	</tr>
						    	<tr>
						    		<?php
						    			if($ppii){
							    			foreach ($ppii as $key => $valu) {
							    				if($verVndLolos){
								    				foreach ($verVndLolos as $val) {
									    				echo "<td align='center'><strong>".$val['VENDOR_NAME']."</strong></td>";
									    			}
									    		}
							    			}
							    		}else{
							    			echo "<td></td>";
							    		}
						    		?>
						    	</tr>
						    	<?php 
						    		$this->load->model('adm_employee');
						    		$this->load->model('vnd_header');
									$this->load->model('prc_tender_quo_item');

						    		foreach ($v_log_main as $val) : ?>
							    	<?php if( $val['PROCESS']=='Evatek' || $val['PROCESS']=='Approval Evatek' || $val['PROCESS']=='Klarifikasi Teknis' || $val['PROCESS']=='Evaluasi Harga'): ?>
							    		<?php
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
							    					if(!empty($encd2->PQI_ID)){ //Itemize
							    						$this->prc_tender_quo_item->join_pqm();
							    						$qiu2=$this->prc_tender_quo_item->get(array('PQI_ID'=>$encd2->PQI_ID), false);
							    						$arr_quo_itm2[$encd2->PQI_ID][$qiu2[0]['TIT_ID']][$qiu2[0]['PTV_VENDOR_CODE']] = $encd->PQI_PRICE_VAL;

							    					}else if(!empty($encd2->PQM_ID)){ //Paket
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
							    		?>					    		
										<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<td><?php echo $assgn; ?></td>
								    		<td><?php 
								    			if(isset($template[$val['LM_ID']])){
								    				echo $template[$val['LM_ID']];
								    			}
								    		?></td>
								    		<?php
								    			if($ppii){
									    			foreach ($ppii as $key => $valu) {
									    				foreach ($verVndLolos as $vali) {
										    					$this->prc_tender_quo_item->join_pqm();
									    					$qi=$this->prc_tender_quo_item->get(array('PRC_TENDER_QUO_ITEM.TIT_ID'=>$key, 'PRC_TENDER_QUO_MAIN.PTM_NUMBER'=>$vali['PTM_NUMBER'], 'PTV_VENDOR_CODE'=>$vali['VENDOR_NO']), false);
									    					if($qi){
									    						echo "<td align='center'>";
										    						if(!empty($arr_quo_itm[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']])){
										    							echo $arr_quo_itm[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']];
										    						}if(!empty($arr_quo_itm2[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']]) && $val['PROCESS'] == 'Evaluasi Harga'){//itemize
										    							echo $arr_quo_itm2[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']];
										    						}if(!empty($arr_quo_main2[$qi[0]['PQM_ID']][$vali['VENDOR_NO']]) && $val['PROCESS'] == 'Evaluasi Harga'){//paket
										    							echo $arr_quo_main2[$qi[0]['PQM_ID']][$vali['VENDOR_NO']];
										    						}
									    						echo "</td>";
									    					}else{
									    						echo "<td></td>";
									    					}
										    			}
									    			}
									    		}else{
									    			echo "<td></td>";
									    		}
								    		?>
								    		<td><?php 
								    			if(isset($dokEvatk[$val['LM_ID']])){
								    				foreach ($dokEvatk[$val['LM_ID']] as $vl) {
								    					echo '<a href="'.base_url('Monitoring_prc').'/viewDok/'.$vl.'" target="_blank" title="File Dokumen Evaluasi">
			                                            	<i class="glyphicon glyphicon-file"></i>
			                                        	</a>';
								    				}
								    			}
								    		?></td>
								    		<td><?php echo $usr_klrfksi; ?></td>
								    		<td><?php 
								    			echo $pesan; 
								    			if(!empty($filePesan)){
						    						echo '<a href="'.base_url('Evaluasi_penawaran').'/viewDok/'.$filePesan.'" target="_blank" title="File Pesan">
			                                            <i class="glyphicon glyphicon-file"></i>
			                                        </a>';
						    					}
								    		?></td>
								    		<td><?php echo $ptc_comment; ?></td>
							    			<td><?php echo $val['IP_ADDRESS']; ?></td>
							    			<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Penentuan Lolos</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center" rowspan="2"><strong>Proses</strong></td>
						    		<td align="center" rowspan="2"><strong>Action</strong></td>
						    		<td align="center" rowspan="2"><strong>User</strong></td>
						    		<?php
						    			if($ptp['PTP_IS_ITEMIZE']==1){ //itemize
						    				if($ppii){
								    			foreach ($ppii as $val) {
								    				echo "<td align='center' colspan='".count($verVndLolos)."'><strong>".$val[0]['PPI_DECMAT']."</strong></td>";
								    			}
								    		}
							    		}else{
							    			echo "<td align='center' colspan='".count($verVndLolos)."'><strong>Vendor</strong></td>";
							    		}
						    		?>
						    		<td align="center" rowspan="2"><strong>Komentar</strong></td>
						    		<td align="center" rowspan="2"><strong>IP Address</strong></td>
						    		<td align="center" rowspan="2"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<?php 
						    			if($ptp['PTP_IS_ITEMIZE']==1){ //itemize 
							    			foreach ($ppii as $key => $valu) {
							    				if($verVndLolos){
								    				foreach ($verVndLolos as $val) {
									    				echo "<td align='center'><strong>".$val['VENDOR_NAME']."</strong></td>";
									    			}
									    		}
							    			}
						    			}else{
						    				if($verVndLolos){
							    				foreach ($verVndLolos as $val) {
								    				echo "<td align='center'><strong>".$val['VENDOR_NAME']."</strong></td>";
								    			}
								    		}
						    			}
						    		?>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if($val['PROCESS']=='Penentuan Lolos Evaluasi'): ?>	
								    	<?php
							    			$ptc_comment='';$quo_itm_lolos=array();
							    			foreach ($detail[$val['LM_ID']] as $dtl){
							    				$encd = json_decode($dtl['DATA']);	
							    				$encd2 = json_decode($dtl['CONDITION']);
							    				if($dtl['TABLE_AFFECTED']=='prc_tender_quo_item' && !empty($encd->PQI_IS_WINNER)){
						    						$this->prc_tender_quo_item->join_pqm();
													$qiu=$this->prc_tender_quo_item->get(array('PQI_ID'=>$encd2->PQI_ID), false);
													if($qiu){
						    							$quo_itm_lolos[$encd2->PQI_ID][$qiu[0]['TIT_ID']][$qiu[0]['PTV_VENDOR_CODE']] = 'Lolos';
						    						}
							    				}			    		
												if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
							    					$ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
							    				}
							    			} 
							    		?>
						    			<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<?php
								    			if($ppii){
								    				if($ptp['PTP_IS_ITEMIZE']==1){ //itemize
								    					foreach ($ppii as $key => $valu) {
										    				foreach ($verVndLolos as $vali) {
											    					$this->prc_tender_quo_item->join_pqm();
										    					$qi=$this->prc_tender_quo_item->get(array('PRC_TENDER_QUO_ITEM.TIT_ID'=>$key, 'PRC_TENDER_QUO_MAIN.PTM_NUMBER'=>$vali['PTM_NUMBER'], 'PTV_VENDOR_CODE'=>$vali['VENDOR_NO']), false);
										    					if($qi){
										    						echo "<td align='center'>";
											    						if(!empty($quo_itm_lolos[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']])){
											    							echo $quo_itm_lolos[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']];
											    						}
										    						echo "</td>";
										    					}else{
										    						echo "<td></td>";
										    					}
											    			}
											    		}
											    	}else{
											    		foreach ($verVndLolos as $vali) {
									    					$this->prc_tender_quo_item->join_pqm();
								    					$qi=$this->prc_tender_quo_item->get(array('PRC_TENDER_QUO_ITEM.TIT_ID'=>$key, 'PRC_TENDER_QUO_MAIN.PTM_NUMBER'=>$vali['PTM_NUMBER'], 'PTV_VENDOR_CODE'=>$vali['VENDOR_NO']), false);
								    					if($qi){
								    						echo "<td align='center'>";
									    						if(!empty($quo_itm_lolos[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']])){
									    							echo $quo_itm_lolos[$qi[0]['PQI_ID']][$key][$vali['VENDOR_NO']];
									    						}
								    						echo "</td>";
								    					}else{
								    						echo "<td></td>";
								    					}
									    			}
											    	}
									    		}else{
									    			if($verVndLolos){
									    				for ($i=0; $i < count($verVndLolos); $i++) { 
									    					echo "<td></td>";
									    				}
									    			}
									    		}
								    		?>
								    		<td><?php echo $ptc_comment; ?></td>
							    			<td><?php echo $val['IP_ADDRESS']; ?></td>
							    			<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Metode Negosiasi</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center" rowspan="2"><strong>Proses</strong></td>
						    		<td align="center" rowspan="2"><strong>Action</strong></td>
						    		<td align="center" rowspan="2"><strong>User</strong></td>
						    		<?php
						    			if($ptp['PTP_IS_ITEMIZE']==1){ //itemize
						    				if($ppii){
								    			foreach ($ppii as $val) {
								    				echo "<td align='center' colspan='2'><strong>".$val[0]['PPI_DECMAT']."</strong></td>";
								    			}
								    		}
							    		}else{
							    			echo "<td align='center' rowspan='2'><strong>Metode</strong></td>";
									    	echo "<td align='center' rowspan='2'><strong>Vendor</strong></td>";
							    		}
						    		?>
						    		<td align="center" rowspan="2"><strong>Komentar</strong></td>
						    		<td align="center" rowspan="2"><strong>IP Address</strong></td>
						    		<td align="center" rowspan="2"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<?php 
						    			if($ptp['PTP_IS_ITEMIZE']==1){ //itemize 
							    			foreach ($ppii as $key => $valu) {
							    				echo "<td align='center'><strong>Metode</strong></td>";
							    				echo "<td align='center'><strong>Vendor</strong></td>";
							    			}
						    			}
						    		?>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if($val['PROCESS']=='Tahap Negosiasi' || $val['PROCESS']=='Approval Negosiasi'): ?>	
								    	<?php
							    			$ptc_comment='';$titStatus=array();$vendorItem=array();$vendorPaket=array();
							    			foreach ($detail[$val['LM_ID']] as $dtl){
							    				$encd = json_decode($dtl['DATA']);	
							    				$encd2 = json_decode($dtl['CONDITION']);
							    				if($dtl['TABLE_AFFECTED']=='prc_tender_item' && !empty($encd->TIT_STATUS)){
						    						$stat='';
						    						if($encd->TIT_STATUS==16){
						    							$stat='Negosiasi';
						    						}
						    						if($encd->TIT_STATUS==48){
						    							$stat='Auction';
						    						}
						    						if($encd->TIT_STATUS==112){
						    							$stat='Analisa Kewajaran Harga';
						    						}
						    						if($encd->TIT_STATUS==6){
						    							$stat='Tunjuk Pemenang';
						    						}
						    						$titStatus[$encd2->TIT_ID]=$stat;
							    				}
							    					//--Itemize--//
							    				if(!empty($encd->TIT_ID) && !empty($encd->PTV_IS_NEGO)){
							    					$vendorItem[$encd->TIT_ID][$encd2->PTV_VENDOR_CODE] = $encd2->PTV_VENDOR_CODE;
							    				}
							    				if(!empty($encd->PTV_VENDOR_CODE) && !empty($encd->PQI_IS_WINNER)){
							    					$vendorItem[$encd2->TIT_ID][$encd->PTV_VENDOR_CODE] = $encd->PTV_VENDOR_CODE;
							    				}
							    					//--End Itemize--//
							    					//--Paket--//
							    				if(isset($encd2->PTV_VENDOR_CODE) && !empty($encd2->PTV_VENDOR_CODE)){
	    											$vendorPaket[$encd2->PTV_VENDOR_CODE] = $encd2->PTV_VENDOR_CODE;
							    				}
							    				if(isset($encd->PTV_VENDOR_CODE) && !empty($encd->PTV_VENDOR_CODE)){
	    											$vendorPaket[$encd->PTV_VENDOR_CODE] = $encd->PTV_VENDOR_CODE;
							    				}		
							    					//--end Paket--//

												if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
							    					$ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
							    				}
							    			} 
							    		?>
						    			<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<?php 
								    			if($ptp['PTP_IS_ITEMIZE']==1){ //itemize 
									    			foreach ($ppii as $tit => $valu) {
									    				if(!empty($titStatus[$tit])){
									    					echo "<td>".$titStatus[$tit]."</td>";
									    				}else{
									    					echo "<td></td>";
									    				}
									    				if(!empty($vendorItem[$tit])){
									    					echo "<td>";
											    				$no=1;
												    			foreach ($vendorItem[$tit] as $ky => $i) {
												    				if($ky){
												    					$n=' || ';
												    					if(count($vendorItem[$tit])==$no){ $n='';}
												    					echo $vendors[$ky].$n;
												    					$no++;
												    				}
												    			}
										    				echo "</td>";
									    				}else{
									    					echo "<td></td>";
									    				}
									    			}
									    		}else{//paket
									    			echo "<td>".$stat."</td>";
									    			echo "<td>";
									    				$no=1;
										    			foreach ($vendorPaket as $key => $p) {
										    				if($key){
										    					$n=' || ';
										    					if(count($vendorPaket)==$no){ $n='';}
										    					echo $vendors[$key].$n;
										    					$no++;
										    				}
										    			}
								    				echo "</td>";
									    		}
									    	?>
								    		<td><?php echo $ptc_comment; ?></td>
							    			<td><?php echo $val['IP_ADDRESS']; ?></td>
							    			<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Negosiasi</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center"><strong>Proses</strong></td>
						    		<td align="center"><strong>Action</strong></td>
						    		<td align="center"><strong>User</strong></td>
						    		<td align="center"><strong>Tgl Selesai</strong></td>
						    		<td align="center"><strong>Pesan</strong></td>
						    		<?php if($tndr_nego){
						    			foreach ($tndr_nego as $val) {
						    				echo "<td align='center'><strong>".$val[0]['PPI_DECMAT']."</strong></td>";
						    			}
						    		} ?>
						    		<td align="center"><strong>File Negosiasi Harga</strong></td>
						    		<td align="center"><strong>Komentar</strong></td>
						    		<td align="center"><strong>IP Address</strong></td>
						    		<td align="center"><strong>Time Action</strong></td>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if($val['PROCESS']=='Buka Negosiasi' || $val['PROCESS']=='Nego Invitation' || $val['PROCESS']=='Tutup Negosiasi'): ?>	
								    	<?php
							    			$ptc_comment='';$tglSelesai='';$pesanNego='';$negoPerItem=array();$fileNego='';$fileNama='';
							    			foreach ($detail[$val['LM_ID']] as $dtl){
							    				$encd = json_decode($dtl['DATA']);	
							    				$encd2 = json_decode($dtl['CONDITION']);
							    				
							    				if(!empty($encd->NEGO_END)){
							    					$tglSelesai = $encd->NEGO_END;
							    				}
							    				if(!empty($encd->PTNS_NEGO_MESSAGE)){
							    					$pesanNego = $encd->PTNS_NEGO_MESSAGE;
							    				}
							    				if(!empty($encd->HARGA) && !empty($encd2->TIT_ID)){
							    					$negoPerItem[$encd2->TIT_ID] = $encd->HARGA;
							    				}
							    				if($dtl['TABLE_AFFECTED']=='prc_tender_nego_vendor_doc' && !empty($encd->FILE_UPLOAD)){
							    					$fileNego = $encd->PTNV_ID;
							    					$fileNama = $encd->FILE_UPLOAD;
							    					$fileVendor = $encd->PTV_VENDOR_CODE;
							    				}
												if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
							    					$ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
							    				}
							    			} 
							    		?>
							    		<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<td><?php echo $tglSelesai; ?></td>
								    		<td><?php echo $pesanNego; ?></td>
								    		<?php if($tndr_nego){
								    			foreach ($tndr_nego as $t => $v) {
								    				if(!empty($negoPerItem[$t])){
								    					echo "<td align='right'>".number_format($negoPerItem[$t])."</td>";
								    				}else{
								    					echo "<td></td>";
								    				}
								    			}
								    		} ?>
								    		<?php 
								    			if(!empty($fileNego)){
						    						echo '<td><a href="'.base_url('Nego_invitation').'/download_file/'.$fileNego.'/'.$fileVendor.'" target="_blank" title="File Nego">
			                                            <i class="glyphicon glyphicon-file"></i>
			                                        </a> '.$fileNama.'</td>';
						    					}else{
							    					echo "<td></td>";
							    				}
						    				?>
								    		<td><?php echo $ptc_comment; ?></td>
							    			<td><?php echo $val['IP_ADDRESS']; ?></td>
							    			<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Auction</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center"><strong>Proses</strong></td>
						    		<td align="center"><strong>Action</strong></td>
						    		<td align="center"><strong>User</strong></td>
						    		<td align="center"><strong>Lokasi Auction</strong></td>
						    		<td align="center"><strong>Tgl Pembukaan</strong></td>
						    		<td align="center"><strong>Tgl Penutupan</strong></td>
						    		<td align="center"><strong>Nilai Pengurangan</strong></td>
						    		<td align="center"><strong>Tipe Auction</strong></td>
						    		<td align="center"><strong>Item</strong></td>
						    		<td align="center"><strong>Vendor</strong></td>
						    		<td align="center"><strong>Harga Terakhir</strong></td>
									<td align="center"><strong>Tipe Breakdown</strong></td>
						    		<td align="center"><strong>IP Address</strong></td>
						    		<td align="center"><strong>Time Action</strong></td>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if($val['PROCESS']=='Konfigurasi Auction' || $val['PROCESS']=='Detail Auction' || $val['PROCESS']=='Auction Negotiation' || $val['PROCESS']=='Edit Konfigurasi Auction' || $val['PROCESS']=='Breakdown Auction'): ?>	
								    	<?php
							    			$lokasi_auc='';$start_auc='';$end_auc='';$nilai_pengurangan='';$tipe_auc='';$item_auc=array();$vendor_auc=array();$final_price='';$tipe_breakdown='';$vnd_winner='';$item_breakdown=array();
							    			foreach ($detail[$val['LM_ID']] as $dtl){
							    				$encd = json_decode($dtl['DATA']);	
							    				$encd2 = json_decode($dtl['CONDITION']);

							    				$link = "";
							    				if(!empty($encd->FILE_UPLOAD)){
							    					$lokasi_FILE_UPLOAD = $encd->FILE_UPLOAD;
							    					$link = '<a href="'.base_url().'upload/paqh_file/'.$lokasi_FILE_UPLOAD.'" target="_blank" title="File per Item">
					                                            <i class="glyphicon glyphicon-file"></i>
					                                        </a>';
								    		
							    				}

							    				if(!empty($encd->PAQH_LOCATION)){
							    					$lokasi_auc = $encd->PAQH_LOCATION;
							    				}
							    				if(!empty($encd->PAQH_AUC_START)){
							    					$start_auc = $encd->PAQH_AUC_START;
							    				}
							    				if(!empty($encd->PAQH_AUC_END)){
							    					$end_auc = $encd->PAQH_AUC_END;
							    				}
							    				if(!empty($encd->PAQH_DECREMENT_VALUE)){
							    					$nilai_pengurangan = number_format($encd->PAQH_DECREMENT_VALUE);
							    				}
							    				if(!empty($encd->PAQH_PRICE_TYPE)){
							    					if($encd->PAQH_PRICE_TYPE=='S'){
							    						$tipe_auc = 'Harga Satuan';
							    					}else{
							    						$tipe_auc = 'Harga Total';
							    					}
							    				}
							    				if($dtl['TABLE_AFFECTED']=='prc_auction_item' && !empty($encd->TIT_ID)){
							    					$item_auc[$encd->TIT_ID]=$encd->TIT_ID;
							    				}
							    				if($dtl['TABLE_AFFECTED']=='prc_auction_detail' && !empty($encd->PTV_VENDOR_CODE)){
							    					$vendor_auc[$encd->PTV_VENDOR_CODE]=$encd->PTV_VENDOR_CODE;
							    				}
							    				if($val['PROCESS']=='Auction Negotiation' && !empty($encd->PAQD_FINAL_PRICE)){
							    					$final_price=number_format($encd->PAQD_FINAL_PRICE);
							    				}
							    				if($dtl['TABLE_AFFECTED']=='prc_auction_quo_header' && !empty($encd->VENDOR_WINNER)){
							    					$vnd_winner=$encd->VENDOR_WINNER;
							    				}
							    				if(!empty($encd->BREAKDOWN_TYPE)){
							    					if($encd->BREAKDOWN_TYPE=='S'){
							    						$tipe_breakdown='Breakdown Sendiri';
							    					}else{
							    						$tipe_breakdown='Breakdown Oleh Vendor';
							    					}
							    				}
							    				if($dtl['TABLE_AFFECTED']=='prc_tender_quo_item' && !empty($encd->PQI_FINAL_PRICE)){
							    					$qiu=$this->prc_tender_quo_item->get(array('PQI_ID'=>$encd2->PQI_ID), false);
							    					$item_breakdown[$qiu[0]['TIT_ID']]=number_format($encd->PQI_FINAL_PRICE);
							    				}
							    			} 
							    		?>
							    		<tr>
								    		<td><?php echo $link.$val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<td><?php echo $lokasi_auc; ?></td>
								    		<td><?php echo $start_auc; ?></td>
								    		<td><?php echo $end_auc; ?></td>
								    		<td align="right"><?php echo $nilai_pengurangan; ?></td>
								    		<td><?php echo $tipe_auc; ?></td>
								    		<td><?php
								    			if(!empty($item_auc)){
								    				$no=1;
									    			foreach ($item_auc as $ky => $i) {
									    				if($ky){
									    					$n=' || ';
									    					if(count($item_auc)==$no){ $n='';}
									    					echo $ppii[$ky][0] ['PPI_DECMAT'].$n;
									    					$no++;
									    				}
									    			}
							    				}
							    				if(!empty($item_breakdown)){
								    				$no=1;
									    			foreach ($item_breakdown as $ky => $i) {
									    				if($ky){
									    					$n=' || ';
									    					if(count($item_breakdown)==$no){ $n='';}
									    					echo $ppii[$ky][0] ['PPI_DECMAT'].' = '.$item_breakdown[$ky].$n;
									    					$no++;
									    				}
									    			}
							    				}
								    		?></td>
								    		<td><?php
								    			if(!empty($vendor_auc)){
								    				$no=1;
									    			foreach ($vendor_auc as $k => $i) {
									    				if($ky){
									    					$n=' || ';
									    					if(count($vendor_auc)==$no){ $n='';}
									    					echo $vendors[$k].$n;
									    					$no++;
									    				}
									    			}
							    				}
							    				if(!empty($vnd_winner)){
							    					echo $vendors[$vnd_winner];
							    				}
								    		?></td>
								    		<td align="right"><?php echo $final_price;?></td>
								    		<td><?php echo $tipe_breakdown; ?></td>
							    			<td><?php echo $val['IP_ADDRESS']; ?></td>
							    			<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
								    <?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Analisa Kewajaran Harga</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center" rowspan="2"><strong>Proses</strong></td>
						    		<td align="center" rowspan="2"><strong>Action</strong></td>
						    		<td align="center" rowspan="2"><strong>User</strong></td>
						    		<td align="center" rowspan="2"><strong>Approval To</strong></td>
						    		<?php if($analisa_harga){
						    			foreach ($analisa_harga as $ah) {
						    				echo "<td align='center' colspan='2'><strong>".$ah[0]['PPI_DECMAT']."</strong></td>";
						    			}
						    		} ?>
						    		<td align="center" rowspan="2"><strong>Dokumen</strong></td>
									<td align="center" rowspan="2"><strong>Keterangan</strong></td>
						    		<td align="center" rowspan="2"><strong>IP Address</strong></td>
						    		<td align="center" rowspan="2"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<?php if($analisa_harga){
						    			foreach ($analisa_harga as $ah) {
						    				echo "<td align='center'><strong>Ece Awal</strong></td>";
						    				echo "<td align='center'><strong>Ece Perubahan</strong></td>";
						    			}
						    		} ?>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if($val['PROCESS']=='Evaluasi ECE' || $val['PROCESS']=='Approval ECE' || $val['PROCESS']=='Reject ECE'): ?>	
							    		<?php
							    			$ptc_comment='';$approveTo='';$eceAwl=array();$eceUbah='';$eceDok='';
							    			foreach ($detail[$val['LM_ID']] as $dtl){
							    				$encd = json_decode($dtl['DATA']);	
							    				
							    				if(!empty($encd->USER_APPROVAL)){
							    					$ev = $this->adm_employee->get(array('ID'=>$encd->USER_APPROVAL));
							    					$approveTo=$ev[0]['FULLNAME'];
							    				}
							    				if(!empty($encd->PRICE_BEFORE)){
							    					$eceAwl[$encd->TIT_ID]=number_format($encd->PRICE_BEFORE);
							    				}
							    				if(!empty($encd->PRICE_AFTER)){
							    					$eceUbah[$encd->TIT_ID]=number_format($encd->PRICE_AFTER);
							    				}
							    				if(!empty($encd->DOKUMEN)){
							    					$eceDok=$encd->DOKUMEN;
							    				}
												if(!empty($encd->PEC_COMMENT)){
							    					$ptc_comment = str_replace("'", "", $encd->PEC_COMMENT);
							    				}
							    			} 
							    		?>
								    	<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<td><?php echo $approveTo; ?></td>
								    		<?php
								    			if($eceAwl){
								    				foreach ($analisa_harga as $tit => $ah) {
								    					if(!empty($eceAwl[$tit])){
								    						echo "<td align='right'>".$eceAwl[$tit]."</td>";
								    					}else{
								    						echo "<td></td>";
								    					}
								    				}
								    			}else{
						    						echo "<td></td>";
						    					}
								    			if($eceUbah){
								    				foreach ($analisa_harga as $tit => $ah) {
								    					if(!empty($eceUbah[$tit])){
								    						echo "<td align='right'>".$eceUbah[$tit]."</td>";
								    					}else{
								    						echo "<td></td>";
								    					}
								    				}
								    			}else{
						    						echo "<td></td>";
						    					}
								    		?>
								    		<td align="center"><?php
								    			if(!empty($eceDok)){
						    						echo '<a href="'.base_url('Ece').'/viewDok/'.$eceDok.'" target="_blank" title="File Ece">
			                                            <i class="glyphicon glyphicon-file"></i>
			                                        </a> ';
						    					}
								    		?></td>
								    		<td><?php echo $ptc_comment; ?></td>
								    		<td><?php echo $val['IP_ADDRESS']; ?></td>
								    		<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
							    	<?php endif; ?>
								<?php endforeach; ?>
					    	</table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>Tunjuk Pemenang</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center"><strong>Proses</strong></td>
						    		<td align="center"><strong>Action</strong></td>
						    		<td align="center"><strong>User</strong></td>
						    		<?php if($tnjk_pmng){
						    			foreach ($tnjk_pmng as $tp) {
						    				echo "<td align='center'><strong>".$tp[0]['PPI_DECMAT']."</strong></td>";
						    			}
						    		} ?>
									<td align="center"><strong>Keterangan</strong></td>
						    		<td align="center"><strong>IP Address</strong></td>
						    		<td align="center"><strong>Time Action</strong></td>
						    	</tr>
						    	<?php foreach ($v_log_main as $val) : ?>
							    	<?php if($val['PROCESS']=='Penunjukan Pemenang'): ?>	
							    		<?php
							    			$ptc_comment='';$vnd_pmng=array();
							    			foreach ($detail[$val['LM_ID']] as $dtl){
							    				$encd = json_decode($dtl['DATA']);	
							    				$encd2 = json_decode($dtl['CONDITION']);
							    				
							    				if(!empty($encd2->TIT_ID)){
							    					$vnd_pmng[$encd2->TIT_ID]=$encd->PEMENANG;
							    				}
												if(!empty($encd->PTC_COMMENT)){
							    					$ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
							    				}
							    			} 
							    		?>
								    	<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<?php 
								    			foreach ($tnjk_pmng as $tit => $tp) {
									    			if(!empty($vnd_pmng[$tit])){
								    					echo "<td>".$vendors[$vnd_pmng[$tit]]."</td>";
								    				}else{
								    					echo "<td></td>";
								    				}
								    			}
							    			?>
								    		<td><?php echo $ptc_comment; ?></td>
								    		<td><?php echo $val['IP_ADDRESS']; ?></td>
								    		<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
							    	<?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<div class="panel panel-default">
					    <div class="panel-heading"><strong>LP3 Lama</strong></div>
					    <div class="table-responsive">
						    <table class="table table-hover" style="font-size:9pt" border="1px">
						    	<tr>
						    		<td align="center" rowspan="2"><strong>Proses</strong></td>
						    		<td align="center" rowspan="2"><strong>Action</strong></td>
						    		<td align="center" rowspan="2"><strong>User</strong></td>
						    		<td align="center" colspan="6"><strong>Detail PO</strong></td>
						    		<td align="center" colspan="<?php echo count($tndr_winner)?>"><strong>Item</strong></td>
									<td align="center" rowspan="2"><strong>Catatan Approval</strong></td>
						    		<td align="center" rowspan="2"><strong>IP Address</strong></td>
						    		<td align="center" rowspan="2"><strong>Time Action</strong></td>
						    	</tr>
						    	<tr>
						    		<td align="center"><strong>Doc Type</strong></td>
						    		<td align="center"><strong>Doc Date</strong></td>
						    		<td align="center"><strong>Delivery Date</strong></td>
						    		<td align="center"><strong>Count days</strong></td>
						    		<td align="center"><strong>Header Text</strong></td>
						    		<td align="center"><strong>Breakdown Delivery Time</strong></td>
						    		<?php
						    			if($tndr_winner){
						    				foreach ($tndr_winner as $win) {
						    					echo "<td><strong>".$win['PPI_DECMAT']."</strong></td>";
						    				}
						    			}else{
						    				echo "<td></td>";
						    			}
						    		?>
						    	</tr>
						    	<?php 
						    		$this->load->model('adm_doctype_pengadaan');
						    		foreach ($v_log_main as $val) : ?>
							    	<?php if($val['PROCESS']=='Create LP3' || $val['PROCESS']=='Approval LP3' || $val['PROCESS']=='Rejected LP3'): ?>	
							    		<?php
							    			$phc_comment='';$doc_tipe='';$doc_date='';$dlvry_date='';$fix_ddate='';$hdr_txt='';$breakdownDlvrTime=array();$itmWinner=array();
							    			foreach ($detail[$val['LM_ID']] as $dtl){
							    				$encd = json_decode($dtl['DATA']);	
							    				$encd2 = json_decode($dtl['CONDITION']);
							    				
							    				if(!empty($encd->DOC_TYPE)){
							    					$dt = $this->adm_doctype_pengadaan->get(array('TYPE' => $encd->DOC_TYPE));
							    					$doc_tipe=$encd->DOC_TYPE.' ('.$dt[0]['DESC'].')';
							    				}
							    				if(!empty($encd->DOC_DATE)){
							    					$doc_date=$encd->DOC_DATE;
							    				}
							    				if(!empty($encd->DDATE)){
							    					$dlvry_date=$encd->DDATE;
							    				}
							    				if(!empty($encd->FIX_DDATE)){
							    					if($encd->FIX_DDATE==1){
							    						$fix_ddate='V';
							    					}
							    				}
							    				if(!empty($encd->HEADER_TEXT)){
							    					$hdr_txt = $encd->HEADER_TEXT;
							    				}
							    				if($dtl['TABLE_AFFECTED']=='po_delivery'){
							    					$dsc='';$tm='';
							    					if(!empty($encd->DESC)){
							    						$dsc = $encd->DESC;
							    					}
							    					if(!empty($encd->TIME)){
							    						$tm = $encd->TIME;
							    					}
							    					$breakdownDlvrTime[]=$dsc.' = '.$tm;
							    				}
							    				if($dtl['TABLE_AFFECTED']=='po_detail' && !empty($encd->ITEM_TEXT) && !empty($encd->PPI_ID)){
							    					$itmWinner[$encd->PPI_ID]=$encd->ITEM_TEXT;
							    				}
												if(!empty($encd->PHC_COMMENT)){
							    					$phc_comment = str_replace("'", "", $encd->PHC_COMMENT);
							    				}
							    			} 
							    		?>
								    	<tr>
								    		<td><?php echo $val['PROCESS']; ?></td>
								    		<td align="center"><?php echo $val['LM_ACTION']; ?></td>
								    		<td><?php echo $val['USER']; ?></td>
								    		<td><?php echo $doc_tipe; ?></td>
								    		<td><?php echo $doc_date; ?></td>
								    		<td><?php echo $dlvry_date; ?></td>
								    		<td align="center"><?php echo $fix_ddate; ?></td>
								    		<td><?php echo $hdr_txt; ?></td>
								    		<td><?php
									    		if($breakdownDlvrTime){
									    			$no=1;
									    			foreach ($breakdownDlvrTime as $value) {
									    				$n=' || ';
								    					if(count($breakdownDlvrTime)==$no){ $n='';}
								    					echo $value.$n;
								    					$no++;
									    			}
									    		}
								    		?></td>
								    		<?php
								    			if($itmWinner){
								    				foreach ($tndr_winner as $tw) {
								    					if(!empty($itmWinner[$tw['PPI_ID']])){
								    						echo '<td>'.$itmWinner[$tw['PPI_ID']].'</td>';
								    					}else{
										    				echo "<td></td>";
										    			}
								    				}
								    			}else{
								    				echo "<td></td><td></td>";
								    			}
								    		?>
								    		<td><?php echo $phc_comment; ?></td>
								    		<td><?php echo $val['IP_ADDRESS']; ?></td>
								    		<td><?php echo $val['LM_DATETIME']; ?></td>
								    	</tr>
							    	<?php endif; ?>
								<?php endforeach; ?>
						    </table>
						</div>
					</div>
					<?php if($lp3):?>
						<?php $this->load->model('adm_doctype_pengadaan');
				    	foreach ($v_log_main as $val) : ?>
					    	<?php if($val['PROCESS']=='Create LP3' || $val['PROCESS']=='Approval LP3' || $val['PROCESS']=='Rejected LP3'): ?>	
			    		<?php
			    			$phc_comment='';$doc_tipe='';$doc_date='';$dlvry_date='';$fix_ddate='';$hdr_txt='';$breakdownDlvrTime=array();$itmWinner=array();
			    			foreach ($detail[$val['LM_ID']] as $dtl){
			    				$encd = json_decode($dtl['DATA']);	
			    				$encd2 = json_decode($dtl['CONDITION']);
			    				
			    				if(!empty($encd->DOC_TYPE)){
			    					$dt = $this->adm_doctype_pengadaan->get(array('TYPE' => $encd->DOC_TYPE));
			    					$doc_tipe=$encd->DOC_TYPE.' ('.$dt[0]['DESC'].')';
			    				}
			    				if(!empty($encd->DOC_DATE)){
			    					$doc_date=$encd->DOC_DATE;
			    				}
			    				if(!empty($encd->DDATE)){
			    					$dlvry_date=$encd->DDATE;
			    				}
			    				if(!empty($encd->FIX_DDATE)){
			    					if($encd->FIX_DDATE==1){
			    						$fix_ddate='V';
			    					}
			    				}
			    				if(!empty($encd->HEADER_TEXT)){
			    					$hdr_txt = $encd->HEADER_TEXT;
			    				}
			    				if($dtl['TABLE_AFFECTED']=='po_delivery'){
			    					$dsc='';$tm='';
			    					if(!empty($encd->DESC)){
			    						$dsc = $encd->DESC;
			    					}
			    					if(!empty($encd->TIME)){
			    						$tm = $encd->TIME;
			    					}
			    					$breakdownDlvrTime[]=$dsc.' = '.$tm;
			    				}
			    				if($dtl['TABLE_AFFECTED']=='po_detail' && !empty($encd->ITEM_TEXT) && !empty($encd->PPI_ID)){
			    					$itmWinner[$encd->PPI_ID]=$encd->ITEM_TEXT;
			    				}
								if(!empty($encd->PHC_COMMENT)){
			    					$phc_comment = str_replace("'", "", $encd->PHC_COMMENT);
			    				}
			    			} 
			    		?>
								<?php foreach ($lp3 as $value):?>
									<div class="panel panel-default">
									    <div class="panel-heading"><strong>LP3</strong></div>
									    <div class="table-responsive">
										    <table class="table table-hover" style="font-size:9pt" border="1px">
										    	<tr>
										    	</tr>
										    </table>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <a href="<?php echo base_url('Monitoring_prc') ?>" class="main_button color7 small_btn">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>

<style>
  table {
    border-collapse: collapse;
  }
  th, td {
    border: 1px solid orange;
    padding: 10px;
  }
</style>