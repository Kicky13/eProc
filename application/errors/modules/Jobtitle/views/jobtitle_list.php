
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Job Title Management</h2>
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
                                        <th>Job Title Name</th>
                                        <th>Departement Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                         
                         
                                <tbody>
                                        <?php foreach ($jobtitle_list_data as $i) {?>
                                        
                                                <tr>
                                                    <td><?php echo $i['JOBTITLE_NAME']?></td>
                                                    <td><?php echo $i['DEPARTEMENT_NAME']?></td>
                                                    <td style="display:none;"><?php echo $i['DEPARTEMENT_ID']?></td>
                                                    <td class="text-center">
                                                    <a class ="main_button small_btn edit_btn" href="#" data-toggle="tooltip" id="<?php echo $i['JOBTITLE_ID']?>" title="Edit Job Title" ><i class="in_left ico-dashboard2"></i></a>
                                                    <a class ="main_button small_btn del_btn" href="#" data-toggle="tooltip" id="<?php echo $i['JOBTITLE_ID']?>" title="Delete Job Title"><i class="in_left ico-dashboard2"></i></a>
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
            <h4 class="modal-title" id="myModalLabel">Add Job Title</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
                    <label >Job Title Name</label>
                    <input type="text" class="form-control" id="name_JobTitle">
            </div>
            <div class="form-group">
                <label>Departement Name</label>
                      <select class="form-control" name="jobtitle_add" id="id_Departement">
                        <option></option>
                      <?php foreach ($departement_list as $i) {?>
                            <option value="<?php echo $i['DEPARTEMENT_ID'] ?>"><?php echo $i['DEPARTEMENT_NAME'] ?></option>
                      <?php } ?>
                      </select>
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
            <h4 class="modal-title" id="myModalLabel">Edit Job Title</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
                    <label >Job Title Name</label>
                    <input type="text" class="form-control" id="nameJobTitle" >
            </div>
            <div class="form-group">
                <label>Departement Name</label>
                      <select class="form-control" name="jobtitle_add" id="idDepartement">
                      <?php foreach ($departement_list as $i) {?>
                        <option value="<?php echo $i['DEPARTEMENT_ID'] ?>"><?php echo $i['DEPARTEMENT_NAME'] ?></option>
                      <?php } ?>
                      </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editAdd">Save</button>
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
            <h4 class="modal-title" id="myModalLabel">Delete Job Title</h4>
          </div>
          <div class="modal-body">
            <p>Are You Sure To Delete Job Title? </p> 
          </div>
          <div class="modal-footer">            
            <button type="button" class="btn btn-primary" id="hapus">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>


<script>
    $(document).ready(function(){
        var id_var;
            $('#add_btn').click(function(e) {
                    e.preventDefault();
                    $('#AddModal').modal('show');
                });

            $("#toggleColumn-datatable").on("click", ".del_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#DeleteModal').modal('show');
                    row=$(this).parent().parent();
            });
            $("#toggleColumn-datatable").on("click", ".edit_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#nameJobTitle').val($(this).parent().prev().prev().prev().html());
                    $('#idDepartement').val($(this).parent().prev().html());
                    row=$(this).parent().parent();
                    $('#EditModal').modal('show');
            });

            $("#saveAdd").click(function(e){
                
                $.ajax({
                    url: '<?php echo site_url(); ?>jobtitle/add',
                    type: 'GET',
                    data: {
                        "name_jobtitle": $('#name_JobTitle').val(),
                        "id_departement" : $('#id_Departement').val(),
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
            
            $("#editAdd").click(function(e){
                $.ajax({
                    url: '<?php echo site_url(); ?>jobtitle/edit',
                    type: 'GET',
                    data: {
                        "id_jobtitle": id_var,
                        "name_jobtitle": $('#nameJobTitle').val(),
                        "id_departement": $('#idDepartement').val(),
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
                e.preventDefault();

                    $.ajax({
                        url: '<?php echo base_url()?>jobtitle/delete',
                        type:'GET',
                        data: {
                            "id": id_var
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