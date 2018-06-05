function loadTable() {

    $('#table_unreported').DataTable().destroy();
    $('#table_unreported tbody').empty();
    mytable1 = $('#table_unreported').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode."bSort" : true,
        "dom" : 'rtpli',
        "pageLength" : 15,
        "lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
        "language" : {
            "loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax" : {
            "url" : $("#base-url").val() + 'EC_Approval/E_Nofa/getDataFakturApproved/U',
            "type" : "POST",
            "data" : [{"aaaa" : "100"}]
        },
        "columnDefs" : [{
            "searchable" : false,
            "orderable" : true,
            "targets" : 0
        }]
    });

    $('.a').on('input', function () {   // for text boxes
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable1.columns(i).search(v).draw();
    } );

    $('.U1').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable1.columns(i).search(v).draw();
    });

    $('.U1').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable1.columns(i).search(v).draw();
    });

    $('.U2').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable1.columns(i).search(v).draw();
    });

    $('.U2').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable1.columns(i).search(v).draw();
    });
}

function loadTable2() {

    $('#table_reported').DataTable().destroy();
    $('#table_reported tbody').empty();
    mytable2 = $('#table_reported').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode."bSort" : true,
        "dom" : 'rtpli',
        "pageLength" : 15,
        "lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
        "language" : {
            "loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax" : {
            "url" : $("#base-url").val() + 'EC_Approval/E_Nofa/getDataFakturApproved/R',
            "type" : "POST"
        },
        "columnDefs" : [{
            "searchable" : false,
            "orderable" : true,
            "targets" : 0
        }]
    });

    $('.b').on('input', function () {   // for text boxes
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable2.columns(i).search(v).draw();
    } );

    $('.R1').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable2.columns(i).search(v).draw();
    });

    $('.R1').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable2.columns(i).search(v).draw();
    });

    $('.R2').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable2.columns(i).search(v).draw();
    });

    $('.R2').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        mytable2.columns(i).search(v).draw();
    });
}

