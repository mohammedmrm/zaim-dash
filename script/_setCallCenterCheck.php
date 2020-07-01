<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,9]);
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
         if($_SESSION['role'] == 1 || $_SESSION['role'] == 9){
            $sql = "update orders set callcenter_id =? where id = ?";
            $result = setData($con,$sql,[$_SESSION['userid'],$id]);
            $success = 1;
         }else{
            $msg = "لا تملك صلاحية";
         }
}else{
  $msg = "فشل الحذف";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>