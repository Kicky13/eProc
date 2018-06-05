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