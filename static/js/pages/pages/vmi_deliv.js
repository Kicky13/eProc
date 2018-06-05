var table_income;
var ArrIDX=[];
$(document).ready(function(){
     var listreceive = [];
	table_income = $('#vmi_deliv_list').DataTable({
		ajax: location+'/../GetDataDBDeliv'
	}); 
        
    $(document).on("click",".cbox",function(){
          nopo = $(this).data('nopo');
          plant_id = $(this).data('plant_id');
          no = $(this).data('no');
          id_list = $(this).data('id_list');
          id_pengiriman = $(this).data('id_pengiriman');
          id_material = $(this).data('id_material');
          var d = new Date();
          tanggal = ('0'+d.getDate());
          bulan = '0'+(d.getMonth()+1);
          tahun = d.getFullYear();
          POSTING_DATE = tahun+''+ bulan.substr(bulan.length -2)+''+tanggal.substr(tanggal.length -2);
          doc_date = POSTING_DATE;    //'sm kyk date po'
          qty_recieve = $("#text"+no).val();
          receive = {};
            receive["DOC_DATE"] = doc_date;
            receive["POSTING_DATE"] = POSTING_DATE ;
            receive["NOPO"] = nopo;
            receive["PLANT"] = plant_id;
            receive["QTY_RECEIVE"] = qty_recieve;
            receive["ID_LIST"] = id_list;
            receive["ID_PENGIRIMAN"] = id_pengiriman;
            receive["ID_MATERIAL"] = id_material;
          iscek = $(this).is(':checked');
          if (iscek)
          {
              listreceive.push(receive);
              ArrIDX.push(no);
          }else{
             idx = ArrIDX.indexOf(no);
             delete listreceive[idx];
             listreceive = listreceive.filter(function (item) {
                 return item !== undefined;
              });

             delete ArrIDX[idx];
             ArrIDX = ArrIDX.filter(function (item) {
                 return item !== undefined;
              });
          }
           console.log(listreceive);
           $("#listreceive").val(JSON.stringify(listreceive));
    });
});

//function UpdateTglTerima(idlist,idpengiriman,cbox)
//{ 
//    if (confirm("Apakah Anda Yakin ?"))
//    {
//        $.ajax({
//           url:location+'/../updateStatusKirim',
//           method: "POST",
//           data:{
//               idlist:idlist,
//               idpengiriman:idpengiriman
//           },
//           success:function(data)
//           {
//               location.reload();
//           },
//           error: function()
//           {
//               alert("Opps SomethinError");
//           }
//        });
//    }else{
//        var a = $("#"+cbox).is(':checked');
//        alert(a);
//    }
//}