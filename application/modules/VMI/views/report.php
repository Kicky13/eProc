<!-- load library jquery dan highcharts -->
<script src="<?php echo base_url();?>static/js/jquery.js"></script>
<script src="<?php echo base_url();?>static/js/pages/highcharts.js"></script>
<!-- end load library -->
 
<?php
    /* Mengambil query report*/
    foreach($report as $result){
        $bulan[] = $result->ID_PLANT; //ambil bulan
        $VMI[] = (float) $result->STOCK_VMI; //ambil nilai
        $STOCK[] = (float) $result->STOCK_AWAL; //ambil nilai
    }
    /* end mengambil query*/
     
?>
 
<!-- Load chart dengan menggunakan ID -->
<?php 
	$variabel = $this->uri->segment(4);
	// echo "coba $variabel aja";
?>
<div id="report"></div>
<!-- END load chart -->
 
<!-- Script untuk memanggil library Highcharts -->
<script type="text/javascript">
$(function () {
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
            text: 'Stock VMI',
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
			title: {
                text: '<br/><br/>Plant'
            },
            categories:  <?php echo json_encode($bulan);?>
        },
        exporting: { 
            enabled: false 
        },
        yAxis: {
            title: {
                text: 'Jumlah'
            },
        },
        /* tooltip: {
             formatter: function() {
                 return 'Plant <b>' + this.x + '</b> sebanyak <b>' + Highcharts.numberFormat(this.y,0) + '</b>, in '+ this.series.name;
             }
          }, */
        series: [
		{
            name: 'Stock VMI',
            data: <?php echo json_encode($VMI);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#045396',
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
            name: 'Stock Awal',
            data: <?php echo json_encode($STOCK);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#dadada',
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
        }]
    });
});
        </script>