  <section>
  <link href='<?php echo base_url("static/css/fonts/raleway.css") ?>' rel='stylesheet' type='text/css'>
                <div class="page-header" style='margin-left:3%;margin-right:3%;'><h3> User Management</h3></div>
                <div id="addSuccess" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> Data has been succesfully Added
                    </div>
                    <div id="delSuccess" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> Data has been succesfully Deleted
                    </div>
                    <div id="editSuccess" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> Data has been succesfully Edited
                    </div>
                
                <div class="panel panel-default"style='margin-left:3%;margin-right:3%;'>
                    <div class="panel-heading">
                        <a href="<?php echo base_url()?>user/form_add" class="btn btn-primary btn-sm">Add Data</a>                       
                        </br></br>
                    </div>
                    <div class="panel-body">
                        
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="toggleColumn-datatable">
                            <thead>                                
                                <tr>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Departement</th>
                                    <th>District</th>
                                    <th>Position</th>
                                    <th>Locked</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                     
                            <tfoot>
                                <tr>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Departement</th>
                                    <th>District</th>
                                    <th>Position</th>
                                    <th>Locked</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>
                                    <?php foreach ($user_list_data as $i) {?>
                                            <tr>
                                                <td><?php echo $i['USERNAME']?></td>
                                                <td><?php echo $i['FIRSTNAME']?> <?php echo $i['LASTNAME']?></td>
                                                <td><?php echo $i['DEPARTEMENT_NAME']?></td>
                                                <td><?php echo $i['DISTRICT_NAME']?></td>
                                                <td><?php echo $i['POSITION_NAME']?></td>
                                                <td><?php echo $i['IS_LOCKED']?></td>
                                                <td style="display:none;"><?php echo $i['IS_COMODITY']?></td>
                                                <td>
                                                <a class ="edit_btn" href="#" data-toggle="tooltip" title="Edit User" id="<?php echo $i['USER_ID']?>"><i class="fa fa-edit fa-lg"></i></a>
                                                <a class ="del_btn" href="#" data-toggle="tooltip" id="<?php echo $i['USER_ID']?>" title="Delete User"><i class="fa fa-trash fa-lg"></i></a>
                                                <a class ="reset_btn" href="#" data-toggle="tooltip" id="<?php echo $i['USER_ID']?>" title="Reset User"><i class="fa fa-reply fa-lg"></i></a>
                                                </td>    
                                            </tr>
                                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                
             
        
        <footer class="container-fluid footer">
            Copyright &copy; 2015 DigIS Indonesia  
            <a href="#" class="pull-right scrollToTop"><i class="fa fa-chevron-up"></i></a>
        </footer>



<!--Delete-->
 <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Delete User</h4>
          </div>
          <div class="modal-body">
            <p>Are You Sure To Delete User? </p> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger" id="hapus">Yes</button>
          </div>
        </div>
      </div>
    </div>
<!--Reset-->
 <div class="modal fade" id="ResetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Reset User</h4>
          </div>
          <div class="modal-body">
            <p>Are You Sure To Reset User? </p> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger" id="reset">Yes</button>
          </div>
        </div>
      </div>
    </div>
<!--edit-->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Edit User</h4>
          </div>
          <div class="modal-body">
                <div class="form-group">
                    <label>Locked</label>
                    <div class="col-lg-1">
                    <label class="cr-styled">
                        <input type="checkbox" id="locked_emp">
                        <i class="fa"></i> 
                    </label>
                    </div>
            </div>
            <div class="form-group">
                   <label>Approved Comodity</label>
                <div class="col-lg-1">
                <label class="cr-styled">
                    <input type="checkbox" id="app_emp">
                    <i class="fa"></i> 
                </label>
                </div>

            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editData">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
<div id="dump">
</div>
<script>
    var id_var,com_var,lock_var;
    $(document).ready(function(){
            $("#toggleColumn-datatable").on("click", ".del_btn", function(e) {
            //row = $(this).parent.parent();

                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#DeleteModal').modal('show');
            });
            $("#toggleColumn-datatable").on("click", ".edit_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    lock_var = $(this).parent().prev().prev().html();
                    com_var = $(this).parent().prev().html();
                    if(com_var == '1')
                    {
                        $( "#app_emp").prop('checked', true);
                    }
                    else
                    {
                        $( "#app_emp").prop('checked', false);   
                    }
                     if(lock_var == '1')
                    {
                        $( "#locked_emp").prop('checked', true);
                    }
                    else
                    {
                        $( "#locked_emp").prop('checked', false);   
                    }
                    $('#dump').html(id_var+" "+lock_var+" "+com_var);
                    $('#EditModal').modal('show');
            });

              $("#toggleColumn-datatable").on("click", ".reset_btn", function(e) {
            //row = $(this).parent.parent();

                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#ResetModal').modal('show');
            });
            $('#hapus').click(function(e){
                e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url()?>User/delete',
                        type:'GET',
                        data: {
                            "id": id_var
                        },
                        success: function(results) {
                            //$("#page_container").html(results);
                            $("#delSuccess").show();
                            $('#DeleteModal').modal('hide');
                              window.setTimeout(function(){location.reload()},1000);    
                        },
                        error: function(xhr, textStatus, error){
                            alert(xhr.statusText);
                            alert(textStatus);
                            alert(error);
                         }
                });
            });
            $('#reset').click(function(e){
                e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url()?>User/reset',
                        type:'GET',
                        data: {
                            "id": id_var
                        },
                        success: function(results) {
                            //$("#page_container").html(results);
                            $("#delSuccess").show();
                            $('#ResetModal').modal('hide');
                            //window.setTimeout(function(){location.reload()},1000);    
                        },
                        error: function(xhr, textStatus, error){
                            alert(xhr.statusText);
                            alert(textStatus);
                            alert(error);
                         }
                });
            });
            $('#editData').click(function(e){
                if($("#app_emp").is(':checked'))
                {
                    com_var = 1;
                }
                else
                {
                    com_var = 0;
                }
                if($("#locked_emp").is(':checked'))
                {
                    lock_var = 1;
                }
                else
                {
                    lock_var = 0;
                }
                $('#dump').html(id_var+" "+lock_var+" "+com_var);
                e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url()?>user/edit',
                        type:'GET',
                        data: {
                            "id": id_var,
                            "locked": lock_var,
                            "comodity": com_var
                        },
                        success: function(results) {
                            //$("#page_container").html(results);
                            $("#editSuccess").show();
                            $('#EditModal').modal('hide');
                              window.setTimeout(function(){location.reload()},1000);    
                        },
                        error: function(){
                             $("#editSuccess").show();
                         }
                });
            });
       
    });            
</script>

</section>