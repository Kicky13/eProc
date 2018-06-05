base_url = $("#base-url").val();


function kirimdata(ID_INVOICE){
     // alert(ID_INVOICE);
    swal({
        title: "Apakah anda yakin akan mengirim data?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#92c135',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: "Tidak",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "post",
                url : $("#base-url").val() + 'Invoice/updateStatus/'+ ID_INVOICE,
                dataType: 'json',
                data : "hapus_id="+ID_INVOICE, 
                success: function(data) {
                    if(data.status == 'success'){
                        swal("Berhasil!", "Data berhasil dikirim", "success")
                        $('#tableMT').DataTable().destroy();            
        				$('#tableMT tbody').empty();
        				loadTable();
                    }else{
                        swal("Error!", "Data gagal dikirim", "error")
                    }
                }
          });
        } else {
        }
    })

}

    function deletedata(ID_INVOICE){
     // alert(ID_INVOICE);
    swal({
        title: "Apakah anda yakin akan menghapus data?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#92c135',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: "Tidak",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "post",
                url : $("#base-url").val() + 'Invoice/updateStatusDelete/'+ ID_INVOICE,
                dataType: 'json',
                data : "hapus_id="+ID_INVOICE, 
                success: function(data) {
                    if(data.status == 'success'){
                        swal("Berhasil!", "Data berhasil dihapus", "success")
                        location.reload();
                    }else{
                        swal("Error!", "Data gagal dihapus", "error")
                    }
                }
          });
        } else {
        }
    })

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
        "language" : {
            "loadingRecords" : "<center><b>Please wait - Updating and Loading Data Strategic Material Assignment...</b></center>"
        },
        // "paging": true,
        // "lengthChange": true,
        // "lengthMenu": [ 10, 25, 50, 75, 100 ],
        //"scrollY": $( window ).height()/2,
        //"pagingType": "scrolling",

        "ajax" : $("#base-url").val() + 'Invoice/getData',

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
                    a += "<div class='col-md-12 text-center'>";
                    a += full[7];
                    a += "</div>";
                    return a;
                } else
                    return "<div class='col-md-12 text-center'>-</div>";
            }
        },{
            mRender : function(data, type, full) {
                if (full[13] != null) {
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
                        return "<div class='col-md-12 text-center'>Submited<br></div>";  
                    }
                    else if (full[8] == "1") {
                        return "<div class='col-md-12 text-center'>Approved</div>";
                    }
                    else if (full[8] == "2"){
                        return "<div class='col-md-12 text-center'>Rejected</div>";
                    }
                    else 
                        return "<div class='col-md-12 text-center'>Saved</div>";
                    
            }
        },{
            mRender : function(data, type, full) {
                if (full[8] == "0"){
                        return '<div class="text-center">-</div>';
                    }
                    else if (full[8] == "1") {
                        return "<div class='col-md-12 text-center'>-</div>";
                    }
                    else if (full[8] == "2"){
                        return '<div class="text-center"> <a title="Edit" href="Invoice/edit/'+full[12]+'" onclick="" class="btn btn-default btn-sm glyphicon glyphicon-edit"></a><a title="Hapus" href="#!" class="btn btn-default btn-sm glyphicon glyphicon-trash" onclick="deletedata(\'' + full[12] + '\')"></a><a title="Kirim" href="javascript:void(0)" onclick="kirimdata(\'' + full[12] + '\')" class="btn btn-default btn-sm glyphicon glyphicon-send"></a></div>'; 
                    }
                    else
                        return '<div class="text-center"> <a title="Edit" href="Invoice/edit/'+full[12]+'" onclick="" class="btn btn-default btn-sm glyphicon glyphicon-edit"></a><a title="Hapus" href="#!" class="btn btn-default btn-sm glyphicon glyphicon-trash" onclick="deletedata(\'' + full[12] + '\')"></a><a title="Kirim" href="javascript:void(0)" onclick="kirimdata(\'' + full[12] + '\')" class="btn btn-default btn-sm glyphicon glyphicon-send"></a></div>'; 
                    
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
}

    $("#button_tambah").click(function() {
            $("#base-url").val() + 'Invoice/add/';
        })
 

$(document).ready(function() {

	$(".select2").select2();

    loadTable();
    
});


