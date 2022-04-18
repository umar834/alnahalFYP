<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="css1/bootstrap.min.css" />
    <!-- Pogo Slider CSS -->
    <link rel="stylesheet" href="css1/pogo-slider.min.css" />
    <!-- Site CSS -->
    <link rel="stylesheet" href="css1/style.css" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css1/responsive.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css1/custom.css" />
<?php
require('includes/head.php');






  


$outlineDescription = "";

if(isset($_POST['addOutlineBtn'])){
    if(empty($_POST['outlineDescription'])){
       array_push($_SESSION['errors'], "Description is Required.");
    }else{
      $outlineDescription = mysqli_real_escape_string($con,$_POST['outlineDescription']); 
    
    }
     if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
     $sql = "INSERT INTO `tbl_course_outline` (`outline_discription`) VALUES ('$outlineDescription')";

     
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = "Outline  Added Successfully";
          header("location:viewAllBooksCategory.php");
          exit();
      }else{
          array_push($_SESSION['errors'], "Curse Outline not Added Successfully, Please try again.");
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
    

<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="heading_main text_align_center">
                           <h2><span>Course </span>Material</h2>
                        </div>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="full blog_img_popular">
                       <img class="img-responsive" src="out.jpg" alt="#" style="height:300px"> 
                       <h4>Outline</h4>
                     <a href="addCourseOutline.php" name="outlineAddBtn" class="btn btn-block btn-primary mr-2" style="float:left">Outline of the Course</a>
                      
                     <!--  <a href="viewCourseOutline.php" name="outlineAddBtn" class="btn btn-primary mr-2" style="float:right">View Outline</a>
                      -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="full blog_img_popular">
                        <img class="img-responsive" src="book1.jpg" alt="#" style="height:300px">
                        <h4>Books</h4>
                        <a href="viewAllCourseBook.php" name="courseBookAddBtn" class="btn btn-block btn-primary mr-2" style="float:left">Book of the Course</a>
                      
                    <!-- <button type="submit" name="courseAddBtn" class="btn btn-primary mr-2" style="float:right">View Book</button> -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="full blog_img_popular">
                        <img class="img-responsive" src="lec1.jpg" alt="#" style="height:300px">
                        <h4>Lectures</h4>
                         <a href="viewAllLecture.php"type="submit" name="courseAddBtn" class="btn btn-block btn-primary mr-2" style="float:left">Manage Lectures</a>
                       <!-- 
                     <button type="submit" name="courseAddBtn" class="btn btn-primary mr-2" style="float:right">View Lectures</button>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                
                <div class="col-md-4">
                    <div class="full blog_img_popular">
                       <img class="img-responsive" src="quiz.jpg" alt="#" style="height:300px"> 
                       <h4>Quiz</h4>
                     <a href="addCourseOutline.php" name="outlineAddBtn" class="btn btn-block btn-primary mr-2" style="float:left">Generates</a>
                      
                     <!--  <a href="viewCourseOutline.php" name="outlineAddBtn" class="btn btn-primary mr-2" style="float:right">View Outline</a>
                      -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="full blog_img_popular">
                        <img class="img-responsive" src="ass.jpg" alt="#" style="height:300px">
                        <h4>Assignments</h4>
                        <a href="viewAllCourseBook.php" name="courseBookAddBtn" class="btn btn-block btn-primary mr-2" style="float:left">Generate </a>
                      
                    <!-- <button type="submit" name="courseAddBtn" class="btn btn-primary mr-2" style="float:right">View Book</button> -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="full blog_img_popular">
                        <img class="img-responsive" src="acc.jpg" alt="#" style="height:300px">
                        <h4>Announncemet</h4>
                         <a href="addCourseLec.php"type="submit" name="courseAddBtn" class="btn btn-block btn-primary mr-2" style="float:left">Important Announcement</a>
                       <!-- 
                     <button type="submit" name="courseAddBtn" class="btn btn-primary mr-2" style="float:right">View Lectures</button>-->
                    </div>
                </div>
            </div>
        </div>


     
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
