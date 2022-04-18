<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');


$materialName = "";
if(isset($_POST['materialAddBtn'])){
    
    if(empty($_POST['materialName'])){
       array_push($_SESSION['errors'], "Material Name is Required.");
    }else{
      $materialName = mysqli_real_escape_string($con,$_POST['materialName']) ;  
      if (checkMaterialExist($materialName)>0) {
       array_push($_SESSION['errors'], "Material Name Already Exist.");
        
      }
    }
    
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
     $sql = "INSERT INTO `tbl_materials` (`material_name`,`material_status`) VALUES ('$materialName','A')";

     
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = "Material Added Successfully";
          header("location:viewAllMaterials.php");
          exit();
      }else{
          array_push($_SESSION['errors'], "Material Not Added Successfully, Please try again.");
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
                  Add New Material
                </div>
                <div class="card-body">
                  <h4 class="card-title">Add New Material</h4>
                  <form method="POST" name="addNewMaterial.php" class="forms-sample">

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
                      <label for="deptName"  class="col-sm-3 col-form-label">Material Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="deptName"  name="materialName" placeholder="Enter Material Name" value="<?php echo $materialName; ?>">
                      </div>
                    </div>
                    
                    <button type="submit" name="materialAddBtn" class="btn btn-primary mr-2">Submit</button>
                    
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