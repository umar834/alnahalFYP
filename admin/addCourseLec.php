<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');
$con = mysqli_connect('localhost','root','');
$db = mysqli_select_db($con,'alnahal');

if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
  $_SESSION['errors'] =  array();
}


$clecfile = $clecNotes = $clecDescription ="";

$teacherID = $_SESSION['userID'];
$courseID = $_SESSION['userCourse'];

$sql = "SELECT * FROM `tbl_course` WHERE `course_id` = '$courseID'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
$duration = $row['course_duration'];
$weeks = $duration * 4;

if(isset($_POST['lectureAddBtn'])){
   if(empty($_POST['clecDescription'])){
       array_push($_SESSION['errors'], " Description is Required.");
    }else{
      $clecDescription = mysqli_real_escape_string($con,$_POST['clecDescription']) ;  
      
    }
    
    if( basename($_FILES["clecfile"]["name"] != "")){
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["clecfile"]["name"]);
    $fileFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["clecfile"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($fileFileType != "mp3" && $fileFileType != "mpeg"  ) {
            array_push($_SESSION['errors'], "Sorry, only mp3 and mpeg files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["clecfile"]["tmp_name"], $target_file)) {
              $clecfile = mysqli_real_escape_string($con,$target_file);

            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        } 
      
    }
    
    if( basename($_FILES["clecNotes"]["name"] != "")){
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["clecNotes"]["name"]);
    $fileFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["clecNotes"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($fileFileType != "pdf" && $fileFileType != "docx"  ) {
            array_push($_SESSION['errors'], "Sorry, only pdf, docx,  files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["clecNotes"]["tmp_name"], $target_file)) {
              $clecNotes = mysqli_real_escape_string($con,$target_file);

            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        } 
      
    }

    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
    $selected_week = $_POST['week'];
    $sql = "INSERT INTO `tbl_course_lecture` ( `clec_audiofile`, `clec_notesfile`, `clec_description`,`clecture_teacherId`, `week`,`clecture_courseId` ) VALUES ( '$clecfile', '$clecNotes','$clecDescription', '$teacherID', '$selected_week','$courseID')";
     $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = " Details Added Successfully";
          header("location:viewAllLecture.php");
          exit();
      }else{
          array_push($_SESSION['errors'], " Lecture Not Added Successfully, Please try again.");
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
                                    Add New Lecture of course
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Add New Lecture of course</h4>
                                    <form method="POST" name="addCourseLec.php?" class="forms-sample"
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


                                        <div class="form-group row">
                                            <label for="clecNotes" class="col-sm-3 col-form-label">Notes</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="clecNotes" name="clecNotes">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="clecfile" class="col-sm-3 col-form-label">Audio File</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="clecfile" name="clecfile">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="clecDescription"
                                                class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea name="clecDescription"
                                                    class="form-control"><?php echo $clecDescription; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="clecDescription"
                                                class="col-sm-3 col-form-label">Week</label>
                                            <div class="col-sm-9">
                                                <select name="week" id="week" class="form-control">
                                                  <?php for($i = 1; $i <= $weeks; $i++){ ?>
                                                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                  <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" name="lectureAddBtn"
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