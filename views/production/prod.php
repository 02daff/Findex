<?php 
  include('header.php'); 

  $crow1 = $conn->query("SELECT stock FROM material WHERE id_material='mat-07'");
    $data = $crow1->fetch();
    $cap1 = $data['stock'];
 
  $crow2 = $conn->query("SELECT stock FROM material WHERE id_material='mat-08'");
    $data = $crow2->fetch();
    $cap2 = $data['stock'];

  $log = $conn->query("SELECT * FROM product");

  $invt = $conn->query("SELECT * FROM material");

  $log = $conn->query("SELECT * FROM proddata");

  $newreq = $conn->query("SELECT * FROM request ORDER BY date DESC LIMIT 1");

  if (isset($_GET['plan'])){
    $year = $_GET['plan'];

    $delactive = $conn->query("UPDATE prodplan SET status=''");
    $active = $conn->query("UPDATE prodplan SET status='Active' WHERE year=$year");
  }

  $tyear = $conn->query("SELECT year, volume FROM prodplan WHERE status='Active'");
    $tdata = $tyear->fetch();

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?php if (isset($msg)){ ?>
            <div class="alert alert-warning text-center" role="alert">
              <span class="badge badge-warning">Warning</span>
              <?=$msg ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php }
          if (isset($succ)){ ?>
            <div class="alert alert-success text-center" role="alert">
              <span class="badge badge-success">Done</span>
              <?=$succ ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
          <?php 
          if($cap1 == 0 AND $cap2 == 0){?>
            <div class="alert alert-danger text-center" role="alert"><span class="badge badge-danger">Danger</span>  Not enough material, please commit procurement</div>
          <?php }elseif($cap1 == 0){?>
            <div class="alert alert-danger text-center" role="alert"><span class="badge badge-danger">Danger</span>  Not enough <strong>Black Finder</strong> material, please commit procurement</div>
          <?php }elseif($cap2 == 0){?>
            <div class="alert alert-danger text-center" role="alert"><span class="badge badge-danger">Danger</span>  Not enough <strong>Blue Finder</strong> material, please commit procurement</div>
          <?php } ?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Production Control</h1>
            <a href="JavaScript: location.reload(true);" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Production Plan</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Data Action:</div>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#upModal" data-whatever="@mdo">Upload</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Monthly Target in <?php echo $tdata['year'];?></h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Select year:</div>
                      <?php
                        $yrow = $conn->query("SELECT * FROM prodplan");
                      
                        if($yrow->rowCount() > 0) {
                          while($data = $yrow->fetch()){
                        ?>
                          <a class="dropdown-item" href="prod?plan=<?php echo $data['year'];?>"><?php echo $data['year'];?></a>
                        <?php }} ?>
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
                      $tarprod = number_format(($tdata['volume']/12),0,",",".");
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
          </div>

          <form method="post" action="../../system/produce.php">
            <div class="row">
              <div class="col mb-4">
                <div class="card bg-primary">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col-sm-8 mr-1">
                        <?php $ratio1 = 0.7 * $tarprod; ?>
                        <div class="h5 mb-0 font-weight-bold text-white">
                          Black Finder
                        </div>
                        <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">Ratio target : <?php echo number_format(ceil($ratio1),0,",",".");?></div>
                      </div>
                      <div class="col input-group text-white">
                        <input type="number" min="0" max="<?php echo $cap1;?>" class="form-control" name="q1" placeholder="Qty" value="" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><?php
                            echo number_format($cap1,0,",",".");
                          ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col mb-4">
                <div class="card bg-primary text-white shadow">
                  <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col-sm-8 mr-1">
                        <?php $ratio2 = 0.3 * $tarprod; ?>
                        <div class="h5 mb-0 font-weight-bold text-white">
                          Blue Finder
                        </div>
                        <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">Ratio target : <?php echo number_format(ceil($ratio2),0,",",".");?></div>
                      </div>
                      <div class="col input-group text-white">
                        <input type="number" min="0" max="<?php echo $cap2;?>" class="form-control" name="q2" placeholder="Qty" value="" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><?php
                            echo number_format($cap2,0,",",".");
                          ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 mb-4">
                <?php if($curprod == $tarprod){?>
                  <button type="submit" name="submit" class="btn btn-secondary btn-block text-uppercase h-100" disabled>
                    <i class="fas fa-check fa-2x">
                    </i>
                  </button>
                <?php } else{?>
                  <button type="submit" name="submit" class="btn btn-warning btn-block text-uppercase h-100">
                    <i class="fas fa-check fa-2x">
                    </i>
                  </button>
                <?php }?>
              </div>
            </div>
          </form>

          <!-- Content Row -->
          <div class="row mb-5" style="height: 565px;">
            <div class="col-lg-3">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Procurement Status</h6>
                </div>
                <div class="card-body text-center text-primary">
                  <?php if($newreq->rowCount() > 0){ ?>
                    <button type="button" class="btn btn-success btn-block" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                      <div class="row no-gutters align-items-center">
                        <div class="col text-left mr-2">
                          <?php $data = $newreq->fetch();?>
                            # REQ-00<?php echo $data['id']?>
                        </div>
                        <div class="col-auto">
                          <?php if($data['status'] == 'Waiting for Confirmation'){ ?>
                              <span class="badge badge-secondary">PND</span><br>
                          <?php }elseif ($data['status'] == 'Waiting for Payment'){ ?>
                              <span class="badge badge-warning">PMT</span><br>
                          <?php }else{ ?>
                              <span class="badge badge-success">DNO</span><br>
                          <?php }?>
                        </div>
                      </div>
                    </button>
                  <?php }else{ ?>
                    <button type="button" class="btn btn-success btn-block" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" disabled>
                      Empty request data
                    </button>
                    <?php } ?>
                  <div class="collapse" id="collapseExample">
                    <div class="table-responsive">
                      <table class="table table-dark table-sm table-bordered rounded-sm text-light" id="dataTable0" width="100%" cellspacing="0">
                        <tbody>
                              <tr>
                                <td>fin-01 Pack</td>
                                <td><?php echo $data['pack1'] ?> Unit(s)</td>
                              </tr>
                              <tr>
                                <td>fin-02 Pack</td>
                                <td><?php echo $data['pack2'] ?> Unit(s)</td>
                              </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <i class="fas fa-plus-square fa-2x pt-3" style="transform: rotate(0);">
                    <a href="#" class="stretched-link"  data-toggle="modal" data-target="#procModal" data-whatever="@mdo"> 
                    </a>
                  </i>
                </div>
              </div>
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Material Stock</h6>
                </div>
                <div class="card-body text-center">
                  <div class="table-responsive">
                    <table class="table table-sm mb-0" id="" width="100%" cellspacing="0">
                      <tbody>
                        <?php                                                                                   
                          if ($invt->rowCount() > 0){
                            while ($data = $invt->fetch()){ ?>

                            <tr>
                              <td><?php echo $data['material_name']?></td>
                              <td><?php echo $data['stock'] ?></td>
                            </tr>

                        <?php }}?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-9 h-100">
              <div class="card shadow h-100 mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Log</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Date</th>
                          <th>Qty. fin-01 (Unit)</th>
                          <th>Qty. fin-02 (Unit)</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if($log->rowCount() > 0) {
                          while($data = $log->fetch()){
                        ?>


                        <tr>
                            <td>P-00<?php echo $data['id'] ?></td>
                            <td><?php echo $data['date'] ?></td>
                            <td class="text-center"><?php echo $data['prod1'] ?></td>
                            <td class="text-center"><?php echo $data['prod2'] ?></td>
                            <td class="text-center">
                              <a href="../../system/deleteorder?id=<?php echo $data['id']?>&pageid=0" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-fw fa-trash"></i></a>
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
          <div class="modal fade" id="procModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header bg-success">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Request Procurement</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="../../system/request?pageid=1" method="POST">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="pack1" class="col-form-label">Black Finder</label>
                      <div class="input-group input-group-sm text-white">  
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">QTY</span>
                        </div>  
                        <input type="number" min="0" class="form-control" name="pack1" placeholder="Quantity" value="" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="pack2" class="col-form-label">Blue Finder</label>
                      <div class="input-group input-group-sm text-white">  
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">QTY</span>
                        </div>  
                        <input type="number" min="0" class="form-control" name="pack2" placeholder="Quantity" value="" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" name="request">Request</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="modal fade" id="upModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header bg-success">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Upload CSV</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form enctype="multipart/form-data" action="../../system/data.php" method="POST">
                  <div class="modal-body">
                    <div class="custom-file">
                      <input type="file" name="uploaded" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">CSV Format: prodplan.csv</label>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" value="upload" class="btn btn-warning" name="upload">Upload</button>
                  </div>
                </form> 
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
<?php 
  include('footer.php'); 
?>