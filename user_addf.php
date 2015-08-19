<?php require_once("codelibrary/inc/db.php");
      require_once("codelibrary/inc/functions.php");
	validate_admin();
	@extract($_REQUEST);
	 if($_POST['submitForm'] == "yes") {
	 	   if(!$id){
                       
		   		$query1=NULL;
		   		$user_id=$_POST['username'];
		   		$sql="select id from tbl_admin where user_id = ? ";
				$stmt = $conn->prepare($sql);
				if($stmt === false) {
				  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
				}
				$stmt->bind_param('s',$user_id);
				$stmt->execute();
				$stmt->bind_result($id); 
				while ($stmt->fetch()) {
				  $query1=$id;
				}
			
			   if($query1){
					$_SESSION['sess_msg'] = "Username already exist! Please Choose Another One.";
				} else if(empty($user_id)){
					$_SESSION['sess_msg'] = "Empty Username";
				} else if(empty($password)){
					$_SESSION['sess_msg'] = "Empty Password";
				} else {
					$sql = "insert into tbl_admin (id,type,name,email,address,phone,user_id,password,status) values (NULL,?,?,?,?,?,?,?,1)";
					/* Prepare statement */
					$stmt = $conn->prepare($sql);
					if($stmt === false) {
					  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
					}
					 $type=$_POST['type'];
					 $name=$_POST['name'];
					 $email=$_POST['email'];
					 $address=$_POST['address'];
					 $phone=$_POST['contact'];
					 $user_id=$_POST['username'];
					 $password=$_POST['password'];
					$stmt->bind_param('sssssss',$type,$name,$email,$address,$phone,$user_id,$password);
					$stmt->execute();
					if($stmt->affected_rows){
							$_SESSION['sess_msg'] = $stmt->affected_rows." User inserted Successfully with id: ".$stmt->insert_id;
							$stmt->close();
							header("Location: user_list.php");
							exit();
					} else {
							$stmt->close();
							$_SESSION['sess_msg'] ="No User inserted!";
					}
				}
			}
		   else{		
				$sql = "update tbl_admin set name=?, email=? , phone=? ,  address = ? ";
					$sql.=", type=? ";
				$sql.=" where id =?";
				$stmt = $conn->prepare($sql);
				if($stmt === false) {
				  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
				}
				 $type=$_POST['type'];
				 $name=$_POST['name'];
				 $email=$_POST['email'];
				 $address=$_POST['address'];
				 $phone=$_POST['contact'];
				 $id=(int)$_POST['id'];
				$stmt->bind_param('sssssi',$name,$email,$address,$phone,$type,$id);	
				$stmt->execute();
				if($stmt->affected_rows){
					$_SESSION['sess_msg'] = "Selected Record(s) Updated Successfully";
				} else {
					$_SESSION['sess_msg'] = "No changes made!";
				}
				$stmt->close();
					header("Location: user_list.php");
					exit();
			}
	
    }

