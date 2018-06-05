
<div id="tree">
</div>

<script type="text/javascript">
	
	$("#tree").dynatree({
		initAjax : {url: "<?php echo base_url() ?>index.php/Master_group_jasa/getTree", 
               	},

	    onActivate: function(node) {
	    	var kat = node.data.kategori;
               	if(kat==1){
               		kat_berikutnya = 'SUB GROUP';
               	}else if(kat==2){
               		kat_berikutnya = 'KLASIFIKASI';
               	}else if(kat==3){
               		kat_berikutnya = 'SUB KLASIFIKASI';
               	}else{
               		alert('Batas Child Jasa');
               		return;
               	}
			$('#parent_id').val(node.data.id);
			$('#parent_name').val(node.data.nama);
			$('#kategori').val(kat_berikutnya);
			$('#kategori_id').val(parseInt(kat)+1);
			$(".bs-example-modal-lg").modal("hide");
		
	    },
	});
</script>