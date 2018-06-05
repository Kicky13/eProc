
$(document).ready(function(){
    $(".open-detail").click(function() {
        ptv = $(this).attr('ptv');
        ptm = $("#ptm_number").val();
        $.ajax({
            url: $("#base-url").val() + 'Snippet_ajax/tender_vendor',
            type: 'POST',
            dataType: 'html',
            data: {
                ptm: ptm,
                ptv: ptv
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
})