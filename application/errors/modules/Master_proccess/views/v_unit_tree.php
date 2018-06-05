
<div id="tree">
</div>
<input id="dataidcom" name="dataidcom" type="hidden" value="<?php echo $nilai ?>">

<script type="text/javascript">
	 $(document).ready(function () {
	$("#tree").dynatree({
				initAjax: {url: '<?php echo base_url() ?>index.php/Master_proccess/getTree/'+$('#dataidcom').val(), 
               	},
				   onActivate: function(node) {
					$('#kode_unit').val(node.data.kode);
					$('#unker').val(node.data.nama);
					
					
				  },
				   onLazyRead: function(node){
       
				node.appendAjax({
				  url: "<?php echo base_url() ?>index.php/Master_proccess/getTree_lazy",
				  data: {key: node.data.kode}
				});
			  }
      			});
				
	 })
</script>