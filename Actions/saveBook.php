<?php
include_once "../Functions/Import.php";
//header('Content-type: application/json');
$response_array = [];
if ( isset ( $_POST [ "token" ] ) ) {
    $db = GetDatabaseConnection( 'library' ) ;
    $title = $_POST[ 'title' ];
    $sub = $_POST["sub"];
    $edition = $_POST["edition"];
    $author = $_POST["author"];
    $publisher = $_POST["publisher"];
    $year = $_POST["year"];
    $copy = $_POST["copy"];
    $dept = $_POST["dept"];
    $price = $_POST["price"];


    $query = $db -> prepare("INSERT INTO books VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?)");

    if($query->execute(array($title,$sub,$edition,$price,$author,$publisher,$year,$dept,$copy,CurruntTimeStamp(),CurruntTimeStamp())))
    {
        $response_array["error"] = "false";
        $_SESSION["bookid"] = $db->lastInsertId();
    } else {
        $response_array["error"] = $query->errorInfo();
    }

    print_r($response_array);
}
//echo json_encode($response_array);
?>