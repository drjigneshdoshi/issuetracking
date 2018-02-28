<?php
include_once "../Functions/Import.php";
header('Content-type: application/json');
$response_array = [];
if ( isset ( $_POST [ "token" ] ) ) {
    $db = GetDatabaseConnection( 'library' ) ;
    $fname = $_POST[ 'firstName' ];
    $lname = $_POST["lastName"];
    $email = $_POST["email"];



    $query = $db -> prepare("INSERT INTO autohr VALUES (NULL,?,?,?,?,?)");

    if($query->execute(array($fname,$lname,$email,CurruntTimeStamp(),CurruntTimeStamp())))
    {
        $response_array["error"] = "false";
    } else {
        $response_array["error"] = "true";
    }
}
echo json_encode($response_array);
?>