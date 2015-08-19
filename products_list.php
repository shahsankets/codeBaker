<?php   require_once("codelibrary/inc/db.php");
        require_once("codelibrary/inc/functions.php");
        validate_admin();
        
       if($_POST["download"]){ //made by R.N.Kushwaha dated 6th April 2014 14:25
	   $where=" where 1=1 ";
                
                if($_REQUEST["product_code"]){
		  $where.=" and product_code  like '%".$_REQUEST["product_code"]."%' ";
		}
               /* 
                if($_REQUEST["product_code"]){
		  $where.=" and product_code  = '".$_REQUEST["product_code"]."' ";
		}
                */
                
                
                if($_REQUEST["product_name"]){
		  $where.=" and product_name  like '%".$_REQUEST["product_name"]."%' ";
		}
               /* 
                if($_REQUEST["product_name"]){
		  $where.=" and product_name  = '".$_REQUEST["product_name"]."' ";
		}
                */
                
                
                if($_REQUEST["product_desc"]){
		  $where.=" and product_desc  like '%".$_REQUEST["product_desc"]."%' ";
		}
               /* 
                if($_REQUEST["product_desc"]){
		  $where.=" and product_desc  = '".$_REQUEST["product_desc"]."' ";
		}
                */
                
                
                if($_REQUEST["image"]){
		  $where.=" and image  like '%".$_REQUEST["image"]."%' ";
		}
               /* 
                if($_REQUEST["image"]){
		  $where.=" and image  = '".$_REQUEST["image"]."' ";
		}
                */
                
                
                if($_REQUEST["price"]){
		  $where.=" and price  like '%".$_REQUEST["price"]."%' ";
		}
               /* 
                if($_REQUEST["price"]){
		  $where.=" and price  = '".$_REQUEST["price"]."' ";
		}
                */
                
                
                if($_REQUEST["added_by"]){
		  $where.=" and added_by  like '%".$_REQUEST["added_by"]."%' ";
		}
               /* 
                if($_REQUEST["added_by"]){
		  $where.=" and added_by  = '".$_REQUEST["added_by"]."' ";
		}
                */
                
                
                if($_REQUEST["added_date"]){
		  $where.=" and added_date  like '%".$_REQUEST["added_date"]."%' ";
		}
               /* 
                if($_REQUEST["added_date"]){
		  $where.=" and added_date  = '".$_REQUEST["added_date"]."' ";
		}
                */
                
                
                if($_REQUEST["datetime"]){
		  $where.=" and datetime  like '%".$_REQUEST["datetime"]."%' ";
		}
               /* 
                if($_REQUEST["datetime"]){
		  $where.=" and datetime  = '".$_REQUEST["datetime"]."' ";
		}
                */
                
                
                if($_REQUEST["status"]){
		  $where.=" and status  like '%".$_REQUEST["status"]."%' ";
		}
               /* 
                if($_REQUEST["status"]){
		  $where.=" and status  = '".$_REQUEST["status"]."' ";
		}
                */
                
        $output="";
	 $line_termineted="\n";
	
        if( $_POST["download"] =="CSV") $field_termineted=","; else $field_termineted="\t"; 
            $enclosed='"';
            $escaped="\\";
            
            $export_schema="ID".$field_termineted."Product Code".$field_termineted."Product Name".$field_termineted."Product Desc".$field_termineted."Image".$field_termineted."Price".$field_termineted."Added By".$field_termineted."Added Date".$field_termineted."Datetime".$field_termineted."Status";
            $dataQuery=executeQuery("select * from tbl_products $where ",$conn);
            $output.=$export_schema;
            
            while($data=$dataQuery->fetch_assoc()) {
	
                $output.= $line_termineted.$data["id"].$field_termineted;
                $output.=$enclosed.$data["product_code"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["product_name"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["product_desc"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["image"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["price"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["added_by"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["added_date"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["datetime"].$enclosed.$field_termineted;
                $output.=$enclosed.$data["status"].$enclosed.$field_termineted;
                }
	
    header("Content-Description: File Transfer");
   if( $_POST["download"] =="CSV"){
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment; filename=products_list_07_04_2014_00_51_40.csv");
	} else {
		header("Content-Type: application/vnd.ms-excel");
		header("Content-disposition: attachment; filename=products_list_07_04_2014_00_51_40.xls");
	}
    
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: ".strlen($output));
    ob_clean();
    flush();
	echo $output;
    exit;
}
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>List | Products :: <?php echo SITE_ADMIN_TITLE;?></title>
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
                            <td width="23"> </td>
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
                                        <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage Products</td>
                                        <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Add Products" onClick="location.href = 'products_addf.php'"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $start = 0;

                        $where = " where 1=1 ";
                        if ($_REQUEST["product_code"]) {
                            $where.=" and product_code like '%" . $_REQUEST["product_code"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["product_code"]) {
                            $where.=" and product_code  ='" . $_REQUEST["product_code"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["product_name"]) {
                            $where.=" and product_name like '%" . $_REQUEST["product_name"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["product_name"]) {
                            $where.=" and product_name  ='" . $_REQUEST["product_name"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["product_desc"]) {
                            $where.=" and product_desc like '%" . $_REQUEST["product_desc"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["product_desc"]) {
                            $where.=" and product_desc  ='" . $_REQUEST["product_desc"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["image"]) {
                            $where.=" and image like '%" . $_REQUEST["image"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["image"]) {
                            $where.=" and image  ='" . $_REQUEST["image"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["price"]) {
                            $where.=" and price like '%" . $_REQUEST["price"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["price"]) {
                            $where.=" and price  ='" . $_REQUEST["price"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["added_by"]) {
                            $where.=" and added_by like '%" . $_REQUEST["added_by"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["added_by"]) {
                            $where.=" and added_by  ='" . $_REQUEST["added_by"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["added_date"]) {
                            $where.=" and added_date like '%" . $_REQUEST["added_date"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["added_date"]) {
                            $where.=" and added_date  ='" . $_REQUEST["added_date"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["datetime"]) {
                            $where.=" and datetime like '%" . $_REQUEST["datetime"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["datetime"]) {
                            $where.=" and datetime  ='" . $_REQUEST["datetime"] . "' ";
                        }
                        */
                        
                        if ($_REQUEST["status"]) {
                            $where.=" and status like '%" . $_REQUEST["status"] . "%'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["status"]) {
                            $where.=" and status  ='" . $_REQUEST["status"] . "' ";
                        }
                        */
                        
                        if (isset($_GET["start"]))
                            $start = $_GET["start"];
                        $pagesize = 50;
                        if (isset($_GET["pagesize"]))
                            $pagesize = $_GET["pagesize"];
                        $order_by = $prefix.$table."id";
                        if (isset($_GET["order_by"]))
                            $order_by = $_GET["order_by"];
                        $order_by2 = "asc";
                        if (isset($_GET["order_by2"]))
                            $order_by2 = $_GET["order_by2"];

                        $sql = executeQuery("select tbl_products.* from tbl_products $where order by $order_by $order_by2 limit $start, $pagesize", $conn);
                        $ret = executeQuery("select tbl_products.id from tbl_products $where", $conn);
                        $reccnt = $ret->num_rows;
                        ?>
                        <tr>
                            <td height="400" align="center" valign="top"><br>
                                    <table width="98%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td height="347" align="center" valign="top">
                                                <span class="warning"><?php print $_SESSION['sess_msg']; $_SESSION['sess_msg'] = ""; ?></span> <br />
                                                <form action="" name="frm_search" method="post">
                                                    <table width="98%" border="0" align=center cellpadding="4" cellspacing="1" class="greyBorder">
                                                        <tr class="blueBackground">
                                                            <td align="right" colspan="100%">Search products
                                                           
                                                            <a href="products_list.php" class="bigWhite" style="text-align:left;">View All Records</a>
                                                            <input type="submit" name="search" value="Search" class="button" />
                                                            <input type="reset" name="reset" value="Reset" class="button" onclick="document.frm_search.reset();">
                                                            <input type="submit" name="download" value="CSV" class="button" />
                                                            <input type="submit" name="download" value="EXCEL" class="button" />
                                                            </td>
                                                                
                                                        </tr>
                                                        <tr> 
                                                             <td align="right" class="bldTxt">Product Code :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="product_code"  value="<?php echo $_REQUEST["product_code"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Product Name :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="product_name"  value="<?php echo $_REQUEST["product_name"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Product Desc :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="product_desc"  value="<?php echo $_REQUEST["product_desc"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Image :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="image"  value="<?php echo $_REQUEST["image"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Price :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="price"  value="<?php echo $_REQUEST["price"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Added By :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="added_by"  value="<?php echo $_REQUEST["added_by"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Added Date :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="added_date"  value="<?php echo $_REQUEST["added_date"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Datetime :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="datetime"  value="<?php echo $_REQUEST["datetime"]; ?>" class="txtfld" size="20"></td>
                                                             
                                                             <td align="right" class="bldTxt">Status :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="status"  value="<?php echo $_REQUEST["status"]; ?>" class="txtfld" size="20"></td>
                                                             </tr>
                                                       
                                                    </table>
                                                </form>
                                                <br/>
                                                <form name="frm_list" method="post" >
                                                    <table width="98%" border="0" align=center cellpadding="4" cellspacing="1" class="greyBorder">
                                                            <?php if ($reccnt > 0) { ?>
                                                            <tr class="blueBackground">
                                                                <td width="5%" align="center">ID<?php echo sort_arrows("tbl_products.id") ?></td><td width="14%" align="center">Product Code<?php echo sort_arrows("tbl_products.product_code") ?></td><td width="14%" align="center">Product Name<?php echo sort_arrows("tbl_products.product_name") ?></td><td width="14%" align="center">Image<?php echo sort_arrows("tbl_products.image") ?></td><td width="14%" align="center">Price<?php echo sort_arrows("tbl_products.price") ?></td><td width="14%" align="center">Added By<?php echo sort_arrows("tbl_products.added_by") ?></td><td width="14%" align="center">Added Date<?php echo sort_arrows("tbl_products.added_date") ?></td><td width="14%" align="center">Datetime<?php echo sort_arrows("tbl_products.datetime") ?></td><td width="14%" align="center">Status<?php echo sort_arrows("tbl_products.status") ?></td> <td width="9%" align="center">Action</td>
                                                                <td width="4%" align="center"><input name="check_all" type="checkbox" id="check_all" value="check_all" onclick="checkall(this.form)" /></td>
                                                            </tr>
                                                        <?php
                                                        $i = 0;
                                                        while ($line = $sql->fetch_array()) {
                                                            $className = ($className == "evenRow") ? "oddRow" : "evenRow";
                                                            $i++;
                                                            ?>
                                                                <tr class="<?php print $className ?>">
                                                                    <td align="center" class="txt" ><?php echo $line["id"]; ?></td>
                                                                       <td align="center" class="txt" ><?php echo $line["product_code"]; ?></td>
                                                                       
                                                                       <td align="center" class="txt" ><?php echo $line["product_name"]; ?></td>
                                                                       
                                                                       <td align="center" class="txt" ><?php echo $line["image"]; ?></td>
                                                                       
                                                                       <td align="center" class="txt" ><?php echo $line["price"]; ?></td>
                                                                       
                                                                       <td align="center" class="txt" ><?php echo $line["added_by"]; ?></td>
                                                                       
                                                                       <td align="center" class="txt" ><?php echo user_date($line["added_date"]); ?></td>
                                                                       
                                                                       <td align="center" class="txt" ><?php echo format_date_time($line["datetime"]); ?></td>
                                                                       
                                                                       <td align="center" class="txt" ><?php echo $line["status"]; ?></td>
                                                                        
                                                                       <td valign="middle" class="txt" align="center"><a href="products_addf.php?id=<?php echo $line["id"]; ?>" class="orangetxt">Edit</a> </td>
                                                                    <td valign="middle" align="center"><input type="checkbox" name="ids[]" value="<?php print $line["id"]; ?>" /></td>
                                                                </tr>
                                                        <?php } ?>
                                                        
                                                        <?php $className = ($className == "evenRow") ? "oddRow" : "evenRow"; ?>
                                                            <tr align="right" class="<?php print $className ?>">
                                                                <td colspan="100%"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td width="24%"  align="left" style="color:#FF0000 " class="txt">
                                                                            <?php include("codelibrary/inc/paging.inc.php"); ?>
                                                                            </td>
                                                                            <td width="58%"  align="right">
                                                                                <input type="submit" name="Submit" value="Activate" class="button" onclick="return del_prompt(this.form, this.value, 'products_del.php')" />
                                                                                <input type="submit" name="Submit" value="Deactivate" class="button" onclick="return del_prompt(this.form, this.value, 'products_del.php')" />
                                                                                <input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form, this.value, 'products_del.php')" /></td>
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
                                            <td> </td>
                                        </tr>
                                        <tr align="center">
                                            <td> </td>
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