<?php require_once("codelibrary/inc/db.php");
      require_once("codelibrary/inc/functions.php");
                   
/**
*@author RN Kushwaha
*@email at Rn.kushwaha022@gmail.com
*@created 5th April 2014
*@modified 8th april 2014
*/

validate_admin();
$arr =$_POST["ids"];
$Submit =$_POST["Submit"];

if(count($arr)>0){
  $str_rest_refs=implode(",",$arr);
  if($Submit == "Delete"){
    $sql="delete from tbl_products where id in ($str_rest_refs) "; 
    executeQuery($sql,$conn);
    $conn->close();
    $_SESSION["sess_msg"] = "Selected record(s) deleted successfully!";
         } else if($Submit == "Activate"){
    $sql="update tbl_products set status=1 where id in ($str_rest_refs)";
    executeQuery($sql,$conn);
    $conn->close();
    $_SESSION["sess_msg"] = "Selected record(s) activated successfully!";
  } else if($Submit == "Deactivate"){
    $sql="update tbl_products set status=0 where id in ($str_rest_refs) ";
    executeQuery($sql,$conn);
    $conn->close();
    $_SESSION["sess_msg"] = "Selected record(s) deactivated successfully!";
  }
} else{
    $_SESSION["sess_msg"]= "Please select Check Box";
    header("Location: ".$_SERVER["HTTP_REFERER"]);
    exit();
}
header("Location: ".$_SERVER["HTTP_REFERER"]);
exit();
?>