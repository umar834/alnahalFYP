<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$BCID= $BCName = "";


$bookName = $bookfile = $bookDesc = $bookISBN = $bookAuthor = $bookStatus = $bookID = "";
if (isset($_GET['BCID']) && isset($_GET['bookID'])) {
  $BCID = $_GET['BCID'];
  $BCName = getBCName($BCID);
  $bookID = $_GET['bookID'];
  
  $sql = "SELECT * FROM `tbl_books_detail` WHERE `book_id` = '$bookID'";
  $result = mysqli_query($con,$sql);
  if ($result) {
      if (mysqli_num_rows($result) == 1) {
        if ($row = mysqli_fetch_array($result)) {
          $bookName = $row['book_title'];
          $bookDesc = $row['book_desc'];
          $bookfile = mysqli_real_escape_string($con,$row['book_file']);
          $bookISBN = $row['book_ISBN'];
           $bookAuthor = $row['book_author'];
          $bookStatus = $row['book_status'];

        }
      }else{
        $_SESSION['errorMsg'] = "Something going worng Please try again";
        header("location:addNewBookDetails.php?BCID=".$BCID);
        exit();
      }
    }else{
      $_SESSION['errorMsg'] = "Something going worng Please try again";
      header("location:addNewBookDetails.php?BCID=".$BCID);
      exit();    
    }
}
if(isset($_POST['bookDetatilsUpdateBtn'])){
    
    if(empty($_POST['bookName'])){
       array_push($_SESSION['errors'], $BCName." Name is Required.");
    }else{
      $bookName = mysqli_real_escape_string($con,$_POST['bookName']) ;  
      if (checkMaterialDetailsExist($bookName,$BCID,$bookID)>0) {
       array_push($_SESSION['errors'], $BCName." Name Already Exist.");
        
      }
    }


     if(empty($_POST['bookDesc'])){
       array_push($_SESSION['errors'], $BCName." Description is Required.");
    }else{
      $bookDesc = mysqli_real_escape_string($con,$_POST['bookDesc']) ;  
      
    }
    if(empty($_POST['bookISBN'])){
       array_push($_SESSION['errors'], $BCName." Book ISBN is Required.");
    }else{
      $bookISBN = mysqli_real_escape_string($con,$_POST['bookISBN']) ;  
      
    }
    if(empty($_POST['bookAuthor'])){
       array_push($_SESSION['errors'], $BCName." Author name is Required.");
    }else{
      $bookAuthor = mysqli_real_escape_string($con,$_POST['bookAuthor']) ;  
      
    }
    

  if(empty($_POST['bookStatus'])){
       array_push($_SESSION['errors'], $BCName." Status is Required.");
    }else{
      $bookStatus = mysqli_real_escape_string($con,$_POST['bookStatus']) ;  
      
    }


    if( basename($_FILES["bookfile"]["name"] != "")){
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["bookfile"]["name"]);
    $fileFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["bookfile"]["tmp_name"]);
    if($check !== false) {
          
        if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["bookfile"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($fileFileType != "pdf" && $fileFileType != "docx"  ) {
            array_push($_SESSION['errors'], "Sorry, only pdf and docx files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["bookfile"]["tmp_name"], $target_file)) {
              if ($bookfile != "" && file_exists($bookID)) {
                unlink($bookID);
              }

                $bookfile = mysqli_real_escape_string($con,$target_file);



            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        }        
      } else {
          array_push($_SESSION['errors'], "Please Upload  File Only");
      }
      
    }
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
      $sql = "UPDATE `tbl_books_detail` SET `book_title` = '$bookName', 
                        `book_desc`='$bookDesc',`book_ISBN`='$bookISBN',`book_author`='$bookAuthor',`book_file` = '$bookfile',`book_status`='$bookStatus' WHERE `book_id` = '$bookID'";
      $result = mysqli_query($con,$sql);
      if($result){
          $_SESSION['successMsg'] = $BCName." Details Added Successfully";
          header("location:viewAllBooksDetails.php?BCID=".$BCID);
          exit();
      }else{
          array_push($_SESSION['errors'], $BCName." Not Added Successfully, Please try again.");
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
                  Update  Book Details of  <?php echo $BCName; ?>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Update Book Details of <?php echo $BCName; ?></h4>
                  <form method="POST" name="editBookDetails.php?BCID=<?php echo $BCID; ?>&bookID=<?php echo $bookID; ?>" class="forms-sample" enctype="multipart/form-data">

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
                      <label for="BCName "  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="BCName "  name="bookName" placeholder="Enter Book Name" value="<?php echo $bookName; ?>">
                      </div>
                    </div>


                     <div class="form-group row">
                      <label for="BCName"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> File</label>
                      <div class="col-sm-6">
                        <input type="file" class="form-control" id="bookfile"  name="bookfile" >
                      </div>
                      <div class="col-sm-3">
                      
                        <?php if($bookfile != "" && file_exists($bookfile)){
                            ?>
                            <a href="<?php echo $row['book_file']; ?>" class="btn btn-primary btn-sm " target="_blank">Book</a>
                            <?php
                        }else{
                           "No File Found";
                        } ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="bookStatus"  class="col-sm-3 col-form-label"> <?php echo $BCName; ?>Status</label>
                      <div class="col-sm-9">
                        <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="bookStatus" id="bookStatus1" value="A" <?php if($bookStatus == "A"){echo "checked";} ?>>
                              Active
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="bookStatus" id="bookStatus2" value="B" <?php if($bookStatus == "B"){echo "checked";} ?>>
                              Block
                            <i class="input-helper"></i></label>
                          </div>
                      </div>      
                    </div>
                    <div class="form-group row">
                      <label for="bookISBN"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Book ISBN</label>
                      <div class="col-sm-9">
                        <textarea name="bookISBN" class="form-control"><?php echo $bookISBN; ?></textarea>
                      </div>
                    </div>
                     <div class="form-group row">
                      <label for="bookAuthor"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Author</label>
                      <div class="col-sm-9">
                        <textarea name="bookAuthor" class="form-control"><?php echo $bookAuthor; ?></textarea>
                      </div>
                    </div>
                    

                    <div class="form-group row">
                      <label for="bookDesc"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Description</label>
                      <div class="col-sm-9">
                        <textarea name="bookDesc" class="form-control"><?php echo $bookDesc; ?></textarea>
                      </div>
                    </div>
                   
                    <button type="submit" name="bookDetatilsUpdateBtn" class="btn btn-primary mr-2">Submit</button>
                    
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