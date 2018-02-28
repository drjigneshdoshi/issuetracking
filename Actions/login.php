<?php
header('Content-type: application/json');
include_once "../Functions/Import.php";
$db=Connection("db_case");
if(isset($_POST["token"]))
{
    $email=$_POST["email"];
    $pass=$_POST["pass"];

    $qry=$db->prepare("SELECT *FROM t_user where email=? AND pwd=?");
    $qry->execute(array($email,md5($pass)));
    $count=$qry->rowCount();
    $data=$qry->fetchAll(PDO::FETCH_ASSOC);
   /* if($count>0 )
    {
        $_SESSION["email"]=$data[0]["email"];
        $_SESSION["name"]=$data[0]["name"];
        $_SESSION["id"]=$data[0]["id"];

        header("Location: home");

    }
    else
    {
        echo '<div class="alert alert-danger">
       	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       	<strong>INVALID ! </strong> Please enter correct user name and password
       </div>';
    }*/

    if($count>0)
    {
        $tc = FetchAccountInfo($data[0]['id'])['tcApproved'];
        $_SESSION["email"]=$data[0]["email"];
        $_SESSION["name"]=$data[0]["name"];
        $_SESSION["id"]=$data[0]["id"];
        $_SESSION["logged"] = "true";
        $response_array["error"] = "false";
        $response_array['tc'] = $tc;
    } else {
        $response_array["error"] = "true";
    }

    echo json_encode($response_array);
}
?>