<?php
ob_start();
require_once 'Functions/Import.php';
if(!isLogged()) {
    header("Location: Login");
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Case Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?=loadResource("css","bootstrap.css") ?>
    <?=loadResource("css","style.css") ?>
    <?=loadResource("css","lines.css") ?>
    <?=loadResource("css","font-awesome.css") ?>
    <?=loadResource("css","custom.css") ?>
    <?=loadResource("css","bootstrap-tagsinput.css") ?>
    <?=loadResource("css","bootstrap-select.css") ?>
    <?=loadResource("css","editor.css") ?>
    <?=loadResource("css","lightbox.css") ?>
    <?=loadResource("css","selectize.css") ?>
    <?=loadResource("css","overlay.css") ?>


    <?=loadResource("js","jquery.min.js") ?>
    <?=loadResource("js","jquery_2.1.1.js") ?>
    <?=loadResource("js","bootstrap-3.3.5.js") ?>

    <?=loadResource("js","metisMenu.min.js") ?>
    <?=loadResource("js","custom.js") ?>
    <?=loadResource("js","bootstrapValidator.js") ?>
    <?=loadResource("js","d3.v3.js") ?>
    <?=loadResource("js","rickshaw.js") ?>
    <?=loadResource("js","bootstrap-tagsinput.js") ?>
    <?=loadResource("js","bootstrap-select.js") ?>
    <?=loadResource("js","tinymce.min.js") ?>
    <?=loadResource("js","lightbox.js") ?>
    <?=loadResource("js","clndr.js") ?>
    <?=loadResource("js","Chart.js") ?>

    <link rel="stylesheet" type="text/css" href="Asset/css/dataTables.bootstrap.css">
    <script type="text/javascript" language="javascript" src="Asset/js/JQuery.Datatables.js"></script>
    <script type="text/javascript" language="javascript" src="Asset/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" language="javascript" src="Asset/js/selectize.js"></script>
</head>
<body>
<div id="wrapper">
    <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Case Manager </a>
        </div>
        <div class="navbar-header" style="float: right;">
            <a class="navbar-brand" href="#"><label style="font-size: 20px;"><? echo "Welcome ".$_SESSION["name"] ?></label> </a>
        </div>
        <?include('leftpanel.php'); ?>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            </li>
        </ul>
    </nav>

    <div id="wrapper">
        <div id="page-wrapper">
            <div class="graphs">
                <?
                $page = isset ( $_REQUEST [ 'page' ] ) ? $_REQUEST [ 'page' ] : 'home' ;
                if ( $page !== 'home' && strlen ( $page ) > 0 ) {
                    $file = sprintf ( '%s.php' , $page ) ;
                    if ( file_exists ( $file ) ) {
                        /** @noinspection PhpIncludeInspection */
                        require_once $file ;
                    } else header ( 'Location: ' . BaseURLConcat ( '404' ) , true ) ;
                } else require_once 'main.php' ;
                ?>
            </div>
        </div>
    </div>
    <?=loadResource("js","bootstrap.min.js") ?>

</body>
</html>
<? ob_end_flush() ?>
