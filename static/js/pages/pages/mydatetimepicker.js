

    /* OTHER */
    $('.input-group.date').datetimepicker({
        format: 'DD-MMM-YY HH:mm',
        // sideBySide: true,
        ignoreReadonly: true,
        // minDate: 'now'
    });

    btn = $('<span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>');
    btn.click(function(e) {
    	e.preventDefault();
    	parent = $(this).parent()
    	date = parent.children('input')
    	date.val('').datetimepicker('update');
    });
    $('.input-group.date').append(btn)

    $('.input-group.date input').attr("readonly", true);