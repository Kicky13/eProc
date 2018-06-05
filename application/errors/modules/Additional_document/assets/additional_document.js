$(document).ready(function(){
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	});
	
	var success = true;
	/* COMPANY EXPERIENCE */
	$('.current_edited_affiliasi').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			address: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				validators: {
					notEmpty: {}
				}
			},
			post_code: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					numeric:{},
					stringLength:{min:5, max:5}
				}
			},
			country: {
				validators: {
					notEmpty: {}
				}
			},
			qualification: {
				validators: {
					notEmpty: {}
				}
			},
			relationship: {
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

	$('#update_doc_affiliasi').click(function(){
		$('.current_edited_affiliasi').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.current_edited_affiliasi').serialize();
			$.ajax({
				url : './Additional_document/do_update_affiliasi',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					swal("Berhasil!", "Updating data berhasil!", "success")
					location.reload();
				}
			})
		}
	});

	$('.current_edited_subkontraktor').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			address: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				validators: {
					notEmpty: {}
				}
			},
			post_code: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					numeric:{},
					stringLength:{min:5, max:5}
				}
			},
			country: {
				validators: {
					notEmpty: {}
				}
			},
			qualification: {
				validators: {
					notEmpty: {}
				}
			},
			relationship: {
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

	$('#update_doc_subkontraktor').click(function(){
		$('.current_edited_subkontraktor').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.current_edited_subkontraktor').serialize();
			$.ajax({
				url : './Additional_document/do_update_subkontraktor',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					swal("Berhasil!", "Updating data berhasil!", "success")
					location.reload();
				}
			})
		}
	});

	$('.current_edited_principal').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			address: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				validators: {
					notEmpty: {}
				}
			},
			post_code: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					numeric:{},
					stringLength:{min:5, max:5}
				}
			},
			country: {
				validators: {
					notEmpty: {}
				}
			},
			qualification: {
				validators: {
					notEmpty: {}
				}
			},
			relationship: {
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

	$('#update_doc_principal').click(function(){
		$('.current_edited_principal').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.current_edited_principal').serialize();
			$.ajax({
				url : './Additional_document/do_update_principal',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					swal("Berhasil!", "Updating data berhasil!", "success")
					location.reload();
				}
			})
		}
	});

	$('.insert_principal').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			address: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				validators: {
					notEmpty: {}
				}
			},
			post_code: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					numeric:{},
					stringLength:{min:5, max:5}
				}
			},
			country: {
				validators: {
					notEmpty: {}
				}
			},
			qualification: {
				validators: {
					notEmpty: {}
				}
			},
			relationship: {
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

	$('#addPrincipal').click(function(){
		$('.insert_principal').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.insert_principal').serialize();
			$.ajax({
				url : './Additional_document/do_insert_principal',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					swal("Berhasil!", "Tambah data berhasil!", "success")
					location.reload();
				}
			})
		}
	});

	$('.insert_subcontractor').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			address: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				validators: {
					notEmpty: {}
				}
			},
			post_code: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					numeric:{},
					stringLength:{min:5, max:5}
				}
			},
			country: {
				validators: {
					notEmpty: {}
				}
			},
			qualification: {
				validators: {
					notEmpty: {}
				}
			},
			relationship: {
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

	$('#addSubcontractor').click(function(){
		$('.insert_subcontractor').bootstrapValidator('validate');
		if(success){
			var form_data = $('.insert_subcontractor').serialize();
			console.log(form_data);
			$.ajax({
				url : './Additional_document/do_insert_subcontractor',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					swal("Berhasil!", "Tambah data berhasil!", "success")
					location.reload();
				}
			})
		}
	});

	$('.insert_affiliation_company').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			address: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				validators: {
					notEmpty: {}
				}
			},
			post_code: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					numeric:{},
					stringLength:{min:5, max:5}
				}
			},
			country: {
				validators: {
					notEmpty: {}
				}
			},
			qualification: {
				validators: {
					notEmpty: {}
				}
			},
			relationship: {
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

	$('#addAffiliation_company').click(function(){
		$('.insert_affiliation_company').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.insert_affiliation_company').serialize();
			$.ajax({
				url : './Additional_document/do_insert_affiliation_company',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					swal("Berhasil!", "Tambah data berhasil!", "success")
					location.reload();
				}
			})  
		}
	});

	$('#saveandcont_additional_document').click(function(){
		window.location.href = 'Additional_document/input_summary';
	});

	$('.update_add_principal').click(function(){
		var add_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#add_principal_id').val(add_id);
		var base_url = $('#base-url').val();
		$('#name_edit_p').val(parent.find(".name").html());
		$('#address_edit_p').val(parent.find(".address").html());
		$('#city_edit_p').val(parent.find(".city").html());
		$('#post_code_edit_p').val(parent.find(".post_code").html());
		$('#country_edit_p').val(parent.find(".country").html());
		$('#qualification_edit_p').val(parent.find(".qualification").html());
		$('#relationship_edit_p').val(parent.find(".relationship").html());
		$('#updatePrincipalModal').modal();
	});

	$('.update_add_subcontractor').click(function(){
		var add_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#add_subkontraktor_id').val(add_id);
		var base_url = $('#base-url').val();
		
		$('#name_edit_s').val(parent.find(".name").html());
		$('#address_edit_s').val(parent.find(".address").html());
		$('#city_edit_s').val(parent.find(".city").html());
		$('#post_code_edit_s').val(parent.find(".post_code").html());
		$('#country_edit_s').val(parent.find(".country").html());
		$('#qualification_edit_s').val(parent.find(".qualification").html());
		$('#relationship_edit_s').val(parent.find(".relationship").html());

		$('#updateSubkontraktorModal').modal();
	});

	$('.update_add_affiliation').click(function(){
		var add_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();

		$('#add_affiliasi_id').val(add_id);
		var base_url = $('#base-url').val();

		$('#name_edit_a').val(parent.find(".name").html());
		$('#address_edit_a').val(parent.find(".address").html());
		$('#city_edit_a').val(parent.find(".city").html());
		$('#post_code_edit_a').val(parent.find(".post_code").html());
		$('#country_edit_a').val(parent.find(".country").html());
		$('#qualification_edit_a').val(parent.find(".qualification").html());
		$('#relationship_edit_a').val(parent.find(".relationship").html());

		$('#updateAffiliasiModal').modal();
	});

	/* OTHER */

	$('.reset_button').click(function(){
		$(this).closest('form').clearForm();
	});

	$(".text-uppercase").keyup(function () {
	    this.value = this.value.toLocaleUpperCase();
	});

	function clearForm(form) {
		$(':input', form).each(function() {
		var type = this.type;
		var tag = this.tagName.toLowerCase();
		if (type == 'text' || type == 'password' || tag == 'textarea')
		this.value = "";
		else if (type == 'checkbox' || type == 'radio')
		this.checked = false;
		else if (tag == 'select')
		this.selectedIndex = -1;
		});
	};

	$.fn.clearForm = function() {
		return this.each(function() {
			var type = this.type, tag = this.tagName.toLowerCase();
			if (tag == 'form')
				return $(':input',this).clearForm();
			if (type == 'text' || type == 'password' || tag == 'textarea')
				this.value = '';
			else if (type == 'checkbox' || type == 'radio')
				this.checked = false;
			else if (tag == 'select')
				this.selectedIndex = -1;
		});
	};
})