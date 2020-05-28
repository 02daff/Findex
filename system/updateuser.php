<?php 
	session_start();
	include "../config/conn.php";

	$rolestat = $_GET['role'];

	$id_user = $_POST['id_user'];
	$role = $_POST['role'];
	$pass = $_POST['pass'];

	if($rolestat == 'sub'){
		$phone = $_POST['phone'];
    	$address = $_POST['address'];

		$row = $conn->query("UPDATE user SET phone='$phone', address='$address', password='$pass'WHERE id_user='$id_user'");

		header("location:../views/".strtolower($_SESSION['role'])."/users?page=5&status=succ");
		exit;
	}else{

		$row = $conn->query("UPDATE user SET role='$role', password='$pass' WHERE id_user='$id_user'");
		header("location:../views/admin/users?page=5&status=succ");
		exit;
	}

?>