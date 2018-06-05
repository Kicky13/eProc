$(document).ready(function() {

	$(":file").filestyle({buttonText: " Find file"});

	$('.startDate').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
    });
    
    $('.endDate').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
    });

    var _sd = $("#startDate").val();
    var _sd2 = $("#endDate").val();
    
    if(_sd == ''){
        $('.startDate').datepicker('setDate',new Date());
    }

    var year = getCurrentYear();
    var date = getLastDate(year,12);
    //alert(date);
    //alert(year);

    if(_sd2 == ''){
        $('.endDate').datepicker('setDate',date);
    }

    date.setFullYear(14, 0, 1);

	$('#file').on('change', function() {
        var _size = this.files[0].size;
        var _type = this.files[0].type;
        var _error = 1;
        var _tipe = _type.split('/');
        var _tape = _tipe[_tipe.length - 1];

        switch (_tape) {
            case 'jpg':
                _error = 0;
            break;
            case 'jpeg':
            	_error = 0;
            break;
            case 'png':
                _error = 0;
            break;
            case 'pdf':
                _error = 0;
            break;
        }

        if (_size > 4096000) {
            _error = 1;
        }

        if (_error == 1) {
            alert('Ukuran File Anda Lebih Besar Dari 4MB atau Tipe File Tidak Sesuai');
            $('#file').val('');
            $("#file").filestyle('clear');
        }
    });

    $('form').submit(function(e){
        var Form = this;
        e.preventDefault();
        var f_awal = hanyaAngka($('input[name=no_awal]').val());
        var f_akhir = hanyaAngka($('input[name=no_akhir]').val());
        var t_awal = $('input[name=startDate]').val().split('-').reverse().join('-');
        var t_akhir = $('input[name=endDate]').val().split('-').reverse().join('-');
        var check = 0;
        
        if(f_awal >= f_akhir){
            check = 1;
        }

        if(t_awal >= t_akhir){
            check = 2;
        }

        if (check == 1) {
            alert('No Akhir Faktur Harus Lebih Besar dari No Akhir');
        }else if(check == 2){
            alert('Persiksa Kembali Tanggal Awal dan Akhir E-Nofa');
        }else{
            Form.submit();
        }
        //alert(' '+f_awal+' '+f_akhir+' '+t_awal+' '+t_akhir+' ');
    });
});

function getLastDate(year,month){
    var d = new Date(year, month, 0);
    return d;
}

function getCurrentYear(){
    y = new Date().getFullYear();
    return y;
}

