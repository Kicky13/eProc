function jq_leadtime(data){
    $('#chart1d').children().remove();
    var previous=0;
    var line1 = [];       
    var obj = JSON.parse(data);
    obj=obj.diffavg;
    console.log(obj);
    $.each(obj,function(key,val){        
        line1.push(val);
        previous += val;
    });  
    var ticks = ['Doc Submit','Usulan Subpratender','Pratender','Quot Deadline','Pengiriman Evatek','Evatek','Negosiasi','PO Created','PO Released','Total'];
    // console.log(line1);
    // console.log(ticks);
    
    plot1d = $.jqplot('chart1d', [line1], {
        title: 'Leadtime Pengadaan',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer, 
            rendererOptions:{ 
                barDirection: 'horizontal',
                barWidth: 20,
                waterfall: true,
                varyBarColor: true,
                shadowDepth:0,
                startAngle : 180,
            },
            pointLabels: {
                show: true,
                hideZeros: false,
                formatString: '%s days' ,
                xpadding:1,
            },
        },
        axes:{
            xaxis:{
                label:'Days',
                min:0,
                max:previous+50,
                tickInterval:50,
            },
            yaxis:{
                renderer:$.jqplot.CategoryAxisRenderer, 
                ticks:ticks,
                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                tickOptions: {
                    angle: 0,
                    fontSize: '10pt',
                    showMark: false,
                    showGridline: true
                },
            }
        }
            
    });
}

function jq_performance(data){
    $('#chart_performance').children().remove();
    var ticks=[],s1=[],s2=[];
    var obj = JSON.parse(data);
    obj=obj.performance;
    $.each(obj,function(key,val){  
        ticks.push(key);
        s1.push(val.sub);  
        s2.push(val.sub+"/"+val.total);
    });
    // var s1 = [2, 6, 7, 10];
    // var s2 = [7, 5, 3, 2];
    plot4 = $.jqplot('chart_performance', [s1], {
            title:'Performance Pengadaan',
            captureRightClick: true,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                rendererOptions: {
                    barDirection: 'horizontal',
                    shadowDepth:0,
                    highlightMouseDown: true   
                },
                pointLabels: {
                    show: true, 
                    labels:s2
                }
            },
            axes: {
                xaxis:{
                    label:'&Sigma; Performance',                    
                },
                yaxis:{
                    renderer:$.jqplot.CategoryAxisRenderer, 
                    ticks:ticks,
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                        angle: 0,
                        fontSize: '10pt',
                        showMark: false,
                        showGridline: true
                    },
                }
            }
        });
}

table_pr = null;
function populate_table(data) {
    if (table_pr != null) {
        table_pr.destroy();
    }
    table_pr = $('#pr').DataTable( {
        "bSort": true,
        "dom": 'rtip',
        "pageLength":5,
        "processing": true,
        "serverSide": true,
        "paging":true,
        "scrollCollapse": true,        
        // "scrollY": "500px",        
        // "scrollX": true,
        // "pagingType": "full_numbers",
        "ajax": {
            url: base_url + "Dashboard_report/get_data_pritem_json", 
            type: 'POST',
            data: {
                filter:data,
            },
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
                {"data" : "NO", "sClass": "text-center"},
                {"data" : "COMPANYNAME", "sClass": "text-center"},
                {"data" : "PPR_PGRP", "sClass": "text-center"},
                {"data" : "PPR_PRNO", "sClass": "text-center"},
                {"data" : "PPI_PRITEM", "sClass": "text-center"},
                {"data" : "PPI_NOMAT", "sClass": "text-center"},
                {"data" : "PPI_DECMAT", "sClass": "text-center"},
                {"data" : "PPR_DATE_RELEASE", "sClass": "text-center"},
                {"data" : "DOC_UPLOAD_DATE", "sClass": "text-center"},
                {"data" : "PTM_SUBPRATENDER", "sClass": "text-center"},
                {"data" : "KONFIGURASI_DATE", "sClass": "text-center"},
                {"data" : "PTM_PRATENDER", "sClass": "text-center"},
                {"data" : "PTP_REG_OPENING_DATE", "sClass": "text-center"},
                {"data" : "RFQ_CREATED", "sClass": "text-center"},
                {"data" : "PTP_REG_CLOSING_DATE", "sClass": "text-center"},
                {"data" : "EVATEK_APPROVE", "sClass": "text-center"},
                {"data" : "EVATEK", "sClass": "text-center"},
                {"data" : "WIN_AT", "sClass": "text-center"},
                {"data" : "PO_CREATED_AT", "sClass": "text-center"},
                {"data" : "RELEASED_AT", "sClass": "text-center"},
        ],
    });
}
$(document).ready(function(){
    $(".select2").select2();

    $(".opco").on('change',function(a){
        var opco = $(this).val();        
        $.ajax({
            url:  base_url + "Dashboard_report/get_pgrp",
            global: false,
            type: 'POST',
            data: { 'opco': opco },
            beforeSend:function(){
                $("#pgrp").attr('placeholder',"Loading...");
            },
            success: function(data){
                $("#pgrp").attr('placeholder',"Pilih Group Purchasing");
                $("#pgrp").select2().empty();
                if(data!=''){
                    var obj = JSON.parse(data);                    
                    $.each(obj,function(key,val){   
                        $("#pgrp").append("<option value='"+val+"'>"+val+"</option>");
                    });
                }
            }
        });
    });
    

    $("#filter").submit(function(e){
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({          
            url: base_url + "Dashboard_report/get_list_item_json", 
            type: 'POST',
            data: data,
            success: function(data) {
                jq_leadtime(data);
                jq_performance(data);
            },
            complete: function(){
                populate_table(data);        
            }
        });
        
    });

    $(".update_data").click(function(){
        var data = $("#filter").serializeArray();
        swal({
                title: "Apakah Anda Yakin untuk Memuat Data baru?",
                text: "Mungkin ini akan memakan waktu yang relatif lama",
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
                    $.ajax({
                        url: base_url + "Dashboard_report/load_pr",
                        type: 'POST',
                        data: data,
                        success: function(data) {                
                            if(data==''){
                                swal("Berhasil!", "Data berhasil dimuat!", "success");
                                console.log('sukses');
                            }else{
                                swal("Gagal!", data, "error");
                                console.log(data);
                            }
                        },
                        complete:function(){
                            console.log('selesai');  
                        }
                    });
                }
            });
        
    });

    
});