<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1]);
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
         if($re['0']['invoice_status'] == 1){
             $sql = "update invoice set invoice_status = 0 where id = ?";
             $result = setData($con,$sql,[$id]);
             if($result > 0){
                 $success = 1;
                 $sql = "update orders set money_status = 0, storage_id=1  where invoice_id=? and order_status_id <> 6 and order_status_id <> 5";
                 $result = setData($con,$sql,[$id]);
                 $sql = "update orders set money_status = 0, storage_id=1  where invoice_id2=? and order_status_id = 6 or order_status_id = 5";
                 $result = setData($con,$sql,[$id]);
             }else{
                $msg = "غير مدفوعه بالفعل";
             }
         }else{
           $msg="لايمكن الغأ دفع فاتوره مدفوعه";
         }
}else{
  $msg = "فشل";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>