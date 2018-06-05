var base_url = $('#base-url').val();
table_vendor_performance_list = null;

function populate_table(argument) {
	if (table_vendor_performance_list != null) {
		table_vendor_performance_list.destroy();
	}
	
	table_vendor_performance_list = $('#vendor_performance_list').DataTable( {
        "bSort": false,
		"dom": 'rtip',
		"processing": true,
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
					return '<a class="btn btn-default" href="'+base_url+'Vendor_performance_management/detail_vendor_performance/'+full.PERF_HIST_ID+'">Detail</a>'
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
				if ($('#SIGN').val() == '-') {
					$('.additional2').fadeIn('slow');
				}
				else {
					$('.additional2').fadeOut('slow');
				};
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
		if ($('#SIGN').val() == '-') {
			$('.additional2').fadeIn('slow');
		}
		else {
			$('.additional2').fadeOut('slow');
		};
		$('#SIGN2').val($('#SIGN').val());
	});
	$('#VALUE').on('change', function() {
		$('#VALUE2').val($('#VALUE').val());
	});
	$('#ACTION').on('change', function() {
		if ($('#ACTION').val() == 2) {
			$('.additional3').fadeIn('slow');
		}
		else {
			$('.additional3').fadeOut('slow');
		};
	});
})