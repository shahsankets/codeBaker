<?php
require_once("codelibrary/inc/db.php");
require_once("codelibrary/inc/functions.php");
validate_admin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo ucfirst(SITE_ADMIN_TITLE); ?></title>
        <link href="codelibrary/css/style.css" rel="stylesheet" type="text/css" />
        <script src="codelibrary/js/script_tmt_validator.js" type="text/javascript"></script>
    </head>
    <body>
<?php include("header.inc.php"); ?>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="180" valign="top" class="rightBorder">
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center"><?php include("left_menu.inc.php"); ?></td>
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
                                        <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage Files</td>
                                        <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Add File" onClick="location.href = 'user_addf.php'">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td height="400" align="center" valign="top"><br>
                                    <table width="98%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td height="347" align="center" valign="top">
                                                <span class="warning"><?php print $_SESSION['sess_msg'];$_SESSION['sess_msg'] = ''; ?></span> 
                                                <form action="" name="frm_search" method="post">
                                                    <table width="98%" border="0" align=center cellpadding="4" cellspacing="1" class="greyBorder">
                                                        <tr class="blueBackground">
                                                            <td align="left" colspan="5">Search File </td>
                                                            <td width="24%" align="right"><a href="user_list.php" class="bigWhite">View All Records</a></td>
                                                        </tr>

                                                        <td width="17%" align="right" class="bldTxt">Filename :</td>
                                                        <td width="17%" align="left" class="txt"><input type="text"  name="sbyusername"  value="<?php echo $_REQUEST['sbyusername']; ?>" class="txtfld" size="20"></td>

                                                        <td  align="right" class="bldTxt">File Type</td>
                                                        <td class="txt"><select name="user_type" class="txtfld">
                                                                <option value="File" <?php if ($_REQUEST['user_type'] == 'File') echo "selected"; ?>>File</option>
                                                                <option value="Admin"  <?php if ($_REQUEST['user_type'] == 'Admin') echo "selected"; ?>>Admin</option>
                                                            </select></td>
                                                        <td colspan="2" align="right"><input type="submit" name="search" value="Search" class="button" />
                                                            <input type="reset" name="reset" value="Reset" class="button" onclick="document.frm_search.reset();"></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                                <br/>
                                                
                                                <form name="frm_list" method="post" >
                                                    <table width="98%" border="0" align=center cellpadding="4" cellspacing="1" class="greyBorder">
                                                       
                                                            <tr class="blueBackground">
                                                                <td width="5%" align="center">SN.<?php echo sort_arrows('tbl_admin.id') ?></td>
                                                                <td width="14%" align="center">Name<?php echo sort_arrows('tbl_admin.name') ?></td>
                                                                <td width="8%" align="center">Size<?php echo sort_arrows('tbl_admin.email') ?></td>
                                                                <td width="12%" align="center">Last Accessed<?php echo sort_arrows('tbl_admin.user_id') ?></td>
                                                                 <td width="12%" align="center">Last Modified<?php echo sort_arrows('tbl_admin.user_id') ?></td>
                                                                 <td width="12%" align="center">File Group</td>
                                                                <td width="11%" align="center">Permission</td>
                                                                <td width="4%" align="center">Action</td>
                                                                <td width="3%" align="center"><input name="check_all" type="checkbox" id="check_all" value="check_all" onclick="checkall(this.form)" /></td>
                                                            </tr>
                                                   <?php $i=1;
                                                          $dir ="tests/";
                                                          if($_REQUEST['folder']){
                                                              $dir = "tests/".urldecode($_REQUEST['folder'])."/";
                                                          }
                                                        
                                                        // echo dirname($dir);
                                                      //echo $_SERVER[DOCUMENT_ROOT];
                                                         if (is_dir($dir)) {
                                                            $dh = opendir($dir);

                                                            while ($file = readdir($dh)) {
                                                                if ($file != '.' && $file != '..') {?>
                                                                <tr class="<?php print $className ?>">
                                                                    <td align="center" class="txt" ><?php echo $i++; ?></td>
                                                                    <td align="center" class="txt" ><a href="generator_list.php?folder=<?php echo urlencode($file); ?>" class="orangetxt"><?php echo $file;?></a></td>
                                                                    <td align="center" class="txt" ><?php echo round(filesize($file)/1024)." kb"; ?></td>
                                                                    <td align="center" class="txt" ><?php echo date('d/m/Y H:i:s',fileatime($file));?></td>
                                                                    <td align="center" class="txt" ><?php echo date('d/m/Y H:i:s',filemtime($file));?></td>
                                                                    <td align="center" class="txt" ><?php echo realpath($dir.$file);?></td>
                                                                    <td align="center" class="txt" ><?php echo fileperms($file); ?></td>
                                                                    <td valign="middle" class="txt" align="center">
                                                                        <?php  if(is_file($file)){?>
                                                                         <a href="write.php?file=<?php echo urlencode($file); ?>" class="orangetxt">EDIT</a> 
                                                                         <?php }?>
                                                                    </td>
                                                                    <td valign="middle" align="center"><input type="checkbox" name="ids[]" value="<?php print $line['id'] ?>" /></td>
                                                                </tr>
                                                                <?php  }
                                                                      }
                                                                    closedir($dh);
                                                                  ?>
                                                                 <?php } else { ?>
                                                            <tr align="center" class="oddRow">
                                                                <td colspan="7" class="warning">Sorry, Currently There are no record to display</td>
                                                            </tr>
                                                            <?php } ?>
                                                    </table>
                                                </form></td>
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
<?php include("footer.inc.php"); ?>
    </body>
</html>