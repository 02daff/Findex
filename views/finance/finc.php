<?php 
  include('header.php'); 
  
  $crow = $conn->query("SELECT * FROM cash");
    $cdata = $crow->fetch();

  $row_od = $conn->query("SELECT * FROM orderdata join user on user.id_user=orderdata.id_user");

  $prow = $conn->query("SELECT * FROM product");

  $newreq = $conn->query("SELECT * FROM request ORDER BY date DESC LIMIT 1");

  $reqrow = $conn->query("SELECT * FROM request WHERE status='Waiting for Payment' OR status='Request Done'");

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?php if (isset($msg)){ ?>
            <div class="alert alert-danger text-center" role="alert">
              <span class="badge badge-danger">Danger</span>
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Financial Control</h1>
            <a href="finc?page=4" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
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
              <?php $pagefrom = 'fina'; include("../invoice.php"); ?>
            </div>
          </div>
          <!--p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p-->

          <!-- DataTales Example -->
          <div class="row" style="height: 437px">
            <div class="col-xl-6 h-100 pb-4">
              <div class="card shadow h-100">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Cash Flow</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body text-center">
                  <div class="text-xs font-weight-bold text-primary text-uppercase pt-0">
                    Cash In
                  </div>
                  <h1 class="display-3 text-success mb-0"><?php echo number_format($cdata['cash_in']) ?></h1>
                  <hr>
                  <h1 class="display-3 mb-1">(<?php echo number_format($cdata['cash_out'])?>)</h1>
                  <div class="text-xs font-weight-bold text-grey text-uppercase pt-0">
                    Cash Out
                  </div>
                </div>
                <div class="card-footer bg-primary">
                  <div class="h5 mb-0 font-weight-bold text-center text-light" style="transform: rotate(0);">
                    <i class="fas fa-arrow-down">
                      <a href="#cashflow" class="stretched-link"> 
                      </a>
                    </i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 h-100 pb-4">
              <div class="card shadow h-100">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Net Cash</h6>
                </div>
                <div class="card-body text-center">
                  <div class="row align-items-center h-100">
                    <div class="col">
                      <h1 class="display-3 text-primary mb-0"><?php echo number_format($cdata['net']) ?></h1>
                      <small class="h4 text-muted align-middle"><i class="indonesia flag"></i>Rupiah</small>
                    </div>
                  </div>
                </div>
                <?php
                  if($cdata['cash_in'] == 0 AND $cdata['cash_out'] == 0 AND $cdata['net'] == 0){?>
                    <button type="submit" name="submit" class="card-footer bg-primary btn-primary text-center text-light mb-0 border-0" data-toggle="modal" data-target="#procModal" data-whatever="@mdo">
                      <i class="fas fa-edit">
                      </i>
                    </button>
                <?php }else{?>
                    <button type="submit" name="submit" class="card-footer btn-secondary text-center text-light mb-0 border-0" disabled>
                      <i class="fas fa-edit">
                      </i>
                    </button>
                <?php }?>
              </div>
            </div>
          </div>
          <div class="row" id="cashflow">
            <div class="col-xl-12 col-lg-7">
              <div class="accordion shadow" id="accordionExample">
                <div class="card">
                  <div class="card-header py-3" id="headingOne">
                    <h6 class="m-0 font-weight-bold text-primary">Product Stock</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table text-center table-bordered" id="" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Stock (Unit)</th>
                            <th>Price per unit (Rp)</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php if($prow->rowCount() > 0) {
                            while($data = $prow->fetch()){
                          ?>


                          <tr>
                              <td><?php echo $data['id_product'] ?></td>
                              <td><?php echo $data['product_name'] ?></td>
                              <td><?php echo $data['stock'] ?></td>
                              <td><?php echo number_format($data['price']) ?></td>
                          </tr>

                          <?php }}?>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header py-3" id="headingTwo">
                    <h5 class="mb-0">
                      <button class="btn btn-link p-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h6 class="m-0 font-weight-bold text-primary">Order</h6>
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Ord. ID</th>
                              <th>Customer</th>
                              <th>Address</th>
                              <th>Prod. ID</th>
                              <th>Amount</th>
                              <th>Price</th>
                              <th>Order Date</th>
                              <th>Payment Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          
                            <?php if($row_od->rowCount() > 0){
                              while($data = $row_od->fetch()){
                            ?>

                            <tr>
                              <td>ORD-00<?php echo $data['id_order'] ?></td>
                              <td><?php echo $data['name'] ?></td>
                              <td><?php echo $data['address'] ?></td>
                              <td><?php echo $data['id_product'] ?></td>
                              <td class="text-center"><?php echo $data['amount'] ?></td>
                              <td class="text-right"><?php echo number_format($data['price']) ?></td>
                              <td><?php echo $data['order_date'] ?></td>
                              <td class="text-center"><?php if ($data['payment_status'] == 'Waiting for Payment'){ ?>
                                    <span class="badge badge-warning">PMT</span><br>
                                <?php }else{ ?>
                                    <span class="badge badge-success">ACC</span><br>
                                <?php }?>
                              </td>
                              <td class="text-center">
                                  <?php if ($data['payment_status'] == 'Accepted'){?>
                                      - 
                                  <?php }else{?>
                                    <a href="../../system/request?id=<?php echo $data['id_order']?>&pageid=4" class="btn btn-sm btn-warning"><i class="fas fa-fw fa-check"></i></a>
                                    <a href="../../system/deleteorder?id=<?php echo $data['id_order']?>&pageid=3" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-fw fa-trash"></i></a>
                                  <?php }?>
                              </td>
                            </tr>
                            
                            <?php }} ?>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header py-3" id="headingThree">
                    <h5 class="mb-0">
                      <button class="btn btn-link p-0" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h6 class="m-0 font-weight-bold text-primary">Requests</h6>
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="accordtable1" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Date</th>
                              <th>Qty. fin-01 (Pack)</th>
                              <th>Qty. fin-02 (Pack)</th>
                              <th>Status</th>
                              <th>Total (Rp)</th>
                              <th>Action</th>
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
                                <td class="text-center"><?php if($data['status'] == 'Waiting for Confirmation'){ ?>
                                      <span class="badge badge-secondary">PND</span><br>
                                  <?php }elseif ($data['status'] == 'Waiting for Payment'){ ?>
                                      <span class="badge badge-warning">PMT</span><br>
                                  <?php }else{ ?>
                                      <span class="badge badge-success">DNO</span><br>
                                  <?php }?>
                                </td>
                                <td class="text-right"><?php echo number_format($data['price_total']) ?></td>
                                <td class="text-center">
                                  <?php if ($data['status'] == 'Request Done'){?>
                                    <a href="../invoice.php?id=<?php echo $data['id']?>&redir=1" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-fw fa-search"></i></a>
                                 <?php }else{?>
                                    <a href="../../system/request?id=<?php echo $data['id']?>&pageid=3" class="btn btn-sm btn-warning"><i class="fas fa-fw fa-check"></i></a>
                                    <a href="../../system/deleteorder?id=<?php echo $data['id']?>&pageid=2" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-fw fa-trash"></i></a>
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
          </div>
          <div class="modal fade" id="procModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Enter Initial Cash</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="../../system/request?pageid=4A" method="POST">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="net" class="col-form-label">Initial Cash Position</label>
                      <div class="input-group text-white">  
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Rp</span>
                        </div>  
                        <input type="number" min="0" class="form-control" name="net" value="">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" name="confirm">Confirm</button>
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