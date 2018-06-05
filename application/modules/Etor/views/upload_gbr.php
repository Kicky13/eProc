<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="container">


                <div class="main_title centered upper">
                    <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                </div>
                <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>Etor/doInsertGambar">

                    <div class="panel-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Panel Upload Gambar</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        GAMBAR
                                    </div>
                                    <div class="col-md-8">
                                        <input name="GAMBAR" id="GAMBAR" onchange="return ValidateFileUploadGAMBAR()" accept="image/x-png,image/gif,image/jpeg,image/jpg,image/png" type="file">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <center>
                                            <button class="main_button color4 small_btn action-button">PROSES</button>
                                        </center>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>

                    <br>
                    <br>
                </form>

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
