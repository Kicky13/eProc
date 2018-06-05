<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $baseLanguage [$title]; ?></h2>
      </div>
      <div class="row">
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <!--<div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title"><a id="data_col" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filter</a></h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">

                  <div class="panel-body">

                    <div class="row">
                      <div class="col-md-3">
                        <label>&nbsp;</label>
                        <div class="field">

                          <input type="text" value="" class="caridata form-control" id="nama_company_f" placeholder="Tahun" />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label>&nbsp;</label>
                        <div class="field">

                          <input type="text" value="" id="nama_unit_f" class="caridata form-control" placeholder="No. Invoice" />
                        </div>
                      </div>

                      <div class="col-md-3">
                        <label>&nbsp;</label>
                        <div class="field filterub0">

                          <input type="text" value="" id="nama_jabatan_f" class="caridata form-control" placeholder="Nama Posisi" />
                        </div>
                      </div>

                      <div class="col-md-3">
                        <label>&nbsp;</label>
                        <div class="field filterub0">

                          <input type="text" value="" id="fullname_f" class="caridata form-control" placeholder="Nama Pegawai" />
                        </div>
                      </div>


                    </div>

                  </div>
                </div>
              </div> -->

              <table id="table_mrpc" class="table table-hover">
                   <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th class="text-center"><?php echo $baseLanguage ['year']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['invoice_no']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['po_no']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['information']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['amount']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['currency']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['doc_date']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['status']; ?></th>
                      <th class="text-center"><?php echo $baseLanguage ['detail']; ?></th>
                    </tr>
                    <tr>
                      <th> </th>
                      <th><input type="text" class="col-xs-12"></th>
                      <th><input type="text" class="col-xs-12"></th>
                      <th><input type="text" class="col-xs-12"></th>
                      <th><input type="text" class="col-xs-12"></th>
                      <th><input type="text" class="col-xs-12"></th>  
                      <th><input type="text" class="col-xs-12"></th>
                      <th><input type="text" class="col-xs-12"></th>
                      <th><input type="text" class="col-xs-12"></th> 
                      <th> </th>
                    </tr>
                    </thead>
                <tbody id="tabelnya">  
                    <tr><td colspan="5">Tidak ada data.</td></tr>                             
                </tbody>
              </table>
            </div>
          </div>
        </div> 
      </div >
    </div >
  </div>
</section >

