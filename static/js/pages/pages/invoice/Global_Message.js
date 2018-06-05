$(document).ready(function() {

    $('.editor-html').trumbowyg({
    btns: [
        ['viewHTML'],
        ['formatting'],
        ['superscript', 'subscript'],
        ['link'],
        ['strong', 'em', 'underline'],
        'btnGrp-justify',
        'btnGrp-lists',
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen']
    ],
    });

    $('.select2').select2();
    $('#attachment').filestyle({buttonText: " Find file"});

    $('#attachment').on('change', function() {
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
            bootbox.alert('Ukuran File Anda Lebih Besar Dari 4MB atau Tipe File Tidak Sesuai');
            $('#attachment').val('');
            $("#attachment").filestyle('clear');
        }
    });

});

    