if($_GET['id']){
	$sql="select * from tbl_admin where id='".$_GET['id']."'";
	$result=executeQuery($sql,$conn);
	$num= $result->num_rows;
	$row =$result->fetch_assoc();
	@extract($row);
	$result->free();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>
<link href="codelibrary/css/style.css" rel="stylesheet" type="text/css" />
<script src="codelibrary/js/script_tmt_validator.js" type="text/javascript"></script>
<script type="text/javascript">
function validate(obj){
 if(obj.name.value==''){
     alert("Please Enter Name");
	 obj.name.focus();
	 return false;
     } 
else if(obj.email.value==''){
     alert("Please Enter Email");
	 obj.email.focus();
	 return false;
     } else if(obj.type.value==''){
     alert("Please Select User Type");
	 obj.type.focus();
	 return false;
     } 
else if(obj.username.value==''){
     alert("Please Enter Username");
	 obj.username.focus();
	 return false;
     } 	 
else if(obj.password.value==''){
     alert("Please Enter Password");
	 obj.password.focus();
	 return false;
     } 
else
   { return true; }
}


function showHint1(str)
{
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","check_username.php?t=a&q="+str,true);
xmlhttp.send();
}



</script>
</head>

<body>
<?php include("header.inc.php");?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top" class="rightBorder">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><?php include("left_menu.inc.php");?></td>
        </tr>
        <tr>
          <td width="23">&nbsp;</td>
        </tr>
      </table>
    <br />
    <br /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
		<table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                      <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage User </td>
                      <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Manage User" onClick="location.href='user_list.php'">
                      &nbsp;</td>
                    </tr>
              </table>
			</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top"><br>
			  <form action="user_addf.php" method="post" enctype="multipart/form-data" name="frm" onSubmit="return validate(this)">
              <table width="94%" border="0" align="center" cellpadding="4" cellspacing="0" class="greyBorder">
			  <input type="hidden" name="submitForm" value="yes">
			  <input type="hidden" name="id" class="txtfld" value="<?php echo $_GET['id'];?>">
			  	<TR align="left"> 
					<TD height="25" colspan="2" class="blueBackground">
                     <?php if($_GET['id']){?>Edit&nbsp;<?php }else{?>&nbsp;Add&nbsp;<?php }?>  User </TD>
				</TR>
			    <?php if($_SESSION['sess_msg']!=''){?>
				<tr>
					<td colspan="2" align="center"  class="warning"><?php print $_SESSION['sess_msg']; $sess_msg='';?></td>
				</tr>
				<?php }?>
				<tr class="evenRow">
					<td class="txt" align="right" colspan="2"><span class="warning">*</span> - Required Fields</td>
				</tr>
				
				<TR class="oddRow">
					<td class="bldTxt" align="right" width="26%">Name :</td>
					<td align="left" width="74%" class="txt"><input name="name" type="text" class="txtfld" id="name" value="<?php echo $name;?>" size="40"><span class="warning">*</span></td>
				</tr>
				<tr class="evenRow">
					<td class="bldTxt" align="right" width="26%">Email :</td>
					<td align="left" width="74%" class="txt"><input name="email" type="text" class="txtfld" id="email" value="<?php echo $email;?>" size="40"><span class="warning">*</span></td>
				</tr>
				<TR class="oddRow">
					<td class="bldTxt" align="right" width="26%">User Type  :</td>
					<td align="left" width="74%" class="txt">
					<select name="type" class="txtfld">
						<option value="User" <?php if($type=='User') echo "selected";?>>User</option>
						<option value="Administrator"  <?php if($type=='Administrator') echo "selected";?>>Administrator</option>
					</select><span class="warning">*</span></td>
				</tr>
				<TR class="evenRow">
					<td class="bldTxt" align="right" width="26%">Username  :</td>
					<td align="left" width="74%" class="txt"><input name="username" type="text" class="txtfld" id="address1" value="<?php echo $user_id;?>" size="40" onChange="showHint1(this.value)" <?php if($_GET['id']){ echo "disabled";}?>><span class="warning">*</span><div id="txtHint"></div></td>
				</tr>
				<TR class="oddRow">
					<td class="bldTxt" align="right" width="26%">Password :</td>
					<td align="left" width="74%" class="txt"><input name="password" type="password" class="txtfld" id="password" value="<?php echo $password;?>" size="40" <?php if($_GET['id']){ echo "disabled";}?>><span class="warning">*</span></td>
				</tr>
				<tr class="evenRow">
					<td class="bldTxt" align="right" width="26%">Contact No.  :</td>
					<td align="left" width="74%" class="txt"><input name="contact" type="text" class="txtfld" id="contact" value="<?php echo $phone;?>" size="40"></td>
				</tr>
				
				<tr class="oddRow">
					<td class="bldTxt" align="right" width="26%">Address :</td>
					<td align="left" width="74%" class="txt"><textarea name="address" class="txtfld" rows="4" cols="30"><?php echo $address;?></textarea></td>
				</tr>
				
				<tr class="evenRow">
					<TD align=center colspan=100%><input type="submit" class="button1" value="Submit"/> <input type="reset" name="reset" class="button1" value="Reset" /></TD>
				</TR>
				</table>
			  </form>
				</td>
       </tr>
     </table>
	</td>
  </tr>
</table>
<?php include("footer.inc.php");?>
</body>
</html>