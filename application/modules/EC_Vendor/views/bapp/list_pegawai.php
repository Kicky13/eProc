<?php
  if(!empty($rows)){
    echo '<table class="table table-bordered">';
    echo '<thead>
            <tr>
              <th>FULLNAME</th>
              <th>JABATAN</th>
              <th>EMAIL</th>
            </tr>
          </thead>';
    echo '<tbody>';
    foreach($rows as $row){
      echo '  <tr onclick="setPegawaiTerpilih(this)">
                <td class="fullname">'.$row['FULLNAME'].'</td>
                <td class="mjab_nama">'.$row['MJAB_NAMA'].'</td>
                <td class="email">'.$row['EMAIL'].'</td>                
              </tr>
            ';
    }
    echo '</tbody>';
    echo '</table>';
  }else{
    echo 'Data tidak ditemukan';
  }
?>
