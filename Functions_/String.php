<?php

function is_utf8 ( $string ) {
    return preg_match ( '%^(?:
                 [\x09\x0A\x0D\x20-\x7E]
                | [\xC2-\xDF][\x80-\xBF]
                | \xE0[\xA0-\xBF][\x80-\xBF]
                | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
                | \xED[\x80-\x9F][\x80-\xBF]
                | \xF0[\x90-\xBF][\x80-\xBF]{2}
                | [\xF1-\xF3][\x80-\xBF]{3}
                | \xF4[\x80-\x8F][\x80-\xBF]{2}
                )*$%xs' , $string
    ) ;
}

function removeAccents ( $string ) {
    return preg_replace (
        array (
            '/\xc3[\x80-\x85]/' ,
            '/\xc3\x87/' ,
            '/\xc3[\x88-\x8b]/' ,
            '/\xc3[\x8c-\x8f]/' ,
            '/\xc3([\x92-\x96]|\x98)/' ,
            '/\xc3[\x99-\x9c]/' ,
            '/\xc3[\xa0-\xa5]/' ,
            '/\xc3\xa7/' ,
            '/\xc3[\xa8-\xab]/' ,
            '/\xc3[\xac-\xaf]/' ,
            '/\xc3([\xb2-\xb6]|\xb8)/' ,
            '/\xc3[\xb9-\xbc]/' ,
        ) , str_split ( 'ACEIOUaceiou' , 1 ) , is_utf8 ( $string ) ? $string : utf8_encode ( $string )
    ) ;
}

function ToURLString ( $string ) {
    return strtolower ( preg_replace( '/\s+/' , '-' , removeAccents ( $string ) ) );
}

function wrap ( $text , $length = 64 , $tail = "..." ) {
    $text = trim ( $text ) ;
    if ( strlen ( $text ) > $length ) {
        for ( $i = 0 ; $text[ $length + $i ] != " " ; $i ++  ) {
            if ( ! $text[ $length + $i ] ) {
                return $text ;
            }
        }
        $text = substr ( $text , 0 , $length + $i ) . $tail ;
    }
    return $text ;
}

function MatchRule ( $regexp , $data ) {
    return preg_match ( $regexp , $data ) ;
}

function MatchLength ( ) {
    $args = func_get_args ( ) ;
    if ( count ( $args ) === 3 ) {
        $min = $args [ 0 ] ;
        $max = $args [ 1 ] ;
        $data = $args [ 2 ] ;
        return ( strlen ( $data ) >= $min && strlen ( $data ) <= $max ) ? true : false ; ;
    } elseif ( count ( $args ) === 2 ) {
        return ( strlen ( $args [ 1 ] ) >= intval ( $args [ 0 ] ) ) ? true : false ;
    } elseif ( count ( $args ) === 1 ) {
        return ( strlen ( $args [ 0 ] ) > 0 ) ? true : false ;
    }
}

function IsEmpty ( $string ) {
    return strlen ( $string ) === 0 || empty ( $string ) ;
}


function CurrantTimeStamp() {
    return date('Y-m-d H:i:s',time());
}

function CurrantDate() {
    return date('Y-m-d',time());
}

function addDayToCurrentDate($day) {

    return date('Y-m-d',strtotime(CurrantDate(). "+".$day." days"));
}

function AddDayToDate($date,$day) {
    return date('Y-m-d',strtotime($date. "+".$day." days"));
}

function MonthFromDate($date) {
    return date('F',strtotime($date));
}

function FormatDate($date) {
    return date('Y-m-d',strtotime($date));
}

function FormatDateToLocal($date) {
    return date('d-m-Y',strtotime($date));
}