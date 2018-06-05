
function cekvendor(e){
    if($(e).prop('checked')){
        if($("#ptp_justification").val() == "2"){
            vnd = $(".cekvendor:checked").length;
            vnd_tmbhn = $(".cekvendor_tambahan:checked").length;
            dicentang = Number(vnd)+Number(vnd_tmbhn);
            if(dicentang > 1 ){
                alert("Metode penunjukan langsung hanya boleh satu vendor");
                $(e).prop("checked", false);
            } 
        }
        $(e).parent().parent().addClass('success');
    } else {
        $(e).parent().parent().removeClass('success');
    }
}

base_url = $("#base-url").val();
var mytable;
var total_price = 0;
function loadTable() {
    // alert("aaaa");
    mytable = $('#pr-list-table-perencanaan').DataTable({
        "ajax" : {'url':base_url + 'Procurement_pratender/get_datatable','type': 'POST',
            'data': function(d){d.jenis_perencanaan=$('#jenis_perencanaan').val()},
        } ,
       //"ajax" : $("#base-url").val() + 'Procurement_pratender/get_datatable',
        "ordering": false,
        "dom": 'rtip',
        "lengthMenu": [ 10, 25, 50 ],
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {
                mRender : function(data,type,full){
                var ans = "";
                open = (full.PPI_QUANTOPEN - full.PPI_QTY_USED);
                if (open > 0) {
                    ans += '<input type="checkbox" class="check" onclick="pilih(this)" value="'+full.PPI_PRNO+':'+full.PPI_PRITEM+'">'
                }

                ans += '<div class="hidden">';
                ans += '<div class="prno">' + full.PPI_PRNO + '</div>';
                ans += '<div class="pritem">' + full.PPI_PRITEM + '</div>';
                ans += '<div class="decmat">' + full.PPI_DECMAT + '</div>';
                ans += '<div class="quantopen">' + open + '</div>';
                ans += '<div class="prqty">' + full.PPI_PRQUANTITY + '</div>';
                ans += '<div class="poqty">' + (full.PPI_PRQUANTITY - full.PPI_QUANTOPEN) + '</div>';
                ans += '<div class="used">' + full.PPI_QTY_USED + '</div>';
                ans += '<div class="quantopen">' + full.PPI_QUANTOPEN + '</div>';
                ans += '<div class="uom">' + full.PPI_UOM + '</div>';
                ans += '<div class="netprice">' + Number(full.PPI_NETPRICE) * 100 + '</div>';
                ans += '<div class="pgrp">' + full.PPR_PGRP + '</div>';
                ans += '<div class="per">' + full.PPI_PER + '</div>';
                ans += '<div class="curr">' + full.PPI_CURR + '</div>';
                    var t=parseInt(full.COUNT_TENDER)+1;
                ans += '<div class="c_tender">' + t + '</div>';
                ans += '</div>';
                return ans;
            }},
            {
                mRender : function(data,type,full){
                var ans = "";
                if (full.PPR_DOC_CAT == '9')
                    ans += '<a href="#modal_dokumen" onclick="open_dokumen(this)" data-ppi="'+full.PPI_ID+'">' + full.PPI_PRNO + '</a>';
                else
                    ans += full.PPI_PRNO
                return ans;
            }},
            {"data" : "PPI_PRITEM"},
            {"data" : "PPI_NOMAT"},

            { mRender :function(data,type,full){
                var ans ="";
                if (full.PPR_DOC_CAT != '9')
                    ans += '<a href="#modal_dokumen_dua" onclick="open_dokumendua(this)" data-ppi="'+full.PPI_ID+'" data-nomat="'+full.PPI_NOMAT+'">' + full.PPI_DECMAT + '</a>';
                else
                    ans += full.PPI_DECMAT
                return ans;
            }},
            // {"data" : "PPI_DECMAT"},

            {"data" : "PPI_MATGROUP"},
            // {"data" : "PPI_PRQUANTITY"},
            {   "sClass": "text-right",
                mRender : function(data,type,full){
                var ans = addCommas(full.PPI_PRQUANTITY);
                if (ans < 0) ans = 0;
                return ans;
            }},
            {   "sClass": "text-right",
                mRender : function(data,type,full){
                var ans = addCommas(full.PPI_QTY_USED);
                if (ans < 0) ans = 0;
                return ans;
            }},
            // {"data" : "PPI_QTY_USED"},
            {   "sClass": "text-right",
                mRender : function(data,type,full){
                var ans = addCommas(full.PPI_PRQUANTITY - full.PPI_QUANTOPEN);
                if (ans < 0) ans = 0;
                return ans;
            }},
            {   "sClass": "text-right",
                mRender : function(data,type,full){
                var ans = addCommas(full.PPI_QUANTOPEN - full.PPI_QTY_USED);
                if (ans < 0) ans = 0;
                return ans;
            }},
            {"data" : "PPR_DOCTYPE"},
            {"data" : "PPR_PLANT"},
            // {"data" : "PPI_REALDATE"},
            {"data" : "PPR_PGRP"},
            {"data" : "PPI_MRPC"},
            {"data" : "COUNT_TENDER"},
            {"data" : "METODE"},
        ],
    });

    mytable.columns().every( function () {
        var that = this;
    
        $( '.input', this.header() ).on( 'keyup change', function () {
            $('.check,#checkAll').prop('checked', false);
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
}

Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function calculateTotal() {
    var TotalHPS = 0;
    var $trs = $(".itemtr");
    // console.log($trs)
    for (var i = 0; i < $trs.length; i++) {
        prc = $(".itemprc" + i).attr('val');
        qty = $(".itemqty" + i).val();
        var subtotal = prc*qty;
        TotalHPS += subtotal;
        $(".itemtot" + i).html(numeral(subtotal).format('$0,0.00'));
    };

    $("#total_hps").html(numeral(TotalHPS).format('$0,0.00'));
    var ppn = 0;
    Ppn = 0.1*TotalHPS;
    $("#ppn").html(numeral(Ppn).format('$0,0.00'));
    $("#total_hps_final").html(numeral(TotalHPS+Ppn).format('$0,0.00'));
}

function justify() {
    val = $("#ptp_justification").val();
    if (val == 2)
        $("#detail_justification").show('slow/400/fast');
    else {
        $("#detail_justification").hide();
    }
}

function qty(e) {
    elem = $(e);
    val = Number(elem.val());
    max = Number(elem.attr('max'));
    if (val <= 0) {
        elem.val(1);
        alert('Jumlah harus diisi.')
    } else if (val > max) {
        elem.val(max);
    } else {
        elem.val(val);
    }
    updateTotal();
}

function updateTotal() {
    total_price = 0;
    $("#tableItem-perencanaan").children('tr').each(function(){
        total = Number($(this).find('.harga_terpilih').val()) * $(this).find('.qty_terpilih').val();
        total_price += total;
        $(this).find('.subtotal_terpilih').html(total.formatMoney(2, '.', ','));
    });
    var price = document.getElementById("total-price-perencanaan");
    price.innerHTML = total_price.formatMoney(2, '.', ',');
}

function pilih(e) {
    elem = $(e);
    parent = elem.parent().parent();
    if (elem.prop('checked')) {
        usedqty = parent.find('.used').html()
        if (usedqty == 'null') {
            usedqty = 0;
        }

        avblqty = parent.find('.quantopen').html();
        if (avblqty < 0) avblqty = 0;
        ans = "";
        ans += '<tr class="tritem" id="' + parent.find('.prno').html() + "-" + parent.find('.pritem').html() +'">';
        ans += '<td class"text-center">' + parent.find('.prno').html();
        ans += '<td class"text-center" style="text-align:center"><a href="#modal_view_pr" onclick="dokumenPR(this)" data-ppi="'+parent.find('.prno').html()+parent.find('.pritem').html()+'" >' + parent.find('.pritem').html() + '</a></td>';
        ans += '<td>' + parent.find('.decmat').html();
        ans += '<td class="text-center">' + parent.find('.c_tender').html();
        ans += '<td class="text-center "><input type="text" name="qty[]" class="col-xs-12 input-sm form-control qty_terpilih" value="'+ avblqty + '" max="'+ avblqty + '" onchange="qty(this)">';
        ans += '<td class="text-center">' + parent.find('.uom').html();
        ans += '<td class="text-right">' + (Number(parent.find('.netprice').html())).formatMoney(2, '.', ',');
        ans += '<td>' + parent.find('.per').html();
        ans += '<td>' + parent.find('.curr').html();
        ans += '<input type="hidden" class="harga_terpilih" value="'+ Number(parent.find('.netprice').html()) + '">';
        ans += '<input type="hidden" class="itemterpilih" name="item[]" value="'+parent.find('.prno').html() + parent.find('.pritem').html()+ ":" + parent.find('.netprice').html()+'">'
        ans += '<td class="text-right subtotal_terpilih">' + (Number(parent.find('.netprice').html() * avblqty)).formatMoney(2, '.', ',');
        //console.log(Number(parent.find('.netprice').html()));
        $("#tableItem-perencanaan").append(ans);

        updateTotal();  
                                    
    }
    else {
        $("#" + parent.find('.prno').html() + "-" + parent.find('.pritem').html()).remove();
        updateTotal();
    }
}

function dokumenPR(e){
    ppi_id = $(e).data('ppi');

    $.ajax({
        url : $("#base-url").val() + 'Procurement_pratender/search_dokumenPR/',
        dataType : 'html',
        method : 'post',
        data : {ppi_id},
        success : function(data){
            $('#dokumen_pr').html(data);
            $("#modal_view_pr").modal("show");
        },
        fail : function(data){
            console.log("error");
            console.log(data);
        }
    });
}

function open_dokumen(e) {
    pr = $(e).html();
    ppi = $(e).data('ppi');
    $("#modal_dokumen").find('.pr').html(pr);
    $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/pr_doc_service/' + ppi,
        type: 'post',
        dataType: 'html'
    })
    .done(function(data) {
        $("#modal_dokumen").find(".modal-body").html(data);
        // table = $("#dokumentable");
        // table.html("");
        // docs = data.docs;
        // for (var i = 0; i < data.docs.length; i++) {
        //     doc = data.docs[i];
        //     table.append('<tr>' +
        //         '<td><input type="radio" value="'+ doc.PPD_ID+'" id="r'+ doc.PPD_ID+'" name="' + doc.PDC_NAME + '"'+(doc.PPD_STATUS == 1 ? "checked" : "")+'></td>' +
        //         '<td>'+ doc.PDC_NAME+'</td>' +
        //         '<td>'+ doc.PPD_DESCRIPTION+'</td>' +
        //         '<td><a href="'+ $("#base-url").val() + $("#UPLOAD_PATH").val() + 'ppm_document/' + doc.PPD_FILE_NAME+'" download>Download</a></td>' +
        //         '<td>'+ doc.PPD_CREATED_AT+'</td>' +
        //         '<td>'+ doc.PPD_CREATED_BY+'</td>' +
        //         '</tr>'
        //     )
        // };
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
    $("#modal_dokumen").modal("show")
}

function open_dokumendua(e) {
    ppi_id = $(e).data('ppi');
    nomat = $(e).data('nomat');
   // docat = $(e).data('docat');
   
    $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/pop_up_barang/'+ppi_id,
        type: 'post',
        dataType: 'html'
    })
    .done(function(data) {

        $("#idku").html(data);
        $("#modal_dokumen_dua").modal("show");

        $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi_id + '/' + nomat,
        type: 'post',
        dataType: 'html'
        })
        .done(function(data) {
            $(".long_text_snippet_item").html(data);
            // $("#modal_dokumen_dua").modal("show");
            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
            console.log(data);
        });

    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });



      // if (docat == '9') {
      //   /* get service line */
      //   $.ajax({
      //     url: $("#base-url").val() + 'Snippet_ajax/pr_doc_service/' + ppi_id,
      //     type: 'get',
      //     dataType: 'html',
          
      //   })
      //   .done(function(data) {
      //     $(".service_line_snippet_item").html(data);
      //   })
      //   .fail(function() {
      //     console.log("error");
      //   })
      //   .always(function(data) {
      //     console.log(data);
      //   });
        
      // }
    // $("#modal_dokumen_dua").modal("show")
   
}

