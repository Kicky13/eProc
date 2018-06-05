var base_url = $('#base-url').val();

$(document).ready(function(){

	$("#getKode").click(function(){			 
	  	$.ajax({
	  		type: "post",
			url : base_url + 'Master_group_jasa/load_data_tree',
			dataType: "html",
			cache: true,
			success: function(hsl) {
				$("#tampilbody").html(hsl);
				$(".bs-example-modal-lg").modal("show");
			}
	  })
	});

    var table = $('#list_jasa').DataTable( {
        "ordering": false,
		"dom": 'rtip',
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url : base_url + "Master_group_jasa/get_list",
		},
		"columnDefs": [{
			"searchable": false,
            "orderable": false,
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "NAMA"},
			{
				mRender : function(data,type,full){
					if (full.KATEGORI == 1) {
						nama_parent = 'GROUP';
					} else if (full.KATEGORI == 2) {
						nama_parent = 'SUBGROUP';
					} else if (full.KATEGORI == 3) {
						nama_parent = 'KLASIFIKASI';
					}
					else if (full.KATEGORI == 4) {
						nama_parent = 'SUBKLASIFIKASI';
					}
				return nama_parent;
			}, "sClass": "text-center"},			
			{"data" : "DESCRIPTION"},
			{
				mRender : function(data,type,full) {
					return '<button title="Edit" onclick="edit('+full.ID+')" class="btn btn-default btn-sm glyphicon glyphicon-pencil"></button>'+
							  '<a title="Hapus" onclick="del('+full.ID+')" class="btn btn-default btn-sm glyphicon glyphicon-trash"></a>';
			}, "sClass": "text-center"}
		],
	} );

	table.on('draw', function () {
		table.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });


    $("form").submit(function( event ) {
    	if($('#nama').val() == ''){
    		swal("Gagal!", "Nama tidak boleh kosong", "warning")
    		return false;
    	}

        event.preventDefault();
        swal({
            title: "Apakah Anda Yakin?",
            text: "Pastikan Semua Data Yang Anda Masukkan Sudah Benar!",
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
                var form_data = $('.form_valid').serialize();
				console.log(form_data);
				$.ajax({
					url : base_url + 'Master_group_jasa/save',
					method : 'post',
					data : form_data,
					success : function(result)
					{
						if(result=='ok'){
							swal("Berhasil!", "Tambah data berhasil!", "success")
							$("form")[0].reset();
							location.reload();
						}
					}
				});
            } else {
            }
        })
    });
     
});

function edit(ID){
    $.ajax({
  		type: "post",
		url : base_url + 'Master_group_jasa/edit',
		data : "id="+ID,
		dataType: "json",
		success: function(data) {
			var kat = data.KATEGORI;
           	if(kat==1){
           		kategori = 'GROUP';
           	}else if(kat==2){
           		kategori = 'SUB GROUP';
           	}else if(kat==3){
           		kategori = 'KLASIFIKASI';
           	}else if(kat==4){
           		kategori = 'SUB KLASIFIKASI';
           	}
			$("#jasa_id").val(ID);
			$("#parent_id").val(data.PARENT_ID);
			$("#parent_name").val(data.PARENT_NAME);
			$("#nama").val(data.NAMA);
			$("#kategori").val(kategori);
			$("#kategori_id").val(kat);
			$("#description").val(data.DESCRIPTION);
		}
  });
}

function del(ID){
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
				url : base_url + 'Master_group_jasa/delete',
				data : "id="+ID,
				//dataType: "json",
				success: function(data) {
					if(data == 'ok'){
						swal("Berhasil!", "Data berhasil dihapus", "success")
						var table = $('#list_jasa').DataTable(); 
						table.ajax.reload();
					}else{
						swal("Error!", "Data gagal dihapus", "error")
					}
				}
		  });
        } else {
        }
    })
    
}