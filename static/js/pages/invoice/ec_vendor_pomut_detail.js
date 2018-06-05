$(document).ready(function() {

    $('form').submit(function(e){
        var Form = this;
        e.preventDefault();
        bootbox.confirm('Apakah Anda Yakin?', function(res){
            if(res){
                Form.submit();
            }
        });
    });
    $('#TGL_BA').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });
});


function cetakDokumen(elm){
    var _no_ba = $(elm).data('no_ba');
    var url = $('#base-url').val() + 'EC_Approval/Pomut/cetakBeritaAcara';

    var _tgl = $('input[name=TGL_BA]').val();
    var _kota = $('input[name=KOTA]').val();
    var _kasi = $('input[name=KASI_PENGADAAN]').val();

    var form = $(elm).closest('form');

    if(empty(_kota)){
        bootbox.alert('Data Kota Belum Terisi');
    }else if(empty(_kasi)){
        bootbox.alert('Data Kasi Pengadaan Barang Belum Terisi');
    }else{
        $.redirect(url,{no_ba:_no_ba,tgl_ba:_tgl,kota:_kota,kasi:_kasi},'POST','_blank');
    }
    
}
 

