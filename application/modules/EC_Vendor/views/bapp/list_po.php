<?php
  $rows = $data['EXPORT_PARAM_TABLE'];
  if(!empty($rows)){
    $po_headers = array_build_key($rows['PO_HEADERS'],'PO_NUMBER');
    $po_items = $rows['PO_ITEMS'];
    echo '<table class="table table-bordered" data-urlservice="'.site_url('EC_Vendor/Bapp/getService').'" data-urlcheckqty="'.site_url('EC_Vendor/Bapp/sisaQty').'">';
    echo '<thead>
            <tr>
              <th>PO_NUMBER</th>
              <th>PO_ITEM</th>
              <th>SHORT_TEXT</th>
              <th>UNIT</th>
              <th>MTRL_GROUP</th>
              <th>DISP_QUAN</th>
              <th>NET_PRICE</th>
              <th>TOTAL</th>
            </tr>
          </thead>';
    echo '<tbody>';
    foreach($po_items as $po){
      $currency = $po_headers[$po['PO_NUMBER']]['CURRENCY'];
      $price = $currency == 'IDR' ? $po['NET_PRICE'] * 100 : $po['NET_PRICE'];
      echo '  <tr data-plant="'.$po['PLANT'].'" onclick="setPOTerpilih(this)">
                <td class="po_number">'.$po['PO_NUMBER'].'</td>
                <td class="po_item">'.$po['PO_ITEM'].'</td>
                <td class="short_text">'.$po['SHORT_TEXT'].'</td>
                <td>'.$po['UNIT'].'</td>
                <td class="mtrl_group">'.$po['MAT_GRP'].'</td>
                <td class="qty text-center">'.ribuan($po['DISP_QUAN']).'</td>
                <td class="text-right">'.ribuan($price).'</td>
                <td class="text-right">'.ribuan($price * $po['DISP_QUAN']).'</td>
              </tr>
            ';
    }
    echo '</tbody>';
    echo '</table>';
  }else{
    echo 'Data tidak ditemukan';
  }
?>
