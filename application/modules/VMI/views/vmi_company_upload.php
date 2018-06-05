<?php //$this->load->view('vmi_menubar');?>
<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
</style>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Upload Prognose</h2>
			</div>
			<form class="form-horizontal" action="<?=base_url('RFC/Excel/act_berkas_oracle.php')?>" method="POST" enctype='multipart/form-data'>
				<div class="form-group">
					<div class="col-sm-3 col-sm-offset-1">
						<label for="inputPassword3" class="control-label">Upload File Prognose</label>
					</div>
					<div class="col-sm-3">
						<input type="file" id="file_prognose" name = "file_prognose" accept="application/vnd.ms-excel" required>NB : File Excel harus berextensi " .xls "
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-3 col-sm-offset-1">
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-primary">Upload</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
