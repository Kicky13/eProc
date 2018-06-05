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


