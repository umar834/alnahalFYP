<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$teacherName = $teacherStatus = $teacherID =$teacherEmail = $teacherAddress=$teacherCourseID= $teacherImage = "";

if (isset($_GET['teacherID'])) {
  $teacherID = $_GET['teacherID'];

  $sql = "SELECT * FROM `tbl_teacher` WHERE `Teacher_Id` = '$teacherID'";
  $result = mysqli_query($con,$sql);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      if ($row = mysqli_fetch_array($result)) {
        $teacherName = $row['Teacher_Name'];
        $teacherEmail = $row['Teacher_Email'];
        $teacherAddress = $row['Teacher_Address'];
        $teacherCourseID = $row['Teacher_Course'];
        $teacherStatus = $row['Teacher_Status'];
        $teacherImage = $row['Teacher_ProfileImg'];


      }
    }else{
      $_SESSION['errorMsg'] = "Access Denied....!";
      header("location:viewAllTeachers.php");
      exit();
    }
  }
  else{
    $_SESSION['errorMsg'] = "Access Denied....!";
    header("location:viewAllTeachers.php");
    exit();
  }
}
else{
  $_SESSION['errorMsg'] = "Access Denied....!";
  header("location:viewAllTeachers.php");
  exit();
}




if(isset($_POST['teacherUpdateBtn'])){
    
    if(empty($_POST['teacherEmail'])){
       array_push($_SESSION['errors'], "Email is Required.");
    }else{
      $teacherEmail= mysqli_real_escape_string($con,$_POST['teacherEmail']);  
      if (checkTeacherEmailExist($teacherEmail,$teacherID)>0) {
       array_push($_SESSION['errors'], "Email Already Exist.");
        
      }
    }


    if(empty($_POST['teacherName'])){
       array_push($_SESSION['errors'], "Teacher Name is Required.");
    }else{
      $teacherName = mysqli_real_escape_string($con,$_POST['teacherName']);  
    }

if(empty($_POST['teacherAddress'])){
       array_push($_SESSION['errors'], "Address is Required.");
    }else{
      $teacherAddress = mysqli_real_escape_string($con,$_POST['teacherAddress']);  
    }

if(empty($_POST['teacherCourseID'])){
       array_push($_SESSION['errors'], "Teacher Course is Required.");
    }else{
      $teacherCourseID = mysqli_real_escape_string($con,$_POST['teacherCourseID']);  
    }

if(empty($_POST['teacherStatus'])){
       array_push($_SESSION['errors'], "Status is Required.");
    }else{
      $teacherStatus = mysqli_real_escape_string($con,$_POST['teacherStatus']);  
    }

 if( basename($_FILES["teacherImage"]["name"] != "")){
   
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["teacherImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["teacherImage"]["tmp_name"]);
    if($check !== false) {
          
        if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["teacherImage"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["teacherImage"]["tmp_name"], $target_file)) {
              
              if ($teacherImage != "" && file_exists($teacherImage)) {
                unlink($teacherImage);
                                
              }
              $teacherImage = $target_file;

            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        }        
      } else {
          array_push($_SESSION['errors'], "Please Upload Image File Only");
      }
      
    }
  

    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) 
    {
     
      $sql = "UPDATE `tbl_teacher` SET `Teacher_Name` = '$teacherName', `Teacher_Status` = '$teacherStatus' , `Teacher_Email` = '$teacherEmail' , `Teacher_Address` = '$teacherAddress' , `Teacher_ProfileImg` = '$teacherImage' ,`Teacher_Status` = '$teacherStatus' , `Teacher_Course` = '$teacherCourseID' WHERE `Teacher_Id` = '$teacherID' ";
      
      $result = mysqli_query($con,$sql);
      if($result)
      {
        $_SESSION['successMsg'] = "Teacher Updated Successfully";
        header("location:viewAllTeachers.php");
        exit();
      }else{
       array_push($_SESSION['errors'], "Teacher Not Updated, please try again.");

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
                  Update Teacher
                </div>
                <div class="card-body">
                  <h4 class="card-title">Update Teacher</h4>
                  <form method="POST" name="editTeacher.php?teacherID=<?php echo $teacherID; ?>" class="forms-sample">

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
                      <label for="teacherName "  class="col-sm-3 col-form-label">Teacher Name</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="teacherName "  name="teacherName" placeholder="Enter Teacher Name" value="<?php echo $teacherName; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="teacherEmail "  class="col-sm-3 col-form-label">Teacher Email</label>
                      <div class="col-sm-6">
                        <input type="email" class="form-control" id="teacherEmail "  name="teacherEmail" placeholder="Enter Teacher Email" value="<?php echo $teacherEmail; ?>">
                      </div>
                    </div>


                     <div class="form-group row">
                      <label for="teacherImage"  class="col-sm-3 col-form-label">Teacher Image</label>
                      <div class="col-sm-6">
                        <input type="file" class="form-control" id="teacherImage"  name="teacherImage" >
                      </div>
                      <div class="col-sm-3">
                      
                        <?php if($teacherImage != "" && file_exists($teacherImage)){
                            ?>
                            <img src="<?php echo $teacherImage; ?>" style="width: 100px; height:100px; border-radius: 10px;">
                            <?php
                        }else{
                          echo "No Image Found";
                        } ?>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="teacherAddress "  class="col-sm-3 col-form-label">Teacher Address</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="teacherAddress "  name="teacherAddress" placeholder="Enter Teacher Address" value="<?php echo $teacherAddress; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="teacherCourseID "  class="col-sm-3 col-form-label">Teacher Course</label>
                      <div class="col-sm-6">

                       <select name="teacherCourseID" class="form-control">
                              <option value="">Select Course</option>
                              <?php $sql = "SELECT * FROM `tbl_course` ORDER BY `course_id` DESC";
                                $result = mysqli_query($con,$sql);
                                if ($result) {
                                   if (mysqli_num_rows($result)>0) {
                                     while($row = mysqli_fetch_array($result)){
                                      ?>
                                      <option <?php if($row['course_id']== $teacherCourseID){ echo "selected"; } ?> value="<?php echo $row['course_id']; ?>"><?php echo $row['course_title']; ?></option>
                                      <?php
                                     }
                                   }
                                 } 
                              ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="teacherStatus"  class="col-sm-3 col-form-label">Teacher Status</label>
                      <div class="col-sm-6">
                        <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="teacherStatus" id="teacherStatus1" value="A" <?php if($teacherStatus == "A"){echo "checked";} ?>>
                              Active
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="teacherStatus" id="teacherStatus2" value="B" <?php if($teacherStatus == "B"){echo "checked";} ?>>
                              Block
                            <i class="input-helper"></i></label>
                          </div>
                      </div>      
                    </div>

                    

                    
                    <button type="submit" name="teacherUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
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