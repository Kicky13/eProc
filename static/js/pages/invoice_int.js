base_url = $("#base-url").val();


function proses (ID_INVOICE) {
  // MATNR='341-107-0083';//341-107-0083  301-200410
    $.ajax({
        url: $("#base-url").val() + 'Int_invoice/add/' + ID_INVOICE,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) { 
         //console.log(data.ID_INVOICE[0]);                      
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        // console.log(MATNR);
    });
}

function cekdata(){
    swal({
        title: "Tidak ada file",
        text: "",
        type: "info",
        showCancelButton: false,
        confirmButtonColor: '#92c135',
        // cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        confirmButtonClass: 'btn btn-success',
        // cancelButtonClass: '',
        // cancelButtonText: "",
        closeOnConfirm: true,
        // closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
        } else {
        }
    })
    };


function loadTable() {
    // no = 1;
    mytable = $('#tableMT').DataTable({
        "bSort" : false,
        "dom" : 'rtip',
        "deferRender" : true,
        // "paging": true,
        // "lengthChange": true,
        // "lengthMenu": [ 10, 25, 50, 75, 100 ],
        //"scrollY": $( window ).height()/2,
        //"pagingType": "scrolling",

        "ajax" : $("#base-url").val() + 'Int_invoice/getData',

        "columnDefs" : [{
            "searchable" : false,
            "orderable" : true,
            "targets" : 0
        }],
        "columns" : [{
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full[0];
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                // console.log(full);
                if (full[15] != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full[15]
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        },{
            mRender : function(data, type, full) {
                // console.log(full);
                if (full[1] != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full[1]
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender : function(data, type, full) {
                if (full[2] != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full[2];
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender : function(data, type, full) {
                if (full[3] != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full[3];
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender : function(data, type, full) {
                if (full[9] == null) {
                    if (full[4] != null)
                        return '<div class="text-center"> <a href="javascript:void(0)" onclick="cekdata()">'+ full[4] +'</a></div>';
                        else 
                        return '<div class="text-center"> <a href="javascript:void(0)" onclick="cekdata()" class="text-center">-</a></div>';                        
                    } else {
                        return '<div class="text-center"> <a target="_blank" href="'+$("#base-url").val()+'upload/vendor/'+full[9]+'">'+ full[4] +'</a> </div>';
                    }
            }
        }, {
            mRender : function(data, type, full) {
                if (full[10] == null) {
                        if (full[5] != null)
                        return '<div class="text-center"> <a href="javascript:void(0)" onclick="cekdata()" >'+ full[5] +'</a></div>';
                        else 
                        return '<div class="text-center"> <a href="javascript:void(0)" onclick="cekdata()" >-</a></div>';
                    } else{
                        return '<div class="text-center"> <a target="_blank" href="'+$("#base-url").val()+'upload/vendor/'+full[10]+'">'+ full[5] +'</a></div>';
                    }
            }
        }, {
            mRender : function(data, type, full) {
                if (full[11] == null) {
                        if (full[6] != null)
                        return '<div class="col-md-12 text-center"> <a href="javascript:void(0)" onclick="cekdata()" >'+ full[6] +'</a></div>';
                        else 
                        return '<div class=" col-md-12 text-center"> <a href="javascript:void(0)" onclick="cekdata()" >-</a></div>';
                    } else{
                        return '<div class="col-md-12 text-center"> <a target="_blank" href="'+$("#base-url").val()+'upload/vendor/'+full[11]+'">'+ full[6] +'</a></div>';
                    }
            }
        }, {
            mRender : function(data, type, full) {
                if (full[7] != null) {
                    a = ''
                    a = "<div class='col-md-12 text-center'>";
                    a += full[7];
                    a += "</div>";
                    return a;
                } else
                    return "<div class='col-md-12 text-center'>-</div>";
            }
        },{
            mRender : function(data, type, full) {
                if (full[13] != null) {
                    a = ''
                    a = "<div class='col-md-12 text-center'>";
                    a += full[13];
                    a += "</div>";
                    return a;
                } else
                    return "<div class='col-md-12 text-center'>-</div>";
            }
        },{
            mRender : function(data, type, full) {
                if (full[8] == "0"){
                        return '<div class="col-md-12 text-center">Submited<br></div>';  
                    }
                    else if (full[8] == "1") {
                        return "<div class='col-md-12 text-center'>Approved</div>";
                    }
                    else 
                        return "<div class='col-md-12 text-center'>Rejected</div>";
            }
        },{
            mRender : function(data, type, full) {
                if (full[8] == "0"){
                        return '<div class="text-center"> <a href="Int_invoice/add/'+full[12]+'" class="btn btn-default btn-sm">Proses</a></div>'; 
                    }
                    else if (full[8] == "1") {
                        return '<div class="col-md-12 text-center"><a href="javascript:void(0)" class="btn btn-default btn-sm">Cetak</a><a href="Int_invoice/createPPL/'+full[12]+'" class="btn btn-default btn-md">PPL</a></div>';
                    }
                    else 
                        return '<div class="text-center">-</div>';
            }
        }],
    });
    
    mytable.on( 'order.dt search.dt', function () {
        mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    mytable.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });

    var table =  $('#tableMT').DataTable();
    
     $('.filterStatus').on('change', function () {
                    table.columns(8).search( this.value ).draw();
                });
     
}

    $("#button_tambah").click(function() {
            $("#base-url").val() + 'Int_invoice/add/';
        })

$(document).ready(function() {

    loadTable();
    $('#stat').change(function(){
        tableMT.ajax.reload();
        });
    // editInv();
    $('input:file').bind('change', function() {
        if (this.files[0].size > 200000) {
            alert('Ukuran file maksimum 200KB.');
            this.value = '';
        } else {
            var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                break;
            default: {
                //$('#uploadButton').attr('disabled', true);
                alert('Kesalahan tipe file.');
                this.value = '';
            }
            }
        }

    });

});


