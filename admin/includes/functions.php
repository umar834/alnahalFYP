<?php 

function isAdminLogin()
{
	if (isset($_SESSION['userRole']) && isset($_SESSION['userFullName']) && $_SESSION['userRole'] == 1 && strlen($_SESSION['userFullName']) > 0) {
		return true;
	}else{
		return false;
	}
}


function getStatusTitle($status){
	if ($status == "A") {
		return "Active";
	}else if ($status == "B") {
		return "Blocked";
	}else if ($status == "P") {
		return "Pending";
	}else if ($status == "R") {
		return "Rejected";
	}else if ($status == "CL") {
		return "Close";
	}else{
		return "N/A";
	}
}

function checkMaterialExist($matrialName , $materialID='')
{
	global $con;
	$sql = "SELECT count(*) as `tot` FROM `tbl_materials` WHERE `material_name` = '$matrialName' AND `material_id` != '$materialID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}
}

function checkCourseCodeExist($courseName , $courseId='')
{
	global $con;
	$sql = "SELECT count(*) as `tot` FROM `tbl_course` WHERE `course_title` = '$courseName' AND `course_id` != '$courseId'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}
}


function checkBookCategoryExist($BCName , $BCID='')
{
	global $con;
	$sql = "SELECT count(*) as `tot` FROM `tbl_books cate` WHERE `BC_name` = '$BCName' AND `BC_id` != '$BCID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}
}


function checkMaterialDetailsExist($materialDetailName,$matrialID,$materialDetailID = '')
{
	global $con;
	$sql = "SELECT count(*) as `tot` FROM `tbl_materials_details` WHERE `mat_detail_title` = '$materialDetailName' AND `mat_detail_materialID` = '$matrialID' AND `mat_detail_id` != '$materialDetailID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}
}
function getMaterialName($materialID)
{
	global $con;
	$sql = "SELECT  `material_name` FROM `tbl_materials` WHERE  `material_id` = '$materialID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['material_name'];
		}
	}
}
function checkDonationCaseExist($caseTitle,$donationID,$caseID = '')
{
	global $con;
	$sql = "SELECT count(*) as `tot` FROM `tbl_donation_cases` WHERE `case_title` = '$caseTitle' AND `case_cate_id` = '$donationID' AND `case_id` != '$caseID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}
}




function getdonationCateTitle($donationID)
{
	global $con;
	$sql = "SELECT  `donation_cate_title` FROM `tbl_donation_categories` WHERE  `donation_cate_id` = '$donationID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['donation_cate_title'];
		}
	}
}
function checkBookDetailsExist($bookName,$BCID,$bookID = '')
{
	global $con;
	$sql = "SELECT count(*) as `tot` FROM `tbl_books_detail` WHERE `book_title` = '$bookName' AND `book_BCID` = '$BCID' AND `book_id` != '$bookID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}
}

function getBCName($BCID)
{
	global $con;
	$sql = "SELECT  `BC_name` FROM `tbl_books_cate` WHERE  `BC_id` = '$BCID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['BC_name'];
		}
	}
}
function checkTeacherEmailExist($teacherEmail,$teacherId=""){
	global $con;
	$sql= "SELECT count(*) as `tot` FROM `tbl_teacher` WHERE `Teacher_Email` = '$teacherEmail' AND `Teacher_Id` !='$teacherId'";
	$result = mysqli_query($con,$sql);
	if($result){
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}

}
function checkUserEmailExist($userEmail,$userId=""){
	global $con;
	$sql= "SELECT count(*) as `tot` FROM `tbl_user` WHERE `user_email` = '$userEmail' AND `user_id` !='$userId'";
	$result = mysqli_query($con,$sql);
	if($result){
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}

}

function getcourseName($courseId){
	global $con;
	$sql= "SELECT `course_title` FROM `tbl_course` WHERE `course_id` ='$courseId'";
	$result = mysqli_query($con,$sql);
	if($result){
		if ($row = mysqli_fetch_array($result)) {
			return $row['course_title'];
		}
	}

}
function checkDonationCategoryExist($donationCateTitle , $donationID='')
{
	global $con;
	$sql = "SELECT count(*) as `tot` FROM `tbl_donation_categories` WHERE `donation_cate_title` = '$donationCateTitle' AND `donation_cate_id` != '$donationID'";
	$result = mysqli_query($con,$sql);
	if ($result) {
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}
}
function checkCourseOutlineExist($teacherID,$courseID){
	global $con;
	$sql= "SELECT count(*) as `tot` FROM `tbl_course_outline` WHERE `outline_teacherID` = '$teacherID ' AND `outline_courseID` ='$courseID'";
	$result = mysqli_query($con,$sql);
	if($result){
		if ($row = mysqli_fetch_array($result)) {
			return $row['tot'];
		}
	}

}



?>