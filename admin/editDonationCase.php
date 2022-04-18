<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$donationID= $donationCateTitle  = "";


$caseTitle = $caseImage = $caseDesc =$caseAmount= $caseForName = $caseForPhoneNo = $caseForAddress = $caseForCNIC ="";
if (isset($_GET['donationID']) && isset($_GET['caseID'])) {
  $donationID = $_GET['donationID'];
  $donationCateTitle  = getdonationCateTitle ($donationID);
  $caseID = $_GET['caseID'];
  
  $sql = "SELECT * FROM `tbl_donation_cases` WHERE `case_id` = '$caseID'";
  $result = mysqli_query($con,$sql);
  if ($result) {
      if (mysqli_num_rows($result) == 1) {
        if ($row = mysqli_fetch_array($result)) {
          $caseTitle = $row['case_title'];
          $caseDesc = $row['case_description'];
          $caseImage = $row['case_image'];
          $caseStatus = $row['case_status'];
           $caseAmount = $row['case_tot_amount_req'];
           $caseForName = $row['case_for_name'];
           $caseForPhoneNo = $row['case_for_phoneNo'];
           $caseForAddress = $row['case_for_address'];
           $caseForCNIC = $row['case_for_CNIC'];


        }
      }else{
        $_SESSION['errorMsg'] = "Something going worng Please try again";
        header("location:addNewDonationCase.php?donationID=".$donationID);
        exit();
      }
    }else{
      $_SESSION['errorMsg'] = "Something going worng Please try again";
      header("location:addNewDonationCase.php?donationID=".$donationID);
      exit();    
    }
}
if(isset($_POST['donationCaseUpdateBtn'])){
    
    if(empty($_POST['caseTitle'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Title is Required.");
    }else{
      $caseTitle = mysqli_real_escape_string($con,$_POST['caseTitle']) ;  
      if (checkDonationCaseExist($caseTitle,$donationID,$caseID)>0) {
       array_push($_SESSION['errors'], $donationCateTitle ." Title Already Exist.");
        
      }
    }


     if(empty($_POST['caseDesc'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Description is Required.");
    }else{
      $caseDesc = mysqli_real_escape_string($con,$_POST['caseDesc']) ;  
      
    }
    

  if(empty($_POST['caseStatus'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Status is Required.");
    }else{
      $caseStatus = mysqli_real_escape_string($con,$_POST['caseStatus']) ;  
      
    }
if(empty($_POST['caseAmount'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Amount is Required.");
    }else{
      $caseAmount = mysqli_real_escape_string($con,$_POST['caseAmount']) ;  
      
    }
if(empty($_POST['caseForName'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Deserving Person name is Required.");
    }else{
      $caseForName = mysqli_real_escape_string($con,$_POST['caseForName']) ;  
      
    }
    if(empty($_POST['caseForAddress'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Deserving Person Address is Required.");
    }else{
      $caseForAddress= mysqli_real_escape_string($con,$_POST['caseForAddress']) ;  
      
    }
    if(empty($_POST['caseForCNIC'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Deserving Person CNIC is Required.");
    }else{
      $caseForCNIC= mysqli_real_escape_string($con,$_POST['caseForCNIC']) ;  
      
    }
    if(empty($_POST['caseForPhoneNo'])){
       array_push($_SESSION['errors'], $donationCateTitle ." Deserving Person PhoneNo is Required.");
    }else{
      $caseForPhoneNo= mysqli_real_escape_string($con,$_POST['caseForPhoneNo']) ;  
      
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
              if ($caseImage != "" && file_exists($caseID)) {
                unlink($caseID);
              }

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
     
    // $sql = "INSERT INTO `tbl_donation_cases` ( `mat_detail_title`, `mat_detail_desc`, `mat_detail_image`, `mat_detail_donationID`, `mat_detail_status`) VALUES ( '$caseTitle', '$caseDesc', '$caseImage', '$donationID', 'A')";


      $sql = "UPDATE `tbl_donation_cases` SET `case_title` = '$caseTitle', 
                        `case_description`='$caseDesc',`case_image` = '$caseImage',`case_for_name`='$caseForName',`case_tot_amount_req`='$caseAmount',`case_for_CNIC`='$caseForCNIC',`case_for_address`='$caseForAddress',`case_for_phoneNo`='$caseForPhoneNo',`case_status`='$caseStatus' WHERE `case_id` = '$caseID'";
     
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = $donationCateTitle ." Details Added Successfully";
          header("location:viewAllDonationCase.php?donationID=".$donationID);
          exit();
      }else{
          array_push($_SESSION['errors'], $donationCateTitle ." Not Added Successfully, Please try again.");
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
                  Update  Donation Case of  <?php echo $donationCateTitle ; ?>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Update Donation Case of <?php echo $donationCateTitle ; ?></h4>
                  <form method="POST" name="editDonationCase.php?donationID=<?php echo $donationID; ?>&caseID=<?php echo $caseID; ?>" class="forms-sample" enctype="multipart/form-data">

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
                      <label for="donationCateTitle "  class="col-sm-3 col-form-label"><?php echo $donationCateTitle ; ?> Image</label>
                      <div class="col-sm-6">
                        <input type="file" class="form-control" id="caseImage"  name="caseImage" >
                      </div>
                      <div class="col-sm-3">
                      
                        <?php if($caseImage != "" && file_exists($caseImage)){
                            ?>
                            <img src="<?php echo $caseImage; ?>" style="width: 100px; height:100px; border-radius: 10px;">
                            <?php
                        }else{
                          echo "No Image Found";
                        } ?>
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


                     
                    <div class="form-group row">
                      <label for="caseStatus"  class="col-sm-3 col-form-label"> <?php echo $donationCateTitle ; ?> Status</label>
                      <div class="col-sm-9">
                        <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="caseStatus" id="caseStatus1" value="A" <?php if($caseStatus == "A"){echo "checked";} ?>>
                              Active
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="caseStatus" id="caseStatus2" value="B" <?php if($caseStatus == "B"){echo "checked";} ?>>
                              Block
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="caseStatus" id="caseStatus3" value="CL" <?php if($caseStatus == "CL"){echo "checked";} ?>>
                              Close
                            <i class="input-helper"></i></label>
                          </div>
                      </div>      
                    </div>

                    
                    
                    <button type="submit" name="donationCaseUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
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