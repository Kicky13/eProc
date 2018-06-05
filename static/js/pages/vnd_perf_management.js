var base_url = $('#base-url').val();
table_vendor_performance_list = null;

function populate_table(argument) {
	if (table_vendor_performance_list != null) {
		table_vendor_performance_list.destroy();
	}
	
	table_vendor_performance_list = $('#vendor_performance_list').DataTable( {
        "bSort": true,
		"dom": 'rtip',
		"pageLength":10,
		"processing": true,
		"serverSide": true,
		"paging":true,
		"ajax": {
			url: base_url + "Vendor_performance_management/get_all_vendor_performance",
			type: 'POST',
			data: {search: argument}
		},
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
		"columns":[
			{"data" : "VENDOR_NO", "sClass": "text-center"},
			{"data" : "VENDOR_NAME"},
			{"data" : "POIN_CURR", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					return '<a class="btn btn-default" href="'+base_url+'Vendor_performance_management/detail_vendor_performance/'+full.VENDOR_ID+'">Detail</a>'
				}, "sClass": "text-center"
			},
		],
	});
}

$(document).ready(function(){
	populate_table('');

	$("#form_filter").submit(function(e) {
		e.preventDefault();
		search = $("#filter_vnd_list").val();
		populate_table(search);
	})

	$('#criteria').on('change', function(event) {
		event.preventDefault();
		var value = $(this).val();
		console.log(value);
		if (value != 0) {
			$('.additional').fadeIn('slow');
			if (value != -1) {
				var data = $('#criteria option:selected').text().split(' | ');
				$('#REASON').val(data[0]+" ("+data[1]+")");
				$('#REASON2').val($('#REASON').val());
				$('#REASON').attr('disabled', 'disabled');
				$('#SIGN').val(data[2]);
				
				$('#SIGN2').val($('#SIGN').val());
				$('#SIGN').attr('disabled', 'disabled');
				$('#VALUE').val(data[3]);
				$('#VALUE2').val($('#VALUE').val());
				$('#VALUE').attr('disabled', 'disabled');
			}
			else {
				$('#REASON').removeAttr('disabled');
				$('#SIGN').removeAttr('disabled');
				$('#VALUE').removeAttr('disabled');
				$('#REASON').val('');
				$('#SIGN').val(0);
				$('#VALUE').val('');
			};
		}
		else {
			$('.additional').fadeOut('slow');
		};
	});
	$('#REASON').on('change', function() {
		$('#REASON2').val($('#REASON').val());
	});
	$('#SIGN').on('change', function() {
		
		$('#SIGN2').val($('#SIGN').val());
	});
	$('#VALUE').on('change', function() {
		$('#VALUE2').val($('#VALUE').val());
	});
	
	
    $('#approve_penilaian').click(function(e) { 

            var data = $("form").serializeArray();
            var vendor = $("#vendor_no").val();

            console.log(data);

            e.preventDefault();
            swal({
                title: "Apakah Anda Yakin?",
                text: "Pastikan semua data yang sudah di submit sudah benar!",
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
                    if ($("#level").val() == 1 || $("#level").val() == 2 || $("#level").val() == 3) {

                            urlnya = 'Vendor_performance_management/approve_manual';

                    }  else {
                        swal("Warning!", "Anda Tidak Punya Akses Untuk Melakukan Action !", "warning")
                        e.preventDefault();
                        return false;
                    }

                    $.ajax({
                        url : base_url + urlnya,
                        method : 'post',
                        data : { perf_tmp_id : data, 
                        		 vendor_no : vendor
                        	}, 
                        dataType : "json"
                    })
                    .done(function(result) {
                        swal("Berhasil!", "Approve berhasil!", "success")
                        var urll = window.location.href;
                        if (urll.substr(-1) == '/') urll = urll.substr(0, urll.length - 2);
                        urll = urll.split('/');
                        urll.pop();
                        urll.pop();
                        window.location = urll.join('/') + '/reload';
                    })
                    .fail(function(result) {
                        swal("Gagal!", "Approve error!", "error")
                    }).always(function(data) {
                        console.log(data);
                    })
                    console.log("aprv");
                    }  else {
                    }
            }) 
       
    });

	$(".select2").select2();

})