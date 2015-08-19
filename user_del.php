<?php require_once("codelibrary/inc/db.php");
      require_once("codelibrary/inc/functions.php");
validate_admin();
$arr =$_POST['ids'];
$Submit =$_POST['Submit'];
if(count($arr)>0){
	$str_rest_refs=implode(",",$arr);
	if($Submit=='Delete')
	{
		$sql="delete from tbl_admin where id in ($str_rest_refs) and id !=1"; 
		executeQuery($sql,$conn);
		$conn->close();
		$sess_msg="Selected Record(s) Deleted Successfully";
		$_SESSION['sess_msg']=$sess_msg;
    } elseif($Submit=='Activate')
	{
		$sql="update tbl_admin set status=1 where id in ($str_rest_refs)";
		executeQuery($sql,$conn);
		$conn->close();
		$sess_msg="Selected Record(s) Activate Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Deactivate')
	{
		$sql="update tbl_admin set status=0 where id in ($str_rest_refs) and id !=1";
		executeQuery($sql,$conn);
		$conn->close();
		$sess_msg="Selected Record(s) Deactivate Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
}
else{
	$sess_msg="Please select Check Box";
	$_SESSION['sess_msg']=$sess_msg;
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit();
}
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>