<section class="content_section">
  <div class="content row_spacer clearfix" style="padding-top: 40px">
    <div class="rows_container clearfix">
      <div class="col-md-12">
        <div class="main_title centered upper">
          <h2>
            <span class="line"><i class="ico-user3"></i></span>
            Forget
            <span class="main_title_c1"> password</span>
          </h2>
        </div>
      </div>
    </div>
    <div class="rows_container clearfix">
      <div class="col-md-4 col-md-offset-4">
    <?php if ($this->session->flashdata('error') == 'error'): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Gagal</strong> Email tidak ditemukan.
        </div>
      <?php endif ?>
        <form class="login_form_colored" role="form" action="<?php echo base_url('Forget/getNewPassword') ?>" method="POST">
          <div class="lfc_user_row">
            <span class="lfc_header">Forget Password E-Procurement</span>
          </div>
          <div class="lfc_user_row">
            <label for="company" class="custom_select">
              <span class="lfc_alert"></span>
              <i class="lfc_icon ico-office"></i>
              <select name="companyid" id="companyid" required="">
                <option value="" selected="" disabled="">Company</option>
                <?php foreach ($company as $key => $value) { ?>
                <option value="<?php echo $value["COMPANYID"]; ?>"><?php echo $value["COMPANYNAME"]; ?></option>
                <?php } ?>
              </select>
            </label>
          </div>
          <div class="lfc_user_row">
            <label for="email">
              <span class="lfc_alert"></span>
              <i class="lfc_icon ico-user5"></i>
              <input type="text" name="email" id="email" placeholder="Email" required="">
            </label>
          </div>
          <div class="lfc_user_row clearfix">
            <div class="my_col_half">
              <?php echo $captcha['image']; ?>
            </div>
            <div class="my_col_half">
              <label for="captcha">
                <span class="lfc_alert"></span>
                <i class="lfc_icon ico-random"></i>
                <input id="captcha" name="captcha" type="text" required="" placeholder="Captcha" value="<?php echo $captcha['word']; ?>">
              </label>
            </div>
          </div>
          <div class="lfc_user_row clearfix">
              <button type="submit" name="login" class="send_button f_right upper">
                Get Password
              </button>
          </div>
          <a class="lfc_forget_pass" href="Login_vendor">Have an account? <strong>Sign in here</strong></a>
        </form>
      </div>
    </div>
  </div>
</section>