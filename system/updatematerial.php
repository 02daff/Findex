<?php 
	session_start();
	include "../config/conn.php";

	$id_material = $_POST['id_material'];
	$material_name = $_POST['material_name'];
	$price = $_POST['price'];
	$stock = $_POST['stock'];

	$row = $conn->query("UPDATE material SET material_name='$material_name', price='$price', stock='$stock' WHERE id_material='$id_material'");
	
	header("location:../views/".strtolower($_SESSION['role'])."/invt?page=1&status=succ");
?>