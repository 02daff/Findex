<?php 
  include 'header.php'; 
  $row = $conn->query("SELECT * FROM product");
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="home" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
  </div>
  <!--p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p-->

  <!-- DataTales Example -->
  <div class="row">
    <div class="col">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Product Stock</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm" id="dataTable0" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width="1%">No.</th>
                  <th>Product Code</th>
                  <th>Name</th>
                  <th>Price (Rp)</th>
                  <th>Stock (Unit)</th>
                  <th width="5%">Action</th>
                </tr>
              </thead>
              <tbody>
              
                <?php if($row->rowCount() > 0){
                  $no = 1;
                  while($data = $row->fetch()){
                ?>

                <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $data['id_product'] ?></td>
                  <td><?php echo $data['product_name'] ?></td>
                  <td><?php echo number_format($data['price']) ?></td>
                  <td><?php echo $data['stock'] ?></td>
                  <td class="text-center">
                    <a href="create-order?id=<?php echo $data['id_product'] ?>" class="btn btn-sm btn-success"><i class="fas fa-fw fa-shopping-cart"></i></a>
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