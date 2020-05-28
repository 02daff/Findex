<?php
    include '../config/conn.php';
    session_start();

    if ($_FILES["uploaded"]["error"] > 0){
        echo "Error: " . $_FILES["uploaded"]["error"] . "<br>";
        header("location: ../views/".strtolower($_SESSION['role'])."/prod?page=2&status=err");
        exit;
    }
    else{
        $lead_file=$_FILES["uploaded"]["name"];

        move_uploaded_file($_FILES["uploaded"]["tmp_name"],
        "csv/" . $_FILES["uploaded"]["name"]);
        
        $conn->query("DELETE FROM prodplan");

        $file_csv = '../../htdocs/Findex/system/csv/prodplan.csv';

        $query = "LOAD DATA INFILE '$file_csv'
            INTO TABLE prodplan
            FIELDS TERMINATED BY ','
            OPTIONALLY ENCLOSED BY '\"' 
            LINES TERMINATED BY '\\r\\n'
            IGNORE 1 LINES ";

        $conn->query($query);

        $conn->query("UPDATE prodplan SET status='Active' ORDER BY year ASC LIMIT 1");

        header("location: ../views/".strtolower($_SESSION['role'])."/prod?page=2&status=succ");
        exit;
    }
?>