<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
require_once("dbconnection.php");
access([1,5,2]);
$ids= $_REQUEST['ids'];
$success = 0;
$msg="";

if(count($ids)){
      try{
         $sql = "update orders set confirm=1,manager_id=?date=? where id = ? and confirm=5";
         foreach($ids as $v){
           $data = setData($con,$sql,[$_SESSION['userid'],date("Y-m-d"),$v]);
           $success="1";
         }
      } catch(PDOException $ex) {
         $data=["error"=>$ex];
         $success="0";
      }
}else{
  $msg = "فشل تأكيد الطلبيات";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>