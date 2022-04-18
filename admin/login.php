<?php 
require("includes/connection.php");
require ("includes/functions.php");

if (isAdminLogin() == true) {
  header("location:index.php");
  exit();
}

$email = $password = "";


if(isset($_POST['loginBtn'])){
    
    if(empty($_POST['email'])){
       array_push($_SESSION['errors'], "Email is Required.");
    }else{
      $email = $_POST['email'];  
    }
    if(empty($_POST['password'])){
       array_push($_SESSION['errors'], "Password is Required.");
    }else{
      $password = md5($_POST['password']);
    }

    

    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {

        $sql = "SELECT * FROM `tbl_user` WHERE `user_email` = '$email' and `user_password` = '$password' ";
        
        $result = mysqli_query($con,$sql);
        
        if($result){
          if(mysqli_num_rows($result) == 1){
            if($row = mysqli_fetch_assoc($result)){    
                $_SESSION['userID'] =  $row['user_id'];
                $_SESSION['userFullName'] = $row['fullname'];
                $_SESSION['userRole'] = $row['role_id'];
                $_SESSION['userImage'] = $row['profileimg'];

                if($row['role_id'] == 1)
                  header("location: index.php");
                elseif($row['role_id'] == 2)
                {
                  $_SESSION['userCourse'] = $row['Teacher_Course'];
                  header("location: index.php");
                }
            }
          }else{
            array_push($_SESSION['errors'], "Email or Password is incorrect Please enter valid credentials.");
          }
        }

     

    }
  
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Al-Nahal Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/logo.png" style="width: 200px;" />
</head>

<body>
  <div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="images/logo.png" style="width:150px;margin-left:120px ;" alt="logo">
                 <h3 style="text-align:center;">Al-Nahal Online Institute</h3>
              </div>
                <h4> let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>

              <?php if (isset($_SESSION['errors'])) { 
                      $errors = $_SESSION['errors'];
                      foreach ($errors as $error) {
                          
                      ?>
                      <div class="alert alert-danger">
                          <?php echo $error; ?>
                      </div>
                      <?php }
                      unset($_SESSION['errors']);
                      } 
              ?>
              <form class="pt-3" method="POST" action="login.php">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                </div>

               <!-- <div class="mt-3">
                 <label class="radio-inline">
                    <input type="radio" value="A" name="loginAs" >&nbsp;Login As Admin
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="radio-inline">
                    <input type="radio" value="T" name="loginAs">&nbsp;Login As Teacher
                  </label>
               </div> -->

                <div class="mt-3">
                
                  <input style="background: black;" type="submit" name="loginBtn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="SIGN IN">

                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
</body>

</html>
