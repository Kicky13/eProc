<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" lang="id"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" lang="id"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ie-lt10 ie-lt9 no-js" lang="id"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 ie-lt10 no-js" lang="id"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="id"><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. --> 
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?> | E-Proc <?php echo $this->session->userdata("COMPANYNAME"); ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="eproc, SEMEN INDONESIA GROUP" />
	<meta name="description" content="E-PROCUREMENT – SEMEN INDONESIA GROUP"/>
	<meta name="author" content="SEMEN INDONESIA GROUP"/>
	<meta name="google-site-verification" content="" />
	<meta name="Copyright" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>static/images/logo/semen_gresik_small.ico" type="image/x-icon" />	
	<?php
		if (!empty($styles)) {
			echo $styles;
		}
	?>
	<?php
		if (!empty($header_scripts)) {
			echo $header_scripts;
		}
	?>

	<link href='<?php echo base_url("static/css/fonts/oswald.css") ?>' rel='stylesheet' type='text/css'>
	<link href='<?php echo base_url("static/css/fonts/lato.css") ?>' rel='stylesheet' type='text/css'>
	<link href='<?php echo base_url("static/css/fonts/opensans.css") ?>' rel='stylesheet' type='text/css'>
	
</head>

<!-- Class ( site_boxed - dark - preloader1 - preloader2 - preloader3 - light_header - dark_sup_menu - menu_button_mode - transparent_header - header_on_side ) -->
<body class="preloader3 dark_sup_menu light_header">
<div id="preloader">
	<div class="spinner">
		<div class="sk-dot1"></div><div class="sk-dot2"></div>
		<div class="rect3"></div><div class="rect4"></div>
		<div class="rect5"></div>
	</div>
</div>

