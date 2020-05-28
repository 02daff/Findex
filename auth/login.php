<?php
    session_start();
    include '../config/conn.php';
    
    $user = $_POST['username'];
    $pass = $_POST['pass'];

    $row = $conn->query("SELECT * FROM user WHERE username= '$user' and password= '$pass'");

    $data = $row->fetch();

    if($row->rowCount() > 0){
        $_SESSION['name'] = $data['name'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['status'] = "login";

        $id_user = $_SESSION['id_user'];
        $name = $_SESSION['name'];
        $role = $_SESSION['role'];

        $urow = $conn->query("INSERT INTO userlog VALUES ('$id_user', '$role', NOW())");

        header("location:../views/".strtolower($_SESSION['role'])."/home?page=0");
    }else{
        header("location:../views/login?message=failed");
    }
    
?>
