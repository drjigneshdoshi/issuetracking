<?php
include_once "../Functions/Import.php";
$db=Connection("db_case");
$response_array= array();
if(isset($_POST["token"]))
{
    $email=$_POST["email"];
    $pass=md5($_POST["pass"]);
    $name=$_POST["name"];
    $phone=$_POST["phone"];
    $dept=$_POST["dept"];
    $enroll=$_POST["enroll"];
    $gender=$_POST["Gender"];
    $div=isset($_POST["div"]) ? $_POST["div"] : null;
    $pv = 0;
    $tc = 0;
    $date = CurrantTimeStamp();

    $query = $db->prepare("INSERT INTO t_user VALUES (NULL,:name,:phone,:email,:pwd,:pv,:tc,:createdAt,:updatedAt)");
    $query->bindParam ( ':name' , $name , PDO::PARAM_STR ) ;
    $query->bindParam ( ':phone' , $phone , PDO::PARAM_STR ) ;
    $query->bindParam ( ':email' , $email , PDO::PARAM_STR ) ;
    $query->bindParam ( ':pwd' , $pass , PDO::PARAM_STR ) ;
    $query->bindParam ( ':pv' , $pv , PDO::PARAM_STR ) ;
    $query->bindParam ( ':tc' , $tc , PDO::PARAM_INT ) ;
    $query->bindParam ( ':createdAt' , $date , PDO::PARAM_STR ) ;
    $query->bindParam ( ':updatedAt' , $date , PDO::PARAM_STR ) ;
    $query->execute();
    $id = $db->lastInsertId();

    $query = $db->prepare("INSERT INTO t_student VALUES (NULL,:uid,:gender,:dept,:div,:enroll,:createdAt,:updatedAt)");
    $query->bindParam ( ':uid' , $id , PDO::PARAM_STR ) ;
    $query->bindParam ( ':gender' , $gender , PDO::PARAM_STR ) ;
    $query->bindParam ( ':dept' , $dept , PDO::PARAM_STR ) ;
    $query->bindParam ( ':div' , $div , PDO::PARAM_STR ) ;
    $query->bindParam ( ':enroll' , $enroll , PDO::PARAM_STR ) ;
    $query->bindParam ( ':createdAt' , $date , PDO::PARAM_STR ) ;
    $query->bindParam ( ':updatedAt' , $date , PDO::PARAM_STR ) ;
    $query->execute();

    return true;
}
?>