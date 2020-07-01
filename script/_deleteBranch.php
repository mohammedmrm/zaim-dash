<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1]);
$id= $_REQUEST['id'];
$success = 0;
$msg="";
require("dbconnection.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'branch_id'    => [$id,'required|int']
    ]);

if($v->passes()){
       $sql = "select * from staff where branch_id = ?";
       $result = count(getData($con,$sql,[$id]));
       $sql2 = "select * from orders where from_branch = ?";
       $result2 = count(getData($con,$sql2,[$id]));
       if($result > 0 || $result2 > 0){
         $success = 0;
         $msg = "لايمكن الحذف هناك عدد من الموظفين و الطلبيات مسجلين ضمن هذا الفرع يجب تحديث بياناتهم اولا";
       }else{
         $sql = "delete from branches where id = ?";
         $result = setData($con,$sql,[$id]);
         if($result > 0){
            $success = 1;
             $sql = "delete from branch_towns where branch_id = ?";
             $result = setData($con,$sql,[$id]);
             $sql = "delete from branch_cities where branch_id = ?";
             $result = setData($con,$sql,[$id]);
         }else{
            $msg = "فشل الحذف";
         }

       }
}else{
  $msg = "فشل الحذف";
  $success = 0;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
?>