<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,5]);
require("dbconnection.php");
require("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$status   = $_REQUEST['show_earnings'];
$id    = $_REQUEST['sett_client_id'];
if($status != 1){
  $status=0;
}


$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'id'    => [$id,    'required|int'],
    'show_earnings' => [$status,    'int'],
]);

if($v->passes()) {
  $sql = 'update clients set show_earnings = ? where id=?';
  $result = setData($con,$sql,[$status,$id]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'id'=> implode($v->errors()->get('id')),
           'show_earnings'=> implode($v->errors()->get('show_earnings')),
           ];
}
echo json_encode([$_REQUEST,'success'=>$success, 'error'=>$error]);
?>