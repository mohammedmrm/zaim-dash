<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,4,5,6]);
error_reporting(0);
$branch = $_REQUEST['branch'];
if(empty($branch)){
  $branch =1;
}
require("dbconnection.php");
try{
  if(!empty($branch) && $branch > 0){
   $query = "select * from clients where branch_id=".$branch;
  }else{
   $query = "select * from clients";
  }
  $data = getData($con,$query);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data,"Q"=>$query)));
?>