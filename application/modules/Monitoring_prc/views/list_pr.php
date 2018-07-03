<!-- https://datatables.net/forums/discussion/36045/excel-export-add-rows-and-data -->
<!-- <script type="text/javascript">
    function fnExcelReport()
    {
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange; var j=0;
    tab = document.getElementById('tbl_group_akses'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
</script> -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.dataTables.min.css">
<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>


<script type="text/javascript">
    function loadTable () {
    // no = 1;
    mytable = $('#tbl_group_akses').DataTable({
        "bSort": false,
        // "searching": false,
        // "lengthChange": false,
        "dom": 'Blfrtip',
        "buttons": [
        {
            extend: 'excel',
            customize: function ( xlsx ) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                //Bold Header Row
                $('row[r=3] c', sheet).attr( 's', '2' );
                //Make You Input Cells Bold Too
                $('c[r=A1]', sheet).attr( 's', '2' );
                $('c[r=A2]', sheet).attr( 's', '2' );

                $('c[r=H2]', sheet).remove();
                $('c[r=H2]', sheet).empty();
                $('c[r=H2]', sheet).val('');
            },
            exportOptions: {
                columns: [ <?php for($i = 1; $i <= 8 ; $i++){echo $i; if($i != $lasting){echo " ,";}}?> ]
                // columns: "thead th:not(.noExport)"
            },
            customizeData: function(data){
                //We want the first line so we disabled the header above. Let's add in our descriptions. Then we're going to add them to the top of the body and do the bolding ourselves with the customize function.
                // var desc = [
                // ['Subpratender','Pratender','No PR','Description','Latest Activity','Purchase Group','Buyer','Status'],
                // ['Report Date',' TEST Report Date']
                // ];

                var desc = [
                ['Subpratender','Pratender','No PR','Description','Latest Activity','Purchase Group','Buyer','Status']
                ];
                // alert(data.header);
                // data.body.unshift(data.header);
                data.header.splice();

                for (var i = 0; i < desc.length; i++) {
                    data.body.unshift(desc[i]);
                };
            }
        }
        ],
        "deferRender": true,
        
        "ajax" : $("#base-url").val() + 'Monitoring_prc/get_datatable',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "columns":[
        {
            mRender : function(data,type,full){
                return '';
            }
        },
        {
            mRender : function(data,type,full){
                    // console.log(full);
                    if(full.PTM_SUBPRATENDER != null){
                        a = ''
                        // a += "<div class='col-md-12 text-center'>";
                        a += full.PTM_SUBPRATENDER;
                        // a += "</div>";
                        return a;
                    }else return "";
                }
            },
            {
                mRender : function(data,type,full){
                    if(full.PTM_PRATENDER != null){
                        a = ''
                        // a += "<div class='col-md-12 text-center'>";
                        a += full.PTM_PRATENDER;
                        // a += "</div>";
                        return a;
                    }else return "";

                }
            },
            {
                mRender : function(data,type,full){ 
                    if(full.PPI_PRNO != null){
                        a = ''
                        // a += "<div class='col-md-12 text-center'>";
                        a += full.PPI_PRNO+"<button class='btn btn-default btn-sm' onclick='opentender("+full.PTM_NUMBER+")' style='background-color: #49ff56;'>"+full.hitungPRA+"</button>";
                        // a += "</div>";
                        return a;
                    }else return "";

                }
            },
            {"data" : "PTM_SUBJECT_OF_WORK"},
            // {"data" : "PTM_SUBPRATENDER"},
            {"data" : "PTC_END_DATE"},
            {
                mRender : function(data,type,full){
                    if(full.PTM_PGRP != null){
                        a = "<div class='col-md-12 text-center'>";
                        a += full.PTM_PGRP;
                        a += "</div>";
                        return a;
                    }else return "";

                }
            },
            {"data" : "buyer"},
            {
                mRender : function(data,type,full) {
                    if (full.PTM_STATUS > 0){
                        if (full.PTM_STATUS == 3 && full.TAMBAHAN_APPROVAL_NAME!="" && full.PTM_COMPANY_ID == '5000') {
                            return full.TAMBAHAN_APPROVAL_NAME;
                        }
                        if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/index' ){
                            return statusRfq(full.PTP_REG_CLOSING_DATE,full.NAMA_BARU);
                        }
                        if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/harga' && full.SAMPUL == 3){
                            return statusPenawaranHarga(full.BATAS_VENDOR_HARGA_VER,full.NAMA_BARU);
                        }
                        if(full.PROCESS_MASTER_ID == 'Tahap_negosiasi/index'){
                            return statusNegosiasi(full.TIT_STATUS_GROUP);
                        }
                        return full.NAMA_BARU;
                    }
                    else {
                        if (full.PTM_COMPANY_ID == '4000') { //Sementara Hardcode untuk kodisi tonasa
                            if (full.PTM_STATUS <= -1 && full.PTM_STATUS >= -8) {
                                return 'Reject';
                            } else if (full.PTM_STATUS == -999) {
                                return 'Batal Tender';
                            }
                            return 'Retender';
                        } else {
                            if (full.PTM_STATUS <= -1 && full.PTM_STATUS >= -7) {
                                return 'Reject';
                            } 
                            return 'Retender';                        
                        } 

                    }
                }
            },
            {
                mRender : function(data,type,full){
                    console.log(full);
                    var button = '<a title="Monitoring Procurement" href="' + $("#base-url").val() + 'Monitoring_prc/detail/'+full.PTM_NUMBER+'" class="btn btn-default btn-sm glyphicon glyphicon-th-list"></a> ' + 
                    '<button title="Current job holder" onclick="openmodal('+full.PTM_NUMBER+')" class="btn btn-default btn-sm glyphicon glyphicon-user"></button>';
                    if(full.cek_buyer_gak=='42' || full.cek_buyer_gak=='281' || full.cek_buyer_gak==42 || full.cek_buyer_gak==281){
                    } else {
                        button +='<a title="Log Tender" href="' + $("#base-url").val() + 'Log/detail/'+full.PTM_NUMBER+'" class="btn btn-default btn-sm glyphicon glyphicon-share"></a>';
                    }
                    if(full.PROCESS_MASTER_ID=='Tahap_negosiasi/index'){
                        button +='<button title="Item Status" onclick="openitemstatus('+full.PTM_NUMBER+')" class="btn btn-default btn-sm glyphicon glyphicon-tag"></button>';
                    }
                    return button;
                }
            },
            ],
        });

    // mytable.on( 'order.dt search.dt', function () {
    //     mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //         cell.innerHTML = i+1;
    //     } );
    // } ).draw();

    mytable.columns().every( function () {
        var that = this;

        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });

        $( 'select', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });

    });
}

