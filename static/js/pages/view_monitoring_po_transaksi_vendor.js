function ValidateFileUploadDOC_PPL() {
    var fuData = document.getElementById('DOC_PPL');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_PPL").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_BILLING() {
    var fuData = document.getElementById('DOC_BILLING');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_BILLING").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_BPN() {
    var fuData = document.getElementById('DOC_BPN');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_BPN").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_MANIFEST() {
    var fuData = document.getElementById('DOC_MANIFEST');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_MANIFEST").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_LS() {
    var fuData = document.getElementById('DOC_LS');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_LS").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_INSURANCE() {
    var fuData = document.getElementById('DOC_INSURANCE');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_INSURANCE").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_SPPB() {
    var fuData = document.getElementById('DOC_SPPB');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_SPPB").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_SPTNP() {
    var fuData = document.getElementById('DOC_SPTNP');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_SPTNP").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_PPL1() {
    var fuData = document.getElementById('DOC_PPL1');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_PPL1").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function ValidateFileUploadDOC_INVOICE1() {
    var fuData = document.getElementById('DOC_INVOICE1');
    var FileUploadPath = fuData.value;
    if (FileUploadPath == '') {
        alert("Please upload an Document");
    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "doc" || Extension == "docx" || Extension == "pdf") {
        }
        else {
            document.getElementById("DOC_INVOICE1").value = "";
            alert("Only allows file types of DOC, DOCX and PDF. ");
            return false;
        }
    }
}

function loadDetailData() {
    var strUser = $('#opco').val();

    $.ajax({
        url: $("#base-url").val() + 'Monitoring_po_import_vendor/getDetailPoImportDB',
        data: {
            company: strUser
        },
        type: "post",
        dataType: "html",
        success: function (data) {
            $('#example2').dataTable().fnClearTable();
            $('#example2').dataTable().fnDestroy();

            $('#resultPO').html('');
            $('#resultPO').html(data);

            var table = $('#example2').DataTable({
                "columnDefs": [
                { "visible": false, "targets": 1 }
                ],
                "order": [[ 1, 'asc' ]],
                "displayLength": 25,
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="9">'+group+'</td></tr>'
                                );

                            last = group;
                        }
                    } );
                }
            });

            $('#example2 tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === 1 && currentOrder[1] === 'asc' ) {
                    table.order( [ 1, 'desc' ] ).draw();
                }
                else {
                    table.order( [ 1, 'asc' ] ).draw();
                }
            });

        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
        }
    });
}

$(document).ready(function(){
    loadDetailData();
    
    $('#TGL').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');
    $('#TGL_SPPB').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');
    $('#TGL_PIB').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');
    $('#TGL_DO').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');
    $('#TGL_MAN').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');
    $('#TGL_TA').mask("9999-99-99").attr('placeholder', 'yyyy-mm-dd (ex:1980-01-31)');

    $('body').on('click', '.update-detail', function()
    {
        $('#formrooms').attr('action',$("#base-url").val() + 'Monitoring_po_import_vendor/updateDetailPo')
        $('#formrooms').submit();  
    })

    $('body').on('click', '.btn-edit', function()
    {
        $("#edit_transaksi_po").modal();
        var no_po = $(this).attr("no_po");
        $("#NO_PO").val(no_po);

        $.ajax({
            url: $("#base-url").val() + 'Monitoring_po_import_vendor/detailPo',
            data: {
                no_po: no_po
            },
            type: "post",
            dataType: "json",
            success: function (data) {
                $("#HS_CODE").val(data.HS_CODE);
                $("#NO_LS").val(data.NO_LS);
                $("#NO_CERT").val(data.NO_CERT);
                $("#TGL").val(data.NEW_TGL);
                $("#TGL_SPPB").val(data.NEW_TGL_SPPB);
                $("#TGL_PIB").val(data.NEW_TGL_PIB);
                $("#TGL_DO").val(data.NEW_TGL_DO);
                $("#TGL_MAN").val(data.NEW_TGL_MAN);
                $("#TGL_TA").val(data.NEW_TGL_TA);
                $("#NILAI_LS").val(data.NEW_NILAI_LS);
                
                $("#TOT_TAGIHAN_KONTRAK").val(data.NEW_TOT_TAGIHAN_KONTRAK);
                $("#NILAI_ONGKOS_ANGKUT").val(data.NEW_NILAI_ONGKOS_ANGKUT);
                $("#NILAI_LAIN_KONTRAK").val(data.NEW_NILAI_LAIN_KONTRAK);
                $("#TOTAL_TAGIHAN_COST").val(data.NEW_TOTAL_TAGIHAN_COST);
                $("#STORAGE").val(data.NEW_STORAGE);
                $("#OTHER").val(data.NEW_OTHER);
                $("#NILAI_LAIN").val(data.NEW_NILAI_LAIN);
                $("#FEE").val(data.NEW_FEE);
                $("#KET").val(data.VenBiaya.KET);

            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
            }
        });

    })
})