
$.fn.extend({
	treed : function(o) {

		var openedClass = 'glyphicon-minus-sign';
		var closedClass = 'glyphicon-plus-sign';

		if ( typeof o != 'undefined') {
			if ( typeof o.openedClass != 'undefined') {
				openedClass = o.openedClass;
			}
			if ( typeof o.closedClass != 'undefined') {
				closedClass = o.closedClass;
			}
		};

		//initialize each of the top levels
		var tree = $(this);
		tree.addClass("tree");
		tree.find('li').has("ul").each(function() {
			var branch = $(this);
			//li with children ul
			branch.prepend("<a href=\"javascript:void(0)\"  style=\"color:#666;\"><i class='indicator glyphicon " + closedClass + "'></i></a>");//<a href=\"javascript:void(0)\"> </a>
			branch.addClass('branch');
			branch.on('click', function(e) {
				if (this == e.target) {
					var icon = $(this).children('a:first').children('i:first');//.children('a:first')
					icon.toggleClass(openedClass + " " + closedClass);
					$(this).children().next().children().toggle();
				}
			})
			branch.children().children().toggle();
		});
		//fire event from the dynamically added icon
		tree.find('.branch .indicator').each(function() {
			$(this).on('click', function() {
				$(this).closest('li').click();
			});
		});
		//fire event to open branch if the li contains an anchor instead of text
		// tree.find('.branch>a').each(function() {
			// $(this).on('click', function(e) {
				// $(this).closest('li').click();
				// e.preventDefault();
			// });
		// });
		//fire event to open branch if the li contains a button instead of text
		tree.find('.branch>button').each(function() {
			$(this).on('click', function(e) {
				$(this).closest('li').click();
				e.preventDefault();
			});
		});
	}
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree1 .branch').each(function() {

	var icon = $(this).children('a:first').children('i:first');//.children('a:first')
	icon.toggleClass('glyphicon-minus-sign glyphicon-plus-sign');
	$(this).children().children().toggle();

}); 