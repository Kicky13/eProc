function numberWithCommas(x) {
	var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}

function removeCommas(x) {
    return x.replace(/,/g, "");
}

// function errorjs() {
// 	$(".panel_waktu").hide();
// 	$(".panel_bidder").hide();
// 	alert('Error. Try using uptodate chrome web browser.')
// 	console.log('Error. Try using uptodate chrome web browser.')
// }
Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };


function qty(e) {
    elem = $(e);
    val = elem.val();
    val = removeCommas(val);
    val = Number(val);
    
    tipeauction = $("#tipeauction").val();
    total_price = 0;
    qt = elem.parent().parent().find(".quantity").html();
    total_price = Number(qt) * val;
    elem.parent().parent().find(".subtotal").html(total_price.formatMoney(2, '.', ','));
    elem.parent().parent().find(".subtot").val(total_price);

    total_price = 0;
    $(".subtot").each(function(){
        total = $(this).val();
        // console.log("total" + total);
        total = Number($(this).val());
        total_price += total;
    });

    var price = document.getElementById("total");

    st1='';st2='';
    if(tipeauction=='S'){
        st1 = '<strong>';
        st2 = '</strong>';
    }

    tt1='';tt2='';
    if(tipeauction=='T'){
        tt1 = '<strong>';
        tt2 = '</strong>';
    }

    $("#total").html(tt1+total_price.formatMoney(2, '.', ',')+tt2);
    $(".total").val(total_price);

    subsatuantotal=0;
    $('.breakdown_price').each(function(){
        subsatuantotal+=Number(removeCommas($(this).val()));
    });
    $("#subsatuantotal").html(st1+subsatuantotal.formatMoney(2, '.', ',')+st2);
    // console.log(subsatuantotal+'|'+total_price+'|'+$('#paqd_final_price').val());
    if(tipeauction=='S'){
        if(subsatuantotal>$('#paqd_final_price').val()){                             
            $(e).addClass('error');
            $(e).attr('title','Harga melebihi harga akhir auction');
            $(e).tooltip();
            $(e).tooltip('show');
            $(".submit_btn").prop('disabled',true);
        }else{
            $(e).tooltip('destroy');
            $(e).removeClass('error');
            $(e).removeAttr('data-toggle');
            $(".submit_btn").prop('disabled',false);
        }
    }else{
        if(total_price>$('#paqd_final_price').val()){                            
            $(e).addClass('error');
            $(e).attr('title','Harga melebihi harga akhir auction');
            $(e).tooltip(); 
            $(e).tooltip('show');
            $(".submit_btn").prop('disabled',true);
        }else{
            $(e).tooltip('destroy');
            $(e).removeClass('error');
            $(e).removeAttr('data-toggle');
            $(".submit_btn").prop('disabled',false);
        }
    }
    
};

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

var base_url = $('#base-url').val();
$(document).ready(function(){     
    breakdown_price = $('.breakdown_price');
    breakdown_price.each(function(){
        if($(this).val()!=''){        
            qty($(this));
        }
    });
    var file_limit=2097152;//byte
    var file_ext_accept=['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'html', 'zip'];
     $('#file_breakown').bind('change', function() {
        var file=this.files[0];
        var file_name = file.name;
        var file_size = file.size;
        var file_ext = file.name.replace(/^.*\./, '');

        if($.inArray(file_ext, file_ext_accept) == -1){
            popupWarning('ERROR','Type File yang di-upload adalah '+file_ext+' yang diperbolehkan hanya: '+file_ext_accept.join(' ,'));
            $(this).val("");
        }
        if(file_size>file_limit){
            popupWarning('ERROR','File yang di-upload sebesar '+file_size/1048576+' MB, File tidak boleh melebihi '+file_limit/1048576+' MB');
            $(this).val("");
        }
    });

    $('form').submit(function(e){  
        $('.breakdown_price').each(function(){
            if(($(this).val()!=0)||($(this).val()!='')){                
                $(this).val(removeCommas($(this).val()));
                return true;
            }else{
                popupWarning('ERROR','Price Item Harus diisi');
                $(this).addClass('error');
                e.preventDefault();
                return false;
            } 
        });
        if($('#is_jasa').val()==1){
            if($('#file_breakdown').val()==''){
                popupWarning('ERROR','File Dokumen harus diisi');
                return false;
            }else{
                return true;
            }
        }
        total_all=0;
        if($("#tipeauction").val()=='S'){          
            subsatuantotal=0;
            $('.breakdown_price').each(function(){
                subsatuantotal+=Number(removeCommas($(this).val()));
            });

            if(subsatuantotal>$('#paqd_final_price').val()){   
                popupWarning('ERROR','Harga total satuan melebihi harga total akhir auction');
                e.preventDefault();
                return false;
            }else{
                // return true;
            }
            total_all = subsatuantotal;
        }else{
            total_price = 0;
            $(".subtot").each(function(){
                total = $(this).val();
                // console.log("total" + total);
                total = Number($(this).val());
                total_price += total;
            });

            if(total_price>$('#paqd_final_price').val()){   
                popupWarning('ERROR','Harga total melebihi harga total akhir auction');
                e.preventDefault();
                return false;
            }else{
                // return true;
            }
            total_all = total_price;
        }

        textConfirm = "Pastikan data yang Anda masukkan sudah benar";
        if(total_all < $('#paqd_final_price').val()){ 
            textConfirm = "Harga Breakdown lebih kecil dari harga Auction";
        }

        var form = this;
        e.preventDefault();
        swal({
            title: "Apakah Anda Yakin?",
            text: textConfirm,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#92c135',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            cancelButtonText: "Tidak",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                form.submit();
            } else {
            }
        })
    });
    
	// $(".submit_btn").click(function(event) {        
	//   	bid = Number(removeCommas($("#harga_bids").val()));
	// 	tot = Number($(".total").val());
 //        console.log(bid);
 //        console.log(tot);
	// 	if(bid >= tot){
			
	// 	} else{
	// 		event.preventDefault();
	// 	}
	// });


});