$(document).ready(function(){
    loadTable();

});
</script>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="row "> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
                        <div class="table-responsive">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <!-- <button id="btnExport" onclick="fnExcelReport();"> EXPORT </button> -->
                                <table id="tbl_group_akses" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><span class="invisible">a</span></th>
                                            <th class="text-center">Subpratender</th>
                                            <th class="text-center">Pratender</th>
                                            <th class="text-center">No PR</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Latest Activity</th>
                                            <th class="text-center">Purchase Group</th>
                                            <th class="text-center">Buyer</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        <tr>
                                            <th class="noExport"> </th>
                                            <th class="noExport"><input type="text" class="col-xs-12"></th>
                                            <th class="noExport"><input type="text" class="col-xs-12"></th>
                                            <th class="noExport"><input type="text" class="col-xs-12"></th>
                                            <th class="noExport"><input type="text" class="col-xs-12"></th>
                                            <th class="noExport"><input type="text" class="col-xs-12"></th>
                                            <th class="noExport"><input type="text" class="col-xs-12"></th>
                                            <th class="noExport"><input type="text" class="col-xs-12"></th>
                                            <th class="noExport">
                                                <!-- <input type="text" class="col-xs-12"> -->
                                                <select class="col-xs-12">
                                                    <option></option>
                                                    <?php 
                                                    foreach ($status as $st) {
                                                        ?>
                                                        <option value="<?php echo $st['STATUS_NAME']; ?>"><?php echo $st['STATUS_NAME']; ?></option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                </div>   
            </div> 
        </div >
    </div >
</section>

<div class="modal fade" id="modalholder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">List Holder</h4>
                </div>
                <div class="modal-body">
                    <div class="panel panel-default">
                        <table class="table table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </thead>
                            <tbody id="tableholder">
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalitemstatus">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Item Status</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel panel-default">
                            <table class="table table-striped">
                                <thead>
                                    <th>PR No</th>
                                    <th>PR Item</th>
                                    <th>Nomor Material</th>
                                    <th>Item Material</th>
                                    <th>Status</th>
                                </thead>
                                <tbody id="tableitemstatus">
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modaltender">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Item Status</h4>
                        </div>
                        <div class="modal-body">
                            <div class="panel panel-default">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Subpratender</th>
                                        <th>Pratender</th>
                                        <th>Description</th>
                                        <th>Aksi</th>
                                        <!-- <th>Status</th> -->
                                    </thead>
                                    <tbody id="tabletender">
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
