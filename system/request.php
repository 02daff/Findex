<?php 
session_start();
include '../config/conn.php';
$pageid = $_GET['pageid'];

    if ($pageid == 1){//Production
        // activate session php
        $newreq = $conn->query("SELECT * FROM request ORDER BY date DESC LIMIT 1");
        $data = $newreq->fetch();

        if($newreq->rowCount() > 0 AND $data['status'] != 'Request Done'){
            header("location: ../views/".strtolower($_SESSION['role'])."/prod?page=2&status=exreq");
            exit;
        }

        // get form data
        $qpack1 = $_POST['pack1'];
        $qpack2 = $_POST['pack2'];
        
        if($qpack1 == 0 AND $qpack2 == 0){
            header("location: ../views/".strtolower($_SESSION['role'])."/prod?page=2&status=empty");
            exit;
        }else{

            $row = $conn->query("SELECT m.price, r1.needs FROM material AS m RIGHT JOIN recipe1 AS r1 ON m.id_material=r1.id");
            // get data

            $ppack1 = 0;

            while($data = $row->fetch()){
                $n = $data['needs'];
                $p = $data['price'];
                
                $ppack1 += ($n * $p);
            }

            //echo $ppack1;

            $row = $conn->query("SELECT m.price, r2.needs FROM material AS m RIGHT JOIN recipe2 AS r2 ON m.id_material=r2.id");
            // get data

            $ppack2 = 0;

            while($data = $row->fetch()){
                $n = $data['needs'];
                $p = $data['price'];
                
                $ppack2 += ($n * $p);
            }
            //echo $ppack2;

            $tpack = ($ppack1 * $qpack1) + ($ppack2 * $qpack2);

            $row = $conn->query("INSERT INTO request VALUES ('', NOW(), '$qpack1', '$qpack2', '$tpack', 'Waiting for Confirmation')") or $conn->errorInfo();
            //echo $tpack;

            header("location: ../views/".strtolower($_SESSION['role'])."/prod?page=2&status=succ");
            exit;
        }
        
    }


    if ($pageid == 2){//Procurement
        $reqid = $_GET['id'];

        $row = $conn->query("UPDATE request SET status='Waiting for Payment' WHERE id='$reqid'") or $conn->errorInfo();

        header("location: ../views/".strtolower($_SESSION['role'])."/proc?page=3&status=succ");
        exit;
    }


    if ($pageid == 3){//Finance
        $reqid = $_GET['id'];

        $row = $conn->query("SELECT pack1, pack2, price_total FROM request WHERE id='$reqid'") or $conn->errorInfo();

        $data = $row->fetch();

        $qpack1 = $data['pack1'];
        $qpack2 = $data['pack2'];
        $ptot = $data['price_total'];

        if ($qpack1 > 0) {
        $row1 = $conn->query("SELECT m.material_name, m.stock, r1.needs FROM material AS m RIGHT JOIN recipe1 AS r1 ON m.id_material=r1.id") or $conn->errorInfo();

            if($row1->rowCount() > 6) {
                while($data = $row1->fetch()){
                    $n = $data['needs'];
                    $q = $data['stock'];
                    $mname = $data['material_name'];

                    $q += ($qpack1 * $n);

                    $row2 = $conn->query("UPDATE material SET stock='$q' WHERE material_name='$mname'") or $conn->errorInfo();
                }
            }
        }

        if ($qpack2 > 0) {
        $row1 = $conn->query("SELECT m.material_name, m.stock, r2.needs FROM material AS m RIGHT JOIN recipe2 AS r2 ON m.id_material=r2.id") or $conn->errorInfo();

            if($row1->rowCount() > 6) {
                while($data = $row1->fetch()){
                    $n = $data['needs'];
                    $q = $data['stock'];
                    $mname = $data['material_name'];

                    $q += ($qpack2 * $n);

                    $row2 = $conn->query("UPDATE material SET stock='$q' WHERE material_name='$mname'") or $conn->errorInfo();
                }
            }
        }

        $row = $conn->query("UPDATE request SET status='Request Done' WHERE id='$reqid'") or $conn->errorInfo();

        $row = $conn->query("UPDATE cash SET cash_out=cash_out+$ptot, net=cash_in-cash_out") or $conn->errorInfo();

        header("location: ../views/".strtolower($_SESSION['role'])."/finc?page=4&status=succ");
        exit;
    }

    if ($pageid == '4'){//Finance
        $reqid = $_GET['id'];

        $row = $conn->query("SELECT id_product, amount, price FROM orderdata WHERE id_order='$reqid'") or $conn->errorInfo();

        $data = $row->fetch();

        $ordid =$data['id_product'];
        $qorder = $data['amount'];
        $stot = $data['price'];

        if ($qorder > 0) {
            $row1 = $conn->query("SELECT stock FROM product WHERE id_product='$ordid'") or $conn->errorInfo();

            $data = $row1->fetch();

            $q = $data['stock'];

            if ($qorder <= $q) {
                //echo $q;
                //echo $qorder;
                $q -= $qorder;

                $row2 = $conn->query("UPDATE product SET stock='$q' WHERE id_product='$ordid'") or $conn->errorInfo();
            }else{
                if($ordid == 'fin-01'){
                    $stat = 'stockout1';
                }elseif($ordid == 'fin-02'){
                    $stat = 'stockout2';
                }
                header("location: ../views/".strtolower($_SESSION['role'])."/finc?page=4&status=$stat");
                exit;
            }

        }
        $row = $conn->query("UPDATE orderdata SET Payment_status='Accepted' WHERE id_order='$reqid'") or $conn->errorInfo();

        $row = $conn->query("UPDATE cash SET cash_in=cash_in+$stot, net=cash_in-cash_out") or $conn->errorInfo();

        header("location: ../views/".strtolower($_SESSION['role'])."/finc?page=4&status=succ");
        exit;
    }

    if ($pageid == '4A'){//Finance
        $initnet = $_POST['net'];

        $row = $conn->query("UPDATE cash SET cash_in=$initnet, net=cash_in-cash_out") or $conn->errorInfo();

        header("location: ../views/".strtolower($_SESSION['role'])."/finc?page=4&status=succ");
        exit;
    }

?>