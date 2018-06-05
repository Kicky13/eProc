
function popupWarning(title,text){
    var pop = swal({
          title: title,
          text: text,
          type: 'warning',
          confirmButtonColor: '#d33',
          confirmButtonText: 'OK',
          confirmButtonClass: 'btn btn-danger',
          closeOnConfirm: true,
        },function(isConfirm) {                 
            // console.log(isConfirm);
            return isConfirm;
        });       
}

function popupKonfirmasi(lanjut){
  var popup=swal({
            title: 'Konfirmasi',
            text: 'Apakah Anda Yakin?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#92c135',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya',
            cancelButtonClass: 'btn btn-success',
            confirmButtonClass: 'btn btn-danger',
            closeOnConfirm: false,
            // closeOnCancel: true
          },
          function(isConfirm) {  
           console.log(isConfirm);
           lanjut = isConfirm; 
           if(lanjut){
              $("form").submit();
            }
          });
}



$(document).ready(function(){
    var itemize = $("table tr td:contains('Metode Penawaran')").next().html();
    if(itemize!='Itemize'){
        $('.cekitem').each(function(){                
            $(this).prop('checked', true);
        });
    }
    $('#submit-form').click(function(e){
      var lanjut=false;
      popupKonfirmasi(lanjut);
      console.log(lanjut);
      return lanjut;
      
          // e.preventDefault();

    });
    $("form").submit(function(e){    
        var state = false;
        var text ='';
        var title = '';
        var itemize = $("table tr td:contains('Metode Penawaran')").next().html();
        if(itemize=='Itemize'){           
           a=false;
             $('.cekitem').each(function(){                
                if($(this).is(":checked")==true){
                    a= true;
                }
            });
             if(a==false){
                state=false;
                title= 'Item Belum Dipilih';
                text= "Pilih minimal 1 item untuk retender";
             }else{
                state = true;
             }
        }else{
            a=true;
            if($('.cekitem').length>0){
              console.log('item ada');
              $('.cekitem').each(function(){
                  if($(this).is(":checked")==false){
                      a= false;
                  }
              });
            }else{
              a=false;
              console.log('item tidak ada');
            }

             if(a==false){
                state=false;
                title= 'Item Paket Bukan Item Itemize';
                text= "Harus pilih semua item untuk retender";
             }else{
                state = true;
             }
        }

    	if(state == false){        
            popupWarning(title,text);           
            e.preventDefault();                        
            return false;
        }

      

    });
})