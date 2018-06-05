<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <?php foreach ($fungsi as $key => $value) { ?>
                <a href="<?php echo base_url().'Export_pdf/'.$value; ?>" target="_blank">Form Cetak <?php echo $value; ?></a><br>
            <?php } ?>
        </div>
    </div>
</section>