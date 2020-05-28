<?php 
	session_start();
	include "../config/conn.php";

	if(isset($_POST['submit'])){

		if ($_POST['submit'] == 'q1') {
			$id1 = 'fin-01';
			$q1 = $_POST['q1'];

			$row = $conn->query("SELECT * FROM product WHERE id_product='$id1'");
			$data = $row->fetch();

			if($data['stock'] != $q1){
				$row = $conn->query("UPDATE product SET stock='$q1' WHERE id_product='$id1'");
	
				header("location:../views/".strtolower($_SESSION['role'])."/invt?page=1&status=succ");
				exit;
			}else{
				header("location:../views/".strtolower($_SESSION['role'])."/invt?page=1&status=empty");
				exit;
			}	
		}

		if ($_POST['submit'] == 'q2') {
			$id2 = 'fin-02';
			$q2 = $_POST['q2'];

			$row = $conn->query("SELECT * FROM product WHERE id_product='$id2'");
			$data = $row->fetch();
		
			if($data['stock'] != $q2){
				$row = $conn->query("UPDATE product SET stock='$q2' WHERE id_product='$id2'");
	
				header("location:../views/".strtolower($_SESSION['role'])."/invt?page=1&status=succ");
				exit;
			}else{
				header("location:../views/".strtolower($_SESSION['role'])."/invt?page=1&status=empty");
				exit;
			}	
		}
	}
?>