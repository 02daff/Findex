<?php 
  include('header.php'); 

  $urow = $conn->query("SELECT * FROM user WHERE role!='Admin'");
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
            <h1 class="h3 mb-0 text-gray-800">Users List</h1>
            <a href="users?page=5" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Accounts</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable0" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Phone #</th>
                      <th>Address</th>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php if($urow->rowCount() > 0) {
                      $no = 0;
                      while($data = $urow->fetch()){
                    ?>


                    <tr>
                        <td>CGN-00<?php echo $data['id_user'] ?></td>
                        <td><?php echo $data['name'] ?></td>
                        <td><?php echo $data['phone'] ?></td>
                        <td class="text-truncate"><?php echo $data['address'] ?></td>
                        <td><?php echo $data['username'] ?></td>
                        <td><?php echo $data['role'] ?></td>
                        <td class="text-center">
                            <button type="submit" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal<?php echo $no;?>" data-whatever="@mdo">
                              <i class="fas fa-edit">
                              </i>
                            </button>
                            <div class="modal fade" id="editModal<?php echo $no;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header bg-success">
                                    <h5 class="modal-title text-light" id="exampleModalLabel">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="../../system/updateuser.php" method="POST">
                                    <div class="modal-body text-left">
                                      <div class="form-group">
                                          <label>ID User</label>
                                          <input type="text" class="form-control form-control-sm" name="id_user" value="<?php echo $data['id_user'] ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                          <label>Name</label>
                                          <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $data['name'] ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                          <label>Role</label>
                                          <input type="text" class="form-control form-control-sm" name="role" value="<?php echo $data['role'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Password</label>
                                          <input type="password" class="form-control form-control-sm" name="pass" value="<?php echo $data['password'] ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer al-right">
                                      <input type="submit" class="btn btn-sm btn-warning" value="Update User">
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <a href="../../system/deleteuser?id=<?php echo $data['id_user']?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-fw fa-trash"></i></a>
                        </td>
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

