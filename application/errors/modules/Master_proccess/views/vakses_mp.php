
<section class="content_section">
  <div class="container clearfix">

    <div class="content_spacer">
      <div class="content">
        <div class="main_title centered upper">
          <h2><span class="line"><i class="ico-users"></i></span>Akses Master Proccess</h2>
        </div>
        <div class="row">
          <!-- Tabs Container -->
          <div class="panel panel-default">
            <div class="panel-heading">Akses Master Proses</div>
            <div class="panel-body">
              <div class="col-md-12 ">
                <form id="form_ms_proccess" method="post" name="form_ms_proccess" action="<?php echo base_url('Master_proccess/simpan_detil_proccess')?>" class="form-group">
                  <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">  
                      <label>Unit Kerja</label>
                      <div class="field">
                        <input name="unker" id="unker" readonly="readonly" type="text"  class=" form-control validate[required]" placeholder="Nama Group" value=""  />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">  
                      <label></label>
                      <div class="field">
                        <input name="get_unit" id="get_unit" type="button" class="btn btn-default" value="Set Unit">
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">  
                      <label></label>
                      <div class="field">
                      </div>
                    </div>

                  </div>
                  <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 " style="padding-top:2%">  
                      <label>
                        <input type="hidden" id="idpros" name="idpros" value="<?php echo $idpros; ?>" />
                        <input type="hidden" id="kode_unit" name="kode_unit" value="" />
                        <input type="hidden" value="" id="tampil" name="tampil" />
                        <input type="hidden" id="idcom" name="idcom" value="<?php echo $idcom; ?>" />
                        <input type="submit" id="simpan_" class="btn btn-success" value="Simpan">&nbsp;&nbsp;
                        <a href="<?php echo base_url('Master_proccess') ?>"   id="batal_" class="btn btn-info">Batal</a>&nbsp;&nbsp;
                      </label>
                      <div class="field">
                        <table id="pr-list-table_tmp" class="table table-striped">
                          <thead>
                            <tr>
                              <th>Pilih</th>
                              <th>Unit Kerja</th>
                              <th>Jabatan</th>
                              <th>Employee</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <hr class="info">
                  </div>
                </form>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-112">
                  <table id="pr-list-table" class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Unit Kerja</th>
                        <th>Jabatan</th>
                        <th>Employee</th>
                        <th>Hapus</th>
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
  </div>
</section>

<div class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Tree Unit</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div id="tampilbody"></div>
        </div>
      </div>
    </div>
  </div>
</div>

     <script>
      
     $(document).ready(function () {
       
  //var mytable_ ;
   var rows_selected = [];
  $('#pr-list-table_tmp tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');

      // Get row data
      var data = mytable_.row($row).data();
    //
    // console.log( mytable_.row($row).data() );
      var rowId = data['POS_ID'];
    
      // Determine whether row ID is in the list of selected row IDs 
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
         rows_selected.push(rowId);

      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
         rows_selected.splice(index, 1);
      }

      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
     // updateDataTableSelectAllCtrl(table);
    $('#tampil').val(rows_selected.toString());
      // Prevent click event from propagating to parent
      e.stopPropagation();
   });
  
       
       $('.bs-example-modal-lg').on('hidden.bs.modal', function () {
          
        mytable_.ajax.reload();
   
  
        })
       
       $("#get_unit").click(function(){
       
        $.ajax({
              type: "post",
            url:'<?php echo base_url() ?>index.php/Master_proccess/load_data_unit/'+$('#idcom').val(),
            dataType: "html",
            cache: true,
            success: function(hsl) {
              $("#tampilbody").html(hsl);
              $(".bs-example-modal-lg").modal("show");
            }
          })
      })
 })
    



          
      </script>
    
    
    
    

