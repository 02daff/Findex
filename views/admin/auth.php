<?php 
	include '../../config/conn.php';

	//Check login status
	if (isset($_SESSION['status'])) {
		if ($_SESSION['role'] != 'Admin') {
			header("location: ../".strtolower($_SESSION['role'])."/home?page=0");
			isset($_SESSION['status']);
		}
	}else{
		header("location: ../login?message=not_logged_in");
	}

?>