<section class="content_section">
  <div class="content row_spacer clearfix" style="padding-top: 40px">
    <div class="rows_container clearfix">
      <div class="col-md-12">
        <div class="main_title centered upper">
          <h2>
            <span class="line"><i class="ico-user3"></i></span>
            Sign
            <span class="main_title_c1"> in</span>
          </h2>
        </div>
      </div>
    </div>
    <div class="rows_container clearfix">
      <div class="col-md-4 col-md-offset-4">
        <form class="login_form_colored" role="form" action="<?php echo base_url('Login_principal/doLoginPrincipal') ?>" method="POST">
          <div class="lfc_user_row">
            <span class="lfc_header">Login E-Procurement For Principal</span>
          </div>
          <div class="lfc_user_row">
            <label for="company" class="custom_select">
              <span class="lfc_alert"></span>
              <i class="lfc_icon ico-office"></i>
              <select name="companyid" id="companyid" required="">
                <option value="" selected="" disabled="">Company</option>
                <?php foreach ($company_name as $key => $value) { ?>
                <option value="<?php echo $value["COMPANYID"]; ?>"><?php echo $value["COMPANYNAME"]; ?></option>
                <?php } ?>
              </select>
            </label>
          </div>
          <div class="lfc_user_row">
            <label for="username">
              <span class="lfc_alert"></span>
              <i class="lfc_icon ico-user5"></i>
              <input type="text" name="username" id="username" placeholder="Username" required="">
            </label>
          </div>
          <div class="lfc_user_row">
            <label for="password">
              <span class="lfc_alert"></span>
              <i class="lfc_icon ico-key3"></i>
              <input type="password" name="password" id="password" placeholder="Password" required="">
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
            <div class="my_col_half">
              <label for="rememberme">
                <span class="remember-box">
                  <input type="checkbox" id="rememberme" name="rememberme">
                  <span>Remember me</span>
                </span>
              </label>
            </div>
            <div class="my_col_half clearfix">
              <button type="submit" name="login" class="send_button f_right upper">
                Sign in
              </button>
            </div>
          </div>
          <a class="lfc_forget_pass" href="<?php echo base_url('Forget'); ?>">Forgot Your Password?</a>
        </form>
      </div>
    </div>
  </div>
</section>