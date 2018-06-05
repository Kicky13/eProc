	<footer id="footer">
		<div class="footer_copyright">
			<div class="container clearfix">
				<div class="col-md-6">
					<span class="footer_copy_text">Copyright &copy; <?php echo date('Y');  ?> <a href="<?php echo base_url(); ?>">eProcurement</a> - Semen Indonesia Group - All Rights Reserved</span>
				</div>
				<div class="col-md-6 clearfix">
					<ul class="footer_menu clearfix">
						<li><a href="<?php echo base_url(); ?>"><span>Home</span></a></li>
						<li>/</li>
						<li><a href="#"><span>Help Center</span></a></li>
						<li>/</li>
						<li><a href="#"><span>Contact Us</span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<a href="#0" class="hm_go_top"></a>
</div>
	<?php
	if (!empty($scripts)) {
		echo $scripts;
	}
?>
	<script type="text/javascript">
	
		<?php
		if ($this->uri->segment(2)!='detail_negotiation'){
		?>
		$(document).ajaxStart(function() {
			$('#freeze').show();
			$('#loading').show();
		});
		$(document).ajaxComplete(function() {
		  	$('#loading').hide();
			$('#freeze').hide();
		});
		<?php
		}
		?>
		
	</script>
</body>
</html>