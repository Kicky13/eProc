
<section class="content_section">
  <div class="container clearfix">

    <div class="content_spacer">
      <div class="content">
        <div class="main_title centered upper">
          <h2><span class="line"><i class="ico-users"></i></span>Master Proccess</h2>
        </div>

        <div class="row">
          <!-- Tabs Container -->

          <div class="panel panel-default">
            <div class="panel-heading">Master Proses</div>

            <div class="panel-body">   

              <div class="col-md-12 ">
                <form id="form_ms_menu_ub" name="form_ms_menu_ub" class="form-group">

                  <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Pengadaan</label>
                      <div class="field">
                        <?php echo form_dropdown('nama_company',$nama_company,'','id="nama_company"  class="form-control"')?>
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Company</label>
                      <div class="field">
                        <?=form_dropdown('company',$company,'','id="company"  class="form-control"')?>
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Jenis Pengadaan</label>
                      <div class="field">
                        <?=form_dropdown('sampul',$sampul,'','id="sampul"  class="form-control"')?>
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Metode Pengadaan</label>
                      <div class="field">
                        <select name="just" id="just" class="form-control">
                          <option value="1">Pemilihan Langsung</option>
                          <option value="3">Lelang Terbuka</option>
                          <option value="4">Pembelian Langsung</option>
                          <option value="5">Penunjukan Langsung - Repeat Order (RO)</option>
                          <option value="6">Penunjukan Langsung - Sole Agent (SA)</option>
                          <option value="7">Penunjukan Langsung - Task Force (TF)</option>
                          <option value="8">Penunjukan Langsung - Other (OT)</option>
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>

                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                      <label>Proccess Name</label>
                      <div class="field">
                        <input name="nama_proccess" id="nama_proccess" type="text"  class=" form-control validate[required]" placeholder="Nama Group" value=""  />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                      <label>Urutan</label>
                      <div class="field">
                        <input name="urutan" id="urutan" type="text"  class=" form-control validate[required]" value=""  />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">  
                      <label>Link Url</label>
                      <div class="field">
                        <?=form_dropdown('link_url',$link_url,'','id="link_url"  class="form-control"')?>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Identifikasi Assignment</label>
                      <div class="field">
                        <select id="assignment_" name="assignment_" class="form-control">
                          <option value="0">-ALL-</option>
                          <option value="1">Perencanaan</option>
                          <option value="2">Pengadaaan</option>
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Identifikasi Proccess</label>
                      <div class="field">
                        <?=form_dropdown('identitas_proccess',$identitas_proccess,'','id="identitas_proccess"  class="form-control"')?>
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Identifikasi Assignment</label>
                      <div class="field">
                        <select id="assign_to" name="assign_to" class="form-control">
                          <option value="0">Tidak</option>
                          <option value="1">YA</option>
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" style="padding-top:2%">
                      <input type="hidden" id="app_id" value="" name="app_id"  />
                      <input type="submit" id="simpandataub" class="btn btn-success" value="Simpan">&nbsp;&nbsp;
                      <input  type="reset"  id="batalub" class="btn btn-info" value="Batal">&nbsp;&nbsp;
                      <input  type="button" id="hpusub" class="btn btn-danger" value="Hapus">&nbsp;&nbsp;<input  type="button" id="gendataub" ub="" style="display:none" class="btn btn-default" value="generate">
                    </div>
                  </div>

                  <div class="row">
                    <hr class="info" />
                  </div>

                </form>
                <table id="pr-list-table" class="table table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Urutan</th>
                      <th>Nama Proccess</th>
                      <th>Pengadaan</th>
                      <th>Type Sampul</th>
                      <th>Url</th>
                      <th>Detil</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
</section>
 <!-- <div class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tree Menu</h4>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid">
                          <div id="tampilbody"></div>
                        </div>
                      </div>
                       
                      </div>
                    </div>
                  </div>
                </div>-->
     <script>

    //   $(document).ready(function () {//
//      
//      $("#fk_ms_group_id03").change(function(){
//   $.ajax({
//          url: "<?php echo base_url() ?>index.php/Master_proccess/getTree",
//           data: {
//                      fk_ms_group_id : $("#fk_ms_group_id03").val()
//                      }, 
//          type : 'POST',
//          dataType :'json',
//          beforeSend:function(){                
//          },
//          success : function(data){
//            $("#tree03").dynatree({children:data});
//            $("#tree03").dynatree("getTree").reload();
//           }
//          });
//});
//
//  
//  $("#tree03").dynatree({
//           initAjax: {url: "<?php echo base_url() ?>index.php/Master_proccess/getTree", 
//               data: {
//                      fk_ms_group_id : $("#fk_ms_group_id03").val()
//                      },type : 'POST'
//               },
//               checkbox : true,
//        onSelect: function(select, node) {
//                if($("#fk_ms_group_id03").val()==''){
//                  alert("Pilih Group terlebih dahulu");
//                   return false;
//
//                }else{
//                  $.ajax({
//            url : "<?=base_url()?>index.php/Master_proccess/crud",
//            data : {
//              action : (select)?'Simpan':'Hapus',
//              fk_ms_group_id : $('#fk_ms_group_id03').val(),
//              fk_ms_menu_id : node.data.id,
//            },
//            type : 'POST',
//            dataType :'JSON',
//            beforeSend:function(){             
//            },
//            success : function(data){
//                alert(data.ket);
//              
//             }
//          });
//                 }
//
//               }
//            });
// })
      </script>