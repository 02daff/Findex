<?php 
include '../config/conn.php';
$pageid = $_GET['pageid'];

	if ($pageid == 0){//Prod
		session_start();

		$id_prod = $_GET['id'];

		$row = $conn->query("DELETE FROM proddata WHERE id='$id_prod'");

		if ($_SESSION['role'] == 'Admin') {
			header("location:../views/admin/prod?page=2&status=succ");
			exit;
		}else{
			header("location:../views/".strtolower($_SESSION['role'])."/prod?page=2&status=succ");
			exit;
		}

	}

	if ($pageid == 1){//Inve
		session_start();

		$id_req = $_GET['id'];

		$row = $conn->query("DELETE FROM request WHERE id='$id_req'");
	
		if ($_SESSION['role'] == 'Admin') {
			header("location:../views/admin/invt?page=1&status=succ");
			exit;
		}else{
			header("location:../views/".strtolower($_SESSION['role'])."/invt?page=1&status=succ");
			exit;
		}

	}

	if ($pageid == 2){//Purch
		session_start();

		$id_req = $_GET['id'];

		$row = $conn->query("DELETE FROM request WHERE id='$id_req'");
	
		if ($_SESSION['role'] == 'Admin') {
			header("location:../views/admin/proc?page=3&status=succ");
			exit;
		}else{
			header("location:../views/".strtolower($_SESSION['role'])."/proc?page=3&status=succ");
			exit;
		}

	}

	if ($pageid == 3){//Fina
		session_start();

		$id_order = $_GET['id'];

		$row = $conn->query("DELETE FROM orderdata WHERE id_order='$id_order'");
		
		if ($_SESSION['role'] == 'Admin') {
			header("location:../views/admin/finc?page=4&status=succ");
			exit;
		}else{
			header("location:../views/".strtolower($_SESSION['role'])."/finc?page=4&status=succ");
			exit;
		}
	}

	if ($pageid == 4){//Cust
		session_start();

		$id_order = $_GET['id'];

		$row = $conn->query("DELETE FROM orderdata WHERE id_order='$id_order'");
		
		header("location:../views/customer/order?page=1&status=succ");
		exit;
	}
?>