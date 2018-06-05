<table class="table table-striped nowrap text-center" width="100%">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Status</th>
            <th class="text-center">User</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($data)){
      $no = 1;
      foreach($data as $d){
        echo '<tr>
          <td>'.$no++.'</td>
          <td>'.$d['STATUS_BAPP'].'</td>
          <td>'.$d['UPDATED'].'</td>
          <td>'.$d['UPDATE_BY'].'</td>
        </tr>';
      }

    }
    ?>
    </tbody>
</table>
