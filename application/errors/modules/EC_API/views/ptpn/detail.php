<div class="row">
  <div class="col-md-12">
    <?php
      if(!empty($list_data)){
        $total = array();
        foreach($numeric_fields as $_nf){
          $total[$_nf] = 0;
        }
        $_header = array_keys($list_data[0]);

        echo '<caption>Detail Timbangan</caption>';
        echo '<table class="table table-bordered">
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
      echo '</table>';
    }else{
      echo 'Data tidak ditemukan';
    }
    ?>
  </div>
</div>
