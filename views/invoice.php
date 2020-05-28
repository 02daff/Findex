<?php
    if(isset($_GET['redir'])){
        include '../config/conn.php';
        $pagefrom = '0';
        $redir = $_GET['redir'];

        if($redir == 1){
            $reqid = $_GET['id'];
            $req = $conn->query("SELECT * FROM request WHERE id=$reqid");

            if($req->rowCount() > 0){
                $data = $req->fetch(); ?>

                <head>

                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <meta name="description" content="">
                    <meta name="author" content="">

                    <title>Invoice # 00<?php echo $data['id']?></title>

                    <!-- Custom fonts for this template-->
                    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
                    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

                    <!-- Custom styles for this template-->
                    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

                </head>
                <body>
                    <div class="container">
                        <div class="card card-body mt-md-5">

<?php       }
        }
    }
?>


<div class="row">
    <div class="col-md-12">
        <div class="row align-items-center">
            <div class="col">
                <h4>Procurement</h4>
            </div>
            <div class="col-auto">
                <h4>Request # 00<?php echo $data['id']?></h4>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <address class="mb-0">
                    <strong>Status: </strong>
                    <?php if($data['status'] == 'Waiting for Confirmation'){ ?>
                        <span class="badge badge-secondary">PND</span><br>
                    <?php }elseif ($data['status'] == 'Waiting for Payment'){ ?>
                        <span class="badge badge-warning">PMT</span><br>
                    <?php }else{ ?>
                        <span class="badge badge-success">DNO</span><br>
                    <?php }echo $data['status']?>
                </address>
            </div>
            <div class="col-sm-6 text-right">
                <address class="mb-0">
                    <strong>Request Date:</strong><br>
                    <?php 
                    $time = strtotime($data['date']);
                    $datetime = date("F j, Y <\b\\r> H:i", $time);
                    echo $datetime;?><br><br>
                </address>
            </div>
        </div>
    </div>
</div>
    
<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title align-items-center mb-0"><strong>Request summary</strong></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-condensed mb-0">
                        <thead class="bg-light">
                            <tr>
                                <td><strong>Item</strong></td>
                                <td class="text-center"><strong>Price</strong></td>
                                <td class="text-center"><strong>Quantity</strong></td>
                                <td class="text-right"><strong>Totals</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach ($order->lineItems as $line) or some such thing here -->

                            <?php 
                            $pid = $conn->query("SELECT id_product FROM product");
                            $q1 = $data['pack1'];
                            $q2 = $data['pack2'];

                            $p = (1/($q1+$q2)) * $data['price_total'];

                            while($summ = $pid->fetch()){
                                if($summ['id_product'] == 'fin-01'){
                                    if($q1 > 0){?>
                                    <tr>
                                        <td><?php echo $summ['id_product'] ?></td>
                                        <td class="text-center">Rp <?php echo number_format($p)?></td>
                                        <td class="text-center"><?php echo $q1?></td>
                                        <td class="text-right">Rp <?php echo number_format($p * $q1)?></td>
                                    </tr>
                                    <?php 
                                    }
                                }
                                if($summ['id_product'] == 'fin-02'){   
                                    if($q2 > 0){?>
                                    <tr>
                                        <td><?php echo $summ['id_product'] ?></td>
                                        <td class="text-center">Rp <?php echo number_format($p)?></td>
                                        <td class="text-center"><?php echo $q2?></td>
                                        <td class="text-right">Rp <?php echo number_format($p * $q2)?></td>
                                    </tr>
                                    <?php 
                                    }
                                }
                            }?>
                            <tr>
                                <td style="border-top: 2px solid"></td>
                                <td style="border-top: 2px solid"></td>
                                <td style="border-top: 2px solid" class="text-center"><strong>Total</strong></td>
                                <td style="border-top: 2px solid" class="text-right">Rp <?php echo number_format($data['price_total'])?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($pagefrom == 'proc' AND $data['status'] == 'Waiting for Confirmation'){?>
    <form action="../../system/request?id=<?php echo $data['id']?>&pageid=2" method="post">
        <button type="submit" class="btn btn-success btn-block text-uppercase">
            Confirm
        </button>
    </form>
<?php } elseif($pagefrom == 'fina' AND $data['status'] == 'Waiting for Payment'){?>
    <form action="../../system/request?id=<?php echo $data['id']?>&pageid=3" method="post">
        <button type="submit" class="btn btn-success btn-block text-uppercase">
            Process
        </button>
    </form>
<?php }?>