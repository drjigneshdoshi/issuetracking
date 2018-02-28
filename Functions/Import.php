<?php

if ( ! isset ( $_SESSION ) ) {
    session_start ( ) ;
  //  echo $_SESSION["name"];
}


$import_filename = explode ( DIRECTORY_SEPARATOR , __FILE__ ) ;
$imp = array_pop ( $import_filename ) ;

foreach ( glob ( str_replace('\\', '/', __DIR__.'/*.php' ) ) as $fn ) {
    if ( $fn !== $imp ) {
        if ( is_readable ( $fn ) ) {
            include_once $fn ;
        }
    }
}

if ( ! HasRequiredDatabaseConnections ( ) ) {
    header ( 'Location: database-error' , true ) ;
    exit ;
}
$permissions = new Permission ( GetLoggedAccountID() , GetDatabaseConnection ( 'db_case' ) ) ;
