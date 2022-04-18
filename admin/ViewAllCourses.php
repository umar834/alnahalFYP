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
                  <h4 class="card-title">Al-Nahal Courses</h4>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Sr. No</th>
                          <th>Code</th>
                          <th>Title</th>
                          <th>Course Image</th>
                          <th>Duration(Months)</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $sql = "SELECT * FROM  `tbl_course` ORDER BY `course_id` DESC";
                        $result = mysqli_query($con,$sql);
                        if ($result) {
                          if (mysqli_num_rows($result)>0) {
                            $srNo = 1;
                            while ($row = mysqli_fetch_array($result)) {
                              ?>
                        <tr>
                                <td><?php echo $srNo; ?></td>
                                <td><?php echo $row['course_code']; ?></td>
                                <td><?php echo $row['course_title']; ?></td>
                                 <td><?php if ($row['course_img'] != "" && file_exists($row['course_img'])) {
                                  ?>
                                  <img src="<?php echo $row['course_img']; ?>" style="width: 80px; height: 80px;">
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?></td>
                                
                                <td><?php echo $row['course_duration']; ?></td>
                                
                                <td>
                                  
                                  <?php echo getStatusTitle($row['course_status']); ?>
                                </td>
                                <td>
                                  <a href="editCourse.php?courseId=<?php echo $row['course_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                  <a href="" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                              </tr>
                              <?php
                              $srNo++;
                            }
                          }else{
                            ?>
                            <div class="alert alert-info">
                              No course(s) Found.
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