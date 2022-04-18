<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

 $teacherId = $teacherName  = $teacherEmail = $teacherAddress=  $teacherCourseID = $teacherImage = "";

if(isset($_POST['teacherAddBtn']))
{
    
    if(empty($_POST['teacherEmail']))
    {
       array_push($_SESSION['errors'], " Teacher Email is Required.");
    }
    else
    {
      $teacherEmail = mysqli_real_escape_string($con,$_POST['teacherEmail']);

      if (checkTeacherEmailExist($teacherEmail)>0) 
      {
       array_push($_SESSION['errors'], "Email Already Exist.");
        
      }
    }
    
    if(empty($_POST['teacherCourseID']))
    {
       array_push($_SESSION['errors'], " Select Course.");
    }
    else
    {
      $teacherCourseID = mysqli_real_escape_string($con,$_POST['teacherCourseID']);
    }
    if(empty($_POST['teacherAddress']))
    {
       array_push($_SESSION['errors'], " Teacher Adress is Required.");
    }
    else
    {
      $teacherAddress = mysqli_real_escape_string($con,$_POST['teacherAddress']);
        }
  
    
    
    if(empty($_POST['teacherName']))
    {
       array_push($_SESSION['errors'], " Teacher Name is Required.");
    }
    else{
      $teacherName = mysqli_real_escape_string($con,$_POST['teacherName']);
      $teacherPassword = md5($_POST['teacherName']);
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
              //unlink($teacherImage);
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
     $sql = "INSERT INTO `tbl_teacher` ( `Teacher_Id`, `Teacher_Name`,`Teacher_Email`, `Teacher_Address`, `Teacher_password`,`Teacher_ProfileImg`,`Teacher_Status`,`Teacher_Course` ) VALUES ( '$teacherId','$teacherName', '$teacherEmail', '$teacherAddress', '$teacherPassword','$teacherImage','A','$teacherCourseID')";
    
      $result = mysqli_query($con,$sql);
      if($result)
      {
        $_SESSION['successMsg'] = "Teacher Added Successfully";
        header("location:viewAllTeachers.php");
        exit();
      }else{
       array_push($_SESSION['errors'], "Teacher Not Added successfully, please try again.");

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
         
          <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Teacher's Detail</h4>
                  <form action="addNewTeachers.php" method="POST" class="form-sample" enctype="multipart/form-data">
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
                    <p class="card-description">
                      Personal info
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Teacher Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="teacherName" value="<?php echo $teacherName; ?>">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Teacher Image</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" name="teacherImage" >
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                     <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" name="teacherEmail" value="<?php echo $teacherEmail; ?>" class="form-control">
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Course</label>
                          <div class="col-sm-9">
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
                      </div>
                     
                    </div>
                    <p class="card-description">
                      Address
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address </label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="teacherAddress" value="<?php echo $teacherAddress; ?>">
                          </div>
                        </div>
                      </div>
                    
                    </div>
                   
                    
                     <button type="submit" name="teacherAddBtn" class="btn btn-primary mr-2">Add Teacher</button>
                  </form>
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