<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
error_reporting(0);
access([1,2,3,4,5,6,7,8,9,10,11,12]);
require("dbconnection.php");
$config = $_REQUEST['config'];
try{
  foreach($config as $v){
   if($v['days'] > 1 and $v['city']){
     $sql = "update auto_update set days=?  where city_id = ?";
     $res=setData($con,$sql,[$v['days'],$v['city']]);
     $success = 1;
   }
  }

  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data)));
?>