$(document).ready(function(){

    $('.DDATE').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');
    $('.DOC_DATE').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');

    $('body').on('click', '.btn-check', function()
    {
        $("#document_shipping").modal();

        id = $(".id").val();
        $.ajax({
            url: $("#base-url").val() + 'Tender_winner/getReleasePO/'+id,
            type: "post",
            dataType: "json",
            success: function (data) {
                $(".HEADER_TEXT").val(data.data.HEADER_TEXT);
                $(".DDATE").val(data.data.NEW_DDATE);
                $(".DOC_DATE").val(data.data.NEW_DOC_DATE);
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
            }
        });

    })

    $('body').on('click', '.save-custom', function()
    {
        $("#document_shipping").hide();

        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: $("#base-url").val() + 'Tender_winner/saveReleasePO',
            data: $('#formrooms2').serializeArray(),
            success: function (data) {
                if (data.success === true) {
                    location.reload(); 
                } else {
                    alert("Sorry, there was a problem!");
                }
            },
            fail: function (e) {
                alert("Sorry, there was a problem!");
            }
        });

    })
})

