
<div id="tree">
</div>

<script type="text/javascript">
	
	$("#tree").dynatree({
				initAjax: {url: "<?php echo base_url() ?>index.php/Menu/getTree", 
               	},
				   onActivate: function(node) {
					$('#parent_kode31').val(node.data.kode);
					$('#parent_id31').val(node.data.id);
					$('#kode31').val(node.data.kode);
					$(".bs-example-modal-lg").modal("hide");
					
				  },
      			});
</script>