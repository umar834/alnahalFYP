 <?php
        require('includes/jsScripts.php');
        ?>    <!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$donationID= $donationCateTitle  = "";


$caseTitle = $caseImage = $caseDesc =$caseAmount= $caseForName = $caseForPhoneNo = $caseForAddress = $caseForCNIC ="";
if (isset($_GET['donationID'])) {
  $donationID = $_GET['donationID'];
  $donationCateTitle = getdonationCateTitle($donationID);
}
if(isset($_POST['caseDetatilsAddBtn'])){
    
    if(empty($_POST['caseTitle'])){
       array_push($_SESSION['errors'], $donationCateTitle." Name is Required.");
    }else{
      $caseTitle = mysqli_real_escape_string($con,$_POST['caseTitle']) ;  
      if (checkDonationCaseExist($caseTitle,$donationID)>0) {
       array_push($_SESSION['errors'], $donationCateTitle." Name Already Exist.");
        
      }
    }


     if(empty($_POST['caseDesc'])){
       array_push($_SESSION['errors'], $donationCateTitle." Description is Required.");
    }else{
      $caseDesc = mysqli_real_escape_string($con,$_POST['caseDesc']) ;  
      
    }
     if(empty($_POST['caseAmount'])){
       array_push($_SESSION['errors'], $donationCateTitle." Case Amount is Required.");
    }else{
      $caseAmount = mysqli_real_escape_string($con,$_POST['caseAmount']) ;  
      
    }
     if(empty($_POST['caseForName'])){
       array_push($_SESSION['errors'], $donationCateTitle." Person Name is Required.");
    }else{
      $caseForName = mysqli_real_escape_string($con,$_POST['caseForName']) ;  
      
    }
    if(empty($_POST['caseForPhoneNo'])){
       array_push($_SESSION['errors'], $donationCateTitle." Deserving Person PhoneNo is Required.");
    }else{
      $caseForPhoneNo = mysqli_real_escape_string($con,$_POST['caseForPhoneNo']) ;  
      
    }
    if(empty($_POST['caseForAddress'])){
       array_push($_SESSION['errors'], $donationCateTitle." Deserving Person Address is Required.");
    }else{
      $caseForAddress = mysqli_real_escape_string($con,$_POST['caseForAddress']) ;  
      
    }
    if(empty($_POST['caseForCNIC'])){
       array_push($_SESSION['errors'], $donationCateTitle." Deserving Person CNIC is Required.");
    }else{
      $caseForCNIC = mysqli_real_escape_string($con,$_POST['caseForCNIC']) ;  
      
    }
    



    if( basename($_FILES["caseImage"]["name"] != "")){
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["caseImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["caseImage"]["tmp_name"]);
    if($check !== false) {
          
        if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["caseImage"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["caseImage"]["tmp_name"], $target_file)) {
              $caseImage = $target_file;

            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        }        
      } else {
          array_push($_SESSION['errors'], "Please Upload Image File Only");
      }
      
    }
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
     $sql = "INSERT INTO `tbl_donation_cases` ( `case_title`, `case_description`,
      `case_tot_amount_req`,`case_for_name`,`case_for_phoneNo`,`case_for_address`,`case_for_CNIC`,`case_image`, `case_cate_id`, `case_status`) VALUES ( '$caseTitle', '$caseDesc','$caseAmount', '$caseForName','$caseForPhoneNo','$caseForAddress','$caseForCNIC','$caseImage','$donationID', 'A')";
     
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = $donationCateTitle." Details Added Successfully";
          header("location:viewAllDonationCase.php?donationID=".$donationID);
          exit();
      }else{
          array_push($_SESSION['errors'], $donationCateTitle." Not Added Successfully, Please try again.");
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
                  Add New Case of <?php echo $donationCateTitle; ?>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Add New Case of <?php echo $donationCateTitle; ?></h4>
                  <form method="POST" name="viewAllDonationCase.php?donationID=<?php echo $donationID; ?>" class="forms-sample" enctype="multipart/form-data">

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
                      <label for="donationCateTitle"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Title</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="donationCateTitle"  name="caseTitle" placeholder="Enter Case Title" value="<?php echo $caseTitle; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="caseAmount"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Amount Required</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="caseAmount"  name="caseAmount" placeholder="Enter Amount Required" value="<?php echo $caseAmount; ?>">
                      </div>
                    </div>


                     <div class="form-group row">
                      <label for="caseImage"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Image</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="caseImage"  name="caseImage" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="caseDescription"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Description</label>
                      <div class="col-sm-9">
                        <textarea name="caseDesc" class="form-control"><?php echo $caseDesc; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="caseForName"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Deserving Person</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="caseForName"  name="caseForName" placeholder="Enter Deserving Person Name" value="<?php echo $caseForName; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="caseForPhoneNo"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Deserving Person PhoneNO</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="caseForPhoneNo"  name="caseForPhoneNo" placeholder="Enter Deserving Person PhoneNo" value="<?php echo $caseForPhoneNo; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="caseForAddress"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Deserving Person Address</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="caseForAddress"  name="caseForAddress" placeholder="Enter Deserving Person Address" value="<?php echo $caseForAddress; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="caseForCNIC"  class="col-sm-3 col-form-label"><?php echo $donationCateTitle; ?> Deserving Person CNIC</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="caseForCNIC"  name="caseForCNIC" placeholder="Enter Deserving Person CNIC" value="<?php echo $caseForCNIC; ?>">
                      </div>
                    </div>
                    <button type="submit" name="caseDetatilsAddBtn" class="btn btn-primary mr-2">Submit</button>
                    
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