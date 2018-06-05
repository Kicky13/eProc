
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Employee Management</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?php echo base_url()?>Employee/form_add" class="main_button color1 small_btn bottom_space pull-right"><i class="in_left ico-plus2"></i> Add Data</a>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="toggleColumn-datatable">
                                <thead>
                                    <tr>
                                        <th>NPP</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                         
                                <tfoot>
                                    <tr>
                                        <th>NPP</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                         
                                <tbody>
                                    <?php foreach ($employee_list_data as $i) {?>
                                        <tr>
                                            <td><?php echo $i['NPP']?></td>
                                            <td><?php echo $i['FIRSTNAME']?> <?php echo $i['LASTNAME']?></td>
                                            <td><?php echo $i['EMAIL']?></td>
                                            <td><?php echo $i['OFFICE_EXTENSION']?></td>
                                            <td class="text-center">
                                            <form action="<?php echo base_url()?>Employee/form_edit" method="POST">
                                                <input style="display:none;" name="employee_id" value="<?php echo $i['EMPLOYEE_ID']?>">
                                                <button class="main_button small_btn bottom_space no_margin_bottom" type="submit">Update</button>
                                            </form>
                                            <!--<a class ="edit_btn" href="#" data-toggle="tooltip" id="<?php echo $i['EMPLOYEE_ID']?>" title="Edit Employee" ><i class="fa fa-edit fa-lg"></i></a>-->
                                            <a class ="del_btn" href="#" data-toggle="tooltip" id="<?php echo $i['EMPLOYEE_ID']?>" title="Delete Employee"><i class="fa fa-trash fa-lg"></i></a>
                                            <a class ="detail_btn" href="#" data-toggle="tooltip" id="<?php echo $i['EMPLOYEE_ID']?>" title="Detail Employee"><i class="fa fa-trash fa-lg"></i></a>
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
    
<!--Detail Employee-->
<div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Position Employee</h4>
          </div>
          <div class="modal-body">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="detail_employee_table">
                <thead>
                    <tr>
                        <th>Job Position</th>
                        <th>Status</th>
                        <th>Main Job</th>
                    </tr>
                </thead>
                <tbody id="detail_display">
                            
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
<!--Delete J-Query -->
 <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Delete Employee</h4>
          </div>
          <div class="modal-body">
            <p>Are You Sure To Delete Employee? </p> 
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
        
          $("#toggleColumn-datatable").on("click", ".del_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#DeleteModal').modal('show');
            });
         $("#toggleColumn-datatable").on("click", ".edit_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    $('#EditModal').modal('show');
            });
         $("#toggleColumn-datatable").on("click", ".detail_btn", function(e) {
                    e.preventDefault();
                    id_var = $(this).attr("id");
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url()?>employee/get_data_person',
                        type:'GET',
                        data: {
                            "id": id_var
                        },
                        success: function(results) {
                            $('#DeleteModal').modal('hide');
                            $('#detail_display').html(results);
                        },
                        error: function(xhr, textStatus, error){
                            alert(xhr.statusText);
                            alert(textStatus);
                            alert(error);
                         }
                    });
                    $('#DetailModal').modal('show');
                    
            });
            $('#hapus').click(function(e){
                e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url()?>employee/delete',
                        type:'GET',
                        data: {
                            "id": id_var
                        },
                        success: function(results) {
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
       
    });            
</script>