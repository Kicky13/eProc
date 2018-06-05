base_url = $("#base-url").val();

	/*
	 MATNR(Material number),
	 MAKTX(shortext),
	 MTART(material type),
	 MEINS(uom),
	 MATKL(material group),
	 ERNAM (creator),
	 ERSDA(create on),
	 AENAM(changed by),
	 LAEDA(last change);
	 NO (longtext item ke ...),
	 TDLINE (Long Text)
	 *
	 */
function openmodal (VENDOR_ID) {
  // MATNR='341-107-0083';//341-107-0083  301-200410
    $.ajax({
        url: $("#base-url").val() + 'Ubah_email_vnd/getDetail/' + VENDOR_ID,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) { 
         console.log(data.VENDOR_ID[0]);              
         dt = data.VENDOR_ID[0];
	         if(dt!=null){
	         $("#formUp").attr("action", "Ubah_email_vnd/updateEmail/" + dt.MATNR);  
             $("#VENDOR_ID").val(dt.VENDOR_ID);       
	         $("#VENDOR_NO").val(dt.VENDOR_NO);
	         $("#VENDOR_NAME").val(dt.VENDOR_NAME);
	         $("#ADDRESS_CITY").val(dt.NAMA);
	         $("#VENDOR_TYPE").val(dt.VENDOR_TYPE);
	         $("#EMAIL_ADDRESS").val(dt.EMAIL_ADDRESS);
	         
         $("#modalholder").modal('show')	
         }         
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        // console.log(MATNR);
    });
}
 function SAPsUpdate() {        
        $.ajax({
            url: $("#base-url").val() + 'Strategic_material/sapUpdate/',
            type: 'POST',
            dataType: 'json'
        })
        .done(function(data) {
            console.log(data);
            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
            //console.log(data);
			$('#tableMT').DataTable().destroy();			
			$('#tableMT tbody').empty();
	        loadTable();
        });
    }
    var t0=true,t1=true,t2=true,t3=true,t4=true,t5=true,t6=true;
