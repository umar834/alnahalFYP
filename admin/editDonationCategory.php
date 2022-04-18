 <!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');



$donationCateTitle = $donationID = $donationStatus = "";

if (isset($_GET['donationID'])) {
  $donationID = $_GET['donationID'];

  $sql = "SELECT * FROM `tbl_donation_categories` WHERE `donation_cate_id` = '$donationID'";
  $result = mysqli_query($con,$sql);
  if ($result) {
      if (mysqli_num_rows($result) == 1) {
        if ($row = mysqli_fetch_array($result)) {
          $donationCateTitle = $row['donation_cate_title'];
          $donationStatus = $row['donation_cate_status'];

        }
      }else{
        $_SESSION['errorMsg'] = "Something going worng Please try again";
        header("location:viewAllDonationCategories.php");
        exit();
      }
    }else{
      $_SESSION['errorMsg'] = "Something going worng Please try again";
      header("location:viewAllDonationCategories.php");
      exit();    
    }  
}else{
  $_SESSION['errorMsg'] = "Access Denied....!";
  header("location:viewAllDonationCategories.php");
  exit();
}



if(isset($_POST['donationCateUpdateBtn'])){
    
    if(empty($_POST['donationCateTitle'])){
       array_push($_SESSION['errors'], "Donation Category Name is Required.");
    }else{
      $donationCateTitle = mysqli_real_escape_string($con,$_POST['donationCateTitle']) ;  
      if (checkDonationCategoryExist($donationCateTitle,$donationID)>0) {
       array_push($_SESSION['errors'], "Donation Category Already Exist.");
        
      }
    }


    if(empty($_POST['donationStatus'])){
       array_push($_SESSION['errors'], "Donation Status is Required.");
    }else{
      $donationStatus = mysqli_real_escape_string($con,$_POST['donationStatus']) ;  
    }
    
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
      $sql = "UPDATE `tbl_donation_categories` SET `donation_cate_title` = '$donationCateTitle', `donation_cate_status` = '$donationStatus' WHERE `donation_cate_id` = '$donationID'";
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = "Donation Category Updated Successfully";
          header("location:viewAllDonationCategories.php");
          exit();
      }else{
          array_push($_SESSION['errors'], "Donation Category Not Updated Successfully, Please try again.");
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
                  Update Donation Categorty
                </div>
                <div class="card-body">
                  <h4 class="card-title">Update Donation Category</h4>
                  <form method="POST" name="editDonationCategory.php?donationID=<?php echo $donationID; ?>" class="forms-sample">

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
                      <label for="donationCateTitle"  class="col-sm-3 col-form-label">Donation Category Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="donationCateTitle"  name="donationCateTitle" placeholder="Enter Donation Category Name" value="<?php echo $donationCateTitle; ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="donationStatus"  class="col-sm-3 col-form-label">Donation Category Status</label>
                      <div class="col-sm-9">
                        <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="donationStatus" id="donationStatus1" value="A" <?php if($donationStatus == "A"){echo "checked";} ?>>
                              Active
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="donationStatus" id="donationStatus2" value="B" <?php if($donationStatus == "B"){echo "checked";} ?>>
                              Block
                            <i class="input-helper"></i></label>
                          </div>
                      </div>      
                    </div>
                    
                    <button type="submit" name="donationCateUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
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