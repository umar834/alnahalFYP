<?php
require('include/head.php');
if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
  $_SESSION['errors'] =  array();
}


$userId = $userName  = $userEmail = $userAddress=  $userCourseID = $userContact = $userStatus = $userPassword =$userConfirmPassword = "";

if(isset($_POST['userAddBtn']))
{
   if(empty($_POST['userEmail']))
    {
       array_push($_SESSION['errors'], " User Email is Required.");
    }
    else
    {
      $userEmail = mysqli_real_escape_string($con,$_POST['userEmail']);

      if (checkUserEmailExist($userEmail)>0) 
      {
       array_push($_SESSION['errors'], "Email Already Exist.");
        
      }
    }
    
    if(empty($_POST['userCourseID']))
    {
       array_push($_SESSION['errors'], " Select Course.");
    }
    else
    {
      $userCourseID = mysqli_real_escape_string($con,$_POST['userCourseID']);
    }
    if(empty($_POST['userAddress']))
    {
       array_push($_SESSION['errors'], " User Adress is Required.");
    }
    else
    {
      $userAddress = mysqli_real_escape_string($con,$_POST['userAddress']);
    }
  
    if (empty($_POST['userPassword'])) {
	    array_push($_SESSION['errors'], "User Password is Required.");
	}else{
	    $userPassword = mysqli_real_escape_string($con,$_POST['userPassword']);
	}

  	if (empty($_POST['userConfirmPassword'])) {
    	array_push($_SESSION['errors'], "User Confirm Password is Required.");
  	}else{
    	$userConfirmPassword = mysqli_real_escape_string($con,$_POST['userConfirmPassword']);
  	}

	if($userConfirmPassword != $userPassword){
		array_push($_SESSION['errors'], "User Password not matched");
	}else{
	  	$userPassword = md5($userPassword);
	}
	  
  
    
   if(empty($_POST['userName'])){
       array_push($_SESSION['errors'], " User Name is Required.");
    }
    else{
      $userName = mysqli_real_escape_string($con,$_POST['userName']);
    }

  	if (empty($_POST['userContact'])) {
	    array_push($_SESSION['errors'], "Contact No is Required.");
  	}else{
	  $userContact = mysqli_real_escape_string($con,$_POST['userContact']);
  	}

 
    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
    	
   		$sql = "INSERT INTO `tbl_user` (`user_name`,`user_email`, `user_address`, `user_password`,`user_contact` ) VALUES ('$userName', '$userEmail', '$userAddress', '$userPassword','$userContact')";
  
     	$result = mysqli_query($con,$sql);
		if ($result) {
			$_SESSION['success'] = "User Regstration Request has been sent to admin, after admin approval you can login.";
		    header("location:login.php");
		    exit();
      	}

    }
}
?>

  

<body id="home" data-spy="scroll" data-target="#navbar-wd" data-offset="98">

    <!-- LOADER -->
    <div id="preloader">
        <div class="loader">
            <img src="images/loader.gif" alt="#" />
        </div>
    </div>
    <!-- end loader -->
    <!-- END LOADER -->

    <!-- Start header -->
    <header class="top-header">
        <nav class="navbar header-nav navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="image"width="100" height="100"><span></span><h1><b>Al Nahal</b></h1></span></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                    <ul class="navbar-nav">
                        <li><a class="nav-link active" href="index.html">Home</a></li>
                        <li><a class="nav-link" href="about.html">About</a></li>
                        <li><a class="nav-link" href="courses.html">Courses</a></li>
                        <li><a class="nav-link" href="Cases.html">Cases</a></li>
						<li><a class="nav-link" href="news.html">News</a></li>
						<li><a class="nav-link" href="contact.html">Contact us</a></li>
                    </ul>
                </div>
                <div class="search-box">
                    <input type="text" class="search-txt" placeholder="Search">
                    <a class="search-btn">
                        <img src="images/search_icon.png" alt="#" />
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <br>
    <br>
    
    <div class="section layout_padding padding_bottom-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="heading_main text_align_center">
						   <h2><span>GET REGISTER</span></h2>
                        </div>
					  </div>
			
                </div>
			  </div>
           </div>
        </div>
	<!-- end section -->
	<!-- section -->
    <div class="section contact_section" style="background:#12385b;">
        <div class="container">
               <div class="row">
                 <div class="col-lg-6 col-md-6 col-sm-12">
				    <div class="full float-right_img">
                        <img src="images/img111.png" alt="#">
                    </div>
                 </div>
				 <div class="layout_padding col-lg-6 col-md-6 col-sm-12">
				    <div class="contact_form">
				    	<div class="row">
              	<?php 
                  if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
                    ?>
                    <br>
                    <?php
                    $errArr = $_SESSION['errors'];
                    foreach ($errArr as $error) {
                    ?>
                    <div class="alert alert-danger">
                        <?php 
                          echo $error; 
                          
                        ?>
                    </div>
                    <?php 
                    }
                    unset($_SESSION['errors']);
                  }

			?>
              </div>
					    <form action="userReg.php" method="POST" >
					     <fieldset>
						       <div class="full field">
							      <input type="text" placeholder="Your Name" name="userName"value="<?php echo $userName; ?>" />
							   </div>
                               <div class="full field">
                                  <input type="phn" placeholder="Phone Number" name="userContact"value="<?php echo $userContact; ?>"  />
                               </div>
							   <div class="full field">
							      <input type="email" placeholder="Email Address" name="userEmail" value="<?php echo $userEmail; ?>" />
							   </div>
                               <div class="full field">
                                  <input type="password" placeholder="Password" name="userPassword" />
                               </div>
                               <div class="full field">
                                  <input type="password" placeholder=" Re Enter Password" name="userConfirmPassword" />
                               </div>
                              
							   
                               
							   <div class="full field">
							      <textarea placeholder="Address" name="userAddress" value="<?php echo $userAddress; ?>" ></textarea>
							   </div>
                               <!--<div class="full field">
                                   <select name="userCourseID" class="form-control">
                              
		                              <option value="">Select Course</option>


		                              <?php
		                              /* $sql = "SELECT * FROM `tbl_course` WHERE `course_status` = 'A' ORDER BY `course_id` DESC";
		                                $result = mysqli_query($con,$sql);
		                                if ($result) {
		                                   if (mysqli_num_rows($result)>0) {
		                                     while($row = mysqli_fetch_array($result)){
		                                      ?>
		                                      <option <?php if($row['course_id']== $userCourseID){ echo "selected"; } ?> value="<?php echo $row['course_id']; ?>"><?php echo $row['course_title']; ?></option>
		                                      <?php
		                                     }
		                                   }
		                                 }*/ 
		                              ?>
		                              
		                            </select>
                               </div>
								-->

							   <div class="full field" style="position: relative; top:10px;" >

							      <div class="center"><button type="submit" name="userAddBtn">Register</button></div>
							   </div>
						   </fieldset>
						</form>
					</div>
                 </div>
               </div>			  
           </div>
        </div>
	<!-- end section -->
    <!-- Start Footer -->
    <?php
require('include/footer.php');
?>
    <a href="#" id="scroll-to-top" class="hvr-radial-out"><i class="fa fa-angle-up"></i></a>

    <!-- ALL JS FILES -->
    <script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.pogo-slider.min.js"></script>
    <script src="js/slider-index.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/custom.js"></script>
	<script>
	/* counter js */

(function ($) {
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			

			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}
}(jQuery));

jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
	formatter: function (value, options) {
	  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
  });
  
  // start all the timers
  $('.timer').each(count);  
  
  function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
  }
});
	</script>
</body>

</html>