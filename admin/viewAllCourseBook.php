<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');
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
                    Course Books
                   <a href="addCourseBook.php" class="btn btn-primary btn-sm float-right" >Add New Book</a>
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
                          <th>Book File</th>
                          <th>Description</th>
                          
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $sql = "SELECT * FROM `tbl_course_book` ORDER BY `cbook_id`"; 
                        $result = mysqli_query($con,$sql);
                        if ($result) {
                          if (mysqli_num_rows($result)>0) {
                            $srNo = 1;
                            while ($row = mysqli_fetch_array($result)) {
                              ?>
                              <tr>
                                <td><?php echo $srNo; ?></td>
                                 <td><?php if ($row['cbook_path'] != "" && file_exists($row['cbook_path'])) {
                                  ?>
                                  <a href="<?php echo $row['cbook_path']; ?>" class="btn btn-primary btn-sm " target="_blank">Book</a>
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?></td>
                                <td><?php echo $row['cbook_desc']; ?></td>
                               
                                <td>
                                  <a href="editCourseBook.php?cbookId=<?php echo $row['cbook_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                  <a href="" class="btn btn-danger btn-sm">Delete</a>

                                </td>
                              </tr>
                              <?php
                              $srNo++;
                            }
                          }else{
                            ?>
                            <div class="alert alert-info">
                              No Book  Found.
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