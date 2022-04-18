
<!DOCTYPE html>
<html lang="en">
<?php
require('includes/head.php');

$donationID= $donationCateTitle = "";
if (isset($_GET['donationID'])) {
  $donationID = $_GET['donationID'];
  $donationCateTitle = getdonationCateTitle($donationID);
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
                    Al-Nahal Donation Case List of <?php echo $donationCateTitle; ?>
                    
                    <a href="addNewDonationCase.php?donationID=<?php echo $donationID; ?>" class="btn btn-primary btn-sm float-right" >Add New <?php echo $donationCateTitle; ?></a>

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
                          <th>Image</th>
                          <th>Deserving Person</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        
                        $sql = "SELECT * FROM `tbl_donation_cases` WHERE `case_cate_id` = '$donationID' ORDER BY `case_id`"; 
                        $result = mysqli_query($con,$sql);
                        if ($result) {
                          if (mysqli_num_rows($result)>0) {
                            $srNo = 1;
                            while ($row = mysqli_fetch_array($result)) {
                              ?>
                              <tr>
                                <td><?php echo $srNo; ?></td>
                                <td><?php echo $row['case_title']; ?></td>
                                <td><?php if ($row['case_image'] != "" && file_exists($row['case_image'])) {
                                  ?>
                                  <img src="<?php echo $row['case_image']; ?>" style="width: 100px; height: 100px;">
                                  <?php
                                }else{
                                  echo "N/A";
                                } ?></td>
                                <td><?php echo $row['case_for_name']; ?></td>
                                <td><?php echo $row['case_tot_amount_req']."PKR"; ?></td>
                                <td><?php echo getStatusTitle($row['case_status']); ?></td>
                                <td>
                                  <a href="editDonationCase.php?caseID=<?php echo $row['case_id']; ?>&donationID=<?php echo $donationID; ?>" class="btn btn-success btn-sm">Edit</a>
                                  <a href="" class="btn btn-danger btn-sm">Delete</a>

                                </td>
                              </tr>
                              <?php
                              $srNo++;
                            }
                          }else{
                            ?>
                            <div class="alert alert-info">
                              No Cases(s) Found.
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