<?php
include_once "../Functions/Import.php";
header('Content-type: application/json');
$response_array = [];
if ( isset ( $_POST [ "token" ] ) ) {
       $db = GetDatabaseConnection( 'db_case' ) ;
       $name = $_POST[ 'name' ];
       $email = $_POST[ 'email' ];
       $pwd = $_POST[ 'pwd' ];
       $phone = $_POST[ 'phone' ];
       $pv = $_POST[ 'role' ];


        if(EmailExists($email)) {
            $response_array['status'] = "error";
            $response_array["message"] = "Email Exist";
        }


       $query = $db -> prepare("INSERT INTO t_user VALUES (NULL,:name,:phone,:email,:pwd,:pv,0,:createdAt,:updatedAt)");
       $query->bindParam ( ':name' , $name , PDO::PARAM_STR ) ;
       $query->bindParam ( ':phone' , $phone , PDO::PARAM_STR ) ;
       $query->bindParam ( ':email' , $email , PDO::PARAM_STR ) ;
       $query->bindParam ( ':pwd' , md5($pwd) , PDO::PARAM_STR ) ;
       $query->bindParam ( ':pv' , $pv , PDO::PARAM_STR ) ;
       $query->bindParam ( ':createdAt' , CurrantTimeStamp() , PDO::PARAM_STR ) ;
       $query->bindParam ( ':updatedAt' , CurrantTimeStamp() , PDO::PARAM_STR ) ;
       if($query->execute())
       {
           $response_array["error"] = "false";
       } else {
           $response_array["error"] = "true";
           $response_array["data"] = $query->errorInfo();
       }
   }
    echo json_encode($response_array);
?>