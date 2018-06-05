$(document).ready(function(){
    $(".open-detail").click(function() {
        ptv = $(this).attr('ptv');
        show_harga = $(this).attr('showHarga');
        ptm = $("#ptm_number").val();
        $.ajax({
            url: $("#base-url").val() + 'Snippet_ajax/tender_vendor',
            type: 'POST',
            dataType: 'html',
            data: {
                ptm: ptm,
                ptv: ptv,
                show_harga:show_harga
            },
        })
        .done(function(data) {
            console.log(data)
            $("#detail-vendor").find(".modal-body").html(data);
            $("#detail-vendor").modal("show");
        })
        .fail(function(data) {
            console.log("error");
            console.log(data);
        });
    });

    $("form").submit(function(e){
        neps = $("#next_process_select").val();
        if (neps == '-1') {
            e.preventDefault(); // ini buat menggagalkan submit
            return false;
        }
        /*if (!confirm('Apakah anda yakin untuk melanjutkan?')) {
            e.preventDefault(); // ini buat menggagalkan submit
            return false;
        }*/
    });

    $("input[name$='evaldio']").click(function() {
        var test = $(this).val();
        $("#hahaha").hide();
        if (test == "2"){
            $("#hahaha").show();    
        }        
    });

    $('.formsubmit_').on('click',function(){
        console.log('click');
        swal({
            title: 'Peringatan',
            text: 'Apakah Anda yakin?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#92c135',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            closeOnConfirm: true,
            closeOnCancel: true
          },
            function(isConfirm){
            console.log(isConfirm);
                if(isConfirm===true){
                    $('#approval-evatek-form')[0].submit();
                }else{
                    console.log('no submit');
                }
                
          });
    });
})

function reject(){
    $("#next_process").val(0);
}

function approve(){
    $("#next_process").val(1);
}