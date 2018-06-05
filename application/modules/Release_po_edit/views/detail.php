<style type="text/css">
    input[name="KOMEN"] { 
        height: 250px !important;
    }
</style>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="container">
                <div class="main_title centered upper">
                    <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                </div>

                <form id="etor-form" enctype="multipart/form-data" method="post" action="<?php echo base_url()?>Doc_po/doSimpan">

                    <input type="hidden" name="PO_ID" id="PO_ID" value="<?php echo $id; ?>">
                    <br>
                    <div class="panel-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Panel Upload Dokumen</div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        Doc. PO :
                                    </div>
                                    <div class="col-md-8">
                                    <input name="DOC_PO" id="DOC_PO" type="file">
                                    </div>
                                </div>
                                <?php
                                if($data_main[0]['DOC_PO']!=""){
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Doc. PO Lama:
                                        </div>
                                        <div class="col-md-8">
                                            <a href="<?php echo base_url()?>upload/temp/<?php echo $data_main[0]['DOC_PO'];?>">ATTACHMENT DOC PO</a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-8">
                                        <button class="main_button color4 small_btn action-button">PROSES</button>
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
