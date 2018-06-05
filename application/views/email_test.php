
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span>Testing Email</h2>
      </div>
      <div class="row">
          <div class="panel-body">

            <div class="form-group">
              <?php echo form_open('TesEmail/email_default',array('class' => 'form-horizontal')); ?>
                    <p>Testing email methods default yang sudah bisa</p>
                      <button class="main_button color2 small_btn" type="submit">Send</button>
              <?php echo form_close(); ?>
            </div>

            <div class="form-group">
                <?php echo form_open('TesEmail/email_php',array('class' => 'form-horizontal')); ?>
                  <p>Testing email methods php mail()</p>
                    <button class="main_button color1 small_btn" type="submit">Send</button>
                <?php echo form_close(); ?>
            </div> 

        </div>   
      </div> 
    </div >
  </div >
</section>
