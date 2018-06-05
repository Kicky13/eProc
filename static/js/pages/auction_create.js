function numberWithCommas(x) {
    if (isNaN(x)) return x;
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function removeCommas(x) {
    return x.replace(/,/g, "");
}

$('.input-group.date').datetimepicker({
	format: 'DD-MMM-YY HH:mm',
	// sideBySide: true,
	ignoreReadonly: true
});

$('.input-group.date input').attr("readonly", true);


function popupWarning(title,text){
     swal({
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

function kirim(){
        state = false;
        title = '';
        text = '';
        var date_start=$('.auc_start').val();
        var date_end=$('.auc_end').val();
        if(date_start==''||date_end==''){
            state = false;
            title= 'Tanggal dan Jam Kosong';
            text='Tanggal Jam Pembukaan dan Tanggal Jam Penutupan Harus Diisi!';           
            
        }else{
            console.log(strTodatetime(date_start)+"|"+strTodatetime(date_start));
             if(strTodatetime(date_start)>=strTodatetime(date_end)){  
                state = false;
                title= 'Tanggal dan Jam Error';
                text='Tanggal dan Jam Penutupan Harus Setelah Tanggal dan Jam Pembukaan';            
                
            }else{

                var nilai_pengurangan = $('.decrement_value').val();
                if(nilai_pengurangan==''||nilai_pengurangan==0){
                    state=false;
                    title= 'Nilai Pengurangan Error';
                    text='Nilai Pengurangan harus diisi';
                }else{
                    b=false;
                    $('.checkuncheck').each(function(){                        
                        if($(this).is(":checked")){
                            b= true;
                        }
                    });
                    if(b==false){
                        state=false;
                        title= 'Item Auction Kosong';
                        text= 'Harus memilih Item Auction dahulu';
                    }else{
                         a=false;
                         $('.cekvendor').each(function(){
                            console.log($(this).is(":checked"));
                            if($(this).is(":checked")){
                                a= true;
                            }
                        });
                         if(a==false){
                            state=false;
                            title= 'Peserta Auction Kosong';
                            text= 'Harus memilih Peserta Auction dahulu';
                         }else{
                            state = true;
                         }
                    }
                    
                }

            }
        }



        if(state == false){        
                popupWarning(title,text);
               e.preventDefault();
        }else{
            $('form').submit();
        }
}

$(document).ready(function(){
    $(".must_autonumeric").autoNumeric('init', {lZero: 'deny', mDec: 0});
    
    // $('form').submit(function(e){
        
    // });

    $('#paqh_hps').val($('#hps_sebagian').val());
    $('#paqh_hps_palsu').val(numberWithCommas($('#hps_sebagian').val()));

	$( ".itemlist" ).hide();

    $('.cekvendor').change(function(){
        cekvendor = $(this);
        idvendor = $(this).val();
        table = $(this).parent().parent().parent().parent();
        table.find("." + idvendor).each(function(){
            if($(this).is(":visible"))
                if($(this).html() == ''){
                    cekvendor.attr('checked',false);
                }
        });
    });

	$('.checkuncheck').change(function() {
        $('.cekvendor').prop('checked', false);
		if($(this).is(":checked")){
            tr = $(this).parent().parent().parent();
	        ppi_nomat = tr.find('.PPI_NOMAT').html();
	        //satuan = $(".satuan"+ppi_nomat).val();
	        $( "."+ppi_nomat ).show();
        } else{
            tr = $(this).parent().parent().parent();
	        ppi_nomat = tr.find('.PPI_NOMAT').html();
	        satuan = 0;
	        $( "."+ppi_nomat ).hide();
        };

        $(".vendor").each(function(){
        	ST = $("#paqh_price_type").val();
        	ptv_vendor_code = $(this).val();
        	// if(ST == "T"){
            hargasatuan = $(".hargasatuan"+ppi_nomat+ptv_vendor_code).val();
    		satuan = $(".qty"+ppi_nomat+ptv_vendor_code).text();
        	// } else{
        		// hargasatuan = $(".hargasatuan"+ptv_vendor_code).val();
        	// }
        	total = 0;
            check_vendor=true;
        	$(".hrg"+ptv_vendor_code).each(function(){
                if($(this).html()!=0){
            		if ($(this).parent().hasClass(ppi_nomat) && ST == "T") {
            			tot = Number(satuan) * Number(hargasatuan);
                        // console.log('tot = ' + tot);
            			$(this).html(numberWithCommas(tot));
            		} else if ($(this).parent().hasClass(ppi_nomat) && ST == "S") {
            			tot = Number(hargasatuan);
            			$(this).html(numberWithCommas(tot));
            		}
                }

        		if($(this).parent().is(":visible")){
                    temp = isNaN(removeCommas($(this).html())) ? 0 : removeCommas($(this).html());
        			total = total + Number(temp);
                    // console.log('notanumber'+isNaN(removeCommas($(this).html()))+' ini:'+removeCommas($(this).html())+' temp = '+temp+' | total = ' + total);
        		  if($(this).html()==0){
                    check_vendor=false;
                  }                    
                }
                
                
        	});
            if(check_vendor){
                $('.vendor_ikut'+ptv_vendor_code).prop('disabled',false);
            }else{
                $('.vendor_ikut'+ptv_vendor_code).prop('disabled',true);
            }
        	$(".hargatotal"+ptv_vendor_code).val(Number(total));
        	$(".total"+ptv_vendor_code).html(numberWithCommas(Number(total)));
        });
    });

	$('#paqh_price_type').change(function(){

		$('.checkuncheck').attr('checked', false);
		$( ".itemlist" ).hide();

		$(".vendor").each(function(){
        	ptv_vendor_code = $(this).val();
        	$(".total"+ptv_vendor_code).html(Number(0));
        })

		if($('#paqh_price_type').val() == 'S'){
			$('#paqh_hps').val($('#hps_sebagian').val());
            $('#paqh_hps_palsu').val(numberWithCommas($('#hps_sebagian').val()));
		}
		else if($('#paqh_price_type').val() == 'T'){
			$('#paqh_hps').val($('#hps_total').val());
            $('#paqh_hps_palsu').val(numberWithCommas($('#hps_total').val()));
		}
	});

    $('#pilihsemua').change(function(){
        if($(this).prop('checked')){
            $('.cekvendor').prop('checked',true);
        }else{
            $('.cekvendor').prop('checked',false);
        }
        
    });

    $('#submit_button').click(function(){
        swal({
            title: 'Peringatan',
            text: 'Apakah Anda yakin?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#92c135',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            closeOnConfirm: true,
            closeOnCancel: true
          },
            function(isConfirm){
            console.log(isConfirm);
                if(isConfirm===true){
                    kirim();
                }else{
                    console.log('no submit');
                }
                
          });
    });

})