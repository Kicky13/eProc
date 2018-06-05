<?php
	$jml_pakan = count($kode_barang);
 ?>
<table class="table table-bordered custom_table" >
	<thead>
			<tr>
				<th class="ftl tanggal" rowspan="3">Tanggal</th>
				<th class="ftl" colspan="<?php echo ($jml_pakan * 2) ?>">Stok Awal</th>
				<th colspan="<?php echo ($jml_pakan * 2) + 1 ?>">Penerimaan</th>
				<th colspan="<?php echo ($jml_pakan * 2) + 2 ?>">Pengeluaran</th>
				<th colspan="<?php echo ($jml_pakan * 2) ?>">Stok Akhir</th>
			</tr>
			<tr>
				<?php
					foreach($kode_barang as $kd){
							echo '<th class="ftl" colspan="2" data-kode_barang="'.$kd['kode_barang'].'">'.$kd['nama_barang'].'</th>';
					}
				?>
					<th rowspan="2">No. Penerimaan</th>
				<?php
					/* penerimaan */
					foreach($kode_barang as $kd){
						echo '<th colspan="2" data-kode_barang="'.$kd['kode_barang'].'">'.$kd['nama_barang'].'</th>';
					}
				?>
				<th rowspan="2">No. Referensi</th>
				<th rowspan="2">Kandang</th>
				<?php
					/* pengeluaran */
					foreach($kode_barang as $kd){
						echo '<th colspan="2" data-kode_barang="'.$kd['kode_barang'].'">'.$kd['nama_barang'].'</th>';
					}
				?>
				<?php
					/* stok akhir */
					foreach($kode_barang as $kd){
						echo '<th colspan="2" data-kode_barang="'.$kd['kode_barang'].'">'.$kd['nama_barang'].'</th>';
					}
				?>
			</tr>
			<tr>
			<?php
				foreach($kode_barang as $kd){
					echo '<th class="ftl">Sak</th>';
					echo '<th class="ftl">Kg</th>';
				}
				foreach($kode_barang as $kd){
					echo '<th>Sak</th>';
					echo '<th>Kg</th>';
					echo '<th>Sak</th>';
					echo '<th>Kg</th>';
					echo '<th>Sak</th>';
					echo '<th>Kg</th>';
				}
			?>
			</tr>
		</thead>
		<tbody>
		<?php

	foreach($farms as $f => $farm){
		echo '<tr style="background-color:gray"><td colspan="4"><strong>Farm '.$namafarm[$f].'('.$f.' '.count($farm).' Kandang )</strong></td><td colspan="18"></td></tr>';
		foreach($farm as $kd => $data){
		$tgl_docin = $data['tgl_docin'];
		$populasi_awal = $data['populasi_awal'];

		echo '<tr style="background-color:green"><td colspan="4"><strong>'.$kd.' ('.$populasi_awal.')'.'</strong></td><td colspan="18" ></td></td></tr>';
		$gterima = $data['gterima'] ;
		$kterima = $data['kterima'] ;
		$rtanggal = $data['rtanggal'] ;
		$jml_baris = 1;
			$showData = 0;
			if(empty($rtanggal)){
				$pesan = 'Data tidak ditemukan';
			}
			else{
				$awal = new \Datetime($rtanggal['min']);
				$akhir = new \Datetime($rtanggal['max']);
				$showData = 1;
				/*cari jumlah baris per kandang untuk dijadikan acuan rowspan */
				$_awal = new \Datetime($rtanggal['min']);
				$_akhir = new \Datetime($rtanggal['max']);
				while($_awal < $_akhir){
					$_awal->add(new \DateInterval('P1D'));
					$_index_hari = date('w',strtotime($awal->format('Y-m-d')));
					if($_index_hari == 0 || $_awal == $_akhir){
						$jml_baris++;
					}
				}

			}
		if($showData){
			$stok_awal = array();
			$stok_akhir = array();
			$stok_awal_minggu = array();
			$total_terima_perminggu = array();
			$total_keluar_perminggu = array();
			$total_terima = array();
			$total_keluar = array();
			foreach($kode_barang as $kd){
				$stok_awal[$kd['kode_barang']] = array('sak' => 0, 'kg' => 0);
				$stok_akhir[$kd['kode_barang']] = array('sak' => 0, 'kg' => 0);
				$stok_awal_mingguan[$kd['kode_barang']] = array('sak' => 0, 'kg' => 0);

				$total_terima[$kd['kode_barang']] = array('sak' => 0, 'kg' => 0);
				$total_keluar[$kd['kode_barang']] = array('sak' => 0, 'kg' => 0);
				$total_terima_perminggu[$kd['kode_barang']] = array('sak' => 0, 'kg' => 0);
				$total_keluar_perminggu[$kd['kode_barang']] = array('sak' => 0, 'kg' => 0);
			}
			$_counter = 0;
			while($awal <= $akhir){
				$tgl = $awal->format('Y-m-d');
				echo '<tr>';
				if(!$_counter){
					echo '<td rowspan="'.$jml_baris.'" class="text-center tanggal">'.$tgl_docin.'</td>';
					$_counter++;
				}
				$sak_tmp = array();
				$kg_tmp = array();
				$terimaKandang = array();
				$terimaGudang = array();
				/* loop stok awal */
				foreach($kode_barang as $kd){
					$_kb = $kd['kode_barang'];
				/* nitip looping */
					$kkg_tmp[$_kb] = array();
					$ksak_tmp[$_kb] = array();
					$terimaKandang[$_kb] = array('sak' => 0, 'kg' => 0);
					$terimaGudang[$_kb] = array('sak' => 0, 'kg' => 0);
				}

				$gterimatgl = isset($gterima[$tgl]) ? $gterima[$tgl] : array();
				$kterimatgl = isset($kterima[$tgl]) ? $kterima[$tgl] : array();
				/* loop penerimaan */

			$noref = array();
			foreach($gterimatgl as $kb => $ss){
				foreach($ss as $_z){
				//	array_push($noref,$_z['no_referensi']);
					foreach($kode_barang as $kd){
						$_kb = $kd['kode_barang'];

						if($kb == $_kb){
				//			$sak_tmp[$_z['no_referensi']][$_kb] = formatAngka($_z['sak'],0);
				//			$kg_tmp[$_z['no_referensi']][$_kb] = formatAngka($_z['kg'],3);
							$terimaGudang[$kb]['sak'] += $_z['sak'];
							$terimaGudang[$kb]['kg'] += $_z['kg'];
						}
					}

				}
			}
			$nomutasi = array();
			$kandang_tujuan = array();
			foreach($kterimatgl as $kb => $ss){
				foreach($ss as $_z){
					foreach($kode_barang as $kd){
						$_kb = $kd['kode_barang'];
						if($kb == $_kb){
		//					array_push($kkg_tmp[$_kb], formatAngka($_z['kg'],3));
		//					array_push($ksak_tmp[$_kb], formatAngka($_z['sak'],0));
							$terimaKandang[$kb]['sak'] += $_z['sak'];
							$terimaKandang[$kb]['kg'] += $_z['kg'];
						}
			/*			else{
							array_push($kkg_tmp[$_kb], '-');
							array_push($ksak_tmp[$_kb], '-');
						}
			*/
					}
				}
			}


				foreach($kode_barang as $kd){
					$_kb = $kd['kode_barang'];
					/* cari stok akhir */
					$stok_awal_minggu[$_kb]['sak'] = $stok_awal[$_kb]['sak'];
					$stok_awal_minggu[$_kb]['kg']= $stok_awal[$_kb]['kg'];
					$stok_akhir[$_kb]['sak'] = $stok_awal[$_kb]['sak'] + $terimaGudang[$_kb]['sak'] - $terimaKandang[$_kb]['sak'];
					$stok_akhir[$_kb]['kg'] = $stok_awal[$_kb]['kg'] + $terimaGudang[$_kb]['kg'] - $terimaKandang[$_kb]['kg'];
					$stok_awal[$_kb]['sak'] = $stok_akhir[$_kb]['sak'];
					$stok_awal[$_kb]['kg'] = $stok_akhir[$_kb]['kg'];

					$total_terima[$_kb]['sak'] += $terimaGudang[$_kb]['sak'];
					$total_terima[$_kb]['kg'] += $terimaGudang[$_kb]['kg'];
					$total_keluar[$_kb]['sak'] += $terimaKandang[$_kb]['sak'];
					$total_keluar[$_kb]['kg'] += $terimaKandang[$_kb]['kg'];

					$total_terima_perminggu[$_kb]['sak'] += $terimaGudang[$_kb]['sak'];
					$total_terima_perminggu[$_kb]['kg'] += $terimaGudang[$_kb]['kg'];
					$total_keluar_perminggu[$_kb]['sak'] += $terimaKandang[$_kb]['sak'];
					$total_keluar_perminggu[$_kb]['kg'] += $terimaKandang[$_kb]['kg'];

				}

				$showRekap = 0;
				$index_hari = date('w',strtotime($awal->format('Y-m-d')));
				/* 0 untuk hari minggu */
				if($index_hari == 0 || $awal == $akhir){
					$showRekap = 1;
				}
				if($showRekap){
					echo '<tr>';
					echo '<td class="ftl tanggal">'.tglIndonesia($tgl,'-',' ').'</td>';
					foreach($kode_barang as $kd){
						$_kb = $kd['kode_barang'];
						echo '<td class="ftl number">'.($stok_awal_minggu[$_kb]['sak'] > 0 ? formatAngka($stok_awal_minggu[$_kb]['sak'],0) : '-').'</td>';
						echo '<td class="ftl number">'.($stok_awal_minggu[$_kb]['kg'] > 0 ? formatAngka($stok_awal_minggu[$_kb]['kg'],3) : '-').'</td>';
					}
					echo '<td class="number"></td>';
					foreach($kode_barang as $kd){
						$_kb = $kd['kode_barang'];
						echo '<td class="number">'.formatAngka($total_terima_perminggu[$_kb]['sak'],0).'</td>';
						echo '<td class="number">'.formatAngka($total_terima_perminggu[$_kb]['kg'],3).'</td>';
						$total_terima_perminggu[$_kb]['sak'] = 0;
						$total_terima_perminggu[$_kb]['kg'] = 0;
					}
					echo '<td colspan="2"></td>';
					foreach($kode_barang as $kd){
						$_kb = $kd['kode_barang'];
						echo '<td class="number">'.formatAngka($total_keluar_perminggu[$_kb]['sak'],0).'</td>';
						echo '<td class="number">'.formatAngka($total_keluar_perminggu[$_kb]['kg'],3).'</td>';
						$total_keluar_perminggu[$_kb]['sak'] = 0;
						$total_keluar_perminggu[$_kb]['kg'] = 0;
					}
					foreach($kode_barang as $kd){
						$_kb = $kd['kode_barang'];
						echo '<td class="number">'.($stok_akhir[$_kb]['sak'] > 0 ? formatAngka($stok_akhir[$_kb]['sak'],0) : '-').'</td>';
						echo '<td class="number">'.($stok_akhir[$_kb]['kg'] > 0 ? formatAngka($stok_akhir[$_kb]['kg'],3) : '-').'</td>';
					}
					echo	'</tr>';
				}
				$awal->add(new \DateInterval('P1D'));
			}
			echo '<tr class="rekap">';
			echo '<td class="ftl" colspan="'.($jml_pakan * 2 + 1).'">Total 1 Siklus</td>';
			echo '<td class="number"></td>';
			foreach($kode_barang as $kd){
				$_kb = $kd['kode_barang'];
				echo '<td class="number">'.formatAngka($total_terima[$_kb]['sak'],0).'</td>';
				echo '<td class="number">'.formatAngka($total_terima[$_kb]['kg'],3).'</td>';
			}
			echo '<td colspan="2"></td>';
			foreach($kode_barang as $kd){
				$_kb = $kd['kode_barang'];
				echo '<td class="number">'.formatAngka($total_keluar[$_kb]['sak'],0).'</td>';
				echo '<td class="number">'.formatAngka($total_keluar[$_kb]['kg'],3).'</td>';

			}
			echo '<td colspan="'.($jml_pakan * 2).'"></td>';
			echo	'</tr>';
		?>
<?php }
		}
	}
?>
</tbody>
</table>
