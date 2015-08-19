<?php session_start();
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
validate_admin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>
<link href="codelibrary/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("header.inc.php");?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="209" valign="top" class="rightBorder">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><?php include("left_menu.inc.php");?></td>
        </tr>

      </table>
    <br />
    <br /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="21" align="left" class="adminGrey">Error</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top"><br>
              <table width="95%" height="200" border="0" cellpadding="5" cellspacing="0">
                <tr align="center">
                      <td class="txt" align="center" valign="top">
					  <div style="height:auto; min-height:40px; width:auto; min-width:300px; max-width:700px; background-color:#FFDEDE; color:#FF0000; border:1px solid #FF8989; text-align:center; padding:20px 30px; font-size:20px; border-radius:5px;-moz-border-radius:5px;-o-border-radius:5px;-webkit-border-radius:5px;-khtml-border-radius:5px; ">
					  	<?php if( $_SESSION['sess_error'] ) echo $_SESSION['sess_error']; else if($_SESSION['sess_msg']) echo $_SESSION['sess_msg']; else echo "Error"; $_SESSION['sess_error']=''; $_SESSION['sess_msg']='';?>
					  </div>
					  </td>
                </tr>
                <tr align="center">
                  <td>&nbsp;</td>
                </tr>
                <tr align="center">
                  <td>&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
		</td>
  </tr>
</table>
<?php include("footer.inc.php");?>
</body>
</html>