<div id="main_wrapper">
	<div id="loading" style="text-align:center">
		<img src="<?php echo base_url().'static/images/semenindonesia.png' ?>" width="60%" style="margin-bottom:10px">
		<div id="fountainG">
			<div id="fountainG_1" class="fountainG"></div>
			<div id="fountainG_2" class="fountainG"></div>
			<div id="fountainG_3" class="fountainG"></div>
			<div id="fountainG_4" class="fountainG"></div>
			<div id="fountainG_5" class="fountainG"></div>
			<div id="fountainG_6" class="fountainG"></div>
			<div id="fountainG_7" class="fountainG"></div>
			<div id="fountainG_8" class="fountainG"></div>
		</div>
	</div>
	<div id="freeze">
	</div>
	<header id="site_header">
		<div class="topbar">
			<div class="content clearfix">
				<div class="top_details clearfix f_left">
					<span><i class="icon ico-phone5"></i><span class="title">SI :</span> (0356) 325 001 EXT (8035)</span>
					<span><i class="icon ico-phone5"></i><span class="title">SP :</span> (0751) 202115</span>
					<span><i class="icon ico-phone5"></i><span class="title">ST :</span> (0410) 310137</span>
				</div>
				<div class="top_details clearfix f_right">
					<div class="right_detail languages-select languages-drop">
						<span><i class="ico-globe4"></i><span><?php echo $available_language[$lang]; ?></span></span>
						<div class="languages-panel">
							<ul class="languages-panel-con">
								<?php foreach ($available_language as $key => $value) { ?>
									<li<?php if($key == $lang) {?> class="active"<?php } ?>><a href="<?php echo base_url(); ?>Language/setLanguage/<?php echo $key; ?>"><?php echo $value; ?><?php if($key == $lang) {?> <i class="ico-check lang_checked"></i><?php } ?></a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<?php if ($this->session->userdata('logged_in')) { ?>
						<span class="right_detail top_login">
							<a href="<?php echo $this->session->userdata('is_vendor') ?site_url('Vendor_change_password/change_password'):'#' ?>"><i class="icon ico-user3"></i><?php echo $this->session->userdata('is_vendor') ? $this->session->userdata('VENDOR_NAME') : $this->session->userdata('USERNAME') ?></a>
							&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url(); ?>Login/doLogout2"><i class="icon ico-sign-out"></i>Logout</a>
						</span>
					<?php }?>
				</div>
			</div>
			<span class="top_expande not_expanded">
				<i class="no_exp ico-angle-double-down"></i>
				<i class="exp ico-angle-double-up"></i>
			</span>
		</div>
			
		<div id="top_bar">
			<div class="content">
				<div id="logo">
						<a href="<?php echo base_url(); ?>">
				<?php if(strpos($_SERVER["REQUEST_URI"],"EC_")===false){ ?>
				
				
						<img class="logo_dark" src="<?php echo base_url(); ?>static/images/logo/logo_eproc.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">
						<img class="logo_light" src="<?php echo base_url(); ?>static/images/logo/logo_eproc.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">
					
				
				<?php } else {?>
				
					<img class="logo" style="max-height:none;height:66px;" src="<?php echo base_url(); ?>static/images/logo/logo_siap.png" alt="Logo Semen Indonesia Advanced Procurement">
				
				<?php }?>
					</a>
				</div>
				<div id="logo_gresik">
					<a href="<?php echo base_url(); ?>">
                                                <!--Iwan (logo diganti KSO 3/1/2017)-->
						<?php if ($this->session->userdata('COMPANYID') == '7000' || $this->session->userdata('COMPANYID') == '2000' || $this->session->userdata('COMPANYID') == '5000') { ?>
							<img class="logo_dark" src="<?php echo base_url(); ?>static/images/logo/logo_sm_kso.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">
						<?php } else if ($this->session->userdata('COMPANYID') == '3000') { ?> 
							<img class="logo_dark" src="<?php echo base_url(); ?>static/images/logo/logo_sm_padang.png" alt="Logo eProcurement PT. Semen Padang Tbk.">
						<?php } else if ($this->session->userdata('COMPANYID') == '4000') { ?>
							<img class="logo_dark" src="<?php echo base_url(); ?>static/images/logo/logo_sm_tonasa.png" alt="Logo eProcurement PT. Semen Tonasa Tbk.">
						<?php } else { ?> 
							<img class="logo_dark" src="<?php echo base_url(); ?>static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">
						<?php } ?>
					</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="navigation_bar">
			<div class="content">
				<nav id="main_nav">
					<div id="nav_menu">
						<span class="mobile_menu_trigger">
						    <a href="#" class="nav_trigger"><span></span></a>
						</span>								
						<ul id="navy" class="clearfix">
							<!-- <li class="normal_menu"><a href="<?php echo base_url(); ?>"><span>Home</span></a></li> -->
							<?php 
							if ($this->session->userdata('logged_in')) {
								if (!empty($menuBar)) {
									echo $menuBar;
								}
							} else { ?>
								<li class="normal_menu"><a href="<?php echo site_url('Register'); ?>"><span><?php echo $baseLanguage['daftar_akun']; ?></span></a></li>
								<li class="normal_menu"><a href="#"><span><?php echo $baseLanguage['pengumuman_lelang']; ?></span></a>
								<li class="normal_menu"><a href="#"><span><?php echo $baseLanguage['pengumuman']; ?></span></a>
							</ul>
							<?php } ?>							
						<!-- </ul> -->

							
					</div>					
				</nav>				
				<nav> 					
					<span style="float:right;margin-top:5px;margin-left:20px;font-size:16px;">WIB</span>
					<span class="real_jam" title="Waktu Sesuai Server" id="tes_jam" style="float:right;margin-top:5px;font-size:16px;"><?php echo date('d M Y H:i:s');?></span>

				</nav>
				<div class="clear"></div>

			</div>
		</div>
		<input type="hidden" id="base-url" value="<?php echo base_url()?>" />
		<input type="hidden" id="UPLOAD_PATH" value="<?php echo UPLOAD_PATH ?>" />
	</header>
