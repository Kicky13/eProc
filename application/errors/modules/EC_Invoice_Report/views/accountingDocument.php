<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom:10px">Follow on Document</div>
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <?php
            $header = $list[0];
            foreach($header as $_k => $_l){
              echo '<th class="text-center">'.$_k.'</th>';
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
<br />
