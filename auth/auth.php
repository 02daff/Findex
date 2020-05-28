<?php 
	include('../config/conn.php');
	session_start();
	//Check login status
	if (isset($_SESSION['status'])) {
		if($_SESSION['status'] == null){
			//echo $_SESSION['status'];
			header("location:../auth/logout.php");
			exit;
		}else{
			//echo $_SESSION['status'];
			header("location:../views/".strtolower($_SESSION['role'])."/home?page=0");
			exit;
		}
	}
?>