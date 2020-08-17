<?php
//error_reporting(0);
date_default_timezone_set('Asia/Baghdad');
try{

$con = new PDO('mysql:host=localhost;dbname=nahar', "root",
"", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException  $e ){
//echo "Error: ".$e;
}
function getData($db,$query,$parm = []) {
  $stmt = $db->prepare($query);
  $stmt->execute($parm);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}
function setData($db,$query,$parm = []) {
  $stmt = $db->prepare($query);
  $stmt->execute($parm);
  $count = $stmt->rowCount();
  return $count;
}
function setDataWithLastID($db,$query,$parm = []) {
  $stmt = $db->prepare($query);
  $stmt->execute($parm);
  $rows = $db->lastInsertId();
  return $rows;
}
$mysqlicon = new mysqli("localhost", "root", "", "nahar");
function getAllUpdatedIds($con,$query) {
$data=[]; 
if (mysqli_multi_query($con, $query)) {
  do {
    // Store first result set
    if ($result = mysqli_store_result($con)) {
      while ($row = mysqli_fetch_row($result)) {
        $data[] = $row;
      }
      mysqli_free_result($result);
    }
     //Prepare next result set
  } while (mysqli_next_result($con));
}
return $data;
}
?>