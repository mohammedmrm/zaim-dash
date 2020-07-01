<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
require_once("dbconnection.php");
access([1]);
$ids= $_REQUEST['ids'];
$success = 0;
$msg="";

if(count($ids)){
      try{
         $query = "update orders set confirm=1 where id=?";
         foreach($ids as $v){
           $data = setData($con,$query,[$v]);
           $success="1";
         }
      } catch(PDOException $ex) {
         $data=["error"=>$ex];
         $success="0";
      }
}else{
  $msg = "فشل الحذف";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>