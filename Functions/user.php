<?php

function EmailExists ( $email ) {
    $db = GetDatabaseConnection ( 'db_case' ) ;
    $query = $db->prepare ( 'SELECT COUNT(*) FROM `t_user` WHERE `email` = :email' ) ;
    $query->bindParam ( ':email' , $email , PDO::PARAM_STR ) ;
    $query->execute () ;
    $data = $query->fetch ( PDO::FETCH_ASSOC ) ;
    return intval ( array_shift ( $data ) ) > 0 ;
}

function GetLoggedAcctName () {
    return isLogged() ? $_SESSION ["name"] : null;
}

function GetLoggedAccountID ( ) {
    return isLogged() ? $_SESSION ["id"] : null;
}

function isLogged () {
    return isset ( $_SESSION [ "logged" ] ) ;
}

function FetchLoggedAccountInfo () {
    $db = GetDatabaseConnection ( 'db_case' ) ;
    $query = $db->prepare ( 'SELECT * FROM `t_user` WHERE `name` = :name' ) ;
    $query->bindParam ( ':name' , $_SESSION [ "name" ] , PDO::PARAM_STR ) ;
    $query->execute () ;
    return ( $query->rowCount () >= 1 ) ? $query->fetch ( PDO::FETCH_ASSOC ) : false ;
}

function FetchAccountInfo ( $id ) {
    $db = GetDatabaseConnection ( 'db_case' ) ;
    $query = $db->prepare ( 'SELECT * FROM `t_user` WHERE `id` = :id' ) ;
    $query->bindParam ( ':id' , $id , PDO::PARAM_STR ) ;
    $query->execute () ;
    return $query->fetch ( PDO::FETCH_ASSOC ) ;
}

function FetchAccountInfoByName ( $account ) {
    $db = GetDatabaseConnection ( 'db_case' ) ;
    $query = $db->prepare ( 'SELECT * FROM `t_user` WHERE `name` = :account' ) ;
    $query->bindParam ( ':account' , $account , PDO::PARAM_STR ) ;
    $query->execute () ;
    return $query->fetch ( PDO::FETCH_ASSOC ) ;
}

function FetchAccountIdByName ( $name )
{

    $id = FetchAccountInfoByName($name)["id"];

    return $id;
}

function EnrollExists ( $enroll ) {
    $db = GetDatabaseConnection ( 'db_case' ) ;
    $query = $db->prepare ( 'SELECT COUNT(*) FROM `t_student` WHERE `enroll` = :enroll' ) ;
    $query->bindParam ( ':enroll' , $enroll , PDO::PARAM_STR ) ;
    $query->execute () ;
    $data = $query->fetch ( PDO::FETCH_ASSOC ) ;
    return intval ( array_shift ( $data ) ) > 0 ;
}

function FetchAccountNameById ( $id ) {

    $name = FetchAccountInfo($id);
    return $name["name"];
}

function IsUser ( ) {
    $acct_info = FetchLoggedAccountInfo ( ) ;
    return ( int ) $acct_info [ 'pv' ] <= 0 ;
}

function IsAdministrator ( ) {
    $acct_info = FetchLoggedAccountInfo ( ) ;
    return ( int ) $acct_info [ 'pv' ] == 1 ;
}

function IsLabAssistant() {
    $acct_info = FetchLoggedAccountInfo ( ) ;
    return ( int ) $acct_info [ 'pv' ] == 2 ;
}

function IsStaff() {
    $acct_info = FetchLoggedAccountInfo ( ) ;
    return ( int ) $acct_info [ 'pv' ] == 3 ;
}


function GetRole($pv) {

    if($pv == 1) {
        return "Admin";
    } else if($pv == 2) {
        return "Lab Assistant";
    } else if($pv == 3) {
        return "Staff";
    } else {
        return "User";
    }
}

function getStaff(){

    $db = GetDatabaseConnection('db_case');
    $query = $db->prepare('SELECT name FROM `t_user` WHERE pv != 0 AND pv != 1');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function GetLab($lab) {

    $db = Connection('db_case');

    $query = $db->prepare("SELECT *FROM t_labs WHERE lab=?");
    $query->execute([$lab]);

    return $query->fetchAll(2);
}