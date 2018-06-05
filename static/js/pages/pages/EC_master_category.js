base_url = $("#base-url").val();

$(document).ready(function() {
	loadTree()
});

var id_parent,
    lvl,
    countLvl0 = 0,
    countLvl1 = 0,
    countLvl2 = 0,
    countLvl3 = 0,
    countLvl4 = 0,
    countLvl5 = 0,
    countLvl6 = 0;
function setCode(args, elme) {
	// id_parent = $(elme).parent().parent().prev().data('id') == null ? '0' : $(elme).parent().parent().prev().data('id')
	id_parent = $(elme).data('id') == null ? '0' : $(elme).data('id')
	$("#desc").val('')
	$(".lvl1").each(function() {
		countLvl0++;
	});
	// console.log($("[data-kode='1-2-1']").text());
	console.log('parent ' + id_parent)
	switch(args) {
	case 'lvl0':
		$("#parent").val('lvl0')
		$("#kode").val((countLvl0 + 1))
		break;
	case 'lvl1':
		$("#parent").val($(elme).data('kode') + "  " + $(elme).text())
		countLvl1 = $(elme).next().find('.lvl2').length
		$("#kode").val($(elme).data('kode') + '-' + (countLvl1 + 1))
		break;
	case 'lvl2':
		$("#parent").val($(elme).data('kode') + "  " + $(elme).text())
		countLvl2 = $(elme).next().find('.lvl3').length
		$("#kode").val($(elme).data('kode') + '-' + (countLvl2 + 1))
		break;
	case 'lvl3':
		$("#parent").val($(elme).data('kode') + "  " + $(elme).text())
		countLvl3 = $(elme).next().find('.lvl4').length
		$("#kode").val($(elme).data('kode') + '-' + (countLvl3 + 1))
		break;
	case 'lvl4':
		$("#parent").val($(elme).data('kode') + "  " + $(elme).text())
		countLvl4 = $(elme).next().find('.lvl5').length
		$("#kode").val($(elme).data('kode') + '-' + (countLvl4 + 1))
		break;
	case 'lvl5':
		$("#parent").val($(elme).data('kode') + "  " + $(elme).text())
		countLvl5 = $(elme).next().find('.lvl6').length
		$("#kode").val($(elme).data('kode') + '-' + (countLvl5 + 1))
		break;
	case 'lvl6':
		$("#parent").val($(elme).data('kode') + "  " + $(elme).text())
		countLvl6 = $(elme).next().find('.lvl7').length
		$("#kode").val($(elme).data('kode') + '-' + (countLvl6 + 1))
		break;
	default:
	}
	$("#parentEdit").val($("#kode").val())
	$("#kodeEdit").val($(elme).data('kode'))
	$("#descEdit").val($(elme).text())
	$("#idEdit").val(id_parent)
	$("#ID_Category").val(id_parent)
	$("#Category").val($(elme).text())
	$("#CODE_Category").val($(elme).data('kode'))
	lvl = args
	countLvl0 = 0
	countLvl1 = 0
	countLvl2 = 0
	countLvl3 = 0
	countLvl4 = 0
	countLvl5 = 0
	countLvl6 = 0
}


$(".formBaru").on("submit", function() {
	if ($("#kode").val() == '') {
		alert('Pilih Parent!!')
		return false;
	};
	console.log(id_parent + " # " + $("#kode").val() + " # " + $("#desc").val() + " # " + lvl)
	baru(id_parent, $("#kode").val(), $("#desc").val(), lvl)
	return false;
})
// $(".formEdit").on("submit", function() {
// return false;
// })
$("#btnEdit").on("click", function() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Master_category/ubah/' + id_parent,
		data : {
			"desc" : $("#descEdit").val(),
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		loadTree()
	});
})
$("#btnDelete").on("click", function() {
	if (confirm("Konfirmasi hapus?") && $("#kodeEdit").val() != "")
		$.ajax({
			url : $("#base-url").val() + 'EC_Master_category/hapus/' + id_parent,
			data : {
				"kodeEdit" : $("#kodeEdit").val(),
			},
			type : 'POST',
			dataType : 'json'
		}).done(function(data) {
		}).fail(function() {
			console.log("error");
		}).always(function(data) {
			loadTree()
		});
})
function baru(id_parent, kode_user, desc, lvl) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Master_category/baru/' + id_parent,
		data : {
			"desc" : desc,
			"kode_user" : kode_user,
			"level" : lvl
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
		loadTree()
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
	});
}

function loadTree() {
	$('#tree1').empty()
	$.ajax({
		url : $("#base-url").val() + 'EC_Master_category/get_data/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
		for (var i = 0,
		    j = data.length; i < j; i++) {
			if (data[i].KODE_PARENT == '0') {
				$('#tree1').append('<li><a href="javascript:void(0)" onclick="setCode(\'lvl1\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" class="lvl1">' + data[i].DESC + '</a><ul></ul></li>');
			};
		};
		$(".lvl1").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'lvl2\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" class="lvl2">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl2").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'lvl3\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" class="lvl3">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl3").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'lvl4\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" class="lvl4">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl4").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'lvl5\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" class="lvl5">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl5").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'lvl6\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" class="lvl6">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$('#tree1').treed();
		$('#tree1 .branch').each(function() {
			var icon = $(this).children('a:first').children('i:first');
			icon.toggleClass('glyphicon-minus-sign glyphicon-plus-sign');
			$(this).children().children().toggle();

		});
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
	});
}