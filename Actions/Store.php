<?php

include_once "../Functions/Import.php";
$db = GetDatabaseConnection("library");


if ($_FILES["ssn"]["size"] > 0 ) {

    //get the csv file
    $file = $_FILES["ssn"]["tmp_name"];
    $handle = fopen($file,"r");
    $theData = fgets($handle);
    $i = 0;
    $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv','application/octet-stream');
    if(in_array($_FILES['ssn']['type'],$mimes)){
        while (!feof($handle)) {
            $csv_data[] = fgets($handle, 1024);
            $csv_array = explode(",", $csv_data[$i]);
            $insert_csv = array();
            $book['ssn'] = $csv_array[1];
            $book['bid'] = $_SESSION["bookid"];
            $book['status'] = GetBookStatusId($csv_array[2]);
            print_r($insert_csv);

            $query = $db->prepare("INSERT INTO stock (ssnNo, bookId, status)  VALUES (?,?,?)");
            if($query->execute(array_values($book))) {
                echo json_encode("success");
            } else {
                echo json_encode("success");
            }

        }
        fclose($handle);
    } else {
        die("fileError");
    }
}