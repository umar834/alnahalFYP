<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$cbookfile = $cbookdescription =$courseBookID="";

if (isset($_GET['courseBookID'])) {
  $courseBookID = $_GET['courseBookID'];

$sql = "SELECT * FROM ` tbl_course_book` WHERE `cbook_id` = '$courseBookID'"; 
  $result = mysqli_query($con,$sql);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      if ($row = mysqli_fetch_array($result)) {
        
        $cbookdescription = $row['cbook_desc'];
        $cbookfile = $row['cbook_path'];
        }
    }
    else{
      $_SESSION['errorMsg'] = "Access Denied....!";
      header("location:viewAllCourseBook.php");
      exit();
    }
  }
  else{
    $_SESSION['errorMsg'] = "Access Denied....!";
    header("location:viewAllCourseBook.php");
    exit();
  }
}
else{
  $_SESSION['errorMsg'] = "Access Denied....!";
  header("location:viewAllCourseBook.php");
  exit();
}




if(isset($_POST['cbookUpdateBtn'])){
    
    

   

if(empty($_POST['cbookdescription'])){
       array_push($_SESSION['errors'], " Book description is Required.");
    }else{
      $cbookdescription = mysqli_real_escape_string($con,$_POST['cbookdescription']);  
    }


if( basename($_FILES["cbookfile"]["name"] != "")){
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["cbookfile"]["name"]);
    $fileFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["cbookfile"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($fileFileType != "pdf" && $fileFileType != "docx"  ) {
            array_push($_SESSION['errors'], "Sorry, only pdf, docx,  files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["cbookfile"]["tmp_name"], $target_file)) {
              $cbookfile = mysqli_real_escape_string($con,$target_file);

            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        } 
      
    }

  

    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) 
    {
     
      $sql = "UPDATE `tbl_course_book` SET `cbook_desc` = '$cbookdescription',`cbook_path` = '$cbookfile'  WHERE `cbook_id` = '$courseBookID' ";
      
      $result = mysqli_query($con,$sql);
      if($result)
      {
        $_SESSION['successMsg'] = "Course Book Updated Successfully";
        header("location:viewAllCourseBook.php");
        exit();
      }else{
       array_push($_SESSION['errors'], "Course Book Not Updated, please try again.");

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
                  <h4 class="card-title">Update Course</h4>
                  <form method="POST" name="editCourseBook.php?courseBookID=<?php echo $courseBookID; ?>" class="forms-sample">

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
                      <label for="cbookfile"  class="col-sm-3 col-form-label">File</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="cbookfile"  name="cbookfile" >
                      </div>
                    </div>

                     <div class="form-group row">
                      <label for="cbookdescription"  class="col-sm-3 col-form-label">Description</label>
                      <div class="col-sm-9">
                        <textarea name="cbookdescription" class="form-control"><?php echo $cbookdescription; ?></textarea>
                      </div>
                    </div>
                   
                    

                    

                    
                    <button type="submit" name="cbookUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
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