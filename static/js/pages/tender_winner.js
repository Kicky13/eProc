$(document).ready(function(){
    $("#panel_return_createpo").hide();

    /* Activate selectize */
    var selectizetiperfq;
    if ($("#tiperfq").length > 0) {
        $tiperfq = $("#tiperfq").selectize();
        selectizetiperfq = $tiperfq[0].selectize;
        selectizetiperfq.setValue($('#hide_doctype').val());
    }
    //*/

    $(".docdate").change(function(){
        date = $(this).val();
        console.log(date);
        pddate = $(".pdtime").val();
        console.log(pddate);
        date = new Date(date);
        date.setDate(date.getDate() + Number(pddate));
        tgl = new Date(date);
        tgl = moment(tgl).format('YYYY-MM-DD');
        $('.ddate').datepicker({
            // format: 'yyyy-mm-dd'
        }).datepicker('setDate', tgl);
    });

    $(".tombolplus").click(function(){
        a = $(".count").val();
        a = Number(a)+1;
        $(".breakdown").append("<tr><td>"+ a +"</td><td><input type='text' class='form-input col-md-12' name='desc[]'></td><td><input type='text' onkeypress='return hanyaAngka(event)' class='col-md-12 form-input text-right' name='time[]'></td>");
        $(".count").val(a);
    });
   
});

function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;        
    } 
    return true;
}