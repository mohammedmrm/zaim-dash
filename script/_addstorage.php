<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,5]);
require("dbconnection.php");
require("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$name    = $_REQUEST['storage_name'];
$branch    = $_REQUEST['storage_branch'];




$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {

    $value  = trim($value);
    $exists = getData($GLOBALS['con'],"SELECT * FROM storage WHERE name =".$value);
    return ! (bool) count($exists);
});
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'قيمة كبيرة جداً',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'storage_name'    => [$name,    'required|max(200)'],
    'storage_branch'  => [$branch,  'required|int']
]);

if($v->passes()) {
  $sql = 'insert into storage (name,branch_id) values (?,?)';
  $result = setData($con,$sql,[$name,$branch]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'storage_name_err'=> implode($v->errors()->get('storage_name')),
           'storage_branch_err'=>implode($v->errors()->get('storage_branch'))
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error]);
?>