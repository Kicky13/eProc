$(document).ready(function() { 

	justification = $("#ptp_justification").val();
    if(justification==5){
        $('#ptp_warning').val(1);
        $('#ptp_batas_penawaran').val(0);
        $('#ptp_batas_penawaran_bawah').val(20);
        $('#ptp_warning_nego').val(1);
        $('#batasatasnego').val(0);
        $(".repeat_order").prop("disabled", true);
        $("#ptp_evaluation_method").parent().val(1);
        $(".repeat_order_method").prop("disabled", true);
        $(".ro_hide").hide();
    }
});