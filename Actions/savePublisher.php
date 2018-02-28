<?php
include_once "../Functions/Import.php";
header('Content-type: application/json');
$response_array = [];
if ( isset ( $_POST [ "token" ] ) ) {
    $db = GetDatabaseConnection( 'library' ) ;

    $name = $_POST["publisher"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];


    $query = $db -> prepare("INSERT INTO publisher VALUES (NULL,?,?,?,?,?,?)");

    if($query->execute(array($name,$address,$email,$phone,CurruntTimeStamp(),CurruntTimeStamp())))
    {
        $response_array["error"] = "false";
    } else {
        $response_array["error"] = "true";
    }
}
echo json_encode($response_array);
?>