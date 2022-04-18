<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$courseCode =  $courseId = $courseName  = $courseDuration = $courseStatus  = $teacherImage = $courseStartDate =  "";

if (isset($_GET['courseId'])) {
  $courseId = $_GET['courseId'];

  $sql = "SELECT * FROM `tbl_course` WHERE `course_id` = '$courseId'";
  $result = mysqli_query($con,$sql);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      if ($row = mysqli_fetch_array($result)) {
        $courseName = $row['course_title'];
        $courseCode = $row['course_code'];
        $courseDuration = $row['course_duration'];
        $courseStatus = $row['course_status'];
        $courseImage = $row['course_img'];
        $courseStartDate = $row['course_start_date'];


      }
    }else{
      $_SESSION['errorMsg'] = "Access Denied....!";
      header("location:viewAllCourses.php");
      exit();
    }
  }
  else{
    $_SESSION['errorMsg'] = "Access Denied....!";
    header("location:viewAllCourses.php");
    exit();
  }
}
else{
  $_SESSION['errorMsg'] = "Access Denied....!";
  header("location:viewAllCourses.php");
  exit();
}




if(isset($_POST['courseUpdateBtn'])){
    
    if(empty($_POST['courseCode'])){
       array_push($_SESSION['errors'], "Course Code is Required.");
    }else{
      $courseCode= mysqli_real_escape_string($con,$_POST['courseCode']);  
      if (checkCourseCodeExist($courseCode,$courseId)>0) {
       array_push($_SESSION['errors'], "Course Code Already Exist.");
        
      }
    }


    if(empty($_POST['courseName'])){
       array_push($_SESSION['errors'], "Course Name is Required.");
    }else{
      $courseName = mysqli_real_escape_string($con,$_POST['courseName']);  
    }

if(empty($_POST['courseDuration'])){
       array_push($_SESSION['errors'], "course duration is Required.");
    }else{
      $courseDuration = mysqli_real_escape_string($con,$_POST['courseDuration']);  
    }

  if(empty($_POST['courseStartDate'])){
    array_push($_SESSION['errors'], "course start date is Required.");
  }else{
    $courseStartDate = mysqli_real_escape_string($con,$_POST['courseStartDate']);  
  }

if(empty($_POST['courseStatus'])){
       array_push($_SESSION['errors'], "Status is Required.");
    }else{
      $courseStatus = mysqli_real_escape_string($con,$_POST['courseStatus']);  
    }
if( basename($_FILES["courseImage"]["name"] != "")){
   
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["courseImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["courseImage"]["tmp_name"]);
    if($check !== false) {
          
        if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["courseImage"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["courseImage"]["tmp_name"], $target_file)) {
              
              if ($courseImage != "" && file_exists($courseImage)) {
                unlink($courseImage);
                                
              }
              $courseImage = $target_file;

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
     
     $sql = "UPDATE `tbl_course` SET `course_title` = '$courseName', `course_code` = '$courseCode' ,`course_start_date`='$courseStartDate', `course_duration` = '$courseDuration' , `course_status` = '$courseStatus', `course_img` = '$courseImage'   WHERE `course_id` = '$courseId' ";
     
      $result = mysqli_query($con,$sql);
      if($result)
      {
        $_SESSION['successMsg'] = "Course Updated Successfully";
        header("location:viewAllCourses.php");
        exit();
      }else{
       array_push($_SESSION['errors'], "Course Not Updated, please try again.");

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
                                    Update Course
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Update Course</h4>
                                    <form method="POST" name="editCourse.php?courseId=<?php echo $courseId; ?>"
                                        class="forms-sample" enctype="multipart/form-data">
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
                                            <label for="courseName" class="col-sm-3 col-form-label">Course Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="courseName"
                                                    name="courseName" placeholder="Enter Course Name"
                                                    value="<?php echo $courseName; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="courseImage" class="col-sm-3 col-form-label">Course
                                                Image</label>
                                            <div class="col-sm-6">
                                                <input type="file" class="form-control" id="courseImage"
                                                    name="courseImage">
                                            </div>
                                            <div class="col-sm-3">

                                                <?php if($courseImage != "" && file_exists($courseImage)){
                            ?>
                                                <img src="<?php echo $courseImage; ?>"
                                                    style="width: 100px; height:100px; border-radius: 10px;">
                                                <?php
                        }else{
                          echo "No Image Found";
                        } ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="courseCode" class="col-sm-3 col-form-label">Course Code</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="courseCode"
                                                    name="courseCode" placeholder="Enter Course Code"
                                                    value="<?php echo $courseCode; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Course Start Date</label>
                                                    <div class="col-sm-6">
                                                        <input type="date" name="courseStartDate"
                                                            value="<?php echo $courseStartDate; ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="courseDuration" class="col-sm-3 col-form-label">Course
                                                Duration</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="courseDuration"
                                                    name="courseDuration" placeholder="Enter course duration"
                                                    value="<?php echo $courseDuration; ?>">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="courseStatus" class="col-sm-3 col-form-label">Course
                                                Status</label>
                                            <div class="col-sm-9">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="courseStatus"
                                                            id="courseStatus1" value="A"
                                                            <?php if ($courseStatus == "A") { echo "checked"; } ?>>
                                                        Active
                                                        <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="courseStatus"
                                                            id="courseStatus2" value="B"
                                                            <?php if ($courseStatus == "B") { echo "checked"; } ?>>
                                                        Block
                                                        <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="courseStatus"
                                                            id="courseStatus3" value="P"
                                                            <?php if ($courseStatus == "P") { echo "checked"; } ?>>
                                                        Pending
                                                        <i class="input-helper"></i></label>
                                                </div>

                                            </div>

                                        </div>

                                        <button type="submit" name="courseUpdateBtn"
                                            class="btn btn-primary mr-2">Submit</button>

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