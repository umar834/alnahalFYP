<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$BCID= $BCName = "";


$bookName = $bookfile  =  $bookISBN = $bookAuthor = $bookDesc="";
if (isset($_GET['BCID'])) {
  $BCID = $_GET['BCID'];
  $BCName = getBCName($BCID);
}
if(isset($_POST['bookDetatilsAddBtn'])){
    
    if(empty($_POST['bookName'])){
       array_push($_SESSION['errors'], $BCName." Name is Required.");
    }else{
      $bookName = mysqli_real_escape_string($con,$_POST['bookName']) ;  
      if (checkBookDetailsExist($bookName,$BCID)>0) {
       array_push($_SESSION['errors'], $BCName." Name Already Exist.");
        
      }
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

     if(empty($_POST['bookDesc'])){
       array_push($_SESSION['errors'], $BCName." Description is Required.");
    }else{
      $bookDesc = mysqli_real_escape_string($con,$_POST['bookDesc']) ;  
      
    }
    



    if( basename($_FILES["bookfile"]["name"] != "")){
    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp.'-'.basename($_FILES["bookfile"]["name"]);
    $fileFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      if (file_exists($target_file)) {
            array_push($_SESSION['errors'], "Sorry, file already exists");
        }

        //Check file size
        if ($_FILES["bookfile"]["size"] > 50000000000) {
            array_push($_SESSION['errors'], "File is too large");
        }


       if($fileFileType != "pdf" && $fileFileType != "docx"  ) {
            array_push($_SESSION['errors'], "Sorry, only pdf, docx,  files are allowed.");
        }
        
        if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
            if (move_uploaded_file($_FILES["bookfile"]["tmp_name"], $target_file)) {
              $bookfile = mysqli_real_escape_string($con,$target_file);

            } else {
              array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
            }
        }        
      
      
    }
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     
     $sql = "INSERT INTO `tbl_books_detail` ( `book_title`, `book_desc`, `book_file`,`book_author`,`book_ISBN` ,`book_status`,`book_BCID`) VALUES ( '$bookName', '$bookDesc', '$bookfile', '$bookAuthor','$bookISBN','A','$BCID')";
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
                  Add New Book of <?php echo $BCName; ?>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Add New Book of <?php echo $BCName; ?></h4>
                  <form method="POST" name="addNewBookDetails.php?ID=<?php echo $BCID; ?>" class="forms-sample" enctype="multipart/form-data">

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
                      <label for="BCName"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="BCName"  name="bookName" placeholder="Enter Book Name" value="<?php echo $bookName; ?>">
                      </div>
                    </div>


                     <div class="form-group row">
                      <label for="BCName"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> File</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="bookfile"  name="bookfile" >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="BCName"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Book ISBN</label>
                      <div class="col-sm-9">
                        <textarea name="bookISBN" class="form-control"><?php echo $bookISBN; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="BCName"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Author </label>
                      <div class="col-sm-9">
                        <textarea name="bookAuthor" class="form-control"><?php echo $bookAuthor; ?></textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="BCName"  class="col-sm-3 col-form-label"><?php echo $BCName; ?> Description</label>
                      <div class="col-sm-9">
                        <textarea name="bookDesc" class="form-control"><?php echo $bookDesc; ?></textarea>
                      </div>
                    </div>
                    
                    <button type="submit" name="bookDetatilsAddBtn" class="btn btn-primary mr-2">Submit</button>
                    
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