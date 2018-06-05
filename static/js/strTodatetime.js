/*
* fungsi untuk mengubah format string text tanggal dari input '17 Jun 2016 03:24'
* menjadi format date sesuai standart javascript.
*/
function strTodatetime(datetime){
    var tgljam = datetime.split(" ");
    var tgl = tgljam[0].split("-");
    var jam = tgljam[1].split(":");
    // alert(tgljam[0]);
    // alert("tgl:"+tgl[0]+"bln:"+tgl[1]+"thn:"+tgl[2]);
    // alert(tgljam[1]);
    // alert("jam:"+jam[0]+"menit:"+jam[1]);
    //format date: Date('17 Dec 2095 03:24:00');
    var nama_bulan_pendek = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var tanggal_jam = new Date();
    tanggal_jam.setFullYear("20"+tgl[2]);
    tanggal_jam.setMonth(nama_bulan_pendek.indexOf(tgl[1]));
    tanggal_jam.setUTCDate(tgl[0]);
    tanggal_jam.setHours(jam[0]);
    tanggal_jam.setMinutes(jam[1]);
    tanggal_jam.setSeconds(0);    
    return tanggal_jam;

}

function statusRfq(dateTimeClosing,nama_baru){
    var date = new Date();
    var dateNew = date.getTime(); 

    var tgljam = dateTimeClosing.split(" ");
    var tgl = tgljam[0].split("-");
    var jam = tgljam[1].split(":");
    var tanggal_jam = new Date();
    tanggal_jam.setFullYear(tgl[0]);
    tanggal_jam.setMonth(tgl[1]-1);
    tanggal_jam.setUTCDate(tgl[2]);
    tanggal_jam.setHours(jam[0]);
    tanggal_jam.setMinutes(jam[1]);
    tanggal_jam.setSeconds(0);    
    var dateClosing = tanggal_jam.getTime();

    if(dateClosing > dateNew){
        return nama_baru;
    }else{
        return 'Verifikasi Penawaran';
    }  
}

function statusPenawaranHarga(batasHarga,nama_baru){
    var date = new Date();
    var dateNew = date.getTime(); 

    var tgljam = batasHarga.split(" ");
    var tgl = tgljam[0].split("-");
    var jam = tgljam[1].split(":");
    var tanggal_jam = new Date();
    tanggal_jam.setFullYear(tgl[0]);
    tanggal_jam.setMonth(tgl[1]-1);
    tanggal_jam.setUTCDate(tgl[2]);
    tanggal_jam.setHours(jam[0]);
    tanggal_jam.setMinutes(jam[1]);
    tanggal_jam.setSeconds(0);    
    var batasPenawaranHarga = tanggal_jam.getTime();

    if(batasPenawaranHarga < dateNew){
        return nama_baru;
    }else{
        return 'Kirim Penawaran Harga';
    }  
}

function statusNegosiasi(ptm){
    var items = ptm.toString().split(",") ;
    status = items;

    for (var i = 0; i < items.length; i++) {
        stts = items[i];
        if(stts==0 || stts==1 || stts==2 || stts==3 || stts==4 || stts==5 || stts==7 || stts==16 || stts==48 || stts==96 || stts==112){
            if(stts == 7){
                for (var n = 0; n < items.length; n++) {
                    status = 'Tahap Negosiasi';
                    stts2 = items[n];
                    if(stts2!=0 && stts2!=1 && stts2!=2 && stts2!=3 && stts2!=4 && stts2!=5 && stts2!=16 && stts2!=48 && stts2!=96 && stts2!=112){
                        status =  'Evaluasi ECE';
                    }
                }
                return status;
            }
            return 'Tahap Negosiasi';
        
        }else if(stts==6){
            st5=true;
            for (var j = 0; j < items.length; j++) {
                stts5 = items[j];
                if(stts5==0 || stts5==1 || stts5==2 || stts5==3 || stts5==4 || stts5==5 || stts5==7 || stts5==16 || stts5==48 || stts5==96 || stts5==112){
                    st5 = false;
                }
            }
            if(st5){
                return 'Penunjukan Pemenang';                
            }

        }else if(stts==8){
            st3=true;
            for (var m = 0; m < items.length; m++) {
                stts3 = items[m];
                if(stts3==0 || stts3==1 || stts3==2 || stts3==3 || stts3==4 || stts3==5 || stts3==7 || stts3==16 || stts3==48 || stts3==96 || stts3==112 || stts3==6){
                    st3 = false;
                }
            }
            if(st3){
                return 'Pembuatan LP3';                
            }

        }else if(stts==9){
            st4=true;
            for (var p = 0; p < items.length; p++) {
                stts4 = items[p];
                if(stts4==0 || stts4==1 || stts4==2 || stts4==3 || stts4==4 || stts4==5 || stts4==7 || stts4==16 || stts4==48 || stts4==96 || stts4==112 || stts4==6 || stts4==8){
                    st4 = false;
                }
            }
            if(st4){
                return 'Approval LP3';                
            }

        }else if(stts==10){
            st6=true;
            for (var r = 0; r < items.length; r++) {
                stts6 = items[r];
                if(stts6==0 || stts6==1 || stts6==2 || stts6==3 || stts6==4 || stts6==5 || stts6==7 || stts6==16 || stts6==48 || stts6==96 || stts6==112 || stts6==6 || stts6==8 || stts6==9){
                    st6 = false;
                }
            }
            if(st6){
                return 'PO Release';                
            }

        }
        // else if(stts==999){
        //     st7=true;
        //     for (var r = 0; r < items.length; r++) {
        //         stts7 = items[r];
        //         if(stts7==0 || stts7==1 || stts7==2 || stts7==3 || stts7==4 || stts7==5 || stts7==7 || stts7==16 || stts7==48 || stts7==96 || stts7==112 || stts7==6 || stts7==8 || stts7==9 || stts7==10){
        //             st7 = false;
        //         }
        //     }
        //     if(st7){
        //         return 'Tender Dibatalkan';                
        //     }
        // }
    }
    return status;
}

