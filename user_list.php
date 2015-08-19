<?php   require_once("codelibrary/inc/db.php");
        require_once("codelibrary/inc/functions.php");
        validate_admin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo SITE_ADMIN_TITLE; ?></title>
        <link href="codelibrary/css/style.css" rel="stylesheet" type="text/css" />
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
                                        <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage Users</td>
                                        <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Add User" onClick="location.href = 'user_addf.php'">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $start = 0;

                        $where = 'where 1=1';

                        if ($_REQUEST['sbyname']) {
                            $where.=" and name like '%" . $_REQUEST['sbyname'] . "%'";
                        }
                        if ($_REQUEST['sbyemail']) {
                            $where.=" and email like '%" . $_REQUEST['sbyemail'] . "%'";
                        }
                        if ($_REQUEST['sbyphone']) {
                            $where.=" and phone like '%" . $_REQUEST['sbyphone'] . "%'";
                        }
                        if ($_REQUEST['sbyusername']) {
                            $where.=" and user_id='" . $_REQUEST['sbyusername'] . "'";
                        }
                        if ($_REQUEST['user_type']) {
                            $where.=" and type ='" . $_REQUEST['user_type'] . "'";
                        }

                        if (isset($_GET['start']))
                            $start = $_GET['start'];
                        $pagesize = 50;
                        if (isset($_GET['pagesize']))
                            $pagesize = $_GET['pagesize'];
                        $order_by = 'id';
                        if (isset($_GET['order_by']))
                            $order_by = $_GET['order_by'];
                        $order_by2 = 'asc';
                        if (isset($_GET['order_by2']))
                            $order_by2 = $_GET['order_by2'];

                        $sql = executeQuery("select * from tbl_admin $where order by $order_by $order_by2 limit $start, $pagesize", $conn);
                        $ret = executeQuery("select id from tbl_admin $where", $conn);
                        $reccnt = $ret->num_rows;
                        ?>
                        <tr>
                            <td height="400" align="center" valign="top"><br>
                                    <table width="98%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td height="347" align="center" valign="top">
                                                <span class="warning"><?php print $_SESSION['sess_msg']; $_SESSION['sess_msg'] = ''; ?></span> <br />
                                                <form action="" name="frm_search" method="post">
                                                    <table width="98%" border="0" align=center cellpadding="4" cellspacing="1" class="greyBorder">
                                                        <tr class="blueBackground">
                                                            <td align="left" colspan="5">Search User </td>
                                                            <td width="24%" align="right"><a href="user_list.php" class="bigWhite">View All Records</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="12%" align="right" class="bldTxt">Name :</td>
                                                            <td width="19%" align="left" class="txt"><input type="text"  name="sbyname"  value="<?php echo $_REQUEST['sbyname']; ?>" class="txtfld" size="20"></td>
                                                            <td width="17%" align="right" class="bldTxt">Email :</td>
                                                            <td width="17%" align="left" class="txt"><input type="text"  name="sbyemail"  value="<?php echo $_REQUEST['sbyemail']; ?>" class="txtfld" size="20"></td>

                                                            <td width="11%" align="right" class="bldTxt">Contact No. :</td>
                                                            <td align="left" class="txt"><input type="text"  name="sbyphone"  value="<?php echo $_REQUEST['sbyphone']; ?>" class="txtfld" size="20" onblur="extractNumber(this, 2, true);" onkeyup="extractNumber(this, 2, true);" onkeypress="return blockNonNumbers(this, event, true, true);"></td> </tr>
                                                        <tr>
                                                            <td width="17%" align="right" class="bldTxt">Username :</td>
                                                            <td width="17%" align="left" class="txt"><input type="text"  name="sbyusername"  value="<?php echo $_REQUEST['sbyusername']; ?>" class="txtfld" size="20"></td>

                                                            <td  align="right" class="bldTxt">User Type</td>
                                                            <td class="txt"><select name="user_type" class="txtfld">
                                                                    <option value="User" <?php if ($_REQUEST['user_type'] == 'User') echo "selected"; ?>>User</option>
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
                                                            <?php if ($reccnt > 0) { ?>
                                                            <tr class="blueBackground">
                                                                <td width="5%" align="center">S.No.<?php echo sort_arrows('tbl_admin.id') ?></td>
                                                                <td width="14%" align="center">Name<?php echo sort_arrows('tbl_admin.name') ?></td>
                                                                <td width="19%" align="center">Email<?php echo sort_arrows('tbl_admin.email') ?></td>
                                                                <td width="12%" align="center">Username<?php echo sort_arrows('tbl_admin.user_id') ?></td>
                                                                <td width="13%" align="center">Contact No.<?php echo sort_arrows('tbl_admin.phone') ?></td>
                                                                <td width="12%" align="center">User Type<?php echo sort_arrows('tbl_admin.type') ?></td>
                                                                <td width="11%" align="center">Status</td>
                                                                <td width="9%" align="center">Action</td>
                                                                <td width="4%" align="center"><input name="check_all" type="checkbox" id="check_all" value="check_all" onclick="checkall(this.form)" /></td>
                                                            </tr>
                                                        <?php
                                                        $i = 0;
                                                        while ($line = $sql->fetch_array()) {
                                                            $className = ($className == "evenRow") ? "oddRow" : "evenRow";
                                                            $i++;
                                                            ?>
                                                                <tr class="<?php print $className ?>">
                                                                    <td align="center" class="txt" ><?php echo $i; ?></td>
                                                                    <td align="center" class="txt" ><?php echo ucwords($line['name']); ?></td>
                                                                    <td align="center" class="txt" ><?php echo $line['email']; ?></td>
                                                                    <td align="center" class="txt" ><?php echo $line['user_id']; ?></td>
                                                                    <td align="center" class="txt" ><?php echo ucwords($line['phone']); ?></td>
                                                                    <td align="center" class="txt" ><?php echo ucwords($line['type']); ?></td>
                                                                    <td align="center" class="txt" ><?php if ($line['status'] == 1) { ?> Activated <?php } else { ?> Deactivated <?php } ?></td>
                                                                    <td valign="middle" class="txt" align="center"><a href="user_addf.php?id=<?php echo $line['id']; ?>" class="orangetxt">Edit</a> </td>
                                                                    <td valign="middle" align="center"><input type="checkbox" name="ids[]" value="<?php print $line['id'] ?>" /></td>
                                                                </tr>
                                                        <?php } ?>
                                                        
                                                        <?php $className = ($className == "evenRow") ? "oddRow" : "evenRow"; ?>
                                                            <tr align="right" class="<?php print $className ?>">
                                                                <td colspan="9"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td width="24%"  align="left" style="color:#FF0000 " class="txt">
                                                            <?php include("codelibrary/inc/paging.inc.php"); ?>
                                                                            </td>
                                                                            <td width="58%"  align="right">
                                                                                <input type="submit" name="Submit" value="Activate" class="button" onclick="return del_prompt(this.form, this.value, 'user_del.php')" />
                                                                                <input type="submit" name="Submit" value="Deactivate" class="button" onclick="return del_prompt(this.form, this.value, 'user_del.php')" />
                                                                                <input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form, this.value, 'user_del.php')" /></td>
                                                                        </tr>
                                                                    </table></td>
                                                            </tr>

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
        <script src="codelibrary/js/script_tmt_validator.js" type="text/javascript"></script>
    </body>
</html>