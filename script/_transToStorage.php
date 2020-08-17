<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
require_once("dbconnection.php");
access([1,5,2,8]);
$invoice= $_REQUEST['storage_invoice_id'];
$storage= $_REQUEST['storage'];
$success = 0;
$msg="";

if($invoice > 0 && $storage > 0){
      try{
         if($storage == $_SESSION['uesr_details']['storage_id'] || $_SESSION['role'] == 1){
           $sql = "update orders set storage_id=? where storage_invoice_id=?";
           $res = setData($con,$sql,[$storage,$invoice]);
           if($res){
            $sql = "update storage_invoice set storage_id=? where id=?";
            setData($con,$sql,[$storage,$invoice]);
            $success = 1;
           }else{
             $success = 0;
             $msg = "لم يتغير شئ";
           }

         }else{
           $msg = "لايمكن نقل الطلبيات للمخزن المحدد";
           $success = 0;
         }

      } catch(PDOException $ex) {
         $data=["error"=>$ex];
         $success="0";
      }
}else{
  $msg = "فشل";
  $success = 0;
}
echo json_encode([$_REQUEST,'success'=>$success, 'msg'=>$msg]);
?>