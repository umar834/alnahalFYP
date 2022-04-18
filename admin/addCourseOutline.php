<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');
?> 
  <script src="ckeditor.js"></script>
    <script src="sample.js"></script>
<?php

$outlineDescription = "";


$teacherID = $_SESSION['userID'];
$courseID = $_SESSION['userCourse'];

 

$sql = "SELECT * FROM `tbl_course_outline` WHERE `outline_courseID` = '$courseID' AND `outline_teacherID` = '$teacherID'";
$result = mysqli_query($con,$sql);
if ($result) {
   if (mysqli_num_rows($result)== 1) {
       while($row = mysqli_fetch_array($result)){
        $outlineDescription = $row['outline_discription'];   
    }
   }
}
if(isset($_POST['updateOutlineBtn'])){
    if(empty($_POST['outlineDescription'])){
       array_push($_SESSION['errors'], "Description is Required.");
    }else{
      $outlineDescription = mysqli_real_escape_string($con,$_POST['outlineDescription']); 
    
    }
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
        if (checkCourseOutlineExist($teacherID,$courseID) == 1) {
            $sql = "UPDATE `tbl_course_outline` SET `outline_discription` = '$outlineDescription' WHERE `outline_courseID` = '$courseID' AND `outline_teacherID` = '$teacherID'";
        }else{
            $sql = "INSERT INTO `tbl_course_outline` (`outline_discription`,`outline_teacherID`,`outline_courseID`) VALUES ('$outlineDescription','$teacherID','$courseID')";
        }


        $result = mysqli_query($con,$sql);
        if ($result) {
            $_SESSION['success'] = " Outline Updated Successfully";
            header("location:addCourseOutline.php");
            exit();
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
       <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col=12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Outline Description</h6>
                    </div>
                    <div class="card-body">
                        <?php 
                        if (isset($_SESSION['success'])) {
                            ?>
                            <div class="alert alert-success">
                                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            </div>
                            <?php
                        }
                            if (isset($_SESSION['errors'])) { 
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
                        <form action="addCourseOutline.php" method="POST" enctype="multipart/form-data">
                          <div class="form-group">

                            <label for="outlineDescription">Outline Description</label>
                            
                            <textarea class="form-control"  id="editor" name="outlineDescription"><?php echo $outlineDescription; ?></textarea>
                          </div>


                         
                          <button type="submit" name="updateOutlineBtn" class="btn btn-primary">Update  Outline</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>




<?php
require('includes/footer.php');
?>       
        <!-- partial -->
    
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
<script>
    initSample();
</script>