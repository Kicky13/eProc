$(document).ready(function () {
    // $('#basic2').selectpicker({
    //   liveSearch: true,
    //   maxOptions: 1
    // });
    $('.date').datepicker({
        format: 'dd-mm-yyyy',
        defaultDate: new Date(),
        autoclose: true,
        todayHighlight: true
    }).on('change', function(){
        $('.datepicker').hide();
    }).on('show.bs.modal', function(event) {
    // prevent datepicker from firing bootstrap modal "show.bs.modal"
        event.stopPropagation();
    });
});