<?php 
  include('header.php'); 
  $invt = $conn->query("SELECT * FROM material");

  $reqrow = $conn->query("SELECT * FROM request");

  $newreq = $conn->query("SELECT * FROM request ORDER BY date DESC LIMIT 1");
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?php if (isset($succ)){ ?>
            <div class="alert alert-success text-center" role="alert">
              <span class="badge badge-success">Done</span>
              <?=$succ ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Procurement Control</h1>
            <a href="proc?page=3" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>
          <?php 
          if($newreq->rowCount() > 0){
            $data = $newreq->fetch();?>
            <div class="alert alert-warning text-center" role="alert"><strong>Latest request #</strong>
              <a href="#" class="stretched-link" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">REQ-00<?php echo $data['id']?></a>
              <?php if($data['status'] == 'Waiting for Confirmation'){ ?>
                  <span class="badge badge-secondary">PND</span><br>
              <?php }elseif ($data['status'] == 'Waiting for Payment'){ ?>
                  <span class="badge badge-warning">PMT</span><br>
              <?php }else{ ?>
                  <span class="badge badge-success">DNO</span><br>
              <?php }?>
            </div>
          <?php } ?>
          <div class="collapse" id="collapseExample">
            <div class="card card-body mb-3">
              <?php $pagefrom = 'proc'; include("../invoice.php"); ?>
            </div>
          </div>
          <!--p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p-->

          <!-- DataTales Example -->
          <div class="row" style="height: 437px">
            <div class="col-xl-4 pb-4 h-100">
              <div class="card shadow h-100">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Monthly Target</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body text-center">
                  <h1 class="display-1 text-success mb-0"><?php
                          $sum = $conn->query("SELECT SUM(stock) AS value_sum FROM product");

                          $data = $sum->fetch();

                          $curprod = number_format($data['value_sum'],0,",",".");
                          echo (int)$curprod;
                        ?></h1>
                  <div class="text-xs font-weight-bold text-primary text-uppercase pt-0">
                    Produced
                  </div>
                  <hr>
                  <h1 class="display-3 mb-1"><?php
                          $target = $conn->query("SELECT volume FROM prodplan WHERE year='2021'");
                          $data = $target->fetch();

                          $tarprod = number_format(($data['volume']/12),0,",",".");
                          echo (int)$tarprod;
                        ?></h1>
                  <div class="text-xs font-weight-bold text-grey text-uppercase pt-0">
                    Target
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                      <?php
                            $ratio = ($curprod/$tarprod)*100;
                            echo number_format($ratio,1,",",".");
                          ?>%
                      </div>
                    </div>
                    <div class="col">
                      <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo ceil($ratio);?>%" aria-valuenow="<?php echo ceil($ratio);?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-8 h-100 pb-4">
              <div class="card shadow h-100">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Material Stock</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table text-center" id="dataTableMini" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Stock (Unit)</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>                     
                        <?php if($invt->rowCount() > 0) {
                          while($data = $invt->fetch()){
                        ?>


                        <tr>
                            <td><?php echo $data['id_material'] ?></td>
                            <td><?php echo $data['material_name'] ?></td>
                            <td><?php echo $data['stock'] ?></td>
                            <td><?php echo number_format($data['price'],0,",",".") ?></td>
                        </tr>

                        <?php }}?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12 col-lg-7">
              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Procurement Log</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Date</th>
                          <th>Qty. fin-01 (Pack)</th>
                          <th>Qty. fin-02 (Pack)</th>
                          <th>Status</th>
                          <th>Total (Rp)</th>
                          <th width="10%">Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php if($reqrow->rowCount() > 0) {
                          while($data = $reqrow->fetch()){
                        ?>


                        <tr>
                            <td>REQ-00<?php echo $data['id'] ?></td>
                            <td><?php echo $data['date'] ?></td>
                            <td class="text-center"><?php echo $data['pack1'] ?></td>
                            <td class="text-center"><?php echo $data['pack2'] ?></td>
                            <td class="text-center">
                            <?php if($data['status'] == 'Waiting for Confirmation'){ ?>
                                <span class="badge badge-secondary">PND</span><br>
                            <?php }elseif ($data['status'] == 'Waiting for Payment'){ ?>
                                <span class="badge badge-warning">PMT</span><br>
                            <?php }else{ ?>
                                <span class="badge badge-success">DNO</span><br>
                            <?php }?></td>
                            <td class="text-right"><?php echo number_format($data['price_total']) ?></td>
                            <td class="text-center">
                              <?php if ($data['status'] == 'Waiting for Confirmation'){?>
                                <a href="../../system/request?id=<?php echo $data['id']?>&pageid=2" class="btn btn-sm btn-warning"><i class="fas fa-fw fa-check"></i></a>
                                <a href="../../system/deleteorder?id=<?php echo $data['id']?>&pageid=2" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-fw fa-trash"></i></a>
                                <?php }else{?>
                                <a href="../invoice.php?id=<?php echo $data['id']?>&redir=1" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-fw fa-search"></i></a>
                              <?php }?>
                            </td>
                        </tr>

                        <?php }}?>
                                  
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

<?php 
  include('footer.php'); 
?>