<div class="modal fade" id="modalholder">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center"><u><?php echo $baseLanguage ['detail_monitoring_invoice']; ?></u></h4>
        </div>
        <div class="modal-body">                
          <!-- <form class="form-horizontal" id="formUp" action="E_Catalog/upload/" method="post" enctype="multipart/form-data"> -->
            <?php echo form_open_multipart('E_Catalog/upload/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
                  <div class="form-group">
                    <label for="GJAHR" class="col-md-3 control-label"><?php echo $baseLanguage ['year']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="GJAHR" readonly>
                    </div>
                  </div> 
                  
                  <div class="form-group">
                    <label for="BELNR" class="col-sm-3 control-label"><?php echo $baseLanguage ['invoice_no']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="BELNR" readonly>
                    </div>
                  </div> 
                  
                  <div class="form-group">
                    <label for="EBELN" class="col-sm-3 control-label"><?php echo $baseLanguage ['purchasing_document']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="EBELN" readonly>
                    </div>
                  </div> 
                  
                  <div class="form-group">
                    <label for="BKTXT" class="col-sm-3 control-label"><?php echo $baseLanguage ['information']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="BKTXT" readonly>
                    </div>
                  </div> 
                   
                  <div class="form-group">
                    <label for="WAERS" class="col-sm-3 control-label"><?php echo $baseLanguage ['currency']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="WAERS" readonly>
                    </div>
                  </div> 
                  
                  <div class="form-group">
                    <label for="DMBTR" class="col-sm-3 control-label"><?php echo $baseLanguage ['amount']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="DMBTR" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="TGL_KIRUKP" class="col-sm-3 control-label"><?php echo $baseLanguage ['ukp_date']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="TGL_KIRUKP" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="TGL_VER" class="col-sm-3 control-label"><?php echo $baseLanguage ['verification_date']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="TGL_VER" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="TGL_BEND" class="col-sm-3 control-label"><?php echo $baseLanguage ['treasurer_date']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="TGL_BEND" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="STATUS_UKP" class="col-sm-3 control-label"><?php echo $baseLanguage ['status']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="STATUS_UKP" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="AUGDT" class="col-sm-3 control-label"><?php echo $baseLanguage ['pay_date']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="AUGDT" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="AUGBL" class="col-sm-3 control-label"><?php echo $baseLanguage ['pay_no']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="AUGBL" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="DATECOL" class="col-sm-3 control-label"><?php echo $baseLanguage ['coll_date']; ?></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="DATECOL" readonly>
                    </div>
                  </div>

                </form>
          <div class="text-right">
            <!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
    table_mrpc = null;
    function editrow(x) {
        $("#edit_modal").modal('show');
        
        e = $(x);
        tr = e.parent().parent();
        $("#modal_edit_id").val(tr.find(".id_adm").html());
        $("#modal_edit_mrpc").val(tr.find(".mrpc").html());
        $("#modal_edit_eselon").val(tr.find(".eselon").html());
        selectize_edit_plant.setValue(tr.find(".id_plant").html());
        selectize_edit_emp.setValue(tr.find(".id_emp").html());
    }
    $('#renewPR').on("click",function() {
    mytable.destroy();
    // $('#curtain').css({ display: "block" });
    if ($("#berdasarkan").val() == "mrp") {
        mrp = [];
        $(".cekmrp:checked").each(function() {
            mrp.push({mrp: $(this).data('mrp'),plant: $(this).data('plant')})
        });
        post = {
                filter: mrp, 
                by: $("#berdasarkan").val()
            };
    } else {
        post = {
                filter: $("#filter").val(), 
                by: $("#berdasarkan").val()
            };
    }
    console.log(post);
    $.post(base_url+"Monitoring_invoice/sap_inv", post)
    .done(function() {
        loadLastUpdate();
        loadTable();
        // $('#curtain').css({ display: "none" });
        $("#modal-renew").modal("hide");
    });
})
    function hapusrow(x) {        
        e = $(x);
        tr = e.parent().parent();
        idnya = tr.find(".id_adm").html();
        if (confirm('Apakah anda yakin akan menghapus data?')) {
            $.ajax({
                url: $("#base-url").val() + 'Administrative_mrpc/delete',
                type: 'post',
                dataType: 'json',
                data: {hapus_id: idnya},
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil mengubah data.');
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function(data) {
                // console.log(data);
                populate_table();
            });
            
        }
    }
    function refreshAll() {
        var tahun=document.getElementById('fil_tahun').value;
        $.ajax({
            url: $("#base-url").val() + 'Monitoring_invoice/get_th/',
            type: 'POST',
            data: 'tahun:tahun',
            dataType: 'json',
        })
        .done(function(data) {
            console.log(data);
            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
        });
    }
    
    function openmodal (BELNR,GJAHR) {
  // MATNR='341-107-0083';//341-107-0083  301-200410
    $.ajax({
        url: $("#base-url").val() + 'Monitoring_invoice/get_detail/' + BELNR,
         data : {
                  "checked" : GJAHR
                  },
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) { 
         //console.log(data.[0]);              
         dt = data.BELNR[0];
             if(dt!=null){
             //$("#formUp").attr("action", "E_Catalog/upload/" + dt.MATNR);         
             $("#GJAHR").val(dt.GJAHR);
             $("#BELNR").val(dt.BELNR);
             if(dt.EBELN != null){
                       $("#EBELN").val(dt.EBELN);
                    }else
                    $("#EBELN").val('-');
             //$("#EBELN").val(dt.EBELN);
             if(dt.BKTXT != null){
                       $("#BKTXT").val(dt.BKTXT);
                    }else
                    $("#BKTXT").val('-');
             //$("#BKTXT").val(dt.BKTXT);
             $("#WAERS").val(dt.WAERS);
             $("#DMBTR").val(dt.DMBTR.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1\."));
             $("#TGL_KIRUKP").val(dt.TGL_KIRUKP.substring(6)+"-"+dt.TGL_KIRUKP.substring(4,6)+"-"+dt.TGL_KIRUKP.substring(0,4));
             $("#TGL_VER").val(dt.TGL_VER.substring(6)+"-"+dt.TGL_VER.substring(4,6)+"-"+dt.TGL_VER.substring(0,4));
             $("#TGL_BEND").val(dt.TGL_BEND.substring(6)+"-"+dt.TGL_BEND.substring(4,6)+"-"+dt.TGL_BEND.substring(0,4));
             $("#STATUS_UKP").val(dt.STATUS_UKP);
             $("#AUGDT").val(dt.AUGDT.substring(6)+"-"+dt.AUGDT.substring(4,6)+"-"+dt.AUGDT.substring(0,4));
             if(dt.AUGBL != null){
                       $("#AUGBL").val(dt.AUGBL);
                    }else
                    $("#AUGBL").val('-');
             //$("#AUGBL").val(dt.AUGBL);
             $("#DATECOL").val(dt.DATECOL.substring(6)+"-"+dt.DATECOL.substring(4,6)+"-"+dt.DATECOL.substring(0,4));

         $("#modalholder").modal('show')    
         }         
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        // console.log(MATNR);
    });
}
    
    
    function loadTable() {
        $.ajax({
            url: $("#base-url").val() + 'Monitoring_invoice/get_data/',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            tabelnya = data.list_inv;
            console.log(tabelnya);
            if (tabelnya.length <= 0) {
                $("#tabelnya").html('<tr><td colspan="7">Tidak ada data.</td></tr>');
            } else {
                $("#tabelnya").html('');
                for (var i = 0; i < tabelnya.length; i++) {
                    v = tabelnya[i];
                    console.log(v);
                    td = '';
                    td += '<td class="text-center">' + (i+1-0) + '</td>';
                    td += '<td class="text-center">' + v.GJAHR + '</td>';
                    td += '<td class="text-center">' + v.BELNR + '</td>';
                    if(v.EBELN != null){
                       td += '<td class="text-center">' + v.EBELN + '</td>';
                    }else
                    td += '<td class="text-center">-</td>';
                    if(v.BKTXT != null){
                       td += '<td class="text-center">' + v.BKTXT + '</td>';
                    }else
                    td += '<td class="text-center">-</td>';
                    td += '<td class="text-center">' + v.WRBTR + '</td>';
                    td += '<td class="text-center">' + v.WAERS + '</td>';
                    td += '<td class="text-center">' + v.BUDAT + '</td>';
                    td += '<td class="text-center">' + v.STATUS_UKP + '</td>';
                    td += '<td><a href="javascript:void(0)" onclick="openmodal('+v.BELNR+','+v.GJAHR+')" >Detail</a></td> ';
                    //td += '<td class="text-center">' + v.WAERS + '</td>';
                    $tr = $('<tr>').html(td)
                    $("#tabelnya").append($tr);
                };
                if (table_mrpc == null) {
                    table_mrpc = $('#table_mrpc').DataTable({
                        "bSort": false,
                        //"searching": false,
                        "searchable": true,
                        "paging": true,
                        "scrollCollapse": true,
                        //"scrollY": "500px",
                        "dom": 'frtip',
                        //"deferRender": true,
                    });
                    table_mrpc.columns().every( function () {
                    var that = this;
    
        $( 'input:text', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
                }

            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
        });
    }
    $(document).ready(function() {
        loadTable();
        

        $("#save_edit").click(function() {
            if (!confirm('Apakah anda yakin mau mengubah data?')) {
                return;
            }
            $.ajax({
                url: $("#base-url").val() + 'Administrative_mrpc/edit',
                type: 'post',
                dataType: 'json',
                data: $("#form_edit").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil mengubah data.');
                }
            })
            .fail(function() {
                alert('Gagal mengubah data.');
            })
            .always(function(data) {
                populate_table();
                $(".modal").modal('hide');
            });
        });

        $("#save_new").click(function() {
            console.log($("#base-url").val());
            $.ajax({
                url: $("#base-url").val() + 'Monitoring_invoice/add',
                type: 'post',
                dataType: 'json',
                data: $("#form_new").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil menambah data.');
                }
            })
            .fail(function() {
                alert('Gagal menambah data.');
            })
            .always(function(data) {
                // console.log(data);
                populate_table();
                $(".modal").modal('hide');
            });
        });

        $("#button_tambah").click(function() {
            $("#new_modal").modal('show');
        });
    });
</script>
