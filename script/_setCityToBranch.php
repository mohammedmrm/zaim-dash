<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,5]);
require_once("dbconnection.php");
require_once("../config.php");
require_once('../validator/autoload.php');
use Violin\Violin;
$v = new Violin;


$success = 0;
$branch    = $_REQUEST['c_Branch_id'];
$town   = $_REQUEST['city'];

$v->addRuleMessages([
    'required' => ' الحقل مطلوب',
    'int'      => ' فقط الارقام مسموح بها',
    'regex'    => ' فقط الارقام مسموح بها',
    'min'      => ' قصير جداً',
    'max'      => ' ( {value} ) قيمة كبيرة جداً غير مسموح بها ',
    'email'    => ' البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'branch' => [$branch,'required|int'],
    'city'   => [$town,  'required|int'],
]);
$msg = "";
if($v->passes() ) {
  $sql = "select * from branch_cities where city_id=?";
  $res = getData($con,$sql,[$town]);
  if(count($res) < 1){
      $sql = 'insert into branch_cities (branch_id,city_id,manager_id) values (?,?,?)';
      $result = setData($con,$sql,[$branch,$town,$_SESSION['userid']]);
      if($result > 0){
        $success = 1;
        $msg = "تم الاضافة";
      }else{
         $msg = "!خطأ";
      }
  }else{
    $msg = "تم تحديد فرع  للمحافظه مسبقاً";
  }

}else{
  $error = [
           'branch_err'=> implode($v->errors()->get('branch')),
           'city_err'=>implode($v->errors()->get('city')),
           ];
 $msg = "خطأ";
}
echo json_encode(['success'=>$success, 'error'=>$error,'msg'=>$msg]);
?>