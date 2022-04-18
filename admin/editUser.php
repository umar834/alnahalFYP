<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$userName  = $userEmail = $userAddress=  $userCourseID = $userContact = $userStatus =  "";

if (isset($_GET['userId'])) {
  $userId = $_GET['userId'];

  $sql = "SELECT * FROM `tbl_user` WHERE `user_Id` = '$userId'";
  $result = mysqli_query($con,$sql);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      if ($row = mysqli_fetch_array($result)) {
       $userName = $row['user_name'];
       $userEmail = $row['user_email'];
        $userAddress = $row['user_address'];
       $userCourseID  = $row['user_courseId'];
       $userContact  = $row['user_contact'];
        $userStatus = $row['user_status'];
     


      }
    }else{
      $_SESSION['errorMsg'] = "Access Denied....!";
      header("location:viewAllUsers.php");
      exit();
    }
  }
  else{
    $_SESSION['errorMsg'] = "Access Denied....!";
    header("location:viewAllUsers.php");
    exit();
  }
}
else{
  $_SESSION['errorMsg'] = "Access Denied....!";
  header("location:viewAllUsers.php");
  exit();
}




if(isset($_POST['userUpdateBtn'])){
    
    if(empty($_POST['userEmail'])){
       array_push($_SESSION['errors'], "Email is Required.");
    }else{
      $userEmail= mysqli_real_escape_string($con,$_POST['userEmail']);  
      if (checkUserEmailExist($userEmail,$userId)>0) {
       array_push($_SESSION['errors'], "Email Already Exist.");
        
      }
    }


    if(empty($_POST['userName'])){
       array_push($_SESSION['errors'], "User Name is Required.");
    }else{
      $userName = mysqli_real_escape_string($con,$_POST['userName']);  
    }

if(empty($_POST['userAddress'])){
       array_push($_SESSION['errors'], "Address is Required.");
    }else{
      $userAddress = mysqli_real_escape_string($con,$_POST['userAddress']);  
    }

if(empty($_POST['userCourseID'])){
       array_push($_SESSION['errors'], "User Course is Required.");
    }else{
      $userCourseID = mysqli_real_escape_string($con,$_POST['userCourseID']);  
    }
    if(empty($_POST['userContact'])){
       array_push($_SESSION['errors'], "User Contact is Required.");
    }else{
      $userContact = mysqli_real_escape_string($con,$_POST['userContact']);  
    }

if(empty($_POST['userStatus'])){
       array_push($_SESSION['errors'], "Status is Required.");
    }else{
      $userStatus = mysqli_real_escape_string($con,$_POST['userStatus']);  
    }

 
  

    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) 
    {
     
      $sql = "UPDATE `tbl_user` SET `user_name` = '$userName', `user_status` = '$userStatus' , `user_email` = '$userEmail' , `user_address` = '$userAddress' , `user_contact` = '$userContact' ,`user_status` = '$userStatus' , `user_courseId` = '$userCourseID' WHERE `user_id` = '$userId' ";
      
      $result = mysqli_query($con,$sql);
      if($result)
      {
        $_SESSION['successMsg'] = "User Updated Successfully";
        header("location:viewAllUsers.php");
        exit();
      }else{
       array_push($_SESSION['errors'], "User Not Updated, please try again.");

      }

    }
  
  }


?>
<body>
  <div class="container-scroller d-flex">
    <!-- partial:./partials/_sidebar.html -->
  <?php
  require('includes/sidebar.php');
  ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./partials/_navbar.html -->
      <?php require ("includes/navbar.php"); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
         
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-header">
                  Update user
                </div>
                <div class="card-body">
                  <h4 class="card-title">Update user</h4>
                  <form method="POST" name="edituser.php?userID=<?php echo $userID; ?>" class="forms-sample">

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
                  <div class="form-group row">
                      <label for="userName "  class="col-sm-3 col-form-label">User Name</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="userName "  name="userName" placeholder="Enter user Name" value="<?php echo $userName; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="userEmail "  class="col-sm-3 col-form-label">User Email</label>
                      <div class="col-sm-6">
                        <input type="email" class="form-control" id="userEmail "  name="userEmail" placeholder="Enter user Email" value="<?php echo $userEmail; ?>">
                      </div>
                    </div>
                      <div class="form-group row">
                      <label for="userContact "  class="col-sm-3 col-form-label">User Contact</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="userContact "  name="userContact" placeholder="Enter user Contact No" value="<?php echo $userContact; ?>">
                      </div>
                    </div>

                     

                    <div class="form-group row">
                      <label for="userAddress "  class="col-sm-3 col-form-label">User Address</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="userAddress "  name="userAddress" placeholder="Enter user Address" value="<?php echo $userAddress; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="userCourseID "  class="col-sm-3 col-form-label">User Course</label>
                      <div class="col-sm-6">

                       <select name="userCourseID" class="form-control">
                              <option value="">Select Course</option>
                              <?php $sql = "SELECT * FROM `tbl_course` ORDER BY `course_id` DESC";
                                $result = mysqli_query($con,$sql);
                                if ($result) {
                                   if (mysqli_num_rows($result)>0) {
                                     while($row = mysqli_fetch_array($result)){
                                      ?>
                                      <option <?php if($row['course_id']== $userCourseID){ echo "selected"; } ?> value="<?php echo $row['course_id']; ?>"><?php echo $row['course_title']; ?></option>
                                      <?php
                                     }
                                   }
                                 } 
                              ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="userStatus"  class="col-sm-3 col-form-label">user Status</label>
                      <div class="col-sm-6">
                        <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="userStatus" id="userStatus1" value="A" <?php if($userStatus == "A"){echo "checked";} ?>>
                              Active
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="userStatus" id="userStatus2" value="B" <?php if($userStatus == "B"){echo "checked";} ?>>
                              Block
                            <i class="input-helper"></i></label>
                             </div>
                        
                            <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="userStatus" id="userStatus3" value="P" <?php if($userStatus == "P"){echo "checked";} ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                      </div>      
                    </div>

                    

                    
                    <button type="submit" name="userUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
                  </form>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:./partials/_footer.html -->
<?php
require('includes/footer.php');
?>       
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

 <?php
        require('includes/jsScripts.php');
        ?>    
</body>

</html>