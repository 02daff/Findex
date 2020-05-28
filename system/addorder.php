<?php 
	session_start();
	include "../config/conn.php";

	$id_order = null;
	$id_user = $_SESSION['id_user'];
	$id_product = $_POST['id_product'];
	$amount = $_POST['amount'];

	$row = $conn->query("SELECT price FROM product WHERE id_product = '$id_product'");
	$data = $row->fetch();
	$price = $amount*$data['price'];

	$order_date = date('Y-m-d');
	$payment_status = 'Waiting for Payment';

	$row = $conn->query("INSERT INTO orderdata VALUES ('$id_order', '$id_user', '$id_product', '$amount', '$price', '$order_date', '$payment_status')");
	
	header("location:../views/customer/order?page=1");
?>