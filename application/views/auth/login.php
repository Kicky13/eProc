<section class="content_section">
    <div class="content row_spacer clearfix" style="padding-top: 40px">
      <div class="rows_container clearfix">
        <div class="col-md-12">
          <div class="main_title centered upper">
            <h2>
              <span class="line"><i class="ico-user3"></i></span>
              Sign in
            </h2>
          </div>
        </div>
      </div>
      <div class="rows_container clearfix">
        <div class="col-md-4 col-md-offset-4">
          <form class="login_form_colored" role="form" action="<?php echo base_url(); ?>Login/doLogin" method="POST">
            <div class="lfc_user_row">
              <span class="lfc_header">Login E-Procurement</span>
            </div>
            <?php if(isset($msg)){?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <?php echo isset($msg)?urldecode($msg):'';?>
            </div>
            <?php }?>
            <div class="lfc_user_row">
              <label for="username">
                <span class="lfc_alert"></span>
                <i class="lfc_icon ico-user5"></i>
                <input type="text" name="username" id="username" placeholder="e-mail">
              </label>
            </div>
            <div class="lfc_user_row">
              <label for="password">
                <span class="lfc_alert"></span>
                <i class="lfc_icon ico-key3"></i>
                <input type="password" name="password" id="password" placeholder="password">
                <input type="hidden" name="channel" id="channel" value="<?php echo isset($channel)?$channel:'';?>">
              </label>  
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
            <a class="lfc_forget_pass" href="#">Forgot Your Password?</a>
          </form>
        </div>
      </div>
    </div>
  </section>
