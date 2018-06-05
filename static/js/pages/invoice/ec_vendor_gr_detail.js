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
});

function reject(elm){
	var _lot = $('input[name=LOT_NUMBER]').val()
    $('#rejectNote').modal('show');
    $('input[name=LOT_NUMBER]').val(_lot);
    $('textarea#msg').val('');
}

function showDocument(elm){
    var lot_no = $(elm).data('lot_no');
    var _po_no = $(elm).data('po_no');
    var _print = $(elm).data('print_type');

    var _data = {
        id : lot_no,
        nopo : _po_no,
        print_type : _print,
        tipe : 'RR'
    };

    $.redirect($('#base-url').val()+'EC_Invoice_Management/showDocument',_data,'POST','_blank');
}
