<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail PR</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3 text-right">Nomor PR</td>
                                <td id="prno"><?php echo $pr['PPV_PRNO'] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Reject Date</td>
                                <td id="prno"><?php echo $pr['PPV_DATE'] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Rejected by</td>
                                <td id="prno"><?php echo $pr['PPV_USER'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <?php foreach ($item as $key => $value): ?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Item <?php echo $key+1 ?></div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3 text-right">Nomor PR</td>
                                <td id="prno"><?php echo $value['PIV_PRNO'] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">PR ITEM</td>
                                <td id="prno"><?php echo $value['PIV_PRITEM'] ?></td>
                            </tr>
                            <?php
                                $desc = $value["PIV_DESCRIPTION"];
                                $des = explode(";",$desc);

                                $pritem = explode(":",$des[0]);
                                $kode = explode(":",$des[1]);
                                $nama = explode(":",$des[2]);
                                $harga = explode(":",$des[3]);
                                $prqty = explode(":",$des[4]);
                                $openqty = explode(":",$des[5]);
                                $poqty = explode(":",$des[6]);
                                $handqty = explode(":",$des[7]);

                                // $data['pritem'] = $pritem;
                                // $data['kode'] = $kode;
                                // $data['nama'] = $nama;
                                // $data['harga'] = $harga;
                                // $data['prqty'] = $prqty;
                                // $data['openqty'] = $openqty;
                                // $data['poqty'] = $poqty;
                            ?>
                            <tr>
                                <td class="col-md-3 text-right">Kode Material</td>
                                <td id="prno"><?php echo $kode["1"] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Nama Material</td>
                                <td id="prno"><?php echo $nama["1"] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Harga</td>
                                <td id="prno"><?php echo $harga["1"] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">PR Qty</td>
                                <td id="prno"><?php echo $prqty["1"] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Open Qty</td>
                                <td id="prno"><?php echo $openqty["1"] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">PO Qty</td>
                                <td id="prno"><?php echo $poqty["1"] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Hand Qty</td>
                                <td id="prno"><?php echo $handqty["1"] ?></td>
                            </tr>
                            <!-- <tr>
                                <td class="col-md-3 text-right">Reject ITEM</td>
                                <td id="prno"><?php if($value['PIV_IS_ITEM'] == 1) echo "YES"; else echo "NO"; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Reject Document</td>
                                <td id="prno"><?php if($value['PIV_IS_ITEM'] == 1 || $value['PIV_IS_DOC']) echo "YES"; else echo "NO"; ?></td>
                            </tr> -->
                            <tr>
                                <td class="col-md-3 text-right">Note</td>
                                <td id="prno"><?php if(is_null($value['PIV_NOTE'])) echo "-"; else echo $value['PIV_NOTE']; ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</section>