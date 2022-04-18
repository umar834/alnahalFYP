
<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$BCID= $BCName = "";

if (isset($_GET['BCID'])) {
  $BCID = $_GET['BCID'];
  $BCName = getBCName($BCID);
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
         
          <div class="card-body">
                  <h4 class="card-title">
                    Al-Nahal  List of <?php echo $BCName; ?>
                    
                    <a href="addNewBookDetails.php?BCID=<?php echo $BCID; ?>" class="btn btn-primary btn-sm float-right" >Add New <?php echo $BCName; ?></a>

                  </h4>
                  
                  <div class="table-responsive">
                    <?php 
                    if (isset($_SESSION['successMsg'])) {
                      ?>
                      <div class="alert alert-success">
                        <?php 
                          echo $_SESSION['successMsg'];
                          unset($_SESSION['successMsg']);
                        ?>
                      </div>
                      <?php
                    }

                    ?>


                    <?php 
                    if (isset($_SESSION['errorMsg'])) {
                      ?>
                      <div class="alert alert-danger">
                        <?php 
                          echo $_SESSION['errorMsg'];
                          unset($_SESSION['errorMsg']);
                        ?>
                      </div>
                      <?php
                    }

                    ?>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>SrNo</th>
                          <th>Title</th>
                          <th>Author Name</th>
                        
                        <th>Book ISBN</th>
                        <th>File</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $sql = "SELECT * FROM `tbl_books_detail` WHERE `book_BCID` = '$BCID' ORDER BY `book_id`"; 
                        $result = mysqli_query($con,$sql);
                        if ($result) {
                          if (mysqli_num_rows($result)>0) {
                            $srNo = 1;
                            while ($row = mysqli_fetch_array($result)) {
                              ?>
                              <tr>
                                <td><?php echo $srNo; ?></td>
                                <td><?php echo $row['book_title']; ?></td>
                                <td><?php echo $row['book_author']; ?></td>
                                <td><?php echo $row['book_ISBN']; ?></td>
                                <td><?php if ($row['book_file'] != "" && file_exists($row['book_file'])) {
                                  ?>
                                  <a href="<?php echo $row['book_file']; ?>" class="btn btn-primary btn-sm " target="_blank">Book</a>
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?></td>
                                <td><?php echo getStatusTitle($row['book_status']); ?></td>
                                <td>
                                  <a href="editBookDetails.php?bookID=<?php echo $row['book_id']; ?>&BCID=<?php echo $BCID; ?>" class="btn btn-success btn-sm">Edit</a>
                                  <a href="" class="btn btn-danger btn-sm">Delete</a>

                                </td>
                              </tr>
                              <?php
                              $srNo++;
                            }
                          }else{
                            ?>
                            <div class="alert alert-info">
                              No Book(s) Found.
                            </div>
                            <?php
                          }
                        }

                        ?>
                        
                      </tbody>
                    </table>
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