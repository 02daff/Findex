<?php 
  include 'header.php'; 
  $id_user = $_SESSION['id_user'];
  $row_od = $conn->query("SELECT * FROM orderdata WHERE id_user = '$id_user'");
?>
	
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>
          <!--p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p-->


          <!-- Content -->
          <div class="row justify-content-center"> 
            <div class="col-lg-12">
              <!-- DataTales Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Order List</h6>
                </div>
                <div class="card-body">

                <!-- TABLE HERE -->
                <div class="table-responsive">
                  <table class="table table-sm" id="dataTable0" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                      <?php if($row_od->rowCount() > 0){
                        $no = 1;
                        while($data = $row_od->fetch()){
                          if ($data['payment_status'] == "Waiting for Payment") {
                            $deletebutton = "href='../../system/deleteorder.php' class='btn btn-sm btn-danger'";
                          }else{
                            $deletebutton = "class='btn btn-sm btn-white' readonly";
                          }
                      ?>

                      <tr>
                        <td><?php echo $no ?></td>
                        <td>ORD-00<?php echo $data['id_order'] ?></td>
                        <td><?php echo $data['id_product'] ?></td>
                        <td><?php echo $data['amount'] ?></td>
                        <td><?php echo number_format($data['price']) ?></td>
                        <td><?php echo $data['order_date'] ?></td>
                        <td><?php echo $data['payment_status'] ?></td>
                        <td class="text-center">
                          <?php if ($data['payment_status'] == "Waiting for Payment") { ?>
                            <a href="../../system/deleteorder?id=<?php echo $data['id_order']?>&pageid=4" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" ><i class="fas fa-fw fa-trash"></i></a>
                          <?php }else{ ?>
                            <i class="fas fa-fw fa-trash text-gray-500"></i>
                          <?php }?>
                          
                        </td>
                      </tr>
                      
                      <?php $no++; }} ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php include 'footer.php' ?>