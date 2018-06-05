<?php
// $x =  file_get_contents('http://svc.efaktur.pajak.go.id/validasi/faktur/704105535648000/0091705731332/93a2bc05e7e4bd0311a3bcb504e1e1eaa3b1949ed6040939f8cb6c8b47e6625b');
?>
<div class="row">
  <div class="col-md-12">
    <iframe src="<?php echo $href?>"  height="400px" style="width:97%">
    </iframe>
  </div>
  <div class="col-md-12">
    <form class="form form-horizontal" method="post" action="<?php echo site_url('EC_Invoice_ver/saveXmlPajak')?>">
      <div class="form-group">
        <label class="col-md-2 control-label">Url</label>
        <div class="col-md-8">
          <input class="form-control col-md-10" required name="URL_FAKTUR" />
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">Data xml</label>
        <div class="col-md-8">
          <input class="form-control col-md-10" rows="2" required name="XML_FAKTUR" readonly />
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4 col-md-offset-2">
          <input type="hidden" name="NO_FAKTUR" value="<?php echo $nofaktur ?>" />
          <input class="btn btn-danger" type="button" onclick="bootbox.hideAll()" value="batal"/>
          <input class="btn btn-success" type="submit" value="simpan"/>
        </div>
      </div>
    </form>
  </div>
</div>
