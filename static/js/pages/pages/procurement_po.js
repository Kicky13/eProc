function calculateTotal() {
    var TotalHPS = 0;
    var $trs = $(".itemtr");
    // console.log($trs)
    for (var i = 0; i < $trs.length; i++) {
        prc = $(".itemprc" + i).attr('val');
        qty = $(".itemqty" + i).val();
        var subtotal = prc*qty;
        TotalHPS += subtotal;
        $(".itemtot" + i).html(numeral(subtotal).format('$0,0.00'));
    };

    $("#total_hps").html(numeral(TotalHPS).format('$0,0.00'));
    var ppn = 0;
    Ppn = 0.1*TotalHPS;
    $("#ppn").html(numeral(Ppn).format('$0,0.00'));
    $("#total_hps_final").html(numeral(TotalHPS+Ppn).format('$0,0.00'));
}

function justify() {
    val = $("#ptp_justification").val();
    if (val == 2)
        $("#detail_justification").show('slow/400/fast');
    else {
        $("#detail_justification").hide();
    }
}

function qty(e) {
    elem = $(e);
    val = elem.val();
    max = elem.attr('max');
    if (val < 0) {
        elem.val(0);
    }
    if (val > max) {
        elem.val(max);
    }
}

function pilih(e) {
    elem = $(e);
    parent = elem.parent().parent();
    if (elem.prop('checked')) {
        usedqty = parent.find('.used').html()
        if (usedqty == 'null') {
            usedqty = 0;
        }

        avblqty = parent.find('.prqty').html() - parent.find('.poqty').html() - usedqty;
        ans = ""
        ans += '<tr class="tritem" id="' + parent.find('.prno').html() + "-" + parent.find('.pritem').html() +'">';
        ans += '<td class"text-center">' + parent.find('.prno').html();
        ans += '<td class"text-center">' + parent.find('.pritem').html() + '</td>';
        ans += '<td>' + parent.find('.decmat').html();
        ans += '<td class"text-center"><input type="text" name="qty[]" class="col-xs-12 input-sm" value="'+ avblqty + '" max="'+ avblqty + '" onchange="qty(this)">';
        ans += '<td class"text-center">' + parent.find('.uom').html();
        ans += '<td>' + parent.find('.netprice').html();
        ans += '<input type="hidden" name="item[]" value="'+parent.find('.prno').html() + ":" + parent.find('.pritem').html()+ ":" + parent.find('.netprice').html()+'">'
        $("#tableItem").append(ans);
    }
    else {
        $("#" + parent.find('.prno').html() + "-" + parent.find('.pritem').html()).remove();
    }
}

$(document).ready(function(){
    numeral.language('id');
    var no = 1;
    var totalItem = 0;

    justify();

    var mytable = $('#pr-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Procurement_po/get_datatable',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {
                mRender : function(data,type,full){
                var ans = "";
                ans += '<input type="checkbox" class="check" onclick="pilih(this)" value="'+full.PPI_PRNO+':'+full.PPI_PRITEM+'">'

                ans += '<div class="hidden">';
                ans += '<div class="prno">' + full.PPI_PRNO + '</div>';
                ans += '<div class="pritem">' + full.PPI_PRITEM + '</div>';
                ans += '<div class="decmat">' + full.PPI_DECMAT + '</div>';
                ans += '<div class="quantopen">' + full.PPI_QUANTOPEN + '</div>';
                ans += '<div class="prqty">' + full.PPI_PRQUANTITY + '</div>';
                ans += '<div class="poqty">' + full.PPI_POQUANTITY + '</div>';
                ans += '<div class="used">' + full.PPI_QTY_USED + '</div>';
                ans += '<div class="quantopen">' + full.PPI_QUANTOPEN + '</div>';
                ans += '<div class="uom">' + full.PPI_UOM + '</div>';
                ans += '<div class="netprice">' + full.PPI_NETPRICE + '</div>';
                ans += '</div>';
                return ans;
            }},
            {"data" : "PPI_PRNO"},
            {"data" : "PPI_PRITEM"},
            {"data" : "PPI_NOMAT"},
            {"data" : "PPI_DECMAT"},
            {"data" : "PPI_PRQUANTITY"},
            {"data" : "PPI_QUANTOPEN"},
            {"data" : "PPI_POQUANTITY"},
            {"data" : "PPR_DOCTYPE"},
            {"data" : "PPR_PLANT"},
            {"data" : "PPI_REALDATE"},
            {"data" : "PPR_PORG"},
        ],
    });

    /* populate items */
    for (var i = 0; i < $(".itemtr").length; i++) {
        prc = $(".itemprc" + i).attr('val');
        $(".itemprc" + i).html(numeral(prc).format('$0,0.00'));
    };

    $(".btw").change(function(event) {
        val = Number($(this).val());
        if (val > Number($(this).attr("max"))) {
            $(this).val($(this).attr("max"))
        }
        if (val < 0) {
            $(this).val(0)
        }
    });

    $(".itemtr input").change(function(event) {
        calculateTotal();
    });

    calculateTotal();
})