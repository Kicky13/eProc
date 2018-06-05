<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Default Public Template
 */
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url('static/css/bootstrap.css') ?>" />
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.js') ?>"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

    <?php // Fixed navbar ?>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('EC_API/Report') ?>">PTPN</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <?php // Nav bar left ?>
                <ul class="nav navbar-nav">
                    <li class=""><a target="_blank" href="<?php echo site_url('EC_API/Timbangan/generateCsv') ?>">Generate File</a></li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Read Files<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li class=""><a target="_blank" href="<?php echo site_url('EC_API/Timbangan/bacaFile') ?>">File SAP</a></li>
                      <li class=""><a target="_blank" href="<?php echo site_url('EC_API/Timbangan/bacaFileError') ?>">File Error SAP</a></li>
                    </ul>
                  </li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Files<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li class=""><a href="<?php echo site_url('EC_API/Report/listFile?url=EC_API/Timbangan/listRemoteFileReceive&mode=files&location=receive') ?>">List File Receive</a></li>
                      <li class=""><a href="<?php echo site_url('EC_API/Report/listFile?url=EC_API/Timbangan/listRemoteFileSend&mode=files&location=send') ?>">List File Send</a></li>
                      <li class=""><a href="<?php echo site_url('EC_API/Report/listFile?url=EC_API/Timbangan/listRemoteFileError&mode=files&location=error') ?>">List File Error</a></li>
                    </ul>
                  </li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Archive<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li class=""><a href="<?php echo site_url('EC_API/Report/listFile?url=EC_API/Timbangan/listRemoteFileArchiveReceive&mode=archive&location=receive') ?>">List File Receive</a></li>
                      <li class=""><a href="<?php echo site_url('EC_API/Report/listFile?url=EC_API/Timbangan/listRemoteFileArchiveSend&mode=archive&location=send') ?>">List File Send</a></li>
                      <li class=""><a href="<?php echo site_url('EC_API/Report/listFile?url=EC_API/Timbangan/listRemoteFileArchiveError&mode=archive&location=error') ?>">List File Error</a></li>
                    </ul>
                  </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php // Main body ?>
    <div class="container theme-showcase" role="main">
        <?php // Page title ?>
        <div class="page-header">
            <h1><?php echo isset($page_title) ? $page_title : 'PTPN' ?></h1>
        </div>

        <?php // Main content ?>
        <?php echo $content; ?>

    </div>
