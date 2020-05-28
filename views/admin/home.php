<?php 
  include('header.php'); 
  $curow = $conn->query("SELECT * FROM user WHERE role!='Admin'");
    $num_usr = $curow->rowCount();

  $sum = $conn->query("SELECT SUM(stock) AS value_sum FROM product");
    $data = $sum->fetch();
    $curprod = $data['value_sum'];

  $target = $conn->query("SELECT volume FROM prodplan WHERE year='2021'");
    $data = $target->fetch();
    $tarprod = $data['volume']/12;
  
  $crow = $conn->query("SELECT * FROM cash");
    $cdata = $crow->fetch();

  $reqrow = $conn->query("SELECT * FROM request WHERE status='Waiting for Payment' OR status='Request Done'");

  $pndrow = $conn->query("SELECT * FROM request WHERE status='Waiting for Confirmation'");
    $num_pnd = $pndrow->rowCount();
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="JavaScript: location.reload(true);" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Pending Requests
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <a href="proc?page=3" class="stretched-link"> 
                        <?php
                          echo "$num_pnd";
                        ?>
                        </a>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                        <?php
                          echo number_format($cdata['net']);
                        ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Production Target</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php
                            $ratio = ($curprod/$tarprod)*100;
                            echo number_format($ratio,0,",",".");
                          ?>%
                          </div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo ceil($ratio);?>%" aria-valuenow="<?php echo ceil($ratio);?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Users
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <a href="users?page=5" class="stretched-link">
                        <?php
                          echo "$num_usr";
                        ?>
                        </a>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Production Plan</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
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
                  <h6 class="m-0 font-weight-bold text-primary">Expense  Log</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable0" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th width="1%">No.</th>
                          <th>ID</th>
                          <th>Date</th>
                          <th>Qty. fin-01</th>
                          <th>Qty. fin-02</th>
                          <th>Status</th>
                          <th>Total (Rp)</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php if($reqrow->rowCount() > 0) {
                          $no = 1;
                          while($data = $reqrow->fetch()){
                        ?>


                        <tr>
                            <td><?php echo $no ?></td>
                            <td>REQ-00<?php echo $data['id'] ?></td>
                            <td><?php echo $data['date'] ?></td>
                            <td class="text-center"><?php echo $data['pack1'] ?></td>
                            <td class="text-center"><?php echo $data['pack2'] ?></td>
                            <td class="text-center"><?php if($data['status'] == 'Waiting for Confirmation'){ ?>
                                    <span class="badge badge-secondary">PND</span><br>
                                <?php }elseif ($data['status'] == 'Waiting for Payment'){ ?>
                                    <span class="badge badge-warning">PMT</span><br>
                                <?php }else{ ?>
                                    <span class="badge badge-success">DNO</span><br>
                                <?php }?>
                            </td>
                            <td class="text-right"><?php echo number_format($data['price_total']) ?></td>
                        </tr>

                        <?php $no++; }}?>
                                  
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

    <?php include('footer.php'); ?>