$(document).ready(function() {
    $(".tgl").daterangepicker({
        autoUpdateInput: false,
        locale: {
          cancelLabel: 'Clear',
          format : 'DD-MM-YYYY'
        }
    });
    loadTable();
    loadTable2();    
});


 $('#detailFaktur').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var _id = button.data('id_invoice');
    $.ajax({
        url : $("#base-url").val()+'EC_Approval/E_Nofa/getDetailItem/'+_id,
        type : 'POST',
        dataType : 'json'
    }).done(function(data) {
        if(!data['H']){
            $('#viewEnofa').modal('hide');
            $("#msg").html("Data Sudah Dihapus");
            $("#msg").removeClass('hide');
        }else{
            /*SET HEADER*/
            var reported = !empty(data['H']['F_REPORT_DATE']) ? data['H']['F_REPORT_DATE'] : '-';
            var teks = "<tr><th><strong>Field</strong></th><th><strong>Value</strong></th></tr>";

            var url_faktur = data['H']['URL_FAKTUR'] != null ? '<a href="'+data['H']['URL_FAKTUR']+
                              '" target=_blank>'+data['H']['URL_FAKTUR']+'</a>' : '-';
            var xml_faktur = data['H']['XML'] != '' ? "<textarea class='form-control' readonly>"+
                             data['H']['XML']+"</textarea>" : '-';
            var note = data['H']['NOTE'] != null ? data['H']['NOTE'] : '-';

            teks +="<tr><td><strong>No. Faktur</strong></td><td>"+data['H']['FAKTUR_PJK']+"</td></tr>";
            teks +="<tr><td><strong>No. Invoice</strong></td><td>"+data['H']['NO_INVOICE']+"</td></tr>";
            teks +="<tr><td><strong>No. Mir7</strong></td><td>"+data['H']['MIR']+"</td></tr>";
            teks +="<tr><td><strong>Vendor</strong></td><td>"+data['H']['VENDOR']+"</td></tr>";
            teks +="<tr><td><strong>No. PO</strong></td><td>"+data['H']['NO_PO']+"</td></tr>";
            teks +="<tr><td><strong>Inv. DPP</strong></td><td>"+data['H']['AMOUNT']+"</td></tr>";
            teks +="<tr><td><strong>Note Inv.</strong></td><td>"+note+"</td></tr>";
            teks +="<tr><td><strong>Currency</strong></td><td>"+data['H']['CURRENCY']+"</td></tr>";
            teks +="<tr><td><strong>Approved By</strong></td><td>"+data['H']['CREATE_BY']+
                   " - "+data['H']['CREATE_ON2']+"</td></tr>";
            teks +="<tr><td><strong>Reported By</strong></td><td>"+reported+"</td></tr>";
            teks +="<tr><td><strong>URL Faktur</strong></td><td>"+url_faktur+"</td></tr>";
            teks +="<tr><td><strong>XML Faktur</strong></td><td>"+xml_faktur+"</td></tr>";
            $("#header_data").html(teks);

            var item = data['I'];
            var teks = '<tr><th><strong>No.</strong></th>'+
                       '<th><strong>GR DOC</strong></th>'+
                       '<th><strong>GR Date</strong></th>'+
                       '<th><strong>Posting Date</strong></th>'+
                       '<th><strong>Description</strong></th>'+
                       '<th><strong>Amount</strong></th>'+
                       '<th><strong>No. PO</strong></th>'+
                       '<th><strong>Item Qty</strong></th></tr>'
                    ;
            /*SET ITEM*/
            var i = 0;
            for(i=0;i<item.length;i++){
                teks += '<tr><td>'+(i+1)+'</td>'+
                        '<td>'+item[i]['GR_DOC']+'</td>'+
                        '<td>'+item[i]['GR_DATE']+'</td>'+
                        '<td>'+item[i]['GR_CREATE_ON']+'</td>'+
                        '<td>'+item[i]['GR_DESCRIPTION']+'</td>'+
                        '<td>'+item[i]['AMOUNTS']+'</td>'+
                        '<td>'+item[i]['NO_PO']+'</td>'+
                        '<td>'+item[i]['GR_ITEM_QTY']+'</td></tr>';
            }
            $("#item_data").html(teks);
        }
    });
});

 function reportFaktur(elm){
    var _id = $(elm).data('id_invoice');

    var _url = $("#base-url").val() + "EC_Approval/E_Nofa/reportFaktur";
    bootbox.confirm("Apakah Anda Yakin", function(res){
        if(res){
            $.post(_url,{id_invoice : _id}, function(data){
                if(data.status){
                    $("#msg").html("Faktur "+data.faktur+" Berhasil Di Laporkan");
                    $("#msg").removeClass('hide');
                    loadTable();
                    loadTable2();  
                }else{
                    $("#msg").html("Faktur Gagal Di Laporkan");
                    $("#msg").removeClass('hide');
                    loadTable();
                    loadTable2();
                }
            },'json');
        }
    });
 }

 function downloadFaktur(elm){
    var _a = $(elm).closest('div').prev().find('li.active').text();
    var _tab = _a == 'Unreported' ? 'U' : 'R';
    var _id = invChecked(_tab);
    var _cmp = $(elm).data('company');
    var _act = 'F';
    
    if(_id.length > 0){
        var _url = $('#base-url').val()+'EC_Approval/E_Nofa/printFaktur';
        $.redirect(_url,{tab:_tab,id_invoice:_id,act:_act,company:_cmp},'POST','_blank');
    }else{
        bootbox.alert('Anda Belum Memilih Faktur yang Akan Didownload');
    }
 }

 function downloadImage(elm){
    var _a = $(elm).closest('div').prev().find('li.active').text();
    var _tab = _a == 'Unreported' ? 'U' : 'R';
    var _id = invChecked(_tab);
    var _cmp = $(elm).data('company');
    var _act2 = 'I';

    if(_id.length == 0){
        bootbox.alert('Anda Belum Memilih Faktur yang Akan Didownload');
    }else if(_id.length > 10){
        bootbox.alert('Batas Maksimal Download Gambar Faktur Pajak adalah 10');
    }else{
        var base = $("#base-url").val().replace('https://','').replace('http://','').replace('int-','');
        var _url = 'https://' + base +'EC_Vendor/Bridge/printFaktur';
        
        $.redirect(_url,{tab:_tab,id_invoice:_id,act:_act2,company:_cmp},'POST','_blank');
    }
}

function invChecked(tab){
    var id = new Array();
    var _i = 0;
    if(tab == 'U'){
        $('#table_unreported :checked').each(function(){
            id[_i] = $(this).data('id_invoice')
            _i++;
        });
    }else{
        $('#table_reported :checked').each(function(){
            id[_i] = $(this).data('id_invoice')
            _i++;
        });
    }
    return id;
}
