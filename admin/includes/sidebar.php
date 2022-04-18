<nav class="sidebar sidebar-offcanvas" id="sidebar" style="background: black;">
  <ul class="nav">
    <li class="nav-item sidebar-category">
      <p>Navigation</p>
      <span></span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.html">
        <i class="mdi mdi-view-quilt menu-icon"></i>
        <span class="menu-title">Dashboard</span>
        <div class="badge badge-info badge-pill">2</div>
      </a>
    </li>
    <li class="nav-item sidebar-category">
      <p>Components</p>
      <span></span>
    </li>

    <?php if($_SESSION['userRole'] == 1){ ?>


        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#material" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-view-headline  menu-icon"></i>
            <span class="menu-title">Manage Material</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="material">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="addNewMaterial.php">Add New Material</a></li>
              <li class="nav-item"> <a class="nav-link" href="viewAllMaterials.php">View All Materials</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#books" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-view-headline  menu-icon"></i>
            <span class="menu-title">Book Categories</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="books">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="addNewBookCategory.php">Add New Book Category</a></li>
              <li class="nav-item"> <a class="nav-link" href="viewAllBooksCategory.php">View All Books Category</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#course" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-palette menu-icon"></i>
            <span class="menu-title">Manage Courses</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="course">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="AddNewCourses.php">Add New Course</a></li>
              <li class="nav-item"> <a class="nav-link" href="ViewAllCourses.php">View All Courses</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#teacher" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-palette menu-icon"></i>
            <span class="menu-title">Manage Teacher</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="teacher">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="AddNewTeachers.php">Add New Teacher</a></li>
              <li class="nav-item"> <a class="nav-link" href="ViewAllTeachers.php">View All Teachers</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#donationCate" aria-expanded="false" aria-controls="donationCate">
            <i class="mdi mdi-view-headline  menu-icon"></i>
            <span class="menu-title">Manage Donations</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="donationCate">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="addNewDonationCategory.php">Add New Category</a></li>
              <li class="nav-item"> <a class="nav-link" href="viewAllDonationCategories.php">View All Categories</a></li>
            </ul>
          </div>
        </li>
        
        <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user">
         
            <i class="mdi mdi-view-headline  menu-icon"></i>
            <span class="menu-title">Manage Users</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="user">
            <ul class="nav flex-column sub-menu">
              
              <li class="nav-item"> <a class="nav-link" href="viewAllUsers.php">View All Users</a></li>
            </ul>
          </div>
        </li>


    <?php } else if($_SESSION['userRole'] == 2){ ?>
      
      <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#courseMaterial" aria-expanded="false" aria-controls="courseMaterial">
            <i class="mdi mdi-view-headline  menu-icon"></i>
            <span class="menu-title"><?php echo getcourseName( $_SESSION['userCourse']); ?></span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="courseMaterial">
            <ul class="nav flex-column sub-menu">
           <li class="nav-item"> <a class="nav-link" href="courseMaterial.php">Course Material</a></li>
            </ul>
          </div>
        </li>


         

    <?php }?>
    
    
    <li class="nav-item sidebar-category">
      <p>Pages</p>
      <span></span>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="mdi mdi-account menu-icon"></i>
        <span class="menu-title">Reports</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> User  </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html"> Teacher </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Course </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/register-2.html"> Donation</a></li>
        </ul>

      </div>
    </li>
    <li class="nav-item sidebar-category">
      <p>Apps</p>
      <span></span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="docs/documentation.html">
        <i class="mdi mdi-file-document-box-outline menu-icon"></i>
        <span class="menu-title">Documentation</span>
      </a>
    </li>
    
  </ul>
</nav>