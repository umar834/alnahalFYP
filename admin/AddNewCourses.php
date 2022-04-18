<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$courseCode =  $courseId = $courseName  = $courseDuration = $courseStatus  = $courseImage = "";

if(isset($_POST['courseAddBtn']))
{
    
    if(empty($_POST['courseCode']))
    {
       array_push($_SESSION['errors'], " Course Code is Required.");
    }
    else
    {
      $courseCode = mysqli_real_escape_string($con,$_POST['courseCode']);

      if (checkCourseCodeExist($courseCode)>0) 
      {
       array_push($_SESSION['errors'], "Course Code Already Exist.");
        
      }
    }
    
  
    if(empty($_POST['courseName']))
    {
       array_push($_SESSION['errors'], " Course Name is Required.");
    }
    else
    {
      $courseName = mysqli_real_escape_string($con,$_POST['courseName']);
        }
  
    
   
    if(empty($_POST['courseDuration']))
    {
       array_push($_SESSION['errors'], " Course Duration is Required.");
    }
    else
    {
      $courseDuration = mysqli_real_escape_string($con,$_POST['courseDuration']);
    }

    if(empty($_POST['courseStartDate']))
    {
       array_push($_SESSION['errors'], " Course Start Date is Required.");
    }
    else
    {
      $courseStartDate = mysqli_real_escape_string($con,$_POST['courseStartDate']);
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
              //unlink($courseImage);
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
     $sql = "INSERT INTO `tbl_course` ( `course_id`, `course_title`,`course_code`, `course_duration`, `course_start_date`,`course_img`, `course_status` ) VALUES ( '$courseId','$courseName', '$courseCode', '$courseDuration','$courseStartDate','$courseImage', 'A')";
    
      $result = mysqli_query($con,$sql);
      if($result)
      {
        $_SESSION['successMsg'] = "Course Added Successfully";
        header("location:viewAllCourses.php");
        exit();
      }else{
       array_push($_SESSION['errors'], "Course Not Added successfully, please try again.");

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
                            <h4 class="card-title">Add Course Detail</h4>
                            <form action="addNewCourses.php" method="POST" class="form-sample"
                                enctype="multipart/form-data">
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
                                    Course Info
                                </p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Course Title</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="courseName"
                                                    value="<?php echo $courseName; ?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Course Image</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="courseImage">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Course Code</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="courseCode" value="<?php echo $courseCode; ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Course Start Date</label>
                                            <div class="col-sm-6">
                                                <input type="date" name="courseStartDate"
                                                    value="<?php echo $courseStartDate; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Course Duration(Months)</label>
                                            <div class="col-sm-6">
                                                <input type="number" name="courseDuration"
                                                    value="<?php echo $courseDuration; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <button type="submit" name="courseAddBtn" class="btn btn-primary mr-2">Add
                                        Course</button>
                                </div>
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