<div class="row">
    <div class="col-md-12">
      <table class="table table-bordered">
      <thead>
          <tr>
              <th>Jenis Dokumen</th>
              <th>No. Dokumen / Nilai</th>
              <th>Check List</th>
          </tr>
      </thead>
      <tbody>
        <?php foreach($lists as $in => $list){
           echo '<tr data-dokumen="'.$in.'"><td colspan="3"><strong>Daftar Dokumen Invoice No. '.$list['Dokument Invoice'].'</strong><span onclick="showDocument(this)" class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span></td></tr>';
            foreach($list as $key => $ld){
                    echo '<tr class="dokumen_'.$in.'" style="display:none">';
                    echo '<td>'.strtoupper($key).'</td>';
                    echo '<td>'.$ld.'</td>';
                    echo '<td class="text-center"><input type="checkbox" checked></td>';
                    echo '</tr>';
                }
                ?>
            <?php }?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-center"><span data-invoice='{ "list_id" : <?php echo $list_id ?>}' class="btn btn-primary" onclick="SubmitDokumen(this)">Submit</span></td>
            </tr>
          </tfoot>
        </table>

    </div>
</div>
