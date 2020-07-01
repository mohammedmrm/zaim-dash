<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,5,2,8]);
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
         $sql = "update orders set storage_id=0 , order_status_id=13
         where storage_id = ?
         and id = ? and (order_status_id=? or order_status_id=? or order_status_id=?)
         and invoice_id=0 and  driver_invoice_id=0";
         $result = setData($con,$sql,[$_SESSION['user_details']['storage_id'],$id,9,6,5]);
         if($result > 0){
            $success = 1;
            $sql ="insert into storage_tracking (order_id,staff_id,status) values(?,?,?)";
            $sql2 = "insert into tracking (order_id,order_status_id,date,staff_id) values(?,?,?,?)";
            setData($con,$sql,[$id,$_SESSION['userid'],2]);
            setData($con,$sql2,[$id,13,date('Y-m-d H:i:s'),$_SESSION['userid']]);
         }else{
            $msg = "فشل الاخراج! قد لاتملك الصلاحية";
         }
}else{
  $msg = "فشل الاخراج";
  $success = 0;
}
echo json_encode([$sql,$id,$_SESSION['user_details']['storage_id'],'success'=>$success, 'msg'=>$msg]);
?>