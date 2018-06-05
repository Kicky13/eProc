var base_url = $('#base-url').val();
$('.flat-toggle').prev().attr('value', 'Inactive');
var approval_setting_list = [];

$(document).ready(function(){	

	var table_company_view = $('#vmi_company_view').DataTable({
		ajax: location+'/../GetAllPO',
                 "columnDefs": [
                        { className: "dt-body-right", "targets": [ 4,5,6,7,8 ] }
                        ]
	});
	
	
	// var table_company_filter = $('#vmi_company_filter').DataTable({
	// 	ajax: location+'/../GetAllPOFilter',
 //                 "columnDefs": [
 //                        { className: "dt-body-right", "targets": [ 4,5,6,7,8 ] }
 //                        ]
	// });
	
    $('#btnGoFilter').on('click',function(e){
        var cawal = $("#datetimepicker1").val();
        var cakhir = $("#datetimepicker2").val();
        cawal=cawal.split("/").join(".");
        cakhir=cakhir.split("/").join(".");
        table_company_view.ajax.url(location+'/../GetAllPO/'+cawal+'/'+cakhir).load();
    });

    // $(document).on("click","#gofilter",function(){
    //     alert("aaaa");
    // });
	// table_cvendor.ajax.url(location+'/../GetDataRfc').load();
    $('#datetimepicker6').datetimepicker({
            format: 'DD-MM-YYYY'
    });
	$('#datetimepicker7').datetimepicker({
            format: 'DD-MM-YYYY'
    });
    
    $('.input-group.date').datetimepicker({
            format: 'DD-MM-YYYY'
    });
    
    $(".basicselect").select2({
//       placeholder: "Select Company"
    });
    
    $('.basicselect').filter("#NselectCompany").on('select2:select', function (evt) {
        idcomp = $(this).val();
        if (idcomp!=""){
            $.ajax({
                    url: location+'/../m_getSelectPlant',
                    type: 'POST',
                    data: {idcomp: idcomp},
                    beforeSend: function(){
                          $('#NselectPlant').empty();
                    },
                    success:function(data){
			JSONdata = JSON.parse(data);
			$('#NselectPlant').append('<option value="">Choose Plant...</option>');
			    $.each(JSONdata, function(index, val) {
                            $('#NselectPlant option:last').after('<option value="'+val.PLANT_CODE+'">'+val.PLANT_CODE+' - '+val.PLANT_NAME+'</option>');
                            });
                    },
                    error :function() {
                            alert("error");
                         }	
		});
        }else{
            $('#NselectPlant').empty();
            $('#NselectPlant').append('<option value="">Choose Plant...</option>');
        }
    });
    
    $('.basicselect').filter("#PselectCompany").on('select2:select', function (evt) {
        idcomp = $(this).val();
        if (idcomp!=""){
            $.ajax({
                    url: location+'/../m_getSelectPlant',
                    type: 'POST',
                    data: {idcomp: idcomp},
                    beforeSend: function(){
                          $('#PselectPlant').empty();
                    },
                    success:function(data){
			JSONdata = JSON.parse(data);
			$('#PselectPlant').append('<option value="">Choose Plant...</option>');
			    $.each(JSONdata, function(index, val) {
                            $('#PselectPlant option:last').after('<option value="'+val.PLANT_CODE+'">'+val.PLANT_CODE+' - '+val.PLANT_NAME+'</option>');
                            });
                    },
                    error :function() {
                            alert("error");
                         }	
		});
        }else{
            $('#PselectPlant').empty();
            $('#PselectPlant').append('<option value="">Choose Plant...</option>');
        }
    });
    
//    $('.basicselect').filter("#KodeMaterial").on('select2:select', function (evt) {
//        $.ajax({
//                    url: location+'/../getVMIMaterial',
//                    type: 'POST',
//                    data: {ID_PLANT: ID_PLANT},
//                    beforeSend: function(){
//                          $('#PselectMaterial').empty();
//                    },
//                    success:function(data){
//			JSONdata = JSON.parse(data);
//			$('#PselectMaterial').append('<option value="">Choose Material...</option>');
//			 $.each(JSONdata, function(index, val) {
//                                $('#PselectMaterial option:last').after('<option value="'+val.ID_MATERIAL+'">'+val.ID_MATERIAL+' - '+val.NAMA_MATERIAL+'</option>');
//                         });
//                    },
//                    error :function() {
//                            alert("error");
//                         }	
//		});
//    });
    
    $('.basicselect').filter("#PselectPlant").on('select2:select', function (evt) {
        ID_PLANT = $(this).val();
        if (ID_PLANT!=""){
            $.ajax({
                    url: location+'/../getVMIMaterial',
                    type: 'POST',
                    data: {ID_PLANT: ID_PLANT},
                    beforeSend: function(){
                          $('#PselectMaterial').empty();
                    },
                    success:function(data){
			JSONdata = JSON.parse(data);
			$('#PselectMaterial').append('<option value="">Choose Material...</option>');
			 $.each(JSONdata, function(index, val) {
                                $('#PselectMaterial option:last').after('<option value="'+val.KODE_MATERIAL+'">'+val.KODE_MATERIAL+' - '+val.NAMA_MATERIAL+'</option>');
                         });
                    },
                    error :function() {
                            alert("error");
                         }	
		});
        }else{
            $('#PselectMaterial').empty();
            $('#PselectMaterial').append('<option value="">Choose Material...</option>');
        }
    });
    
    $('#btncariNNOPO').on('click',function(e){
        nopo = $("#NNOPO").val();
        opco = $("#NselectCompany").val();
        material = $("#NkodeMaterial").val();
        if (nopo!==""){
            $.ajax({
                    url: location+'/../getDataByNOPO',
                    type: 'POST',
                    data: {NOPO: nopo,
                           OPCO: opco,
                           MATERIAL: material,
                          },
                    beforeSend: function(){
                        $('#NselectPlant').empty();
                        $('#NselectVendor').empty();
//                        $('#NselectMaterial').empty();
                    },
                    success:function(data){
//                      alert(JSON.stringify(data));
			ArrData = JSON.parse(data);
                        plant="";
                        plant_name="";
                        vendor_no="";
                        vendor_id="";
                        vendor_name="";
                        kode_material="";
                        material_name="";
                        id_material="";
                        if (Object.keys(ArrData).length>0)
                        {
                            $.each(ArrData,function(idx,obj){
                                plant = obj.PLANT;
                                plant_name = obj.PLANT_NAME; 
                                vendor_no = obj.VENDOR_NO;
                                vendor_name = obj.VENDOR_NAME; 
                                vendor_id = obj.VENDOR_ID; 
                                kode_material = obj.KODE_MATERIAL;
                                material_name = obj.MATERIAL_NAME; 
                                id_material = obj.ID_MATERIAL; 
                                po_item = obj.PO_ITEM; 
                                sloc = obj.SLOC; 
                                doc_date = obj.DOC_DATE; 
                                unit = obj.UNIT; 
                            });
                             $("#NselectPlant").val(plant_name);
                             $("#NkodePlant").val(plant); 
                             $("#NselectVendor").val(vendor_name);
                             $("#NkodeVendor").val(vendor_no); 
                             $("#NidVendor").val(vendor_id); 
                            $("#NselectMaterial").val(material_name);                              
                             $("#NkodeMaterial").val(kode_material);
                             $("#Nnamamaterial").val(material_name);
                             $("#NidMaterial").val(id_material);
                             $("#Ndocdate").val(doc_date);
                             $("#Nsloc").val(sloc);
                             $("#Npoitem").val(po_item);
                             $("#Nunit").val(unit);
                             
                             $.ajax({
                                url: location+'/../getMINMAXRFCbyMaterial',
                                type: 'POST',
                                data: {KODE_MATERIAL: kode_material},
                                beforeSend: function(){
                                    $('#Nmin').empty();
                                    $('#Nmax').empty();
                                },
                                success:function(data){
                                    ArrData = JSON.parse(data);
                                    console.log(ArrData);
                                    min =0;
                                    max =0;
                                    $.each(ArrData,function(idx,obj){
                                       min = parseInt(obj.MIN);
                                       max = parseInt(obj.MAX); 
                                    });
                                    $('#Nmin').val(min);
                                    $('#Nmax').val(max);
                                    $('#datetimepicker6').data("DateTimePicker").date('01-10-2017');
                                    $('#datetimepicker7').data("DateTimePicker").date('30-09-2018');
                                 },
                                    error :function() {
                                 }	
                        });
                        }else{
                            alert("Nomer PO tidak ditemukan");
                        }
                    },
                    error :function() {
                         }	
		});
        }else{
            alert("Nomer PO tidak boleh kosong");
        }
    })
    
    $('.basicselect').filter("#PselectMaterial").on('select2:select', function (evt) {
        ID_MATERIAL = $(this).val();
        vendor = $("#NselectVendor").val();
//        company = $("#NselectCompany").val();
        plant = $("#PselectPlant").val();
//        alert(company+" - "+vendor);
        if (ID_MATERIAL!=""){
            $.ajax({
                    url: location+'/../getMINMAXPrognose',
                    type: 'POST',
                    data: {ID_MATERIAL: ID_MATERIAL},
                    beforeSend: function(){
                        $('#Pmin').empty();
                        $('#Pmax').empty();
                    },
                    success:function(data){
			ArrData = JSON.parse(data);
                        min =0;
                        max =0;
                        $.each(ArrData,function(idx,obj){
                           min = parseInt(obj.MIN);
                           max = parseInt(obj.MAX); 
                        });
                        $('#Pmin').val(min);
                        $('#Pmax').val(max);
                    },
                    error :function() {
                         }	
		});
        }else{
            $('#Pmin').empty();
            $('#Pmax').empty();
        }
    });
    ///////////////////////////////////////////////////////////////////////////
    $('.basicselect').filter("#NselectMaterial").on('select2:select', function (evt) {
        ID_MATERIAL = $(this).val();
        vendor = $("#NselectVendor").val();
        company = $("#NselectCompany").val();
        plant = $("#NselectPlant").val();
//        alert(company+" - "+vendor);
        if (ID_MATERIAL!=""){
            $.ajax({
                    url: location+'/../getMINMAX',
                    type: 'POST',
                    data: {ID_MATERIAL: ID_MATERIAL},
                    beforeSend: function(){
                        $('#Nmin').empty();
                        $('#Nmax').empty();
                    },
                    success:function(data){
			ArrData = JSON.parse(data);
                        min =0;
                        max =0;
                        $.each(ArrData,function(idx,obj){
                           min = parseInt(obj.MIN_STOCK);
                           max = parseInt(obj.MAX_STOCK); 
                        });
                        $('#Nmin').val(min);
                        $('#Nmax').val(max);
                        $('#datetimepicker6').data("DateTimePicker").date('01-10-2017');
                        $('#datetimepicker7').data("DateTimePicker").date('30-09-2018');
//                        $("#NActiveContract").val('01-10-2017');
//                        $("#NEndContract").val('31-09-2018');
                        $.ajax({
                            type: "post",
                            url: "location+'/../GetNomerPo",
                            data: {
                                company:company,
                                plant:plant,
                                vendor:vendor
                            },
                            success: function (data) {
//                                prompt("",JSON.stringify(data));
                                ArrData = JSON.parse(data);
                                length = Object.keys(ArrData).length;
                                if (length>0){
                                    var nomerpo;
                                    $.each(ArrData,function(idx,obj){
                                        nomerpo = obj.NOMER_PO;
                                    });
                                    $("#NNOPO").val(nomerpo);
                                }else{
                                    alert("Nomer PO tidak ditemukan");
                                }
                            }
                        });
                    },
                    error :function() {
                         }	
		});
        }else{
            $('#Nmin').empty();
            $('#Nmax').empty();
        }
    });
});

