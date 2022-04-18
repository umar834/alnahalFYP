<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$materialID= $materialName = "";


$materialDetailName = $materialDetailImage = $materialDetailDesc = "";
if (isset($_GET['materialID'])) {
  $materialID = $_GET['materialID'];
  $materialName = getMaterialName($materialID);
}
if(isset($_POST['materialDetatilsAddBtn'])){
    
    if(empty($_POST['materialDetailName'])){
       array_push($_SESSION['errors'], $materialName." Name is Required.");
    }else{
      $materialDetailName = mysqli_real_escape_string($con,$_POST['materialDetailName']) ;  
      if (checkMaterialDetailsExist($materialDetailName,$materialID)>0) {
       array_push($_SESSION['errors'], $materialName." Name Already Exist.");
        
      }
    }


     if(empty($_POST['materialDetailDesc'])){
       array_push($_SESSION['errors'], $materialName." Description is Required.");
    }else{
      $materialDetailDesc = mysqli_real_escape_string($con,$_POST['materialDetailDesc']) ;  
      
    }
    



    if( basename($_FILES["materialDetailImage"]["name"] != "")){
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["materialDetailImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["materialDetailImage"]["tmp_name"]);
    if($check !== false) {
          
        if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["materialDetailImage"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["materialDetailImage"]["tmp_name"], $target_file)) {
              $materialDetailImage = $target_file;

            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        }        
      } else {
          array_push($_SESSION['errors'], "Please Upload Image File Only");
      }
      
    }
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
     $sql = "INSERT INTO `tbl_materials_details` ( `mat_detail_title`, `mat_detail_desc`, `mat_detail_image`, `mat_detail_materialID`, `mat_detail_status`) VALUES ( '$materialDetailName', '$materialDetailDesc', '$materialDetailImage', '$materialID', 'A')";

     
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = $materialName." Details Added Successfully";
          header("location:viewAllMaterialsDetails.php?materialID=".$materialID);
          exit();
      }else{
          array_push($_SESSION['errors'], $materialName." Not Added Successfully, Please try again.");
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
                  Add New Material of <?php echo $materialName; ?>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Add New Material of <?php echo $materialName; ?></h4>
                  <form method="POST" name="addNewMaterialDetails.php?materialID=<?php echo $materialID; ?>" class="forms-sample" enctype="multipart/form-data">

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
                      <label for="materialName"  class="col-sm-3 col-form-label"><?php echo $materialName; ?> Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="materialName"  name="materialDetailName" placeholder="Enter Material Name" value="<?php echo $materialDetailName; ?>">
                      </div>
                    </div>


                     <div class="form-group row">
                      <label for="materialName"  class="col-sm-3 col-form-label"><?php echo $materialName; ?> Image</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="materialDetailImage"  name="materialDetailImage" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="materialName"  class="col-sm-3 col-form-label"><?php echo $materialName; ?> Description</label>
                      <div class="col-sm-9">
                        <textarea name="materialDetailDesc" class="form-control"><?php echo $materialDetailDesc; ?></textarea>
                      </div>
                    </div>
                    
                    <button type="submit" name="materialDetatilsAddBtn" class="btn btn-primary mr-2">Submit</button>
                    
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