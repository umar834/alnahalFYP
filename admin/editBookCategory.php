<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');


$BCName = $BCID = $BCStatus = "";

if (isset($_GET['BCID'])) {
  $BCID = $_GET['BCID'];

  $sql = "SELECT * FROM `tbl_books_cate` WHERE `BC_id` = '$BCID'";
  $result = mysqli_query($con,$sql);
  if ($result) {
      if (mysqli_num_rows($result) == 1) {
        if ($row = mysqli_fetch_array($result)) {
          $BCName = $row['BC_name'];
          $BCStatus = $row['BC_status'];

        }
      }else{
        $_SESSION['errorMsg'] = "Something going worng Please try again";
        header("location:viewAllBookCategory.php");
        exit();
      }
    }else{
      $_SESSION['errorMsg'] = "Something going worng Please try again";
      header("location:viewAllBookCategory.php");
      exit();    
    }  
}else{
  $_SESSION['errorMsg'] = "Access Denied....!";
  header("location:viewAllBookCategory.php");
  exit();
}



if(isset($_POST['BCUpdateBtn'])){
    
    if(empty($_POST['BCName'])){
       array_push($_SESSION['errors'], "Book Category Name is Required.");
    }else{
      $BCName = mysqli_real_escape_string($con,$_POST['BCName']) ;  
      if (checkBookCategoryExist($BCName,$BCID)>0) {
       array_push($_SESSION['errors'], "Book Category Name Already Exist.");
        
      }
    }


    if(empty($_POST['BCStatus'])){
       array_push($_SESSION['errors'], "Book Category Status is Required.");
    }else{
      $BCStatus = mysqli_real_escape_string($con,$_POST['BCStatus']) ;  
    }
    
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
      $sql = "UPDATE `tbl_books cate` SET `BC_name` = '$BCName', `BC_status` = '$BCStatus' WHERE `BC_id` = '$BCID'";
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = "Book Category Updated Successfully";
          header("location:viewAllBooksCategory.php");
          exit();
      }else{
          array_push($_SESSION['errors'], "Book Category Not Updated Successfully, Please try again.");
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
                  Update Book Category
                </div>
                <div class="card-body">
                  <h4 class="card-title">Update Book Category</h4>
                  <form method="POST" name="editBookCategory.php?BCID=<?php echo $BCID; ?>" class="forms-sample">

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
                      <label for="BCName"  class="col-sm-3 col-form-label">Book Category Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="BCName"  name="BCName" placeholder="Enter Book Category Name" value="<?php echo $BCName; ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="BCStatus"  class="col-sm-3 col-form-label">Book Category Status</label>
                      <div class="col-sm-9">
                        <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="BCStatus" id="BCStatus1" value="A" <?php if($BCStatus == "A"){echo "checked";} ?>>
                              Active
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="BCStatus" id="BCStatus2" value="B" <?php if($BCStatus == "B"){echo "checked";} ?>>
                              Block
                            <i class="input-helper"></i></label>
                          </div>
                      </div>      
                    </div>
                    
                    <button type="submit" name="BCUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
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