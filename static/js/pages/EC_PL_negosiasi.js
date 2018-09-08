

$(document).ready(function () {

    console.log('test');

    $('#modalNego').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var vendorno = (button.data('vendorno'))
        console.log('test');
    })
});