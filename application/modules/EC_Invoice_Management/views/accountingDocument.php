<div class="row">
  <div class="col-md-12">
    <caption class="primary">Follow on Document</caption><br><br>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <?php
            $header = $list[0];
            foreach($header as $_k => $_l){
              echo '<th>'.$_k.'</th>';
            }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach($list as $k => $baris){
          echo '<tr>';
          foreach($baris as $_k => $_l){
            echo '<td>'.$_l.'</td>';
          }
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
