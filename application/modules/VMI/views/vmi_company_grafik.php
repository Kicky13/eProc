<!-- load library jquery dan highcharts -->
<script src="<?php echo base_url();?>static/js/pages/highcharts.js"></script>
<!-- end load library -->
<?php
    /* Mengambil query report*/
	// $x = 0;
	// echo "<pre>";
	// print_r($value['data']);
	foreach($value['data'] as $result){
		$quan_pr[]  = intval($result['Quan_Prognose']); //ambil nilai
        $quan_rfc[] = $result['Quan_Realisasi']; //ambil nilai
        $date[] = $result['TANGGAL']; //ambil nilai
    }
	// print_r($value);
	
	foreach($list_gi as $result){
        $realisasi[] 		= (float) $result->REALISASI; //ambil nilai
        // $quan1[] 		= (float) $result->QUANTITY; //ambil nilai
        // $post_date[] 	= $result->POSTING_DATE; //ambil nilai
    }
	// print_r($quan);
	// echo "<br/>";
	// print_r($realisasi);
	
	foreach($view as $result1){
        $kode[] 	= $result1->KODE_MATERIAL; //ambil nilai
        $min[] 		= $result1->MIN; //ambil nilai
        $max[] 		= $result1->MAX; //ambil nilai
        $unit[] 	= $result1->UNIT; //ambil nilai
        $tgl_awal[] = $result1->TANGGAL_AWAL; //ambil nilai
        $tgl_akhir[]= $result1->TANGGAL_AKHIR; //ambil nilai
        $plant[] 	= $result1->PLANT; //ambil nilai
        $quantity[] = (float) $result1->QUANTITY; //ambil nilai
        $nama[] = $result1->NAMA_MATERIAL; //ambil nilai
    }
	$a1 = count($quan_pr);
	$a2 = count($kode);
?>
<style type="text/css">
    .dt-body-right{
        text-align:right;
    }
</style>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Rencana Kebutuhan</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<!--<div class="panel-heading">
							<div class="panel-title pull-left"></div>
							<div class="btn-group pull-right">
							<!-- <a href="<?php echo site_url(''); ?>" class="btn btn-success btn-sm">Perencanaan</a>
							</div>
							<div class="clearfix"></div>
						</div>-->
						<div class="panel-body">
							<div id="report"></div>
						</div>
					</div>
				</div>
			</div>
			
			<!--<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title pull-left">Daftar Kebutuhan</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<table class="table table-hover" id="vmi_cvendor_list">		<!-- Ada di VMI_ALL.js -->
								<!--<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Plant</th>
										<th class="text-center">Material</th>
										<th class="text-center">Kode Material</th>
										<th class="text-center">Periode Awal</th>
										<th class="text-center">Periode Akhir</th>
										<th class="text-center">Quantity</th>
										<!--<th class="text-center">Action</th>-->
									<!--</tr>
								</thead>
								<tbody>
								<?php
								/* $nom = 1;
								for($j=0;$j<$a2;$j++)
								{
								echo "
									<tr>
										<td>$nom</td>
										<td>$plant[$j]</td>
										<td>$nama[$j]</td>
										<td>$kode[$j]</td>
										<td>$tgl_awal[$j]</td>
										<td>$tgl_akhir[$j]</td>
										<td>$quantity[$j]</td>
									</tr>
								";
										// <td><a href='#'><span class='label-success label label-success'>Edit Kebutuhan</span></a></td>
								$nom++;
								} */
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>-->
		</div>
	</div>
</section>

<br/>
<br/>
<!-- END load chart -->
 
<!-- Script untuk memanggil library Highcharts -->
<script type="text/javascript">
$(function () {
		var satuan = " <?php echo $unit[0];?>";
		$('#report').highcharts({
			chart: {
				type: 'line',
				margin: 75,
				options3d: {
					enabled: false,
					alpha: 10,
					beta: 25,
					depth: 70
				}
			},
			title: {
				text: '<?php echo $nama[0];?>',
				style: {
						fontSize: '18px',
						fontFamily: 'Verdana, sans-serif'
				}
			},
			/* subtitle: {
			   text: 'Stock',
			   style: {
						fontSize: '15px',
						fontFamily: 'Verdana, sans-serif'
				}
			}, */
			plotOptions: {
				column: {
					depth: 25
				}
			},
			credits: {
				enabled: false
			},
			xAxis: {
				// title: {
					// text: 'Month'
				// }
				// ,
				categories : [
						<?php
							for($i=0;$i<$a1;$i++)
							{
								$pecah  = explode('-',$date[$i]);
								$baru	= $pecah[1];
								echo "'$baru',";
							}
						?>
				]
			},
			exporting: { 
				enabled: false 
			},
			yAxis: {
				title: {
					text: 'Quantity'
				},
				min:0
			},
			tooltip: {
				 formatter: function() {
					 // return 'Bulan <b>' + this.x + '</b> membutuhkan material sebanyak <b>' + Highcharts.numberFormat(this.y,0) + '</b>, in '+ this.series.name;
					 return 'Bulan <b>' + this.x + '</b> membutuhkan material sebanyak <b>' + Highcharts.numberFormat(this.y,0) + '</b>' + satuan;
				 }
			  },
			series: [
				{
					name: 'Prognose',
					data: <?php echo json_encode($quan_pr);?>,
					// shadow : true,
					color: '#000000',
					dataLabels: {
						enabled: true,
						color: '#000000',
						align: 'center',
						formatter: function() {
							 return Highcharts.numberFormat(this.y, 0);
						}, // one decimal
						y: 0, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				{
					name: ' Realisasi Pemakaian (GI)',
					data: <?php echo json_encode($quan_rfc);?>,
					// data: <?php echo "[8,0,0,0,0,0,0,0,0,0,0,0]";?>,	
					// shadow : true,
					color: '#f51a1a',
					dataLabels: {
						enabled: true,
						color: '#f51a1a',
						align: 'center',
						formatter: function() {
							 return Highcharts.numberFormat(this.y, 0);
						}, // one decimal
						y: 0, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}
			]
		});
	});
</script>