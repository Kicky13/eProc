<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <?php
            $disabled = ""; 
            if($tor_data[0]['IS_SUBMIT_PR']==0 || $tor_data[0]['IS_SUBMIT_PR']=="0"){
                $disabled = "readonly=readonly";
            } else {
                $disabled = "disabled=disabled";
            }

            if(count($tor_data_appv)<3){
                $panel = "panel-danger";
                $pesan = "Dokumen E-Tor ini kurang dari 3 approval";
            } else {
                $panel = "panel-success";
                $pesan = "Dokumen E-Tor telah dapat 3 approval";

            }
            ?>
            <div class="container">
                <div class="main_title centered upper">
                    <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                </div>

                <div class="panel-group">
                    <div class="panel <?php echo $panel; ?>">
                        <div class="panel-heading"><?php echo $pesan; ?></div>
                        <div class="panel-body">


                            <form id="etor-form" enctype="multipart/form-data" method="post" action="<?php echo base_url()?>Etor/doUpdateTORPR">
                                <input type="hidden" name="loaddt" id="loaddt" value="createprtor">
                                <input type="hidden" name="ID_TOR" id="ID_TOR" value="<?php echo $tor_data[0]['ID_TOR']; ?>">

                                <div class="row">
                                    <div class="col-md-4">
                                        No Tor :
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="NO_TOR" class="form-control" value="<?php echo $tor_data[0]['NO_TOR']; ?>" <?php echo $disabled; ?>>
                                    </div>
                                </div>
                                <br>

                                <?php
                                if($tor_data[0]['IS_SUBMIT_PR']==0 || $tor_data[0]['IS_SUBMIT_PR']=="0"){

                                    ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            No PR :
                                        </div>
                                        <div class="col-md-8">
                                            <select name="NO_PR" value="" class="form-control select2">
                                                <option disabled value>Pilih PR</option>
                                                <?php foreach ($data_pr['data'] as $dpr ) :?>
                                                    <?php
                                                    $selected = "";
                                                    if($dpr['PPR_PRNO']==$tor_data[0]['NO_PR']){
                                                        $selected = "selected=selected";
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?> value="<?php echo $dpr['PPR_PRNO'];?>"><?php echo $dpr['PPR_PRNO'].'-'.$dpr['PPR_DOCTYPE'];?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="panel panel-default">
                                        <div class="panel-body text-center">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <select name="type">
                                                            <option value="0">draft</option>
                                                            <option value="1">submit</option>
                                                        </select>
                                                        <button class="main_button color4 small_btn action-button">PROSES</button>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            No PR :
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="NO_PR" class="form-control" value="<?php echo $tor_data[0]['NO_PR']; ?>" <?php echo $disabled; ?>>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <br>
                                <br>
                            </form>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<br>
<br>
<br>
<br>
<br>
<br>
