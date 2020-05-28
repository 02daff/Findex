<?php 
  include('header.php'); 
  $row = $conn->query("SELECT * FROM material");

  $prow = $conn->query("SELECT * FROM product WHERE id_product='fin-01'");
    $data = $prow->fetch();  
    $stck1 = $data['stock'];

  $prow = $conn->query("SELECT * FROM product WHERE id_product='fin-02'");
    $data = $prow->fetch();  
    $stck2 = $data['stock'];

  $reqrow = $conn->query("SELECT * FROM request");
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Invetory List</h1>
            <a href="invt?page=1" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>
          <!--p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p-->

          <!-- DataTales Example -->
          <div class="row mb-4" style="height: 430px">
            <div class="col-sm-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Product Stock</h6>
                </div>
                <div class="card-body">
                  <img src="../../assets/img/Finder.png" class="img mx-auto d-block">
                </div>
              </div>
              <form method="post" action="../../system/updateproduct.php">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="card bg-success">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="input-group input-group-sm text-white w-75 pr-3">  
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">QTY</span>
                              </div>  
                              <input type="number" min="0" value="<?php echo (int)$stck1;?>" class="form-control" name="q1" placeholder="Quantity" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="text-xs font-weight-bold text-white text-uppercase mt-1">Black Finder</div>
                          </div>
                          <div class="col-auto">
                            <button type="submit" name="submit" value="q1" class="btn p-0">
                              <i class="fas fa-edit fa-2x text-light">
                              </i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card bg-success">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="input-group input-group-sm text-white w-75 pr-3">  
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">QTY</span>
                              </div>  
                              <input type="number" min="0" value="<?php echo (int)$stck2;?>" class="form-control" name="q2" placeholder="Quantity" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="text-xs font-weight-bold text-white text-uppercase mt-1">Blue Finder</div>
                          </div>
                          <div class="col-auto">
                            <button type="submit" name="submit" value="q2" class="btn p-0">
                              <i class="fas fa-edit fa-2x text-light">
                              </i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-sm-6 h-100 ">
              <div class="card shadow h-100">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Material Stock</h6>
                </div>
                <div class="card-body align-items-center">
                  <div class="row align-items-center h-100">
                    <div class="col">
                      <div class="table-responsive ">
                        <table class="table table-sm text-center" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Stock (Unit)</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>                     
                            <?php if($row->rowCount() > 0) {
                              $no = 0;
                              while($data = $row->fetch()){
                            ?>


                            <tr>
                                <td><?php echo $data['material_name'] ?></td>
                                <td><?php echo $data['stock'] ?></td>
                                <td class="text-center">
                                  <button type="submit" class="btn btn-sm btn-warning px-1 py-0" data-toggle="modal" data-target="#editModal<?php echo $no;?>" data-whatever="@mdo">
                                    <i class="fas fa-edit">
                                    </i>
                                  </button>
                                  <div class="modal fade" id="editModal<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header bg-success">
                                          <h5 class="modal-title text-light" id="exampleModalLabel">Edit Material</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form method="post" action="../../system/updatematerial.php">
                                          <div class="modal-body text-left">
                                            <div class="form-group">
                                                <label>ID Material</label>
                                                <input type="text" class="form-control form-control-sm" name="id_material" value="<?php echo $data['id_material'] ?>" readonly>
                                              </div>
                                              <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control form-control-sm" name="material_name" value="<?php echo $data['material_name'] ?>" required>
                                              </div>
                                              <div class="form-group">
                                                <label>Price</label>
                                                <input type="number" min="0" class="form-control form-control-sm" name="price" value="<?php echo $data['price'] ?>" required>
                                              </div>
                                              <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" min="0" class="form-control form-control-sm" name="stock" value="<?php echo $data['stock'] ?>" required>
                                              </div>
                                          </div>
                                          <div class="modal-footer al-right">
                                            <input type="submit" class="btn btn-sm btn-warning" value="Update Material">
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </td>
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
          </div>
          <div class="row">
            <div class="col">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Procurement Request</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    
                    <table class="table" id="dataTableMini" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Date</th>
                          <th>Qty. fin-01 (Pack)</th>
                          <th>Qty. fin-02 (Pack)</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php if($reqrow->rowCount() > 0) {
                          $no = 1;
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
