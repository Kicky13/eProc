var table_vendor;
$(document).ready(function(){
    var url =document.URL; 
    url = url.split("//").join("/");
    arrurl = url.split("/");
    var segment = arrurl[(arrurl.length)-1];
	table_vendor = $('#vmi_list').DataTable({
		ajax: location+'/../GetDataDB'
	}); 
	table_vendordetail = $('#vmi_vendor_detail').DataTable({
		ajax: location+'/../../GetDetail/'+segment
	}); 
        var namaVendor = $("#selectVendor option:selected").text()
        $("#nameVendor").html(namaVendor);
        $('#modal_maintenanceStock').on('show.bs.modal', function (e) {
              var button = $(e.relatedTarget)
              var id_list = button.data('idlist');
              $("#Nid_list").val(id_list);
              $.ajax({
                url : location+"/../getDataByIdVendor",
                method : "POST",
                data: {idlist: id_list},
                success:function(data){
			hasil = JSON.parse(data);
                        $("#NselectCompany").val(hasil.COMPANYNAME);
                        $("#NselectPlant").val(hasil.PLANT_NAME);
                        $("#NselectMaterial").val(hasil.NAMA_MATERIAL);
                        $("#NkodeMaterial").val(hasil.KODE_MATERIAL);
                        $("#idVendor").val(hasil.KODE_VENDOR);
                        $("#Nquantity").val(hasil.QUANTITY);
                        $("#Npo").val(hasil.NO_PO);
                        $("#Nstock").val(hasil.STOCK_AWAL);
                        $("#NselectVendor").val(hasil.NAMA_VENDOR);
                        $("#namaVendor").html(" "+hasil.NAMA_VENDOR);
                 },
                 error :function() {
                            alert("error");
                    }
                });
        });
        
        $('#modal_maintenanceStock2').on('shown.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var id_list = button.data('idlist'); 
            $("#Nid_list2").val(id_list);
            $.ajax({
                url : location+"/../getDataByIdVendor",
                method : "POST",
                data: {idlist: id_list},
                success:function(data){
			hasil = JSON.parse(data);
                        $("#NselectCompany2").val(hasil.COMPANYNAME);
                        $("#NselectPlant2").val(hasil.PLANT_NAME);
                        $("#NselectMaterial2").val(hasil.NAMA_MATERIAL);
                        $("#NselectVendor2").val(hasil.NAMA_VENDOR);
                        $("#namaVendor2").html(" "+hasil.NAMA_VENDOR);
                        $("#idVendor2").val(hasil.KODE_VENDOR);
                        $("#idMaterial2").val(hasil.KODE_MATERIAL);
                 },
                 error :function() {
                            alert("error");
                    }
                });
        });
});
        function changedata(){
            idvendor = $("#selectVendor").val();
            var namaVendor = $("#selectVendor option:selected").text()
            $("#nameVendor").html(namaVendor);
             table_vendor.ajax.url(location+'/../GetDataDBByVendor/'+idvendor).load();
        }

