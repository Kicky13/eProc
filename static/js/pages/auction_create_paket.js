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

$(document).ready(function(){
    $(".must_autonumeric").autoNumeric('init', {lZero: 'deny', mDec: 0});
    
    $('#paqh_hps').val($('#hps_sebagian').val());
    $('#paqh_hps_palsu').val(numberWithCommas($('#hps_sebagian').val()));

    totals();

    $('#paqh_price_type').change(function(){
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
        totals();
    });

    $('#pilihsemua').change(function(){
        if($(this).prop('checked')){
            $('.cekvendor').prop('checked',true);
        }else{
            $('.cekvendor').prop('checked',false);
        }
        
    });
})

function totals(){
    $(".vendor").each(function(){
        vendor = $(this);
        $('.PPI_NOMAT').each(function(){
            nomat = $(this);
            ppi_nomat = nomat.html();
            
            ST = $("#paqh_price_type").val();
            ptv_vendor_code = vendor.val();
            hargasatuan = $(".hargasatuan"+ppi_nomat+ptv_vendor_code).val();
            satuan = $(".qty"+ppi_nomat+ptv_vendor_code).text();
            // alert(vendor.parent().hasClass(ppi_nomat));
            total = 0;
            check_vendor=true;
            $(".hrg"+ptv_vendor_code).each(function(){
                if ($(this).parent().hasClass(ppi_nomat) && ST == "T") {
                    tot = Number(satuan) * Number(hargasatuan);
                    // console.log('tot = ' + tot);
                    $(this).html(numberWithCommas(tot));
                } else if ($(this).parent().hasClass(ppi_nomat) && ST == "S") {
                    tot = Number(hargasatuan);
                    $(this).html(numberWithCommas(tot));
                    // console.log('hargasatuan = ' + hargasatuan);
                }

                if(isNaN(tot)){
                    $(this).html(0);
                    check_vendor=false;
                }

                if($(this).parent().is(":visible")){
                    temp = isNaN(removeCommas($(this).html())) ? 0 : removeCommas($(this).html());
                    total = total + Number(temp);
                    // console.log('total = ' + total);
                     if($(this).html()==0){
                        check_vendor=false;
                      }  
                }
            });
             if(check_vendor){
                $('.vendor_ikut'+ptv_vendor_code).prop('disabled',false);
            }else{
                $('.vendor_ikut'+ptv_vendor_code).prop('disabled',true);
                console.log($('.vendor_ikut'+ptv_vendor_code).prop('disabled'));
            }
            $(".hargatotal"+ptv_vendor_code).val(Number(total));
            $(".total"+ptv_vendor_code).html(numberWithCommas(Number(total)));
        })
    })
}