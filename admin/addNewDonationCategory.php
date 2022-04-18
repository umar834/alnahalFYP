<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');


$donationCateTitle = "";
if(isset($_POST['donationAddBtn'])){
    
    if(empty($_POST['donationCateTitle'])){
       array_push($_SESSION['errors'], "Donation Category Title is Required.");
    }else{
      $donationCateTitle = mysqli_real_escape_string($con,$_POST['donationCateTitle']) ;  
      if (checkDonationCategoryExist($donationCateTitle)>0) {
       array_push($_SESSION['errors'], "Donation Category Title Already Exist.");
        
      }
    }
    
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
     $sql = "INSERT INTO `tbl_donation_categories` (`donation_cate_title`,`donation_cate_status`) VALUES ('$donationCateTitle','A')";

     
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = "Donation Category Added Successfully";
          header("location:viewAllDonationCategories.php");
          exit();
      }else{
          array_push($_SESSION['errors'], "Donation Category Not Added Successfully, Please try again.");
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
                  Add New Donation Category
                </div>
                <div class="card-body">
                  <h4 class="card-title">Add New Donation Category</h4>
                  <form method="POST" name="addNewDonationCategory.php" class="forms-sample">

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
                      <label for="deptName"  class="col-sm-3 col-form-label">Donation Category Title</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="cateName"  name="donationCateTitle" placeholder="Enter Donation Category Title" value="<?php echo $donationCateTitle; ?>">
                      </div>
                    </div>
                    
                    <button type="submit" name="donationAddBtn" class="btn btn-primary mr-2">Submit</button>
                    
                  </form>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:./partials/_footer.html -->
<?php  require("includes/footer.php");
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