<table class="noborder" style="margin-top:1cm;margin-bottom:2cm;">
    <tr>
        <td style="width:50%;text-align:center;">
        	Penerima
        	<br>
        	<br>
        	<br>
            <br>
            <!-- <br> -->
            <br>
            <br>
            <br>
        	(
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        	)
        </td>        
        <td style="width:50%;text-align:center;">
        	Pengirim
        	<br>
        	<br>
        	<br>
        	<br>
            <br>
        	<br>
            <?php if(!empty($sap[0]['NAMA'])) echo $sap[0]['NAMA']."<br>"; ?>
            <?php if(!empty($sap[0]['EMAIL'])) echo $sap[0]['EMAIL']."<br>"; ?>
        	( <?php echo $vendor_name; ?> )
        </td>        
    </tr>
</table>