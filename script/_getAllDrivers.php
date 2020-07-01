<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("_access.php");
access([1,2,3,5,6,9]);
require("dbconnection.php");
$branch = $_REQUEST['branch'];
try{
  if($branch > 0 && ($_SESSION['role']== 1 || $_SESSION['role']== 5 || $_SESSION['role']== 9)){
  $query = "select * from staff where role_id=4 and branch_id=?";
  $data = getData($con,$query,[$branch]);
  }else if($_SESSION['role']!= 1 && $_SESSION['role']!= 5){
  $query = "select * from staff where role_id=4 and branch_id=? order by name";
  $data = getData($con,$query,[$_SESSION['user_details']['branch_id']]);
  }else{
  $query = "select * from staff where role_id=4 order by name";
  $data = getData($con,$query);
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>