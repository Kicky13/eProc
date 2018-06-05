<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-danger">' . $pesannya . '</div>';
            }
            $btnNewForm = '';
            $btnListCancel = '<a class="btn btn-primary" href="'.site_url('EC_Invoice_ver/EC_List_Canceled').'">List Canceled</a>';
            if(!empty($adaInvoice)) {
              $btnNewForm = '<a class="btn btn-primary" href="'.site_url('EC_Invoice_ver/EC_Reverse_Invoice/form').'">Form Baru</a>';

            }
            ?>
          <?php echo form_open_multipart('EC_Invoice_ver/EC_Reverse_Invoice/reverseInvoice/', array('method' => 'POST', 'class' => 'form-horizontal formEdit', 'id' => 'formDetailInvoice')); ?>
            <div class="panel panel-default">
                <div class="panel-heading">Form Reverse Invoice Dengan Status <strong>Posting</strong> <span class="right"><?php echo $btnNewForm.' '.$btnListCancel; ?></span></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12 col-lg-12">
                            <div class="form-group">
                                <?php
                                if (isset($pesan) && !empty($pesan)) {
                                    echo '<div class="col-md-12" style="text-align:center;margin:2px auto"><span class="col-md-12 alert alert-danger">' . $pesan . '</span></div>';
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="Invoice Date" class="col-sm-2 control-label">Nomer Mir</label>
                                <div class="col-sm-3 tgll">
                                    <div class="input-group date startDate">
                                        <input  class="form-control" name="mir"  type="text" required value="<?php echo $dataCancel['DOCUMENT'] ?>" />

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Invoice No" class="col-sm-2 control-label">Tahun</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" maxlength="4" name="tahun" required value="<?php echo $dataCancel['TAHUN'] ?>" />
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="Invoice No" class="col-sm-2 control-label">Nomer PO</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" required maxlength="10" name="po_number" value="<?php echo $dataCancel['PO_NUMBER'] ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                              <label for="Invoice No" class="col-sm-2 control-label">Alasan</label>
                                <div class="col-sm-10">
                                    <textarea maxlength="300" name="alasan_reject" required class="form-control" rows="3"><?php echo $dataCancel['ALASAN'] ?></textarea>
                                </div>
                            </div>
                            <?php if(empty($adaInvoice)) { ?>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button class="btn btn-info" type="reset">Reset</button>
                                    <button class="btn btn-info" type="submit">Simpan</button>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(!empty($listTask)){
                                echo '<div class="col-md-offset-2 col-md-8">';
                                echo '<table class="table table-bordered">';
                                echo '<thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Nama Task</th>
                                    <th>Status</th>
                                  </tr>
                                </thead>';
                                echo '<tbody>';
                                $no = 1;
                                foreach ($listTask as $_lt) {
                                  echo '<tr data-url="'.$urlProsess[$_lt['TASK_ID']].'" data-taskid="'.$_lt['TASK_ID'].'" data-status="'.trim($_lt['STATUS']).'"  data-documentid="'.$_lt['DOCUMENT_ID'].'">
                                    <td>'.$no.'</td>
                                    <td>'.$_lt['TASK_NAME'].'</td>
                                    <td>'.($_lt['STATUS'] ? '<span class="label label-success">Done</span>' : '<span class="btn btn-primary" onclick="openFormProses(this)" >Proses</span>').'</td>
                                  </tr>';
                                  $no++;
                                }
                                echo '</tbody>';
                              /*  echo '<tfoot>
                                    <tr>
                                      <td colspan="3"><span class="btn btn-primary" onclick="prosesReviseInvoice(this)">Proses</span></td>
                                    </tr>
                                  </tfoot>';
                              */
                                echo '</table>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

          <?php echo form_close() ?>
        </div>
    </div>
</section>
