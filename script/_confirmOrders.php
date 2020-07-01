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
         if($_SESSION['role'] != 1 || $_SESSION['role'] != 5){
           $sql = "update orders set confirm=1 where id = ? and to_branch=?";
         }else{
           $sql = "update orders set confirm=1 where id = ? and ( to_branch=? or to_branch=null or to_branch='')";
         }
         foreach($ids as $v){
           $data = setData($con,$sql,[$v,$_SESSION['user_details']['branch_id']]);
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