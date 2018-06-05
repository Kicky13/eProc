  <section>
        <div class="warper container-fluid">
            
            <div class="page-header"><h1>User Management </h1></div>
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
        <div class="row">
            <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Personal Details</div>
                        <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Employee Name</label>
                                <div class="col-sm-7">
                                    <p class="form-control-static" id="emp_name">-</p>
                                    
                                </div>
                                <div class="col-sm-1">
                                <a class ="add_emp" href="#" data-toggle="tooltip" title="Add Data Employee"><b class="btn btn-primary btn-sm"><b class="fa fa-bars fa-2x" ></b></b></a>
                                    
                                    </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email Address</label>
                                <div class="col-sm-9">
                                    <p class="form-control-static" id="emp_email">-</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Office Exstension</label>
                                <div class="col-sm-9">
                                    <p class="form-control-static" id="emp_office">-</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Position</label>
                                <div class="col-sm-9">
                                    <p class="form-control-static" id="emp_position">-</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Departement</label>
                                <div class="col-sm-9">
                                    <p class="form-control-static" id="emp_departement">-</p>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">User Management Information</div>
                    <div class="panel-body">    
                    <form method="post" class="form-horizontal validator-form" action="">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" id="username" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" id="password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="confirmPassword" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Locked</label>
                            <div class="col-sm-9">
                            <label class="cr-styled">
                                <input type="checkbox" id="locked_emp">
                                <i class="fa"></i> 
                            </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Approved Comodity</label>
                            <div class="col-sm-9">
                            <label class="cr-styled">
                                <input type="checkbox" id="app_emp">
                                <i class="fa"></i> 
                            </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5">
                                <button class="btn btn-primary" id="userSave">Save</button>
                                <a href="<?php echo base_url()?>user" class="btn btn-info">Cancel</a>
                            </div>
                        </div>      
                    </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="container-fluid footer">
            Copyright &copy; 2014 <a href="">DigIs Indonesia</a>
            <a href="#" class="pull-right scrollToTop"><i class="fa fa-chevron-up"></i></a>
        </footer>    
    </section>

    <div class="modal fade" id="AddEmpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div  style="margin:10% ">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
            <h4 class="modal-title" id="myModalLabel">Choose Employee</h4>
          </div>
          <div class="modal-body">
              <div class="panel-body">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="toggleColumn-datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>NPP</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                     
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>NPP</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>
                                    <?php foreach ($employee_list as $i) {?>
                                            <tr>
                                                <!--<td style="display:none"><?php echo $i['EMPLOYEE_ID']?></td>-->
                                                <td><?php echo $i['FIRSTNAME']?> <?php echo $i['LASTNAME']?></td> 
                                                <td><?php echo $i['POSITION_NAME']?></td>
                                                <td style="display:none;"><?php echo $i['DEPARTEMENT_NAME']?></td>
                                                <td><?php echo $i['NPP']?></td>
                                                <td><?php echo $i['EMAIL']?></td>
                                                <td><?php echo $i['OFFICE_EXTENSION']?></td>
                                                <td>
                                                 <a class ="add_employee" href="#" data-toggle="tooltip" title="Add Eployee"  id="<?php echo $i['EMPLOYEE_ID']?>"><b class="btn btn-info" >Add</b></a>
                                                </td>    
                                            </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
      </div>
    </div>
    <div id ="wow">

    </div>
    <script>
      $(document).ready(function(){
        $('#AddEmpModal').modal('show');
        var currentdate = new Date(); 
        var datetime = currentdate.getFullYear() + "-"
                    + (currentdate.getMonth()+1) + "-" 
                    + currentdate.getDate() + " "  
                    + currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds();


        var id_emp, name_emp, tel_emp, email_emp, position_emp, npp_emp,depart_emp;
        var emp_app,  emp_locked;
        $('.add_emp').click(function()
        {
          $('#AddEmpModal').modal('show');
        });
        $('.add_employee').click(function(){
            id_emp = $(this).attr("id"); 
            tel_emp = $(this).parent().prev().html();
            email_emp= $(this).parent().prev().prev().html();
            npp_emp = $(this).parent().prev().prev().prev().html();
            depart_emp = $(this).parent().prev().prev().prev().prev().html();
            position_emp = $(this).parent().prev().prev().prev().prev().prev().html();
            name_emp = $(this).parent().prev().prev().prev().prev().prev().prev().html();
            $('#emp_name').html(name_emp);
            $('#emp_email').html(email_emp);
            $('#emp_office').html(tel_emp);
            $('#emp_position').html(position_emp);
            $('#emp_departement').html(depart_emp);
            $("#AddEmpModal").modal('hide');
         
        }) 
        
        $('#userSave').click(function()
        {
            if($("#app_emp").is(':checked'))
            {
                emp_app = 1;
            }
            else
            {
                emp_app = 0;
            }
            if($("#locked_emp").is(':checked'))
            {
                emp_locked = 1;
            }
            else
            {
                emp_locked = 0;
            }

            $('#AddEmpModal').modal('hide');
             $.ajax({
                        url: '<?php echo base_url()?>user/add',
                        type:'GET',
                        data: {
                            "id": id_emp,
                            "username" : $('#username').val(),
                            "password" : $('#password').val(),
                            "is_locked": emp_locked,
                            "is_comodity" : emp_app,
                            "date" : datetime

                        },
                        success: function(results) {
                            $("#addSuccess").show();
                             window.setTimeout(function(){location.reload()},1000);   
                        },
                        error: function(){
                            $("#editSuccess").show();
                            //('button').attr('enabled');
                         }
                });
        });

      });
    </script>