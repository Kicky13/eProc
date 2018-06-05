
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
                        
                          <form method="post" class="form-horizontal validator-form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">No. Pokok Pegawai (NPP)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="NPP" id="npp"/>
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
                          
                            <div id="template">
                            <form method="post" class="form-horizontal validator-form">
                                  <!--<div class="form-group">
                                      <label class="col-sm-3 control-label">District</label>
                                      <div class="col-sm-9">
                                          <select class="form-control" name="district" id="district">
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-3 control-label">Department</label>
                                      <div class="col-sm-9">
                                          <select class="form-control" name="departement" id="departement">
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-3 control-label">Job Title</label>
                                      <div class="col-sm-9">
                                          <select class="form-control" name="jobtitle" id="jobtitle">
                                          <option value="">--</option>
                                          <?php foreach ($jobtitle as $i) {?>
                                              <option value="<?php echo $i['JOBTITLE_ID'] ?>" ><?php echo $i['JOBTITLE_NAME'] ?></option>       
                                          <?php } ?>
                                          </select>
                                      </div>
                                  </div>-->
                                  <div class="form-group">
                                      <label class="col-sm-3 control-label">Job Position</label>
                                      <div class="col-sm-9">
                                          <select class="form-control" name="jobPosition" id="jobposition">
                                          <?php foreach ($job_position as $i) {?>
                                              <option value="<?php echo $i['POSITION_ID'] ?>" class="<?php echo $i['JOBTITLE_ID'] ?>"><?php echo $i['POSITION_NAME'] ?></option>       
                                          <?php } ?>
                                          </select>
                                      </div>
                                  </div>
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
      </section>
  <script>
    !function(a){"use strict";a.fn.remoteChained=function(b){var c=a.extend({},a.fn.remoteChained.defaults,b);return c.loading&&(c.clear=!0),this.each(function(){function b(b){var c=a(":selected",d).val();a("option",d).remove();var e=[];if(a.isArray(b))e=a.isArray(b[0])?b:a.map(b,function(b){return a.map(b,function(a,b){return[[b,a]]})});else for(var f in b)b.hasOwnProperty(f)&&e.push([f,b[f]]);for(var g=0;g!==e.length;g++){var h=e[g][0],i=e[g][1];if("selected"!==h){var j=a("<option />").val(h).append(i);a(d).append(j)}else c=i}a(d).children().each(function(){a(this).val()===c+""&&a(this).attr("selected","selected")}),1===a("option",d).size()&&""===a(d).val()?a(d).prop("disabled",!0):a(d).prop("disabled",!1)}var d=this,e=!1;a(c.parents).each(function(){a(this).bind("change",function(){var f={};a(c.parents).each(function(){var b=a(this).attr(c.attribute),e=(a(this).is("select")?a(":selected",this):a(this)).val();f[b]=e,c.depends&&a(c.depends).each(function(){if(d!==this){var b=a(this).attr(c.attribute),e=a(this).val();f[b]=e}})}),e&&a.isFunction(e.abort)&&(e.abort(),e=!1),c.clear&&(c.loading?b.call(d,{"":c.loading}):a("option",d).remove(),a(d).trigger("change")),e=a.getJSON(c.url,f,function(c){b.call(d,c),a(d).trigger("change")})}),c.bootstrap&&(b.call(d,c.bootstrap),c.bootstrap=null)})})},a.fn.remoteChainedTo=a.fn.remoteChained,a.fn.remoteChained.defaults={attribute:"name",depends:null,bootstrap:null,loading:null,clear:!1}}(window.jQuery||window.Zepto,window,document);

  </script>
	<script>
    !function(a,b){"use strict";a.fn.chained=function(c){return this.each(function(){function d(){
      var d=!0,g=a("option:selected",e).val();a(e).html(f.html());var h="";a(c).each(function(){
        var c=a("option:selected",this).val();c&&(h.length>0&&(h+=b.Zepto?"\\\\":"\\"),h+=c)});
      var i;i=a.isArray(c)?a(c[0]).first():a(c).first();var j=a("option:selected",i).val();a("option",e).each(function(){
        a(this).hasClass(h)&&a(this).val()===g?(a(this).prop("selected",!0),d=!1):a(this).hasClass(h)||a(this).hasClass(j)||""===a(this).val()||a(this).remove()}),1===a("option",e).size()&&""===a(e).val()?a(e).prop("disabled",!0):a(e).prop("disabled",!1),d&&a(e).trigger("change")}var e=this,f=a(e).clone();a(c).each(function(){a(this).bind("change",function(){d()}),a("option:selected",this).length||a("option",this).first().attr("selected","selected"),d()})})},a.fn.chainedTo=a.fn.chained,a.fn.chained.defaults={}}(window.jQuery||window.Zepto,window,document);
  </script>
  
  <script>
  $(document).ready(function(){
    var get_table = $("#workTable tbody");
    $('#add_employee').click(function(e) {
        var npp_val = $('#npp').val()
        e.preventDefault();
        $.ajax({
          url: '<?php echo site_url(); ?>employee/add_employee',
          type: 'GET',
          data: {
              "npp": npp_val,
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
                  "npp": npp_val,
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
         // $("#dicky").html($('#npp').val()+" "+jobposition +" "+ active + " "+main_job);
        });
      });
      
    $(function(){
        $("#addData").bind("click", Add);
        $(".btnDelete").bind("click",Delete);
        
        $("#jobtitle").chained("#jobposition");
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