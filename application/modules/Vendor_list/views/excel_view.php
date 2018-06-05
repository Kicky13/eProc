<style>
table, th, td {
    padding:5px;
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
<h1>DAFTAR SELURUH VENDOR</h1>
	<table border="1"  cellpadding="0" cellspacing="0" >
		<tr>
			<th align="center" bgcolor="#359AFF" width="30" >No</th>
			<th align="center" bgcolor="#359AFF" width="30" >Vendor No</th>
			<th align="center" bgcolor="#359AFF" width="30" >Product Type</th>
			<th bgcolor="#359AFF" width="150" >Vendor Name</th>
			<th bgcolor="#359AFF" width="80" >Status Update Profile</th>
			<th bgcolor="#359AFF" width="200" >Status Registrasi</th>
			<th bgcolor="#359AFF" width="70" >Email</th>
		</tr>
		<?php $no=1;
			foreach($data_vendor as $row){
				$bg=$no%2;
				if($bg==0){
					$bg=' bgcolor="#E1F0FF" ';
				} else {
					$bg=' bgcolor="#FFFFFF" ';
				}
		?>
		<tr>
			<td '.$bg.'  align="center" width="30">'.$no.'</td>
			<td ".$bg." width='150' align='center' >$row['VENDOR_NO']</td>
			<td '.$bg.' width="150" align="center" >'.$produk_type.'</td>
			<td '.$bg.'  width="200" >'.$row['VENDOR_NAME'].'</td>
					
			<?php if (!empty($row['STATUS_PERUBAHAN'])) {
				
				$status_per = $row['STATUS_PERUBAHAN'];
				
				if ($status_per == "8"){
					echo '<td '.$bg.'  width="200" >Persetujuan New Update Profile</td>';
                } else if($status_per == "4") {
					echo '<td '.$bg.'  width="200" >Approve Update Profile Kasi</td>'; 
                } else if($status_per == "5"){
					echo '<td '.$bg.'  width="200" >Approve Update Profile Kabiro</td>';
                } else if($status_per == "9"){
					echo '<td '.$bg.'  width="200" >Update Data Ditolak</td>';
                } else if($status_per == "0"){
					echo '<td '.$bg.'  width="200" >Vendor Updated</td>';
                } else {
					echo '<td '.$bg.'  width="200" ></td>';
                }
			}else {
				echo "<td '.$bg.'  width='200' ></td>'";
			} 
				$status = $row['STATUS'];
                if ($status == "1" || $status == "2"){
					echo '<td '.$bg.'  width="200" >New Registrasi</td>';
                } else if($status == "3") {
					echo '<td '.$bg.'  width="200" >Vendor Aktif</td>';
                } else if($status == "-1"){
					echo '<td '.$bg.'  width="200" >Registrasi Ditolak</td>';
                } else if($status == "99"){
					echo '<td '.$bg.'  width="200" >Dikembalikan ke Vendor</td>';
                } else if($status == "5"){
					echo '<td '.$bg.'  width="200" >Approve Registrasi Kasi Perencanaan</td>';
                } else if($status == "6"){
					echo '<td '.$bg.'  width="200" >Approve Registrasi Kasi Kabiro</td>';
                } else if($status == "7"){
					echo '<td '.$bg.'  width="200" >Approve New Registrasi Ditolak</td>';
                } else if($status == "0"){
					echo '<td '.$bg.'  width="200" >Registrasi Akun</td>';
                } else {
					echo '<td '.$bg.'  width="200" ></td>';
                }

                if (!empty($row['EMAIL_ADDRESS'])) {
					echo '<td '.$bg.'  width="200" >'.$row['EMAIL_ADDRESS'].'</td>';
                }else{
					echo '<td '.$bg.'  width="200" ></td>';
                }
				echo '</tr>';
				$no++;
			}
			?>
	</table>';