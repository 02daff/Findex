<?php 
  include('header.php'); 

  $id_user = $_SESSION['id_user'];

  $urow = $conn->query("SELECT l.*, u.name FROM userlog AS l JOIN user AS u ON l.id_user=u.id_user WHERE l.id_user=$id_user");
  
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Log</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Login History</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable0" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="1%">No.</th>
                      <th>User ID</th>
                      <th>Name</th>
                      <th>Role</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php if($urow->rowCount() > 0) {
                      $no = 1;
                      while($data = $urow->fetch()){
                    ?>


                    <tr>
                      <td><?php echo $no ?></td>
                        <td>CGN-00<?php echo $data['id_user'] ?></td>
                        <td><?php echo $data['name'] ?></td>
                        <td><?php echo $data['role'] ?></td>
                        <td><?php echo $data['date'] ?></td>
                    </tr>

                    <?php $no++; }}?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
<?php 
  include('footer.php'); 
?>

