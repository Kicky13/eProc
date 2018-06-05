function pilih(e) {
    elem = $(e);
    parent = elem.parent().parent();
    if (elem.prop('checked')) {
        usedqty = parent.find('.used').html()
        if (usedqty == 'null') {
            usedqty = 0;
        }

        avblqty = parent.find('.quantopen').html();
        if (avblqty < 0) avblqty = 0;
        ans = "";
        
        $("#tableItem-perencanaan").append(ans);

        updateTotal();   
                                    
    }
    else {
        $("#" + parent.find('.prno').html() + "-" + parent.find('.pritem').html()).remove();
        updateTotal();
    }
}