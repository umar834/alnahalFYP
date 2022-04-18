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
                  <h4 class="card-title">Teacher's Detail</h4>
                  
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
                          <th>Teacher Name</th>
                          <th>Teacher Image</th>
                          <th>Teacher Course</th>
                          <th>Teacher Email</th>
                          <th>Teacher Address</th>
                           <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $sql = "SELECT * FROM  `tbl_teacher` ORDER BY `Teacher_Id` DESC";
                        $result = mysqli_query($con,$sql);
                        if ($result) {
                          if (mysqli_num_rows($result)>0) {
                            $srNo = 1;
                            while ($row = mysqli_fetch_array($result)) {
                              ?>
                              <tr>
                                <td><?php echo $srNo; ?></td>
                                <td><?php echo $row['Teacher_Name']; ?></td>
                                
                                <td><?php if ($row['Teacher_ProfileImg'] != "" && file_exists($row['Teacher_ProfileImg'])) {
                                  ?>
                                  <img src="<?php echo $row['Teacher_ProfileImg']; ?>" style="width: 80px; height: 80px;">
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?></td>
                                <td><?php echo getcourseName($row['Teacher_Course']); ?></td>
                                <td><?php echo $row['Teacher_Email']; ?></td>
                                <td><?php echo $row['Teacher_Address']; ?></td>
                                <td>
                                  <?php echo getStatusTitle($row['Teacher_Status']); ?>
                                </td>
                                <td>
                                  <a href="editTeacher.php?teacherID=<?php echo $row['Teacher_Id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                  <a href="" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                              </tr>
                              <?php
                              $srNo++;
                            }
                          }else{
                            ?>
                            <div class="alert alert-info">
                              No Teacher(s) Found.
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

</html>