function listmaterial(){
	vplant = $("#selectPlant").val();
	if (vplant!=""){
		$.ajax({
			url: location+'/../GetSelectMaterial',
			type: 'POST',
			data: {plant: vplant},
			beforeSend: function(){
				$('#selectMaterial').empty();
			},
			success:function(data){
				JSONdata = JSON.parse(data);
				$('#selectMaterial').append('<option value="">Choose Material...</option>');
			    $.each(JSONdata, function(index, val) {
					 $('#selectMaterial option:last').after('<option value="'+val.KODE_MATERIAL+'">'+val.NAMA_MATERIAL+'</option>');
				});
			;
			},
			error :function() {
					alert("error");
				}	
		});
	}
}

function Nlistplant(){
	vcompany = $("#NselectCompany").val();
	if (vcompany!=""){
		$.ajax({
			url: location+'/../GetSelectPlant',
			type: 'POST',
			data: {company: vcompany},
			beforeSend: function(){
				$('#selectVendor').empty();
			},
			success:function(data){
				JSONdata = JSON.parse(data);
				$('#selectVendor').append('<option value="">Choose Vendor...</option>');
			    $.each(JSONdata, function(index, val) {
					 $('#selectVendor option:last').after('<option value="'+val.KODE_VENDOR+'">'+val.NAMA_VENDOR+'</option>');
				});
			;
			},
			error :function() {
					alert("error");
				}	
		});
	}
}

function listvendor(){
	vmaterial = $("#selectMaterial").val();
	if (vmaterial!=""){
		$.ajax({
			url: location+'/../GetSelectVendor',
			type: 'POST',
			data: {material: vmaterial},
			beforeSend: function(){
				$('#selectVendor').empty();
			},
			success:function(data){
				JSONdata = JSON.parse(data);
				$('#selectVendor').append('<option value="">Choose Vendor...</option>');
			    $.each(JSONdata, function(index, val) {
					 $('#selectVendor option:last').after('<option value="'+val.KODE_VENDOR+'">'+val.NAMA_VENDOR+'</option>');
				});
			;
			},
			error :function() {
					alert("error");
				}	
		});
	}
}

