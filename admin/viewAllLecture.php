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
                    Course Lectures
                   <a href="addCourseLec.php" class="btn btn-primary btn-sm float-right" >Add New Lecture</a>
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
                          <th>Notes</th>
                          <th>Audio File</th>
                          <th>Description</th>
                          <th>Status</th>

                          
                         
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $sql = "SELECT * FROM `tbl_course_lecture` ORDER BY `course_lec_id`"; 
                        $result = mysqli_query($con,$sql);
                        if ($result) {
                          if (mysqli_num_rows($result)>0) {
                            $srNo = 1;
                            while ($row = mysqli_fetch_array($result)) {
                              ?>
                              <tr>
                                <td><?php echo $srNo; ?></td>
                                 <td><?php if ($row['clec_notesfile'] != "" && file_exists($row['clec_notesfile'])) {
                                  ?>
                                  <a href="<?php echo $row['clec_notesfile']; ?>" class="btn btn-primary btn-sm " target="_blank">Notes</a>
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?></td>
                                <td><?php if ($row['clec_audiofile'] != "" && file_exists($row['clec_audiofile'])) {
                                  ?>
                                  <a href="<?php echo $row['clec_audiofile']; ?>" class="btn btn-primary btn-sm " target="_blank">Audio File</a>
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?></td>

                                <td><?php echo $row['clec_description']; ?></td>
                               
                                <td>
                                  <a href="editCourseLec.php?clecId=<?php echo $row['course_lec_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                  <a href="" class="btn btn-danger btn-sm">Delete</a>

                                </td>
                              </tr>
                              <?php
                              $srNo++;
                            }
                          }else{
                            ?>
                            <div class="alert alert-info">
                              No Book Lecture Found.
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