function doc_status(id, stat) {
    $.ajax({
        url: $('#base-url').val() + 'Procurement_sap/tor_status',
        type: 'post',
        dataType: 'json',
        data: {id: id, status: stat},
    })
    .done(function() {
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
}

$(document).ready(function(){

    $("#ptp_justification").change(function(e){
        $(".penunjukanlangsung").val("false");
        $(".cekvendor").prop("checked", false);
        $(".cekvendor_tambahan").prop("checked", false);
        $("#table_vendor_terpilih tbody").empty();
        $("#table_vendor_terpilih_nonDirven tbody").empty();
    });
    $('#RO').change(function(event){
        if($('#RO').is(':checked')){ 
            $('.panelvendor_barang').attr('hidden','hidden');
            $('.panelvendor_jasa').hide();
            $('#panelpo').removeAttr('hidden');
            $(".cekvendor").prop("checked", false);
        } else {
            console.log("unchecked");
            if($('#jenis_perencanaan').val() == 1){ //jasa
                $('.panelvendor_jasa').show();
            }
            $('.panelvendor_barang').attr('hidden');
            $('#panelpo').removeAttr('hidden');
        }
    });
    $('#ptp_justification').change(function(event){
        if($(this).val() == 3 || $(this).val() == 4){
            sweetAlert(
              'Metode ini belum ada',
              '',
              'error'
            );
            $("#ptp_justification").val(1);
        }
        if($(this).val() != "2"){ 
            $('#panelpo').attr('hidden','hidden');
            $('.panelvendor_barang').removeAttr('hidden');
        } else {
            if($('#RO').is(':checked')){ 
                $('.panelvendor_barang').attr('hidden','hidden');
                $('#panelpo').removeAttr('hidden');
            }
        }
        if (tables != null) {
            tables.clear();
            tables.draw();
            $("#table_vendor_barang_tambahan tbody").remove();
        }
        if (table_generate_po != null) {
            table_generate_po.clear();
            table_generate_po.draw();
        }
    });
    $(".sub_detail_justification").change(function(){
        if (tables != null) {
            tables.clear();
            tables.draw();
            $("#table_vendor_barang_tambahan tbody").remove();
            $("#table_vendor_terpilih tbody").empty();
        }
        if (table_generate_po != null) {
            table_generate_po.clear();
            table_generate_po.draw();
        }
    })
    $('.vnd').change(function(event){
        if($(this).is(':checked')){ 
            $('#panelpo').attr('hidden','hidden');
            $('.panelvendor_barang').removeAttr('hidden');
            if($('#jenis_perencanaan').val() == 1){ //jasa
                $('.panelvendor_jasa').show();
            }
        }
    });

    $( "form" ).submit(function( event ) {
        if($("#subject").val() == ''){
            sweetAlert(
                'Perencanaan Kosong',
                'Lengkapi Nama Perencaan',
                'warning'
            )
            event.preventDefault();
            return false;
        }

        // if($('#RO').is(':checked')){ 
        //     if($(".tritem").length >= 2){
        //         alert("Untuk Repeat Order (RO), Item yang dipilih tidak boleh lebih dari 2");
        //         event.preventDefault();
        //     }
        // }
        vnd = $(".cekvendor:checked").length;
        vndTmbhn = $(".cekvendor_tambahan:checked").length;
        cekCentang = Number(vnd)+Number(vndTmbhn);
        if (cekCentang <= 0) {
            sweetAlert(
              'Vendor Belum Dipilih',
              'Pilih Vendor',
              'warning'
            )
            event.preventDefault();
            return false;
        }

        var form = this;
            event.preventDefault();
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Pastikan Semua Data Yang Anda Masukkan Sudah Benar!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#92c135',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    cancelButtonText: "Tidak",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                         form.submit();
                    } else {
                    }
                }) 
    });

    numeral.language('id');
    var no = 1;
    var totalItem = 0;
    justify();
    loadTable();

    /* populate items */
    for (var i = 0; i < $(".itemtr").length; i++) {
        prc = $(".itemprc" + i).attr('val');
        $(".itemprc" + i).html(numeral(prc).format('$0,0.00'));
    };

    $("#ptp_justification").change(function(event) {
        justify();
    });

    // $(".btw").change(function(event) {
    //     val = Number($(this).val());
    //     if (val > Number($(this).attr("max"))) {
    //         $(this).val($(this).attr("max"))
    //     }
    //     if (val < 0) {
    //         $(this).val(0)
    //     }
    // });

    $(".itemtr input").change(function(event) {
        calculateTotal();
    });

    calculateTotal();

    $("#savedoc").click(function() {
        for (var i = 0; i < docs.length; i++) {
            // docs[i];
            ppd_id = docs[i].PPD_ID;
            bolo = $('#r' + ppd_id).is(':checked')
            doc_status(ppd_id, bolo ? 1 : 0);
        };

        $("#modal_dokumen").modal("hide")
    });

    $(".close-modal").click(function() {
        $(".modal").modal("hide")
    });

    $("form").submit(function(e) {
        tanggal = $("#ptp_prebid_date").val();
        lokasi = $("#ptp_prebid_location").val();
        if ((tanggal != '' )&& (lokasi == '')) {
            console.log('gagal aanwijzing');
            alert('Lokasi aanwijzing wajib diisi jika tanggal aanwijzing diisi.')
            e.preventDefault();
        }
    });

    $('.panelvendor_jasa').hide();
    $('#jenis_perencanaan').change(function(){
        if($('#jenis_perencanaan').val() == 1){  //jasa
            $('.panelvendor_jasa').show();
            $('.panelvendor_barang.pnl_satu').hide();
            $('.panelvendor_barang.pnl_dua').show();
            $(".cekvendor").prop("checked", false);

        }else{ //barang
            $('.panelvendor_jasa').hide();
            $('.panelvendor_barang').show();
            $(".cekvendor").prop("checked", false);
        }
        $('#tableItem-perencanaan').empty();
        updateTotal();
        mytable.ajax.reload();
        //console.log($('#jenis_perencanaan').val());                    
    });
    var tables = null;
    $('.generate_vendor').click(function(){
        just = '';
        just = Number($("#ptp_justification").val());
        if (just == 2) {
            $(".sub_detail_justification").each(function() {
                if ($(this).prop("checked")) {
                    just += Number($(this).val());
                }
            });
        }
        $('.generate_vendor').addClass('disabled');
        $table = $("#pr-list-table-vendor tbody");
        $table.html('<td colspan="8">Sedang memproses..</td>');
        
        i = 0;
        tits = new Array()
        $(".itemterpilih").each(function() {
            tits[i++] = $(this).val();
        });
        $.ajax({
            url: $("#base-url").val() + 'Procurement_pratender/get_vendor',
            type: 'POST',
            dataType: 'json',
            data: {tits: tits, just: just},
        })
        .done(function(data) {
            vendor = data.vendor;
            j = 1;
            $table = $("#pr-list-table-vendor tbody");
            $table.html('');

            if (tables != null) {
                tables.clear();
            }

            if(tables == null ) {
            
                tables = $('#pr-list-table-vendor').DataTable({
                    "bSort": false,
                    "paging": false,
                    "scrollCollapse": true,
                    "scrollY": "500px",
                    "dom": 'rtip'
                });

                tables.columns().every( function () {
                    var that = this;
                    $( 'input', this.header() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                            that.search( this.value ).draw();
                        }
                    });
                });
            }

            for (var i = 0; i < vendor.length; i++) {
                v = vendor[i];
                if (v.header != null) {
                    td = ''
                    td += '<td class="text-center">'+
                            '<input type="checkbox" class="hidden" checked name="vendor_driSAP[]" value="' + v.LIFNR + '"> '+
                            '<input type="checkbox" class="cekvendor vendors" name="vendor[]" onchange="terpilih(this)" value="' + v.LIFNR + '"> '+(j++)+'</td>';
                    td += '<td class="text-center">' + v.LIFNR + '</td>';
                    td += '<td class="namavendor">' + v.header.VENDOR_NAME + '</td>';
                    td += '<td class="text-center">' + v.MATKL + '</td>';
                    td += '<td class="text-center">' + v.SUB_MATKL + '</td>';
                    td += '<td class="text-center">' + v.JP + '</td>';
                    td += '<td class="text-center">' + v.header.PERFORMA + '</td>';
                    td += '<td class="text-center">' + v.header.CATEGORY + '</td>';
                    td += '<td class="text-center">' + v.PO_TOTAL + '</td>';
                    td += '<td class="text-center">' + v.PO_OUTST + '</td>';
                    $tr = $('<tr class="listvendor">').html(td)
                    tables.row.add($tr);
                } else {
                    console.log("Vendor ini ga ada di database:")
                    console.log(v);
                }
            }

            tables.draw();

        })
        .fail(function() {
            console.log("error");
            $table = $("#pr-list-table-vendor tbody");
            $table.html('<td colspan="8">Gagal mengambil data dari SAP.</td>');
        })
        .always(function(data) {
            console.log(data);
            $('.generate_vendor').removeClass('disabled');
        });
    })

    var table_generate_po = null;
    $(".generate_po").click(function() {
        if($(".tritem").length == 0){
            alert("Pilih item terlebih dahulu.");
            return;
        }
        just = '';
        just = Number($("#ptp_justification").val());
        if (just == 2) {
            $(".sub_detail_justification").each(function() {
                if ($(this).prop("checked")) {
                    just += Number($(this).val());
                }
            });
        }
        $('.generate_po').addClass('disabled');
        $table = $("#pr-list-table-po tbody");
        $table.html('<td colspan="8">Sedang memproses..</td>');

        i = 0;
        tits = new Array()
        $(".itemterpilih").each(function() {
            tits[i++] = $(this).val();
        });

        $.ajax({
            url: $("#base-url").val() + 'Procurement_pratender/get_po',
            type: 'POST',
            dataType: 'html',
            data: {tits: tits, just: just},
            success : function(results){
                $('#pr-list-table-po').html(results); 
                $('.generate_po').removeClass('disabled');
            },
            fail : function(results){
                console.log(results);
            }
        });
        
        // .done(function(data) {            
        //     po = data.IT_DATA
        //     $table.html('');
        //     j = 1;

        //     if (table_generate_po != null) {
        //         table_generate_po.clear();
        //     }

        //     if(table_generate_po == null) {
        //         table_generate_po = $('#pr-list-table-po').DataTable({
        //             "bSort": false,
        //             "paging": false,
        //             "scrollCollapse": true,
        //             "scrollY": "500px",
        //             "dom": 'rtip'
        //         });

        //         table_generate_po.columns().every( function () {
        //             var that = this;
        //             $( 'input', this.header() ).on( 'keyup change', function () {
        //                 if ( that.search() !== this.value ) {
        //                     that.search( this.value ).draw();
        //                 }
        //             });
        //         });
        //     }

        //     $.each( po, function( key, value ) {
        //         v = value;
        //         if (v.LIFNR == '') {
        //             // ga ada kode vendor
        //         } else {
        //             td = ''
        //             td += '<td class="text-center"><input type="checkbox" class="cekpo vendors" name="vendor[]" onchange="cekvendor(this)" value="' + v.LIFNR + '"> '+(j++)+'</td>';
        //             td += '<td>' + v.LIFNR + '</td>';
        //             td += '<td class="namavendor">' + v.NAME1 + '</td>';
        //             td += '<td>' + v.EBELN + '</td>';
        //             td += '<td>' + '' + '</td>';
        //             td += '<td>' + v.count + '</td>';
        //             // $table.append('<tr class="listpo">' + td + '</tr>');
        //             $tr = $('<tr class="listpo">').html(td)
        //             table_generate_po.row.add($tr);
        //         }
        //     });

        //     table_generate_po.draw();
        // })
        // .fail(function() {
        //     $table.html('<td colspan="8">Gagal mendapatkan data.</td>');
        //     console.log("error");
        // })
        // .always(function(data) {
        //     console.log(data);
        //     $('.generate_po').removeClass('disabled');
        // });
        
    });

    $('#generate_vnd_brg_tmbhn').click(function(){
        $table = $("#table_vendor_barang_tambahan tbody");
        $table.html('<td colspan="8">Sedang memproses..</td>');

        vendor = new Array();
        $.each($("input[name='vendor_driSAP[]']:checked"), function() {
            vendor.push($(this).val());
        });
        
        $(function() {
          $("#grdBarang").height(460);
        });
        
        var tableGridBarang = $('#table_vendor_barang_tambahan').DataTable( {            
            "bDestroy": true,
            "ordering": false,
            "dom": 'rtip',
            "lengthMenu": [5],
            // "scrollY": "500px",
            "scrollCollapse": true,
            // "paging": false,

            "ajax": {
                url : $("#base-url").val() + "Procurement_pengadaan/get_vendor_barang",
                method : 'post',
                data : {vendor},
            },
            "columnDefs": [{
                // "searchable": false,
                // "orderable": false,
                "targets": 1
            }],
            "columns":[
                {
                    "data":   null,
                },
                {
                    mRender: function (data,type,full) {
                        return '<input type="checkbox" onchange="terpilih_vnd_tambahan(this)" class="cekvendor_tambahan" name="vendor_tambahan[]" value="' + full.VENDOR_NO + '">';
                    },
                    className: "dt-body-center"
                },
                {"data" : "VENDOR_NO"},
                {
                    mRender: function (data,type,full) {
                        return full.VENDOR_NAME;
                    },
                    className: "namavendor_tambahan"
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
            ],
        } );
        
        tableGridBarang.on('draw', function () {
            tableGridBarang.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        tableGridBarang.columns().every( function () {
            var that = this;
        
            $( 'input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            });
        });

    });

    $(".select2").select2();

    $('#group_jasa_id').change(function(){
        id = $('#group_jasa_id').val();
        $.ajax({
            url:"pilih_child",
            method : 'post',
            data : "id="+id,
            success: function(data){
                $("#subGroup_jasa_id").select2("val", "");
                $("#klasifikasi_jasa_id").select2("val", "");
                $("#subGroup_jasa_id").html(data);
                $("#klasifikasi_jasa_id").html(''); 
                $('.new_data').remove();
                $('#table_vendor_jasa tbody').remove();
            }
        });
        return false;
    });

    $('#subGroup_jasa_id').change(function(){
        id = $('#subGroup_jasa_id').val();
        $.ajax({
            url:"pilih_child",
            method : 'post',
            data : "id="+id,
            success: function(data){
                $("#klasifikasi_jasa_id").select2("val", "");
                $("#klasifikasi_jasa_id").html(data);
                $('.new_data').remove();
                $('#table_vendor_jasa tbody').remove();
            }
        });
        return false;
    });

    $('#klasifikasi_jasa_id').change(function(){
        id = $('#klasifikasi_jasa_id').val();
        $('.new_data').remove();
        $.ajax({
            url : 'pilih_sub_klasifikasi',
            method : 'post',
            data : "id="+id,
            success : function(result)
            {
                var val = $.parseJSON(result);
                var options1 = '';
                var options2 = '';
                if(val != null){
                    for (var i = 0; i < val.length; i++) {
                        description = '';
                        if(val[i].DESCRIPTION != null){
                            description = ' - ' + val[i].DESCRIPTION;
                        }
                        if(i % 2 == 0){
                            options1 += '<div class="new_data"><input class="check_jasa" type="checkbox" onchange="cekvendor_jasa(this)" name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"> ' + val[i].NAMA + description +'</div>';
                        }
                        else{
                            options2 += '<div class="new_data"><input class="check_jasa" type="checkbox" onchange="cekvendor_jasa(this)" name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"> ' + val[i].NAMA + description +'</div>';
                        }
                    }
                    $('#subKlasifikasi_ganjil').append(options1);
                    $('#subKlasifikasi_genap').append(options2);
                    $('#table_vendor_jasa tbody').remove();
                
                }else{
                    $('#subKlasifikasi').append('<div class="new_data"> Data Kosong. </div>');
                }
            }
        })
    });   

    $('#search').click(function(){
        $("#table_vendor_terpilih tbody").empty();
        $table = $("#table_vendor_jasa tbody");
        $table.html('<td colspan="8">Sedang memproses..</td>');
        
        group_jasa_id = $('#group_jasa_id').val();
        subGroup_jasa_id = $('#subGroup_jasa_id').val();
        klasifikasi_jasa_id = $('#klasifikasi_jasa_id').val();
        subKlasifikasi_jasa_id = new Array();
        $.each($("input[name='subKlasifikasi_jasa_id[]']:checked"), function() {
            subKlasifikasi_jasa_id.push($(this).val());
        });

        if(group_jasa_id == ''){
            alert('Pilih dahulu yang akan di filter !!');
            return false;
        }
            
        var tableGrid = $('#table_vendor_jasa').DataTable( {
            "bDestroy": true,
            "ordering": false,
            "dom": 'rtip',
            "scrollY": "500px",
            "scrollCollapse": true,
            "paging": false,
            "ajax": {
                url : $("#base-url").val() + "Procurement_pratender/get_vendor_jasa",
                method : 'post',
                data : {group_jasa_id, subGroup_jasa_id, klasifikasi_jasa_id, subKlasifikasi_jasa_id},
            },
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "columns":[
                {
                    "data":   null,
                },
                {
                    mRender: function (data,type,full) {
                        return '<input type="checkbox" class="cekvendor vendors" onchange="terpilih(this)" name="vendor[]" value="' + full.VENDOR_NO + '">'+
                        '<input type="hidden" name="ptp_filter_vnd_product" value="'+ full.PTP_FILTER_VND_PRODUCT +'">'+
                        '<input type="hidden" name="ptp_filter_name" value="'+ full.PTP_FILTER_NAME +'">';
                    },
                    className: "dt-body-center"
                },
                {"data" : "VENDOR_NO"},
                {
                    "data":   "VENDOR_NAME",
                    className: "namavendor"
                },
                {"data" : "PRODUCT_NAME"},
                {"data" : "KLASIFIKASI_NAME"},
                {"data" : "SUBKUALIFIKASI_NAME"},
                {
                    "data":   "PERFORMA",
                    className: "text-center"
                },
                {
                    "data":   "CATEGORY",
                    className: "text-center"
                },
            ],
        } );
        
        tableGrid.on('draw', function () {
            tableGrid.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        tableGrid.columns().every( function () {
            var that = this;
        
            $( 'input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            });
        });

    });

    $('#checkAll').click(function(){
        chk = $(this).is(':checked');
        if(chk){
            $('.check').prop('checked', true);
        }else{
            $('.check').prop('checked', false);
        }
    });

});

function cekvendor_jasa(e){
    if($(e).prop('checked')){
        $('#table_vendor_jasa tbody').remove();
    } 
}

function terpilih(e){
    vendorno = $(e).val();
    if($(e).is(":checked")){
        vendorExpired(vendorno,'terpilih');

        if($("#ptp_justification").val() == 2){
            vnd = $(".cekvendor:checked").length;
            vnd_tmbhn = $(".cekvendor_tambahan:checked").length;
            dicentang = Number(vnd)+Number(vnd_tmbhn);
            if(dicentang > 1 ){
                alert("Metode penunjukan langsung hanya boleh satu vendor");
                $(e).prop("checked", false);
                return false;
            } 
        }

        // $(e).parent().parent().css("background-color","#dff0d8");
        $(e).parent().parent().addClass("success");
        ada = false;
        $(".vnd_terpilih").each(function() {
            if ($(this).val() == vendorno) {
                ada = true;
            }
        });

        if (!ada) {
            tr = '<tr>' +
                    '<td class="text-center"><input type="checkbox" class="vnd_terpilih" onclick="nocentang(this)" value="' + vendorno + '" checked></td>' +
                    '<td>' + vendorno + '</td>' +
                    '<td>' + $(e).parent().parent().find('.namavendor').html() + '</td>' +
                  '</tr>';
            $(".vendor_terpilih").append(tr);
        }

    } else {
        // $(e).parent().parent().css("background-color","");
        masih_ada = false;
        $(".cekvendor:checked").each(function() {
            if ($(this).val() == vendorno) {
                masih_ada = true;
            }
        });
        if (masih_ada) {

        } else {
            $(".vnd_terpilih").each(function() {
                if ($(this).val() == vendorno) {
                    $(this).parent().parent().remove();
                }
            });
        }
        $(e).parent().parent().removeClass("success");
    }

}

function nocentang(e){
    if($(e).is(":checked")){

    } else {
        vendorno = $(e).val();
        $(".cekvendor:checked").each(function() {
            if ($(this).val() == vendorno) {
                $(this).prop('checked', false);
                terpilih(this);
            }
        });
        $(e).parent().parent().remove();
    }
}

function terpilih_vnd_tambahan(e){
    vendorno = $(e).val();
    if($(e).is(":checked")){ 
        vendorExpired(vendorno,'tambahan');

        if($("#ptp_justification").val() == 2 ){
            vnd = $(".cekvendor:checked").length;
            vnd_tmbhn = $(".cekvendor_tambahan:checked").length;
            dicentang = Number(vnd)+Number(vnd_tmbhn);
            if(dicentang > 1 ){
                alert("Metode penunjukan langsung hanya boleh satu vendor");
                $(e).prop("checked", false);
                return false;
            } 

        }      
        $(e).parent().parent().addClass("success");
        ada = false;
        $(".vnd_terpilih_tambahan").each(function() {
            if ($(this).val() == vendorno) {
                ada = true;
            }
        });

        if (!ada) {
            tr = '<tr>' +
                    '<td class="text-center"><input type="checkbox" name="coba_vnd_terpilih_tambahan[]" class="vnd_terpilih_tambahan" onclick="nocentang_tambahan(this)" value="' + vendorno + '" checked></td>' +
                    '<td>' + vendorno + '</td>' +
                    '<td>' + $(e).parent().parent().find('.namavendor_tambahan').html() + '</td>' +
                  '</tr>';
            $(".vendor_terpilih_tambahan").append(tr);
        }

    } else {
        masih_ada = false;
        $(".cekvendor_tambahan:checked").each(function() {
            if ($(this).val() == vendorno) {
                masih_ada = true;
            }
        });
        if (masih_ada) {

        } else {
            $(".vnd_terpilih_tambahan").each(function() {
                if ($(this).val() == vendorno) {
                    $(this).parent().parent().remove();
                }
            });
        }
        $(e).parent().parent().removeClass("success");
    }

}

function nocentang_tambahan(e){
    if($(e).is(":checked")){

    } else {
        vendorno = $(e).val();
        $(".cekvendor_tambahan:checked").each(function() {
            if ($(this).val() == vendorno) {
                $(this).prop('checked', false);
                terpilih_vnd_tambahan(this);
            }
        });
        $(e).parent().parent().remove();
    }
}

function batalCentang(vendorno, status){
    if(status == 'terpilih'){
        $(".cekvendor:checked").each(function() {
            if ($(this).val() == vendorno) {
                $(this).prop('checked', false);
                terpilih(this);
            }
        });
    }else{
        $(".cekvendor_tambahan:checked").each(function() {
            if ($(this).val() == vendorno) {
                $(this).prop('checked', false);
                terpilih_vnd_tambahan(this);
            }
        });
    }
}

function vendorExpired(no_vendor, status){
    $.ajax({
        url: $("#base-url").val() + 'Procurement_pratender/vendor_expired',
        type: 'POST',
        dataType: 'json',
        data: {no_vendor: no_vendor},
        success: function(data){
            if(data.stt == 'warning'){
                ketDomisili = 'hampir';ketSiup = 'hampir';ketTdp = 'hampir';
                if(data.domisili <= 0){
                    ketDomisili = 'sudah';
                }
                if(data.siup <= 0){
                    ketSiup = 'sudah';
                }
                if(data.tdp <= 0){
                    ketTdp = 'sudah';
                }
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Dokumen Vendor Domisili "+ketDomisili+" expired "+data.domisili+" hari, SIUP "+ketSiup+" expired "+data.siup+" hari, TDP "+ketTdp+" expired "+data.tdp+" hari",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#92c135',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    cancelButtonText: "Tidak",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {                   
                    } else {
                        batalCentang(no_vendor, status);
                    }
                }) 
            }
        }
    });
}