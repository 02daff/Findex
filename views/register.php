<?php    
    include('portal_header.php');

    if(isset($_GET['message'])){
      if($_GET['message'] == "failed"){
        $msg = "Username already exist!";
      }elseif($_GET['message'] == "errpass"){
        $msg = "Password doesn't match!";
      }elseif($_GET['message'] == "404"){
        $msg = "Something Wrong, Try again later!";
      }
    }
?>

<body class="bg-gradient-primary">
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" action="../auth/register.php" method="POST">
                <?php if (isset($msg)){ ?>
                <div class="alert alert-warning" role="alert">
                  <i class="fas fa-exclamation-circle">&nbsp;</i> 
                  <?=$msg ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php } ?>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" name="fname" required placeholder="First Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" name="lname" required placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="exampleInputText" name="phone" required placeholder="Phone #">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="exampleInputText" name="address" required placeholder="Address">
                </div>
                <div class="form-group">
                  <input type="username" class="form-control form-control-user" id="exampleInputEmail" name="username" required placeholder="Username">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="pw" required placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" name="pw_verify" required placeholder="Repeat Password">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block" name="submit">Register Account</button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="login">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include('portal_footer.php'); ?>