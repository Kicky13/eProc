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
<script type="text/javascript">
	$(function () {
		$('#datetimepicker1').datetimepicker({
                 format: 'DD/MM/YYYY'
        });
		$('#datetimepicker2').datetimepicker({
                 format: 'DD/MM/YYYY'
        });
	});
</script>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>User Guide</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href = 'http://int-eprocurement.semenindonesia.com/eproc/upload/file_vmi/User_Guide-VMI(Company).pdf'>User Guide VMI</a>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade modal_upload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload File Prognose</h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" action="<?=base_url('RFC/Excel/act_berkas_oracle.php')?>" method="POST" enctype='multipart/form-data'>
              <input type="hidden" id="Nid_list" name="Nid_list">
			<div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
					<label for="inputPassword3" class="control-label">Upload File</label>
			  </div>
			    <div class="col-sm-1">
					<input type="file" id="file_prognose" name = "file_prognose" required>
			    </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-6 col-sm-offset-1">
					NB : File Excel harus berextensi " .xls "
			  </div>
			</div>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Upload</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
		</form>
    </div>
  </div>
</div>