function loadTable () {
    // no = 1;
    mytable = $('#tableMT').DataTable({
        "bSort": false,      
        "dom": 'rtip',
        "deferRender": true,
        "language": {
		    // "loadingRecords": "<center><b>Please wait - Updating and Loading Data Strategic Material Assignment...</b></center>"
		},
        // "paging": true,
        // "lengthChange": true, 
        // "lengthMenu": [ 10, 25, 50, 75, 100 ],
        //"scrollY": $( window ).height()/2,
        //"pagingType": "scrolling",
        
        "ajax" : $("#base-url").val() + 'Ubah_email_vnd/get_data_vnd',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "columns":[
            {
                mRender : function(data,type,full){
                        a = "<div class='col-md-12 text-center'>";
                        a += full[0] ;
                        a += "</div>";
                        return a;
                }
            },
            {
                mRender : function(data,type,full){
                    // console.log(full);
                    if(full[1] != null){
                        a = ''
                        a += "<div class='col-md-12 text-center'>";
                        a += full[1];
                        a += "</div>";
                        return a;
                    }else return "";
                }
            },
            {
                mRender : function(data,type,full) {
                   if(full[2] != null){
                        a = "<div class='col-md-12 text-left'>";
                        a += full[2] ;
                        a += "</div>";
                        return a;
                    }else return "";
                }
            },
            {
                mRender : function(data,type,full){
                    if(full[3] != null){
                        a = ''
                        a += "<div class='col-md-12 text-left'>";
                        a += full[3];
                        a += "</div>";
                        return a;
                    }else return "";
                }
            },
            {
                mRender : function(data,type,full){
                    if(full[4] != null){
                        a = "<div class='col-md-12 text-center'>";
                        a += full[4];
                        a += "</div>";
                        return a;
                    }else return "";
                }
            },	
            {
                mRender : function(data,type,full){ 
                    if(full[5] != null){
                        a = ''
                        a += "<div class='col-md-12 text-center'>";
                        a += full[5];
                        a += "</div>";
                        return a;
                    }else return "";
                }
            }, 	
            {
                mRender : function(data,type,full){ 
                    // if(full[6] != null){
                        a = ''
                        a += '<a href="javascript:void(0)" onclick="openmodal('+full[6]+')" class="main_button color1 small_btn">Edit</a> ';
                        a += "</div>";
                        return a;
                    // }else return "";
                }
            } 
        ],
    });
     /*
          class="btn btn-default btn-sm glyphicon glyphicon-check"
     */
    mytable.columns().every( function () {
        var that = this;
          
        $( '.srch', this.header() ).on( 'keyup change', function () {        	
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
        $( 'input:checkbox', this.header() ).on( 'keyup change', function () {            
			var a = [];            
			if ($('#checkAll:checked').length === 1) {
				$('input:checkbox', mytable.table().body()).prop('checked', true);
				$('input:checkbox', mytable.table().body()).each(function() {
					a.push(this.value);
					chk2("1", this.value);
				});
			} else if ($('#checkAll:checked').length === 0) {
				$('input:checkbox', mytable.table().body()).prop('checked', false);
				$('input:checkbox', mytable.table().body()).each(function() {
					a.push(this.value);
					chk2("0", this.value);
				});
			}
            
             
			console.log(a);
        });
    });
		        
	$('#tableMT').find("th").off("click.DT");
		  
    $( '.ts0').on( 'click', function () {
    	if(t0){
    		mytable.order( [0, 'asc' ] ).draw();
    		t0=false;	
    	}		
		else{
			mytable.order( [0, 'desc' ] ).draw();
			t0=true;
		}            		
    });    
    $( '.ts1').on( 'click', function () {
    	if(t1){
    		mytable.order( [1, 'asc' ] ).draw();
    		t1=false;	
    	}		
		else{
			mytable.order( [1, 'desc' ] ).draw();
			t1=true;
		}            		
    });  
    $( '.ts2').on( 'click', function () {
    	if(t2){
    		mytable.order( [2, 'asc' ] ).draw();
    		t2=false;	
    	}		
		else{
			mytable.order( [2, 'desc' ] ).draw();
			t2=true;
		}            		
    });  
    $( '.ts3').on( 'click', function () {
    	if(t3){
    		mytable.order( [3, 'asc' ] ).draw();
    		t3=false;	
    	}		
		else{
			mytable.order( [3, 'desc' ] ).draw();
			t3=true;
		}            		
    });  
    $( '.ts4').on( 'click', function () {
    	if(t4){
    		mytable.order( [4, 'asc' ] ).draw();
    		t4=false;	
    	}		
		else{
			mytable.order( [4, 'desc' ] ).draw();
			t4=true;
		}            		
    });  
    $( '.ts5').on( 'click', function () {
    	if(t5){
    		mytable.order( [5, 'asc' ] ).draw();
    		t5=false;	
    	}		
		else{
			mytable.order( [5, 'desc' ] ).draw();
			t5=true;
		}            		
    });  
    $( '.ts6').on( 'click', function () {
    	if(t6){
    		mytable.order( [6, 'asc' ] ).draw();
    		t6=false;	
    	}		
		else{
			mytable.order( [6, 'desc' ] ).draw();
			t6=true;
		}            		
    });      
}
function chk(ck) {
	var button = $(ck);
	var recipient = button.data('matnr');
	var stat = "0";
	if (button.is(":checked")) {
		stat = "1";
	}
	$.ajax({
		url : $("#base-url").val() + 'Strategic_material/ubahStat/' + recipient,
		data : {
			"checked" : stat
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$('#tableMT').DataTable().destroy();			
		$('#tableMT tbody').empty();
		loadTable();
	});

}

$("#save_edit").click(function() {
            if (!confirm('Apakah anda yakin mau mengubah data?')) {
                return;
            }
            $.ajax({
                url: $("#base-url").val() + 'Ubah_email_vnd/updateEmail',
                type: 'post',
                dataType: 'json',
                data: $("#form_edit").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil mengubah data.');
                }
            })
            .fail(function() {
                alert('Gagal mengubah data.');
            })
            .always(function(data) {
                populate_table();
                $(".modal").modal('hide');
            });
        });

function chk2(stat, recipient) {
	$.ajax({
		url : $("#base-url").val() + 'Strategic_material/ubahStat/' + recipient,
		data : {
			"checked" : stat
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$('#tableMT').DataTable().destroy();			
		$('#tableMT tbody').empty();
		loadTable();
	});

}  

$(document).ready(function() {
	loadTable();
	$('input:file').bind('change', function() {
		if (this.files[0].size > 200000) {
			alert('Ukuran file maksimum 200KB.');
			this.value = '';
		} else {
			var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext) {
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
				break;
			default: {
				//$('#uploadButton').attr('disabled', true);
				alert('Kesalahan tipe file.');
				this.value = '';
			}
			}
		}

	});

});


