<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <form action="<?php echo base_url()."Dashboard_report/PO" ?>" method="POST">
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="col-md-2">Opco</td>
                                    <td>
                                        <div class="col-xs-4 " style="padding:0">
                                            <input type="checkbox" name="opco[]" value="1000" <?php if(isset($post['opco'])) if(in_array("1000",$post['opco'])) echo "checked"; ?>> Holding Semen Gresik Group
                                        </div>
                                        <div class="col-xs-4 " style="padding:0">
                                            <input type="checkbox" name="opco[]" value="2000" <?php if(isset($post['opco'])) if(in_array("2000",$post['opco'])) echo "checked"; ?>> PT. Semen Indonesia (Tbk)
                                        </div>
                                        <div class="col-xs-4 " style="padding:0">
                                            <input type="checkbox" name="opco[]" value="7000" <?php if(isset($post['opco'])) if(in_array("7000",$post['opco'])) echo "checked"; ?>> PT. Semen Indonesia - VO
                                        </div>
                                        <div class="col-xs-4 " style="padding:0">
                                            <input type="checkbox" name="opco[]" value="3000" <?php if(isset($post['opco'])) if(in_array("3000",$post['opco'])) echo "checked"; ?>> Semen Padang
                                        </div>  
                                        <div class="col-xs-4 " style="padding:0">
                                            <input type="checkbox" name="opco[]" value="4000" <?php if(isset($post['opco'])) if(in_array("4000",$post['opco'])) echo "checked"; ?>> Semen Tonasa
                                        </div>
                                        <div class="col-xs-4 " style="padding:0">
                                            <input type="checkbox" name="opco[]" value="5000" <?php if(isset($post['opco'])) if(in_array("5000",$post['opco'])) echo "checked"; ?>> Semen Gresik
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tahun</td>
                                    <td>
                                        <?php for ($i=2000; $i <= Date("Y"); $i++) { ?>
                                            <div class="col-xs-1 " style="padding:0">
                                                <input type="checkbox" name="tahun[]" value="<?php echo $i ?>"  <?php if(isset($post['tahun'])) if(in_array($i,$post['tahun'])) echo "checked"; ?>> <?php echo $i ?>
                                            </div>
                                        <?php } ?>
                                        
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bulan</td>
                                    <td>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="01" <?php if(isset($post['bulan'])) if(in_array("1",$post['bulan'])) echo "checked"; ?>> Jan
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="02" <?php if(isset($post['bulan'])) if(in_array("2",$post['bulan'])) echo "checked"; ?>> Feb
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="03" <?php if(isset($post['bulan'])) if(in_array("3",$post['bulan'])) echo "checked"; ?>> Mar
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="04" <?php if(isset($post['bulan'])) if(in_array("4",$post['bulan'])) echo "checked"; ?>> Apr
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="05" <?php if(isset($post['bulan'])) if(in_array("5",$post['bulan'])) echo "checked"; ?>> May
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="06" <?php if(isset($post['bulan'])) if(in_array("6",$post['bulan'])) echo "checked"; ?>> Jun
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="07" <?php if(isset($post['bulan'])) if(in_array("7",$post['bulan'])) echo "checked"; ?>> Jul
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="08" <?php if(isset($post['bulan'])) if(in_array("8",$post['bulan'])) echo "checked"; ?>> Aug
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="09" <?php if(isset($post['bulan'])) if(in_array("9",$post['bulan'])) echo "checked"; ?>> Sep
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="10" <?php if(isset($post['bulan'])) if(in_array("10",$post['bulan'])) echo "checked"; ?>> Okt
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="11" <?php if(isset($post['bulan'])) if(in_array("11",$post['bulan'])) echo "checked"; ?>> Nov
                                        </div>
                                        <div class="col-xs-1 " style="padding:0">
                                            <input type="checkbox" name="bulan[]" value="12" <?php if(isset($post['bulan'])) if(in_array("12",$post['bulan'])) echo "checked"; ?>> Dec
                                        </div>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Purch Group</td>
                                    <td>    
                                        <?php foreach ($pgrp as $key => $value): ?>
                                                <div class="col-xs-1 " style="padding:0">
                                                    <input type="checkbox" name="pgrp[]" value="<?php echo $value['PURCH_GRP_CODE'] ?>" <?php if(isset($post['pgrp'])) if(in_array($value['PURCH_GRP_CODE'],$post['pgrp'])) echo "checked"; ?>> <?php echo $value['PURCH_GRP_CODE'] ?>&nbsp;&nbsp;
                                                </div>
                                        <?php endforeach ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <button type="submit" class="btn btn-success">Search</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                    <div class="panel-body text-center">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
