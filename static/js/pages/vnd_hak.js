$(document).ready(function(){
    base_url = $("#base-url").val();
    var mytable;

    mytable = $('#tbl_data').DataTable({

        "bSort": false,
        "dom": 'rtip',
        "ajax" : {'url':base_url + 'Vendor_akses_proses/get_data'},

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "EMP_NAME"},
            {"data" : "NAME_LEVEL"},
            {"data" : "COMPANYNAME"},
            {
                mRender : function(data,type,full){
                
                    ans = '<a title="Hapus" OnClick="deletedata('+full.ID+')" class="btn btn-default btn-sm glyphicon glyphicon-trash delete_data"></a>';
                    return ans;
            }},
        ],
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

    $('#company').change(function(){
        $('#company_id').val($('#company option:selected').text()); 
        id = $('#company').val();
        $.ajax({ 
            url : base_url + 'Vendor_akses_proses/pilih_employee',
            method : 'post',
            data : "id="+id,
            success: function(data){
                $("#emplo_id").html(data);
                $('.new_emplo').remove();
            }
        });
        return false;
    });

    $('#emplo_id').change(function(){ 
        $('#emplo').val($('#emplo_id option:selected').text());
        $('.new_emplo').remove();
        return false;
    });
 
    $(".select2").select2();

    $('.formInitialize').bootstrapValidator({
        fields: {
            company: {
                validators: {
                    notEmpty: {}
                }
            },
            emplo_id: {
                validators: {
                    notEmpty: {}
                }
            }, 
            level: {
                validators: {
                    notEmpty: {}
                }
            }
        }
    }).on('error.form.bv', function(e) {
            success = false;
    }).on('success.form.bv', function(e) {
        success = true;
    });

    $('#save').click(function(e){ 
        var form_data = $('.formInitialize').serialize();
        console.log(form_data);
        
        $('.formInitialize').bootstrapValidator('validate');

        if (success) {
        e.preventDefault();
            swal({
                title: "Apakah Anda Yakin?",
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
                        url : base_url + 'Vendor_akses_proses/insert_akses',
                        method : 'post',
                        data : form_data,
                        success : function(result)
                        {
                            if(result == 'ok'){
                                swal("Berhasil!", "Data berhasil disimpan", "success")
                                location.reload();
                            }else{
                                swal("Error!", "Data gagal disimpan", "error")
                            }
                        }
                    });
                } else {}
            })
        };
    });
})

function deletedata(ID){
     // alert(ID);
    swal({
        title: "Apakah Anda Yakin?",
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
                url : base_url + 'Vendor_akses_proses/deleteven',
                data : "id="+ID, 
                success: function(data) {
                    if(data == 'ok'){
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