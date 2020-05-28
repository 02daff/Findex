<?php
session_start();
include '../config/conn.php';

if(isset($_POST['submit'])){
    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];

    if($q1 > 0){
        $row1 = $conn->query("SELECT needs FROM recipe1") or $conn->errorInfo();
        $row2 = $conn->query("SELECT m.material_name, m.stock, r1.needs FROM material AS m RIGHT JOIN recipe1 AS r1 ON m.id_material=r1.id WHERE stock>=$q1*needs") or $conn->errorInfo();
        
        if($row1->rowCount() == $row2->rowCount()) {
            while($data = $row2->fetch()){
                $n = $data['needs'];
                $q = $data['stock'];
                $mname = $data['material_name'];

                $q -= ($q1 * $n);

                $setrow = $conn->query("UPDATE material SET stock='$q' WHERE material_name='$mname'") or $conn->errorInfo();      
            }

            $row3 = $conn->query("UPDATE product SET stock=stock + $q1 WHERE id_product='fin-01'") or $conn->errorInfo();
        
        } 
    }

    if($q2 > 0){
        $row1 = $conn->query("SELECT needs FROM recipe2") or $conn->errorInfo();
        $row2 = $conn->query("SELECT m.material_name, m.stock, r2.needs FROM material AS m RIGHT JOIN recipe2 AS r2 ON m.id_material=r2.id WHERE stock>=$q2*needs") or $conn->errorInfo();
        
        if($row1->rowCount() == $row2->rowCount()) {
            while($data = $row2->fetch()){
                $n = $data['needs'];
                $q = $data['stock'];
                $mname = $data['material_name'];

                $q -= ($q2 * $n);

                $setrow = $conn->query("UPDATE material SET stock='$q' WHERE material_name='$mname'") or $conn->errorInfo();
            }

            $row3 = $conn->query("UPDATE product SET stock=stock + $q2 WHERE id_product='fin-02'") or $conn->errorInfo();
        }
    }

    if($q1 == 0 AND $q2 == 0){
        header("location: ../views/".strtolower($_SESSION['role'])."/prod?page=2&status=empty");
        exit;
    }else{
        $insert = $conn->query("INSERT INTO proddata VALUES ('', NOW(), '$q1', '$q2')") or $conn->errorInfo();

        header("location: ../views/".strtolower($_SESSION['role'])."/prod?page=2&status=succ");
        exit;
    }
  }