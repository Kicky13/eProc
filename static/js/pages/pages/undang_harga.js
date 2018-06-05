$(document).ready(function() {    
    $(".cek_vendor").each(function(){
        
        var status_lulus = $(this).parent().parent().nextUntil(".vendor").find('.lulus_tech');
        var state = false;
        status_lulus.each(function(){
            if($(this).text()=='Tidak'){
                state = true;
            }
        });
        $(this).prop('disabled',state);
        
    });
    
    $('form').submit(function(e){
        flag_min1vendor = true;
        if($('#next_process_select').val() == 1){   // jika di approve


            if ($("#batas_vendor_harga").val() == '') {
                swal("Perhatian!", "Batas Tanggal Memasukkan Penawaran Harga tidak boleh kosong!", "warning")
                return false;
            }

            $('.evaluasi_tit_id').each(function() {
                tit_id = $(this).val();
                panjang = $('[data-tit="'+tit_id+'"]:checked').length;
                if (panjang == 0) {
                    flag_min1vendor = false;
                }
            });
            if (!flag_min1vendor) {
                swal("Perhatian!", "Pilih vendor yang akan diundang harga!", "warning")
                return false;
            }
            if ( $( ".cek_vendor" ).length ){
                var pilihsatusaja=false;
                $('.cek_vendor').each(function(){
                    if($('.cek_vendor').is(':checked')){
                        pilihsatusaja=true;
                    }
                });
                if (!pilihsatusaja) {
                    swal("Perhatian!", "Pilih minimal satu vendor!", "warning")
                    flag_min1vendor=pilihsatusaja;
                }
            }
        }
        // return flag_min1vendor;        
        var form = this;
        e.preventDefault();
            swal({
                title: "Apakah Anda Yakin?",
                text: "Pastikan Semua Data Yang Anda Masukkan Sudah Benar!",
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
                    $('.milihtombol_publicjs').prop('disabled', true);
                    form.submit();
                } else {
                }
            }) 
    });

});