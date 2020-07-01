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
         $query = "delete from orders where id=?";
         foreach($ids as $v){
           $data = setData($con,$query,[$v]);
           if($data > 0){
            $success="1";
            $sql = "delete from tracking where order_id = ?";
            setData($con,$sql,[$v]);
           }
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