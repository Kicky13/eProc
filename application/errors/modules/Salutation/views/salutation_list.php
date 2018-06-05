
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Salutation Management</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="addSuccess" class="alert alert-success" style="display:none; margin-left:3%;margin-right:3%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> Data has been succesfully Added
                            </div>
                            <div id="delSuccess" class="alert alert-success" style="display:none; margin-left:3%;margin-right:3%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> Data has been succesfully Deleted
                            </div>
                            <div id="editSuccess" class="alert alert-success" style="display:none; margin-left:3%;margin-right:3%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> Data has been succesfully Edited
                            </div>

                            <div id="addFailed" class="alert alert-danger" style="display:none; margin-left:3%;margin-right:3%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Error!</strong> Could not save data
                            </div>
                            <div id="delFailed" class="alert alert-danger" style="display:none; margin-left:3%;margin-right:3%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Error!</strong> Could not delete data
                            </div>
                            <div id="editFailed" class="alert alert-danger" style="display:none; margin-left:3%;margin-right:3%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Error!</strong> Could not save data
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default"style='margin-left:3%;margin-right:3%;'>
                        <div class="panel-heading">
                        
                            <a href="#" class="btn btn-primary btn-sm pull-right" id="add_btn">Add Data</a>                       
                            <br></br></div>
                        <div class="panel-body">
                            
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="toggleColumn-datatable">
                                <thead>
                                    <tr>
                                        <th>Salutation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                         
                         
                                <tbody>
                                        <?php foreach ($salutation_list_data as $i) {?>
                                        
                                                <tr>
                                                    <td><?php echo $i['SALUTATION_NAME']?></td>
                                                    <td class="text-center">
                                                    <a class ="main_button small_btn edit_btn" href="#" data-toggle="tooltip" id="<?php echo $i['SALUTATION_ID']?>" title="Edit Salutation" ><i class="in_left ico-dashboard2"></i></a>
                                                    <a class ="main_button small_btn del_btn" href="#" data-toggle="tooltip" id="<?php echo $i['SALUTATION_ID']?>" title="Delete Salutation"><i class="in_left ico-dashboard2"></i></a>
                                                   </td>    
                                                </tr>
                                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
<!--Add Data -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Add Salutation</h4>
          </div>
          <div class="modal-body">
             <div class="form-group">
                    <label >Salutation Name</label>
                    <input type="text" class="form-control" id="name_Salutation">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="saveAdd">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

<!--Edit Data -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Salutation</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
                    <label >Salutation Name</label>
                    <input type="text" class="form-control" id="nameSalutation" >
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editData">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>


<!--Delete Data -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Delete Salutation</h4>
          </div>
          <div class="modal-body">
            <p>Are You Sure To Delete Salutation? </p> 
          </div>
          <div class="modal-footer">            
            <button type="button" class="btn btn-primary" id="hapus">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
    ga('create', 'UA-56821827-1', 'auto');
    ga('send', 'pageview');
</script>


<script>
    $(document).ready(function(){
            var id_var;
            $('#add_btn').click(function(e) {
                    e.preventDefault();
                    $('#AddModal').modal('show');
                });

            $("#toggleColumn-datatable").on("click", ".edit_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#nameSalutation').val($(this).parent().prev().html());
                    row=$(this).parent().parent();
                    $('#EditModal').modal('show');
            });

            $("#toggleColumn-datatable").on("click", ".del_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#DeleteModal').modal('show');
                    row=$(this).parent().parent();
            });

            $("#saveAdd").click(function(e){
                $.ajax({
                    url: '<?php echo site_url(); ?>salutation/add',
                    type: 'GET',
                    data: {
                        "name_salutation": $('#name_Salutation').val(),
                    },
                    success: function(results){
                        $('#AddModal').modal('hide');
                        $('#addSuccess').show();
                         window.setTimeout(function(){location.reload()},1000);
                        
                    },
                    error: function(){
                        $('#AddModal').modal('hide');
                        $('#addFailed').show();
                        $('#addFailed').fadeOut(2000);
                         }
                });
            });

             $("#editData").click(function(e){
                $.ajax({
                    url: '<?php echo site_url(); ?>salutation/edit',
                    type: 'GET',
                    data: {
                        "id_salutation": id_var,
                        "name_salutation": $('#nameSalutation').val(),
                    },
                    success: function(results){
                        $('#EditModal').modal('hide');
                        $('#editSuccess').show();
                        window.setTimeout(function(){location.reload()},1000);
                        
                    },
                    error: function(){
                        $('#EditModal').modal('hide');
                        $('#editFailed').show();
                        $('#editFailed').fadeOut(2000);
                         }
                });
            });

            $('#hapus').click(function(e){
                //$('#dump').html($('#dump').val());
                e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url()?>salutation/delete',
                        type:'GET',
                        data: {
                            "id": id_var,
                        },
                        success: function(results) {
                            $('#DeleteModal').modal('hide');
                            $('#delSuccess').show();
                             window.setTimeout(function(){location.reload()},1000);
                        
                        },
                        error: function(){
                            $('#DeleteModal').modal('hide');
                            $('#delFailed').show();
                            $('#delFailed').fadeOut(2000);
                         }
                });
            });
    });            
</script>