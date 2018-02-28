<?php
require_once '../Functions/Database.php' ;
$db = GetDatabaseConnection( 'db_case' );
if(isset($_POST["id"]))
{
    $id = $_POST["id"];
    $query = $db->prepare('DELETE FROM `t_user` WHERE id=?');
    $query->execute(array($id));
}
