<?php 
    require_once("codelibrary/inc/db.php");
    require_once("codelibrary/inc/functions.php");
                   
/**
*@author RN Kushwaha
*@email at Rn.kushwaha022@gmail.com
*@created 5th April 2014
*/

    @extract($_REQUEST);
    validate_admin();
    if( $_POST["submitForm"]=="yes"){
   
    $_SESSION["sess_error_msg"] = array();

    if($product_code==""){
        $_SESSION["sess_error_msg"][] = "Please enter Product Code";
    }

    if($product_name==""){
        $_SESSION["sess_error_msg"][] = "Please enter Product Name";
    }

    if($price==""){
        $_SESSION["sess_error_msg"][] = "Please enter Price";
    }

    if( count( $_SESSION["sess_error_msg"] ) ){

        $_SESSION["sess_msg"] = "<p>".implode("</p><p>", $_SESSION["sess_error_msg"])."</p>";

    } else{
             if( array_key_exists("image",$_FILES)){//used for image upload
                if($_FILES["image"]["size"] > 0){
                    
                    $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
                    $detectedType = exif_imagetype($_FILES["image"]["tmp_name"]);
                    if(!in_array($detectedType, $allowedTypes)){//check for image type
                        $_SESSION["sess_msg"]="Invalid file type!";
                    } else{
                        $imgpath="image/";//img folder with slash in last
                        //$small_imgpath="image/thumb/";//small img folder with slash in last
                        $image = time().str_replace(" ","",$_FILES["image"]["name"]);
                        @move_uploaded_file($_FILES["image"]["tmp_name"],$imgpath.$image);
                        //@resize_img($imgpath.$image,100,80,false); //use it for image resize
                        //@copy($imgpath.$image,$small_imgpath.$image);
                        $new_name =  "image/". $image;
                       // @watermark_image($imgpath . $image, $new_name);//for creating watermark with png logo, but does not add watermarks to a png image
                        //@watermark_text($imgpath.$image, $new_name, 20, "RN", "Kushwaha");//for creating watermark with text, does not add watermarks to a png image
				
			    }
                }
            }
            $added_date = mysql_date($added_date);$datetime = format_date_time_mysql($datetime);
            if(!$id){//insert query
            
            $sql = "insert into tbl_products (product_code, product_name, product_desc, image, price, added_by, added_date, datetime, status)  values( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
           if($stmt === false) {
             trigger_error("Wrong SQL: " . $sql . " Error: " . $conn->error, E_USER_ERROR);
           }
           $stmt->bind_param("ssssdissi",$product_code, $product_name, $product_desc, $image, $price, $added_by, $added_date, $datetime, $status);
                $stmt->execute();
                if($stmt->affected_rows){
                     $_SESSION["sess_msg"] = $stmt->affected_rows." Products inserted Successfully with id: ".$stmt->insert_id;
                     $stmt->close();
                     
                     header("Location: products_addf.php");
                     exit();
                } else {
                     $stmt->close();
                     $_SESSION["sess_msg"] ="No Products inserted!";
                }
            } else {//update Query
           
                    $sql = "update tbl_products set product_code =?, product_name =?, product_desc =?, image =?, price =?, added_by =?, added_date =?, datetime =?, status  =? where id=?";
                    $stmt = $conn->prepare($sql);
                  
                    if($stmt === false) {
                     trigger_error("Wrong SQL: " . $sql . " Error: " . $conn->error, E_USER_ERROR);
                   }
                   
                   $stmt->bind_param("ssssdissii",$product_code, $product_name, $product_desc, $image, $price, $added_by, $added_date, $datetime, $status, $id);
                        $stmt->execute();
                        if($stmt->affected_rows){
                             $_SESSION["sess_msg"] = "Record successfully updated! ";
                             $stmt->close();
                              
                             header("Location: products_list.php");
                             exit();
                        } else {
                             $stmt->close();
                             $_SESSION["sess_msg"] ="No Products updated!";
                        }
            }
                     
    }       
}
if($_GET["id"]){
  $sql="select * from tbl_products where id='".$_GET['id']."'";
  $result=executeQuery($sql,$conn);
  $num= $result->num_rows;
  $row =$result->fetch_assoc();
  @extract($row);
  $result->free();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add | Products :: <?php echo SITE_ADMIN_TITLE;?></title>
<link href="codelibrary/css/style.css" rel="stylesheet" type="text/css" />
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
                      <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage Products </td>
                      <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Manage Products" onClick="location.href='products_list.php'">
                      &nbsp;</td>
                    </tr>
              </table>
  </td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top"><br>
        <form action="" method="post" enctype="multipart/form-data" name="frm" onSubmit="return validate(this)">
                          
                           <table width="94%" border="0" align="center" cellpadding="4" cellspacing="0" class="greyBorder">
        <input type="hidden" name="submitForm" value="yes">
        <input type="hidden" name="id" class="txtfld" value="<?php echo $_GET['id'];?>">
                          <tr align="left"> 
         <td height="25" colspan="2" class="blueBackground">
                            <?php if($_GET['id']){?>Edit&nbsp;<?php }else{?>&nbsp;Add&nbsp;<?php }?>  Products </td>
                            </tr>
          <?php if($_SESSION['sess_msg']){?>
        <tr>
                                    <td colspan="2" align="center"  class="warning"><?php print $_SESSION['sess_msg']; $_SESSION['sess_msg']="";?></td>
        </tr>
        <?php }?>
        <tr class="evenRow">
                                    <td class="txt" align="right" colspan="2"><span class="warning">*</span> - Required Fields</td>
        </tr> <?php //some dynamic fields from database;?><tr class="oddRow">
                            <td class="bldTxt" align="right" width="25%">Product Code :</td>
                            <td align="left" width="75%" class="txt"> <input name="product_code" type="text" class="txtfld" id="product_code" value="<?php echo $product_code;?>" size="40" maxlength="60"><span class="warning">*</span></td>
    </tr><tr class="evenRow">
                            <td class="bldTxt" align="right" width="25%">Product Name :</td>
                            <td align="left" width="75%" class="txt"> <input name="product_name" type="text" class="txtfld" id="product_name" value="<?php echo $product_name;?>" size="40" maxlength="60"><span class="warning">*</span></td>
    </tr><tr class="oddRow">
                            <td class="bldTxt" align="right" width="25%">Product Desc :</td>
                            <td align="left" width="75%" class="txt"> <textarea name="product_desc" class="txtfld editor" id="product_desc" rows="6" cols="65"><?php echo $product_desc;?></textarea></td>
    </tr><tr class="evenRow">
                            <td class="bldTxt" align="right" width="25%">Image :</td>
                            <td align="left" width="75%" class="txt"> <input name="image" type="file" class="txtfld image" id="image" size="40"></td>
    </tr><tr class="oddRow">
                            <td class="bldTxt" align="right" width="25%">Price :</td>
                            <td align="left" width="75%" class="txt"> <input name="price" type="text" class="txtfld date" id="price" value="<?php echo $price;?>" onblur="extractNumber(this,2,true);" onkeyup="extractNumber(this,2,true);" onkeypress="return blockNonNumbers(this, event, true, true);" size="30"><span class="warning">*</span></td>
    </tr><tr class="evenRow">
                            <td class="bldTxt" align="right" width="25%">Added By :</td>
                            <td align="left" width="75%" class="txt"><select name="added_by" class="txtfld" id="added_by">
                        <option value="">Select Added By</option>
                <?php //as we guess you have used a foreign key, here set here the name of column from referenced table to be showed in dropdown;
                $column_Name = "";//add comma before column name to be fetch from db eg. , title
                $column_show = "id";//replace with column name to be shown  eg. title 
                $sqlQuery = "select id $column_Name from tbl_admin where 1 =1 order by id asc ";
                $resultQuery = executeQuery($sqlQuery,$conn);//$conn is connection object
                $numResults = $resultQuery->num_rows;
                if( $numResults ){              
                     
                    while( $getResults = $resultQuery->fetch_assoc()){?>
                            <option value="<?php echo $getResults[id];?>" <?php if($added_by == $getResults["id"]) echo "selected='selected'";?>><?php echo $getResults[$column_show];?></option>
                <?php }
                }?>
                </select></td>
    </tr><tr class="oddRow">
                            <td class="bldTxt" align="right" width="25%">Added Date :</td>
                            <td align="left" width="75%" class="txt"> <input name="added_date" type="text" class="txtfld datepicker" id="added_date" value="<?php echo user_date($added_date);?>" size="20"></td>
    </tr><tr class="evenRow">
                            <td class="bldTxt" align="right" width="25%">Datetime :</td>
                            <td align="left" width="75%" class="txt"> <input name="datetime" type="text" class="txtfld datetimepicker" id="datetime" value="<?php echo format_date_time($datetime,1);?>" size="30"></td>
    </tr><tr class="oddRow">
                            <td class="bldTxt" align="right" width="25%">Status :</td>
                            <td align="left" width="75%" class="txt"> <select name="status" class="txtfld" id="status">
                    <option value="1" <?php if($status == 1) echo "selected='selected'";?>>Activate</option>
                    <option value="0"  <?php if($status == 0) echo "selected='selected'";?>>Deactivate</option>
                    </select></td>
    </tr><tr class="evenRow">
                    <td align=center colspan=100%>
                        <input type="submit" name="submit" class="button1" value="Submit" id="submitbtn1"/> 
                        <input type="reset" name="reset" class="button1" value="Reset" id="submitbtn3"/>
                    </td>
            </tr>
            </table>
            </form>
            </td>
       </tr>
     </table>
    </td>
  </tr>
</table>
<?php include("footer.inc.php");?>
<script src="codelibrary/js/script_tmt_validator.js" type="text/javascript"></script>
<script type="text/javascript">
function validate(obj){
    
if(obj.product_code.value==""){
    alert("Please enter Product Code");
    obj.product_code.focus();
    return false;
}
 else if(obj.product_name.value==""){
    alert("Please enter Product Name");
    obj.product_name.focus();
    return false;
}
 else if(obj.price.value==""){
    alert("Please enter Price");
    obj.price.focus();
    return false;
}
else {
            document.getElementById("submitbtn1").value="Sending..";
            document.getElementById("submitbtn1").setAttribute("disabled","disabled");
            return true;
            }
         }
    
function extractNumber(obj, decimalPlaces, allowNegative){
    var temp = obj.value;
    
    // avoid changing things if already formatted correctly
    var reg0Str = '[0-9]*';
    if (decimalPlaces > 0) {
        reg0Str += '\.?[0-9]{0,' + decimalPlaces + '}';
    } else if (decimalPlaces < 0) {
        reg0Str += '\.?[0-9]*';
    }
    reg0Str = allowNegative ? '^-?' + reg0Str : '^' + reg0Str;
    reg0Str = reg0Str + '$';
    var reg0 = new RegExp(reg0Str);
    if (reg0.test(temp)) return true;

    // first replace all non numbers
    var reg1Str = '[^0-9' + (decimalPlaces != 0 ? '.' : '') + (allowNegative ? '-' : '') + ']';
    var reg1 = new RegExp(reg1Str, 'g');
    temp = temp.replace(reg1, '');

    if (allowNegative) {
        // replace extra negative
        var hasNegative = temp.length > 0 && temp.charAt(0) == '-';
        var reg2 = /-/g;
        temp = temp.replace(reg2, '');
        if (hasNegative) temp = '-' + temp;
    }
    
    if (decimalPlaces != 0) {
        var reg3 = /\./g;
        var reg3Array = reg3.exec(temp);
        if (reg3Array != null) {
            // keep only first occurrence of .
            //  and the number of places specified by decimalPlaces or the entire string if decimalPlaces < 0
            var reg3Right = temp.substring(reg3Array.index + reg3Array[0].length);
            reg3Right = reg3Right.replace(reg3, '');
            reg3Right = decimalPlaces > 0 ? reg3Right.substring(0, decimalPlaces) : reg3Right;
            temp = temp.substring(0,reg3Array.index) + '.' + reg3Right;
        }
    }
    
    obj.value = temp;
}
function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{
    var key;
    var isCtrl = false;
    var keychar;
    var reg;
        
    if(window.event) {
        key = e.keyCode;
        isCtrl = window.event.ctrlKey
    }
    else if(e.which) {
        key = e.which;
        isCtrl = e.ctrlKey;
    }
    
    if (isNaN(key)) return true;
    
    keychar = String.fromCharCode(key);
    
    // check for backspace or delete, or if Ctrl was pressed
    if (key == 8 || isCtrl)
    {
        return true;
    }

    reg = /\d/;
    var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
    var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
    
    return isFirstN || isFirstD || reg.test(keychar);
} 
</script>
<!----- this code is for datetime picker, change it if you do not want to use it -->
<link rel="stylesheet" media="all" type="text/css" href="codelibrary/js/dateandtime/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="codelibrary/js/dateandtime/jquery-ui-timepicker-addon.css" />
 <script type="text/javascript" src="codelibrary/js/dateandtime/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="codelibrary/js/dateandtime/jquery-ui.min.js"></script>
<script type="text/javascript" src="codelibrary/js/dateandtime/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="codelibrary/js/dateandtime/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript">
    $jq=jQuery.noConflict();
    $jq(".datepicker").datetimepicker({
        timeFormat:"",
        showTime:false,
        changeMonth:true,
         onSelect:function(){
            $jq("#ui-datepicker-div").hide();
        },
        changeYear:true,
        dateFormat: "dd/mm/yy"
    })
    $jq(".datetimepicker").datetimepicker({
        timeFormat: "HH:mm",
        changeMonth:true,
        changeYear:true,
        dateFormat: "dd/mm/yy"
    })
</script>

<!---- this is for jce editor, change it if you do not want to use it ---->
<script type="text/javascript" src="codelibrary/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="codelibrary/js/tiny_mce/include_mce.js"> </script>
<h1 class="editable">RN</h1>
</body>
</html>