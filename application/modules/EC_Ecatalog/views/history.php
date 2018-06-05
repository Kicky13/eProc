<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="row">
				<div class="col-lg-12">
					<h5>Shopping Chart</h5>
				</div>
			</div>
			<div class="row" style="padding-top: 5px">
				<div class="col-lg-8">
					<div class="row" style="border-top: 1px solid #ccc;"></div>
					<br>
					<div id="goods"></div>
				</div>
				<div class="col-lg-4 pull-right" style="border-left: 1px solid #ccc;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;">
					<form class="form-horizontal">
						<input type="hidden" id="hid_current_budget" />
						<input type="hidden" id="hid_estimated_budget" />
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Budget</label>
							<label id="budgett" class="col-sm-8 control-label pull-right">Email</label>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Total</label>
							<label id="totall" class="col-sm-8 control-label pull-right">Email</label>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-4 control-label text-left">Sisa Budget</label>
							<label id="totalsisa" class="col-sm-8 control-label pull-right">0</label>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<button type="button" id="btn_confirm" class="btn btn-danger disabled">
									Konfirmasi Beli
								</button>
							</div>
						</div>
					</form>
					<!-- <button type="submit" id="compare" style="width: auto;" class="btn btn-danger">
					Konfirmasi Beli
					</button> -->
					</center>
				</div>
			</div>
		</div >
	</div >
</section>