
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Employee Management</h2>
                    </div>
            <div class="row">
            	<div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Employee Management Information</div>
                        <div class="panel-body">
                        
                        	<form method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">No. Pokok Pegawai (NPP)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="NPP" id="npp" value="<?php echo $id ?>" />
                                    </div>
                                </div>
          								
          								
          								<div class="form-group">
                                  <label class="col-sm-3 control-label">Salutation</label>
                                  <div class="col-sm-9">
                                      <select class="form-control" name="salutation" id="salutation">
                                      <?php foreach ($salutation as $i) {?>
                                        <option value="<?php echo $i['SALUTATION_ID'] ?>"><?php echo $i['SALUTATION_NAME'] ?></option>
                                      
                                      <?php } ?>
                                      </select>
                                  </div>
                              </div>
          								
                          <div class="form-group">
                                <label class="col-sm-3 control-label">Employee Type</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="employee type" id="employee_type">
                                    <?php foreach ($employee_type as $i) {?>
                                      <option value="<?php echo $i['EMPLOYEE_TYPE_ID'] ?>"><?php echo $i['EMPLOYEE_TYPE_NAME'] ?></option>
                                    
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
          								
          								<div class="form-group">
                                    <label class="col-sm-3 control-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="firstName" id="firstname"/>
                                    </div>
                                </div>
          								
          								<div class="form-group">
                              <label class="col-sm-3 control-label">Last Name</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="lastName" id="lastname"/>
                              </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-sm-3 control-label">Gender</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="gender" id="gender">
                                    <?php foreach ($gender as $i) {?>
                                      <option value="<?php echo $i['GENDER_ID'] ?>"><?php echo $i['GENDER_NAME'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                        </div>
                        </br></br>
                        

                        </div>
          </div>
          <div class="col-md-6">
					  <div class="panel panel-default">
                        <div class="panel-heading">Company Information</div>
                        <div class="panel-body">
                        
                        	<form method="post" class="form-horizontal validator-form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" id="email"/>
                                    </div>
                                </div>
								                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Office Extention</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="phoneNumber" id="phone"/>
                                    </div>
                                </div>
                            </form>
                        </div>
            </div>
            <div class="panel panel-default">
                        <div class="panel-heading">Position Details</div>
                        <div class="panel-body">
                        
                          <form method="post" class="form-horizontal validator-form" >
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Job Position</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="jobPosition" id="jobposition">
                                        <?php foreach ($job_position as $i) {?>
                                                    <option value="<?php echo $i['POSITION_ID'] ?>"><?php echo $i['POSITION_NAME'] ?></option>
                                                  
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <!--
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Department</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="jobPosition">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Job Position</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="jobPosition">
                                        </select>
                                    </div>
                                </div>
                                -->
                                
                                <div class="form-group">
                                  <label class="col-sm-3 control-label" >Active</label>
                                  <div class="col-sm-2">
                                      <label class="cr-styled">
                                        <input type="checkbox" id="active_emp">
                                        <i class="fa"></i> 
                                      </label>
                                  </div>
                                  <label class="col-sm-2 control-label">Main Job</label>
                                  <div class="col-sm-2">
                                      <label class="cr-styled">
                                          <input type="checkbox" id="main_job_emp">
                                          <i class="fa"></i> 
                                      </label>
                                  </div>
                                </div>
                              
                                
                                
                                <div class="form-group">
                                <div class="col-sm-offset-5">
                                  <button type="button" class="btn btn-primary" id="addData">Add</button>
                                </div>
                                </div>    
                         </form>
                        </div>
                </div>
          </div>
      </div>
					
      <div class="panel panel-default">
        <div class="panel-heading">Position List</div>
            <div class="panel-body">
                <div class="panel-body" id="workTable">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="toggleColumn-datatable">
                            <thead>
                                <tr>
                                    <th>Job Position</th>
                                    <th>Status</th>
                                    <th>Main Job</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                            </tbody>
                        </table>
                </div>
                <div class="col-sm-offset-5">
                    <button type="button" class="btn btn-primary" id="add_employee">Add Employee</button>
                     <a href="<?php echo base_url()?>Employee" class="btn btn-info">Cancel</a>
                </div>
            </div>
      </div>
            </div>
        </div>
      </div>
    </section>
	
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
    var get_table = $("#workTable tbody");
    $('#add_employee').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: '<?php echo site_url(); ?>employee/add_employee',
          type: 'GET',
          data: {
              "npp": $('#npp').val(),
              "salutation" : $('#salutation').val(),
              "employee_type" : $('#employee_type').val(),
              "firstname" : $('#firstname').val(),
              "lastname" : $('#lastname').val(),
              "email" : $('#email').val(),
              "phone" : $('#phone').val(),
              "gender" : $('#gender').val()
          },
           error: function(xhr, textStatus, error){
                            alert(xhr.statusText);
                            alert(textStatus);
                            alert(error);
                         }
        });        
        var active,main_job;    
        get_table.find('tr').each(function (i) {
        var $tds = $(this).find('td'),
            jobposition = $tds.eq(1).text();
            if($tds.eq(2).text()=='active')
            {
              active = 1;   
            }
            else
            {
              active = 0;
            }
            if($tds.eq(3).text()=='main job')
            {
              main_job = 1;
            }
            else
            {
              main_job = 0;
            }
            $.ajax({
              url: '<?php echo site_url(); ?>employee/add_employee_position',
              type: 'GET',
              data: {
                  "npp": $('#npp').val(),
                  "jobposition" : jobposition,
                  "active" : active,
                  "main_job" : main_job
            },
            error: function(xhr, textStatus, error){
                            alert(xhr.statusText);
                            alert(textStatus);
                            alert(error);
                         }
          });
          $("#dicky").html($('#npp').val()+" "+jobposition +" "+ active + " "+main_job);
        });
      });
    $(function(){
        $("#addData").bind("click", Add);
        $(".btnDelete").bind("click",Delete);
      });
    function Add(){
        var jobposition_id = $("#jobposition").val();
        var jobposition_name = $( "#jobposition option:selected" ).text();
        if($("#active_emp").is(':checked'))
        {
            var active_emp = 'active';
        }
        else
        {
          var active_emp = 'non-active';
        }
        if($("#main_job_emp").is(':checked'))
        {
            var main_job_emp = 'main job';
        }
        else
        {
          var main_job_emp = 'non-main job';
        }
        $("#workTable tbody").append(
          "<tr>"+
          "<td>"+jobposition_name+"</td>"+
          "<td style='display:none'>" +jobposition_id+ "</td>"+
          "<td>"+active_emp+"</td>"+
          "<td>"+main_job_emp+"</td>"+
          "<td><a class='btnDelete'><i class='fa fa-remove fa-lg'></i></a></td>"+
          "</tr>"); 
          $(".btnDelete").bind("click", Delete);
    };

    function Delete(){
        var par = $(this).parent().parent(); //tr
        par.remove();
    }
  });
  </script>