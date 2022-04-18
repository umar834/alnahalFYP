<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');


$materialName = $materialID = $materialStatus = "";

if (isset($_GET['materialID'])) {
  $materialID = $_GET['materialID'];

  $sql = "SELECT * FROM `tbl_materials` WHERE `material_id` = '$materialID'";
  $result = mysqli_query($con,$sql);
  if ($result) {
      if (mysqli_num_rows($result) == 1) {
        if ($row = mysqli_fetch_array($result)) {
          $materialName = $row['material_name'];
          $materialStatus = $row['material_status'];

        }
      }else{
        $_SESSION['errorMsg'] = "Something going worng Please try again";
        header("location:viewAllMaterials.php");
        exit();
      }
    }else{
      $_SESSION['errorMsg'] = "Something going worng Please try again";
      header("location:viewAllMaterials.php");
      exit();    
    }  
}else{
  $_SESSION['errorMsg'] = "Access Denied....!";
  header("location:viewAllMaterials.php");
  exit();
}



if(isset($_POST['materialUpdateBtn'])){
    
    if(empty($_POST['materialName'])){
       array_push($_SESSION['errors'], "Material Name is Required.");
    }else{
      $materialName = mysqli_real_escape_string($con,$_POST['materialName']) ;  
      if (checkMaterialExist($materialName,$materialID)>0) {
       array_push($_SESSION['errors'], "Material Name Already Exist.");
        
      }
    }


    if(empty($_POST['materialStatus'])){
       array_push($_SESSION['errors'], "Material Status is Required.");
    }else{
      $materialStatus = mysqli_real_escape_string($con,$_POST['materialStatus']) ;  
    }
    
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
      $sql = "UPDATE `tbl_materials` SET `material_name` = '$materialName', `material_status` = '$materialStatus' WHERE `material_id` = '$materialID'";
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = "Material Updated Successfully";
          header("location:viewAllMaterials.php");
          exit();
      }else{
          array_push($_SESSION['errors'], "Material Not Updated Successfully, Please try again.");
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
                  Update Material
                </div>
                <div class="card-body">
                  <h4 class="card-title">Update Material</h4>
                  <form method="POST" name="editMaterial.php?materialID=<?php echo $materialID; ?>" class="forms-sample">

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
                      <label for="materialName"  class="col-sm-3 col-form-label">Material Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="materialName"  name="materialName" placeholder="Enter Material Name" value="<?php echo $materialName; ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="materialStatus"  class="col-sm-3 col-form-label">Material Status</label>
                      <div class="col-sm-9">
                        <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="materialStatus" id="materialStatus1" value="A" <?php if($materialStatus == "A"){echo "checked";} ?>>
                              Active
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="materialStatus" id="materialStatus2" value="B" <?php if($materialStatus == "B"){echo "checked";} ?>>
                              Block
                            <i class="input-helper"></i></label>
                          </div>
                      </div>      
                    </div>
                    
                    <button type="submit" name="materialUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
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