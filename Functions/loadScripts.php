<?php

function load_fancybox ( ) {
    echo '<link rel="stylesheet" href="', BaseURLConcat ( 'Asset/css/jquery.fancybox-1.3.4.css' ) ,'" />' ;
    echo '<script type="text/javascript" src="', BaseURLConcat ( 'Asset/js/Fancybox/jquery.easing-1.3.pack.js' ) ,'"></script>' ;
    echo '<script type="text/javascript" src="', BaseURLConcat ( 'Asset/js/Fancybox/jquery.fancybox-1.3.4.js' ) ,'"></script>' ;
    echo '<script type="text/javascript" src="', BaseURLConcat ( 'Asset/js/Fancybox/jquery.fancybox-1.3.4.pack.js' ) ,'"></script>' ;
    echo '<script type="text/javascript" src="', BaseURLConcat ( 'Asset/js/Fancybox/jquery.mousewheel-3.0.4.pack.js' ) ,'"></script>' ;
    return "";
}

function load_cycle ( ) {
    echo '<script type="text/javascript" src="', BaseURLConcat ( 'Asset/js/jquery.cycle.all.latest.js' ) ,'"></script>' ;
    return "";
}

function load_tipsy ( ) {
    echo '<script type="text/javascript" src="', BaseURLConcat ( 'Asset/js/jquery.tipsy.js' ) ,'"></script>' ;
    return "";
}

function load_hint ( ) {
    echo '<script type="text/javascript" src="', BaseURLConcat ( 'Asset/css/hint.css' ) ,'"></script>' ;
    return "";
}