<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2]);
require("dbconnection.php");
try{
  if($_SESSION['role'] == 1 ){
  $query = "select staff.*,
            branches.name as branch_name,
            role.name as role_name,storage.name as storage_name
            from staff inner join branches on branches.id = staff.branch_id
            inner join role on role.id = staff.role_id
            left join storage on storage.id = staff.storage_id
            where account_type <> 2 and developer=0";
  }else{
   $query = "select staff.*,
            branches.name as branch_name,
            role.name as role_name,storage.name as storage_name
            from staff inner join branches on branches.id = staff.branch_id
            inner join role on role.id = staff.role_id
            left join storage on storage.id = staff.storage_id
            where account_type <> 2 and staff.branch_id = '".$_SESSION['user_details']['branch_id']."'
            and developer=0 and role_id <> 1
            ";
  }
  $data = getData($con,$query);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data)));
?>