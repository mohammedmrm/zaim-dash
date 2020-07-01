<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,5,2]);
$staff= $_REQUEST['s_staff_id'];
$storage= $_REQUEST['storage'];
$success = 0;
$msg="";
require("dbconnection.php");
use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'staff'    => [$staff,'required|int'],
    'storage'    => [$storage,'required|int']
    ]);

if($v->passes()){
         $sql = "update staff set storage_id=? where id = ?";
         $result = setData($con,$sql,[$storage,$staff]);
         if($result > 0){
            $success = 1;
         }else{
            $msg = "فشل تحديد المخزن";
         }
}else{
  $msg = "خطا";
  $success = 0;
}
echo json_encode([$_REQUEST,'success'=>$success, 'msg'=>$msg]);
?>