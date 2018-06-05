var table_income;
$(document).ready(function(){
	table_income = $('#vmi_grgi_list').DataTable({
		ajax: location+'/../GetDataDBGr'
	}); 
        
});

function UpdateTglApproveGR(idlist,idgr)
{
    if (confirm("Apakah Anda Yakin ?"))
    {
        $.ajax({
           url:location+'/../updateTglApproveGR',
           method: "POST",
           data:{
               idlist:idlist,
               idgr:idgr
           },
           success:function(data)
           {
               location.reload();
           },
           error: function()
           {
               alert("Opps SomethingError");
           }
        });
    }
}