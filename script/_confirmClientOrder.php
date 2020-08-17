<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,5,2]);
$id= $_REQUEST['id'];
$success = 0;
$msg="";
require("dbconnection.php");
use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'order_id'    => [$id,'required|int']
    ]);

if($v->passes()){
         $sql = "update orders set confirm=1,manager_id=?,date=? where id = ? and confirm=5";
         $result = setData($con,$sql,[$_SESSION['userid'],date("Y-m-d"),$id]);
         if($result > 0){
            $success = 1;
         }else{
            $msg = "فشل التأكيد, قد يكون ماكد مسبقاً";
         }
}else{
  $msg = "فشل التأكيد";
  $success = 0;
}
echo json_encode([$sql,$_SESSION['user_details']['branch_id'],'success'=>$success, 'msg'=>$msg]);
?>