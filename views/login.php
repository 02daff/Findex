<?php    
    include 'portal_header.php';
    if(isset($_GET['message'])){
      if($_GET['message'] == "failed"){
        $msg = "Username or Password is incorrect!";
      }else if($_GET['message'] == "not_logged_in"){
        $msg = "You must login first!";
      }else if($_GET['message'] == "success"){
        $msg = "Sign Up Success!";
      }
    }
?>


<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" action="../auth/login.php" method="POST">
                    <?php if (isset($msg)){ ?>
                    <div class="alert alert-warning" role="alert">
                      <i class="fas fa-exclamation-circle">&nbsp;</i> 
                      <?=$msg ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                      <input type="username" class="form-control form-control-user" name="username" id="exampleInputUsername" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="pass" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="submit">Login</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="register">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include 'portal_footer.php';?>
