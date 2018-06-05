<div class="row">
  <div class="col-md-12">
    <?php
      if(!empty($list_data)){
        $total = array();
        foreach($numeric_fields as $_nf){
          $total[$_nf] = 0;
        }
        $_header = array_keys($list_data[0]);
      }
      echo '<table id="resumeTable" class="table table-bordered">
        <thead>
          <tr>';
          echo '<th>No. </th>';
          foreach($_header as $_head){
            echo '<th>'.$_head.'</th>';
          }
      echo '
          </tr>
        </thead>';
    echo '<tbody>';
    $no = 1;
    foreach($list_data as $tr){
      $error_class = $tr['QTY'] != $tr['QTY_SAP'] ? 'text-danger' : '';
      echo '<tr class="'.$error_class.'">';
      echo '<td>'.$no++.'</td>';
      foreach($_header as $_head){
        if(in_array($_head,$numeric_fields)){
          $total[$_head] += $tr[$_head];
          echo '<td class="text-right '.$_head.'">'.ribuan($tr[$_head],2).'</td>';
        }else{
          echo '<td class="'.$_head.'">'.$tr[$_head].'</td>';
        }
      }

      echo '</tr>';
    }
    echo '</tbody>';
    echo '<tfoot>';
    echo '<tr><td colspan="7" class="text-right">Total</td><td class="text-right">'.ribuan($total['QTY'],2).'</td><td></td><td class="text-right">'.ribuan($total['QTY_SAP'],2).'</td></tr>';
    echo '</tfoot>';
    echo '</table>';
    ?>
  </div>
  <div class="detail_timbangan col-md-12" id="detail_timbangan" style="max-width:100%;overflow:auto">

  </div>
</div>

<script type="text/javascript">
  $(function(){
    $('#resumeTable>tbody>tr').dblclick(function(){
      var _tr = $(this);
      var _plant = _tr.find('td.PLANT').text();
      var _wb = _tr.find('td.WB').text();
      var _jenistransaksi = _tr.find('td.JENISTRANSAKSI').text();
      var _materialno = _tr.find('td.MATERIALNO').text();
      var _tglkeluar = _tr.find('td.TGLKELUAR').text();
      var _url = "<?php echo site_url('EC_API/Report/detail') ?>";
      _tr.siblings().removeClass('terpilih');
      _tr.addClass('terpilih');
      var _data = {
        plant : _plant,
        wb : _wb,
        jenistransaksi : _jenistransaksi,
        materialno : _materialno,
        tglkeluar : _tglkeluar
      };
      $('#detail_timbangan').html('Harap ditunggu .....');
      $.get(_url,_data,function(data){
        $('#detail_timbangan').html(data);
      },'html');
    })
  })
</script>
<style>
  tr.terpilih{
    background-color: #FFF999;

  }
</style>
