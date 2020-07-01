<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,5,2]);
$id= $_REQUEST['id'];
$success = 0;
$msg="";
require_once("dbconnection.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'id'    => [$id,'required|int']
    ]);

if($v->passes()){
         $sql ="select * from invoice where id=?";
         $re=getData($con,$sql,[$id]);
         if($re['0']['invoice_status'] != 1){
             $sql = "update driver_invoice set invoice_status = 1 where id = ?";
             $result = setData($con,$sql,[$id]);
             if($result > 0){
                 $success = 1;
             }else{
                $msg = "مدفوعه مسبقاً";
             }
         }else{
           $msg="تم التحاسب مسبقاً";
         }
}else{
  $msg = "فشل";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>