<?php
/**
 * Created by PhpStorm.
 * User: Divyank
 * Date: 22-Jan-17
 * Time: 12:32 PM`
 */

include_once "../Functions/Import.php";
if(isset($_POST["assign"])) {

    $name = $_POST["name"];
    $id = $_POST["id"];
    $uid = FetchAccountIdByName($name);
    $db = Connection('db_case');

    $case = GetCaseByID($id);

    if($case["status"] != "Opened" && !IsAdministrator()) {

        echo "notOpen";
        return;
    }

    if(count(GetAssignedCaseByCaseId($id,$uid)) > 0) {

        echo "assigned";
        return;
    }



    $assigned = $db->prepare("SELECT count(*) FROM t_assign WHERE cid=?");
    $assigned->execute([$id]);

    if($assigned->fetchColumn() > 0) {
        $query = $db->prepare("UPDATE t_assign SET uid =?,time=CURRENT_TIMESTAMP WHERE cid=?");
    } else $query = $db->prepare("INSERT INTO  t_assign (uid, cid, time) VALUES (?,?,CURRENT_TIMESTAMP)");

    createLog(GetLoggedAccountID(),"Case ".$id." Assigned to ".$name."");
    echo $query->execute(array($uid,$id));

    $query = $db->prepare("UPDATE t_cases SET status=? WHERE cid=?");
    $query->execute(['Assigned',$id]);

}