<script type="text/javascript">
	$(document).ready(function() {

		$(".number").keydown(function (e) {
	        // Allow: backspace, delete, tab, escape, enter and .
	        // Allow: [46, 8, 9, 27, 13, 110] .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
             // Allow: Ctrl/cmd+A
             (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
             (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
             (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
             return;
         }
        	// Ensure that it is a number and stop the keypress
        	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        		e.preventDefault();
        	}
        });

		// $('.number').keyup(function(event) {
		// 	if(event.which >= 37 && event.which <= 40){
		// 		event.preventDefault();
		// 	}
		// 	$(this).val(function(index, value) {
		// 		value = value.replace(/,/g,'');
		// 		return numberWithCommas(value);
		// 	});
		// });

		// function numberWithCommas(x) {
		// 	var parts = x.toString().split(".");
		// 	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		// 	return parts.join(".");
		// }
	});
</script>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if($this->session->flashdata('success')) { ?>
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
						</div>
					<?php } ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							Form SPB
						</div>
						<div class="panel-body">
							<form id="etor-form" enctype="multipart/form-data" method="post" action="<?php echo base_url()?>Tender_awarded_spb/insertSPB">

								<input type="hidden" name="PO_ID" id="PO_ID" value="<?php echo $id; ?>">
								<input type="hidden" name="POD_ID" id="POD_ID" value="<?php echo $id_item; ?>">
								<input type="hidden" name="VND_CODE" id="VND_CODE" value="<?php echo $VENDOR_NO; ?>">
								<input type="hidden" name="ID_SPB" id="ID_SPB" value="<?php echo $ID_SPB; ?>">

								<div class="row">
									<div class="col-md-2" style="padding-left:1%">PLAT <font color="red">*</font></div>
									<div class="col-md-10">
										<input type="text" name="PLAT" class="form-control" value="<?php echo ($ID_SPB!=null ? $spb_detail['PLAT'] : ''); ?>" onkeypress="return (event.keyCode != 32&&event.which!=32)" required>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-2" style="padding-left:1%">DRIVER <font color="red">*</font></div>
									<div class="col-md-10">
										<input type="text" name="DRIVER" class="form-control" value="<?php echo ($ID_SPB!=null ? $spb_detail['DRIVER'] : ''); ?>" required>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-2" style="padding-left:1%">TUJUAN <font color="red">*</font></div>
									<div class="col-md-10">
										<input type="hidden" name="TUJUAN" class="form-control" value="<?php echo $po_detail['PLANT']; ?>">
										<input type="text" name="TUJUAN_SHOW" class="form-control" value="<?php echo $po_detail['PLANT']; ?>" readonly>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-2" style="padding-left:1%">QTY <font color="red">*</font></div>
									<div class="col-md-10">
										<!-- <input type="text" name="QTY" class="form-control number" value=""> -->
										<input type="number" name="QTY" class="form-control" min="1" max="<?php echo ($ID_SPB!=null ? $spb_detail['QTY']+$SISA_QTY : $SISA_QTY); ?>" step="0.01" value="<?php echo ($ID_SPB!=null ? $spb_detail['QTY'] : ''); ?>" required>
									</div>
								</div>

								<br>
								<div class="row">
									<div class="col-md-2" style="padding-left:1%"></div>
									<div class="col-md-10">
										<button type="submit" class="btn btn-info">Simpan SPB</button>
									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>