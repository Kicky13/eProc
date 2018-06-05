$(document).ready(function() {
		$("#input-21f").rating({
			starCaptions : function(val) {
				if (val < 3) {
					return val;
				} else {
					return 'high';
				}
			},
			starCaptionClasses : function(val) {
				if (val < 3) {
					return 'label label-danger';
				} else {
					return 'label label-success';
				}
			},
			hoverOnClear : false
		});

		$('.ratingstar1').rating({
			size : 'xs',
			showClear : false,
			showCaption : false,
			readonly : true
		});

		$('#rating-input').rating({
			min : 0,
			max : 5,
			step : 1,
			size : 'xs',
			showClear : false

		});

		$('#btn-rating-input').on('click', function() {
			$('#rating-input').rating('refresh', {
				showClear : true,
				disabled : !$('#rating-input').attr('disabled')
			});
		});

		$('.btn-danger').on('click', function() {
			$("#kartik").rating('destroy');
		});

		$('.btn-success').on('click', function() {
			$("#kartik").rating('create');
		});

		$('#rating-input').on('rating.change', function() {
			//alert($('#rating-input').val());
			$('#btn-submit').removeAttr('disabled');
		});

		$('.rb-rating').rating({
			'showCaption' : true,
			'stars' : '3',
			'min' : '0',
			'max' : '3',
			'step' : '1',
			'size' : 'xs',
			'starCaptions' : {
				0 : 'status:nix',
				1 : 'status:wackelt',
				2 : 'status:geht',
				3 : 'status:laeuft'
			}
		});
}); 