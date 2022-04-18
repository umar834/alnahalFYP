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
                  <h4 class="card-title">Al-Nahal Materials List</h4>
                  
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
                          <th>Details</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $sql = "SELECT * FROM `tbl_materials` ORDER BY `material_id`"; 
                        $result = mysqli_query($con,$sql);
                        if ($result) {
                          if (mysqli_num_rows($result)>0) {
                            $srNo = 1;
                            while ($row = mysqli_fetch_array($result)) {
                              ?>
                              <tr>
                                <td><?php echo $srNo; ?></td>
                                <td><?php echo $row['material_name']; ?></td>
                                <td><a href="viewAllMaterialsDetails.php?materialID=<?php echo $row['material_id']; ?>" class="btn btn-primary btn-sm">View All <?php echo $row['material_name']; ?></a></td>
                                <td><?php echo getStatusTitle($row['material_status']); ?></td>
                                <td>
                                  <a href="editMaterial.php?materialID=<?php echo $row['material_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                  <a href="" class="btn btn-danger btn-sm">Delete</a>

                                </td>
                              </tr>
                              <?php
                              $srNo++;
                            }
                          }else{
                            ?>
                            <div class="alert alert-info">
                              No Material(s) Found.
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