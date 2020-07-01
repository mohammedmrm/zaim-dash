<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,5]);
require("dbconnection.php");
require("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$city    = $_REQUEST['town_city'];
$town    = $_REQUEST['town_name'];
$center  = (bool) $_REQUEST['center'];
if($center){
   $center = 1;
}else{
  $center = 0;
}
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى '
]);
$v->addRuleMessage('uniqueTownName', ' القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('uniqueTownName', function($value, $input, $args) {
    $value  = trim($value);
    if(!empty($value)){
    $exists = getData($GLOBALS['con'],"SELECT * FROM towns WHERE name ='".$value."' and city_id='".$args[0]."'");
    }else{
      $exists = 0;
    }
    return ! (bool) count($exists);
});
$v->validate([
    'city'   => [$city, 'required|max(3)|int'],
    'town'   => [$town, 'required|max(50)|min(3)|uniqueTownName('.$city.')'],
    'center' => [$center, 'min(1)|max(1)']
]);

if($v->passes()) {
  $sql = 'insert into towns (city_id,center,name) values
                             (?,?,?)';
  $result = setData($con,$sql,[$city,$center,$town]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'city_err'=> implode($v->errors()->get('city')),
           'town_err'=>implode($v->errors()->get('town')),
           'center_err'=>implode($v->errors()->get('center')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error,$_POST]);
?>