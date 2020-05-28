<?php 
	include '../config/conn.php';

	session_start();

	$id_user = $_GET['id'];

	$row = $conn->query("DELETE FROM user WHERE id_user='$id_user'");
	
	header("location:../views/admin/users?page=5&status=succ");
	exit;
?>