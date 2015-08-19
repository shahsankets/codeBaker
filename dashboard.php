<?php session_start();
require_once("codelibrary/inc/functions.php");
require_once("codelibrary/inc/db.php");
validate_admin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>
<link href="codelibrary/css/style1.css" rel="stylesheet" type="text/css" />
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
            <td height="21" align="left" class="adminGrey">Admin Home</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top"><br>
              <table width="95%" height="200" border="0" cellpadding="5" cellspacing="0">
                <tr align="center">
                      <td class="txt" align="left" valign="top">
					  Welcome to <?php echo ucfirst(SITE_TITLE);?> Administration Suite<br>
                        Please use the navigation links on the left side to access 
                        different sections of the main administration suite.</td>
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
