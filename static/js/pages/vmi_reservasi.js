var table_income;
$(document).ready(function(){
    var listreservasi = [];
//	table_income = $('#vmi_reservasi_list').DataTable({
//		ajax: location+'/../GetDataReservasi'
//	}); 
        
        $('.cbox').on('click',function(e){
//            posting date => date now
//            doc date=> req_date
//            material
//            plant
//            stage_loc
//            qnt
//            oum
//            ponumber
//            po_item
          docdate = $(this).data('req_date');
          material = $(this).data('material');
          plant = $(this).data('plant');
          STORE_LOC = $(this).data('store_loc');
          REQ_QUAN = $(this).data('req_quan');
          OUM = $(this).data('req_unit');
          PO_NUMBER = $(this).data('po_number');
          PO_ITEM = $(this).data('po_item');
          RES_NO = $(this).data('res_no');
          RES_ITEM = $(this).data('res_item');
          VENDOR = $(this).data('vendor');
          no = $(this).data('no');
          var d = new Date();
          tanggal = ('0'+d.getDate());
          bulan = '0'+(d.getMonth()+1);
          tahun = d.getFullYear();
          POSTING_DATE = tahun+''+ bulan.substr(bulan.length -2)+''+tanggal.substr(tanggal.length -2);
          doc_date = docdate;
          iscek = $(this).is(':checked');
            reservasi = {};
            reservasi["DOC_DATE"] = docdate;
            reservasi["POSTING_DATE"] = POSTING_DATE ;
            reservasi["MATERIAL"] = material;
            reservasi["PLANT"] = plant;
            reservasi["STORE_LOC"] = STORE_LOC;
            reservasi["REQ_QUAN"] = REQ_QUAN;
            reservasi["OUM"] = OUM;
            reservasi["PO_NUMBER"] = PO_NUMBER;
            reservasi["PO_ITEM"] = PO_ITEM;
            reservasi["RES_NO"] = RES_NO;
            reservasi["RES_ITEM"] = RES_ITEM;
            reservasi["VENDOR"] = VENDOR;
          if (iscek)
          {
              listreservasi[no] = reservasi;
//            listreservasi.push(reservasi);
//            listreservasi[no] = reservasi;
//            console.log(listreservasi);
//            console.log(JSON.stringify(listreservasi));   
          }else{
//              console.log(listreservasi[no]);
//              key2 = listreservasi.indexOf(no);
//              alert(key2);
              delete listreservasi[no];
              listreservasi = listreservasi.filter(function (item) {
                 return item !== undefined;
              });
          }
           console.log(listreservasi);
           $("#listreservasi").val(JSON.stringify(listreservasi));
        });
});

// function UpdateTglApproveGR(idlist,idgr)
// {
    // if (confirm("Apakah Anda Yakin ?"))
    // {
        // $.ajax({
           // url:location+'/../updateTglApproveGR',
           // method: "POST",
           // data:{
               // idlist:idlist,
               // idgr:idgr
           // },
           // success:function(data)
           // {
               // location.reload();
           // },
           // error: function()
           // {
               // alert("Opps SomethingError");
           // }
        // });
    // }
// }