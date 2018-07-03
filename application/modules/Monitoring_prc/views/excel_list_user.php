<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=List_user.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1">
    <tr>
        <td>No</td>
        <td>Nama</td>
        <td>Gender</td>
        <td>Phone</td>
        <td>Email </td>
        <td>alamat</td>
        <td>Tanggal Lahir</td>
        <td>Last Education</td>
        <td>Status</td> 
        <td>Jurusan</td>
        <td>IPK</td>
        <td>Skill</td>
        <td>Pengalaman</td>
        <td>Video</td>
        <td>Application</td>
        <td>Submited Status</td>
    </tr>

<?php

    echo $data;
?>

</table>