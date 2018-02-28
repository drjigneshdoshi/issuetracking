<?php
    require_once("../Functions/Import.php");
    if(isset($_POST["validate"]) && $_POST["validate"] == "email") {
        $response = EmailExists($_POST["email"]) == 0 ? true : false;
        echo json_encode(array('valid' => $response));
    } else if(isset($_POST["validate"]) && $_POST["validate"] == "lab") {
        $response = count(GetLab($_POST['lab'])) == 0 ? true : false;
        echo json_encode(array('valid' => $response));
    } else if(isset($_POST["validate"]) && $_POST["validate"] == "enroll") {
        $response = EnrollExists($_POST["enroll"]) == 0 ? true : false;
        echo json_encode(array('valid' => $response));
    }

