<?php
include('../config/conn.php');

if(isset($_POST['submit'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $name = $fname .' '. $lname;

    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $pass = $_POST['pw'];
    $verify_pass = $_POST["pw_verify"];
    $role = 'Customer';

    $row = $conn->query("SELECT * FROM user WHERE username= '$username'");

    if($row->rowCount() > 0){
        header("location:../views/register?message=failed");
        exit;
    }elseif($pass != $verify_pass){
        header("location:../views/register?message=errpass");
        exit;
    }else{
        //$password = sha1($pass);
        $row = $conn->query("INSERT INTO user (name, phone, address, username, password, role) VALUES ('$name','$phone','$address','$username','$pass','$role')");   
        
        if ($row) {
            header("location:../views/login?message=success");
        }else{
            header("location:../views/register?message=404");	
        }
    }
}
?>