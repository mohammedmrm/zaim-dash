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
          $sql2 = "update orders set storage_id=? where id = ? and (order_status_id=? or order_status_id=? or order_status_id=? )";
          foreach($ids as $v){
            $data = setData($con,$sql2,[$_SESSION['user_details']['storage_id'],$v,9,6,5]);
            $success="1";
            $sql ="insert into storage_tracking (order_id,staff_id,status) values(?,?,?)";
            setData($con,$sql,[$v,$_SESSION['userid'],1]);
          }
      } catch(PDOException $ex) {
         $data=["error"=>$ex];
         $success="0";
         $msg = "فشل تأكيد الطلبيات";
      }
}else{
  $msg = "فشل تأكيد الطلبيات";
  $success = 0;
}
echo json_encode([$data,$ids,'success'=>$success, 'msg'=>$msg]);
?>