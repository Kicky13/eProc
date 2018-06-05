<?php
	foreach($list as $result){
		$RES_NO[] 	= $result['RES_NO'];
		$MATERIAL[] 	= $result['MATERIAL'];
		$PLANT[] 	= $result['PLANT'];
		$REQ_DATE[] 	= $result['REQ_DATE'];
		$REQ_QUAN[] 	= $result['REQ_QUAN'];
		$REQ_UNIT[] 	= $result['UNIT'];
		$QUANTITY[] 	= $result['QUANTITY'];
		$MOVE_TYPE[] 	= $result['MOVE_TYPE'];
                $G_L_ACCT[] 	= $result['G_L_ACCT'];
		$SHORT_TEXT[] 	= $result['SHORT_TEXT'];
		$MAT_GRP[] 	= $result['MAT_GRP'];
		$STORE_LOC[] 	= $result['STORE_LOC'];
		$PO_ITEM[] 	= $result['PO_ITEM'];
		$RES_ITEM[] 	= $result['RES_ITEM'];
		$PO_NUMBER[] 	= $result['PO_NUMBER'];
		$RES_ITEM[] 	= $result['RES_ITEM'];
		$VENDOR[] 	= $result['VENDOR'];
		
	}
	$jum = count($list);
?>
<style type="text/css">
    .dt-body-right{
        text-align:right;
    }
</style>
<?php $this->load->view('vmi_menubar');?>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Approval List Reservasi</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> 
					</div>
					<?php } ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title pull-left">List Reservasi</div>
							<div class="btn-group pull-right">
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
                                                    <form  action="<?= site_url('VMI/Company/GIReserve')?>" method="POST">
                                                        <input type="text" value="" id="listreservasi" name="listreservasi">
                                                        <input type="submit" class="btn btn-default">
                                                    </form>
							<table class="table table-hover" id="vmi_reservasi_list">
								<thead>
									<tr>
										<th class="text-center">Reservasi</th>
                                                                                <th class="text-center">RES ITEM</th>
                                                                                <th class="text-center">PO NUMBER</th>
										<th class="text-center">PO ITEM</th>
										<th class="text-center">Material</th>
                                                                                <th class="text-center">Descriptions</th>
										<th class="text-center">Plant</th>
										<th class="text-center">Req Quantity</th>
										<th class="text-center">Req Unit</th>
										<th class="text-center">Quantity</th>
                                                                                <th class="text-center">Storage Location</th>
										<th class="text-center">Move Type</th>
                                                                                <th class="text-center">GL Account</th>
										<th class="text-center">Mat Group</th>
										<th class="text-center">Doc Date</th>
										<th class="text-center">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									for($i=0;$i<$jum;$i++)
									{
										echo '
											<tr>
												<td>'.$RES_NO[$i].'</td>
                                                                                                <td>'. $RES_ITEM[$i].'</td>
                                                                                                <td>'. $PO_NUMBER[$i].'</td>
												<td>'. $PO_ITEM[$i].'</td>
                                                                                                 <td>'.$MATERIAL[$i].'</td>
                                                                                                <td>'. $SHORT_TEXT[$i].'</td>
												<td>'. $PLANT[$i].'</td>
												<td>'. $REQ_QUAN[$i].'</td>
												<td>'. $REQ_UNIT[$i].'</td>
												<td>'. $QUANTITY[$i].'</td>
												<td>'. $STORE_LOC[$i].'</td>
												<td>'. $MOVE_TYPE[$i].'</td>
                                                                                                <td>'. $G_L_ACCT[$i].'</td>
                                                                                                <td>'. $MAT_GRP[$i].'</td>
												<td>'. $REQ_DATE[$i].'</td>
												
												<td>
												  <input type = "checkbox" value = "1" class="cbox" 
                                                                                                   data-res_no="'.$RES_NO[$i].'"
                                                                                                   data-res_item="'.$RES_ITEM[$i].'"
                                                                                                   data-material="'.$MATERIAL[$i].'"
                                                                                                   data-plant="'.$PLANT[$i].'"
                                                                                                   data-req_date="'.$REQ_DATE[$i].'"
                                                                                                    data-req_quan="'.$REQ_QUAN[$i].'"
                                                                                                    data-req_unit="'.$REQ_UNIT[$i].'"
                                                                                                    data-quantity="'.$QUANTITY[$i].'"
                                                                                                    data-store_loc="'.$STORE_LOC[$i].'" 
                                                                                                    data-move_type="'.$MOVE_TYPE[$i].'"
                                                                                                    data-g_l_acct="'.$G_L_ACCT[$i].'"
                                                                                                    data-short_text="'.$SHORT_TEXT[$i].'"
                                                                                                    data-mat_grp="'.$MAT_GRP[$i].'"
                                                                                                    data-po_item="'.$PO_ITEM[$i].'"
                                                                                                    data-po_number="'.$PO_NUMBER[$i].'"
                                                                                                    data-res_item="'.$RES_ITEM[$i].'"
                                                                                                    data-vendor="'.$VENDOR[$i].'"
                                                                                                    data-no="'.$i.'"
                                                                                                    >
												</td>
											</tr>
										';
									}
													// <a href='".base_url('VMI/Company/Grafik/')."/".$value['ID_LIST']."'>
													// </a>
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>