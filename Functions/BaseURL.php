<?php

/**
 * @return string
 */
function GetBaseURL ( ) {
    $burl = array ( ) ;
    $burl [ 'schema' ] = sprintf ( 'http%s' , isset( $_SERVER[ 'HTTPS' ] ) ? 's' : null ) ;
    $burl [ 'host' ] = sprintf ( '://%s' , $_SERVER [ 'HTTP_HOST' ] ) ;
    $burl = implode ( $burl ) ;
    $burl = str_replace ( array ( '\\' , '/' ) , '/' , $burl ) ;
    return $burl . '/issuetracking' ;
}

/**
 * @param $concat
 * @return string
 */
function BaseURLConcat ($concat ) {
    if ( ! is_null ( $concat ) && strlen ( $concat ) > 0 ) {
        if ( substr ( GetBaseURL ( ) , -1 ) === '/' ) {
            return sprintf ( '%s%s' , GetBaseURL ( ) , $concat ) ;
        } else return sprintf ( '%s/%s' , GetBaseURL ( ) , $concat ) ;
    }
    return null;
}

function loadResource( $type, $link ) {
    if ( $type == "css" ) {
        return "<link href='".BaseURLConcat("Asset/css/".$link)."' rel='stylesheet' type='text/css' />";
    } else if( $type == "js" ) {
        return "<script src='".BaseURLConcat("Asset/js/".$link)."'></script>";
    } else {
        return null;
    }
}