<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');


$BCName = "";
if(isset($_POST['BCAddBtn'])){
    
    if(empty($_POST['BCName'])){
       array_push($_SESSION['errors'], "Book Category Name is Required.");
    }else{
      $BCName = mysqli_real_escape_string($con,$_POST['BCName']) ;  
      if (checkBookCategoryExist($BCName)>0) {
       array_push($_SESSION['errors'], "Book Category Name Already Exist.");
        
      }
    }
    
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
     $sql = "INSERT INTO `tbl_books_cate` (`BC_name`,`BC_status`) VALUES ('$BCName','A')";

     
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = "Book Category Added Successfully";
          header("location:viewAllBooksCategory.php");
          exit();
      }else{
          array_push($_SESSION['errors'], "Book Category Not Added Successfully, Please try again.");
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
                  Add  Book Category
                </div>
                <div class="card-body">
                  <h4 class="card-title">Add  Book Category</h4>
                  <form method="POST" name="addNewBookCategory.php" class="forms-sample">

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
                    
                    <button type="submit" name="BCAddBtn" class="btn btn-primary mr-2">Submit</button>
                    
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