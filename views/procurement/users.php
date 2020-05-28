<?php 
  include('header.php'); 

  $id_user = $_SESSION['id_user'];

  $urow = $conn->query("SELECT * FROM user WHERE id_user=$id_user");
  $data = $urow->fetch();
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
            <h1 class="h3 mb-0 text-gray-800">Profile</h1>
            <a href="users?page=5" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sm text-white-50"></i>Refresh</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
            </div>
            <div class="card-body">
              <form action="../../system/updateuser.php?role=sub" method="POST">
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
                      <input type="text" class="form-control form-control-sm" name="role" value="<?php echo $data['role'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label>Phone #</label>
                      <input type="text" class="form-control form-control-sm" name="phone" value="<?php echo $data['phone'] ?>" required>
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" class="form-control form-control-sm" name="address" value="<?php echo $data['address'] ?>" required>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control form-control-sm" name="pass" value="<?php echo $data['password'] ?>">
                    </div>
                </div>
                <div class="modal-footer al-right">
                  <input type="submit" class="btn btn-sm btn-warning" value="Save">
                </div>
              </form>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
<?php 
  include('footer.php'); 
?>

