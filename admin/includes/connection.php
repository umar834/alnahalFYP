<?php
session_start();
$con = mysqli_connect('localhost','root','');
$db = mysqli_select_db($con,'alnahal');

if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
  $_SESSION['errors'] =  array();
}
?>