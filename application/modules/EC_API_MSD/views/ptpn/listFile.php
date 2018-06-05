<div class="row">
  <div class="col-md-12">
    <div id="listFile"></div>

  </div>
</div>

<script type="text/javascript">
  $(function(){
    var _url = "<?php echo $url ?>";
    var _mode = "<?php echo $mode ?>";
    var _location = "<?php echo $location ?>";
    var _urlFtp = "<?php echo $ftp_url ?>";
    var _link = '';
    $.get(_url,{},function(data){
      var _href = [];
        for(var i in data.content){
          _link = _urlFtp+'?filename='+data.content[i]+'&mode='+_mode+'&location='+_location;
          _href.push('<li  class="list-group-item"><a href="'+_link+'">'+data.content[i]+' &nbsp;<span style="cursor:pointer" class="badge badge-success"> Download </span></a></li>');
        }
        $('#listFile').html('<ul class="list-group">'+_href.join('')+'</ul>');
    },'json');
  })
</script>
