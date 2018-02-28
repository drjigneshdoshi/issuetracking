<?php
$server = 'localhost' ;
$username = 'root' ;
$password = '' ;

function GetDatabaseConnection ( $useDb = null ) {
    global $server , $username , $password ;
    $dsn = sprintf ( 'mysql:host=%s' , $server ) ;
    if ( ! is_null ( $useDb ) ) :
        $dsn .= sprintf ( ';dbname=%s' , $useDb ) ;
    endif ;
    $pdo = new PDO ( $dsn , $username , $password ) ;
    $pdo->setAttribute ( PDO::ATTR_TIMEOUT , 1 ) ;
    $pdo->setAttribute ( PDO::ATTR_PERSISTENT , false ) ;
    $pdo->setAttribute ( PDO::MYSQL_ATTR_INIT_COMMAND , 'SET NAMES utf8' ) ;
    return $pdo ;
}

function HasRequiredDatabaseConnections ( ) {
    $connected = 0 ;
    global $server , $username , $password ;
    foreach ( array ( 'db_case'  ) as $database ) :
        $connection = new mysqli ( $server , $username , $password ) ;
        if ( $connection->select_db( $database ) === true ) {
            ++ $connected ;
            $connection->close();
        } else --$connected ;

    endforeach ;
    return ( $connected === 1 ) ;
}

function Connection ( $useDb = null ) {
    return GetDatabaseConnection ( $useDb ) ;
}