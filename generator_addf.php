<?php
require_once("codelibrary/inc/db.php");
require_once("codelibrary/inc/functions.php");
validate_admin();
if ($_POST['submitForm'] == "yes") {
    $prefix = $_POST['prefix'];
    $table = $_POST['name'];

    if (is_dir("tests/" . $table)) {
        $dh = opendir("tests/" . $table);

        while ($file = readdir($dh)) {
            if ($file != '.' && $file != '..') {
                unlink("tests/" . $table . "/" . $file);
            }
        }
        closedir($dh);
        rmdir("tests/" . $table);
    }
    mkdir("tests/" . $table, 077);

 $phpcode = '<?php require_once("codelibrary/inc/db.php");
    require_once("codelibrary/inc/functions.php");
                   ';
$addf = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add | ' . ucwords(str_replace("_", " ", $table)) . ' :: <?php echo SITE_ADMIN_TITLE;?></title>
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
                      <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage ' . ucwords($table) . ' </td>
                      <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Manage ' . ucwords($table) . '" onClick="location.href='; $addf.="'" . $table . '_list.php\'">
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
			  <input type="hidden" name="id" class="txtfld" value="<?php echo $_GET[\'id\'];?>">
                          <tr align="left"> 
			   <td height="25" colspan="2" class="blueBackground">
                            <?php if($_GET[\'id\']){?>Edit&nbsp;<?php }else{?>&nbsp;Add&nbsp;<?php }?>  ' . ucwords($table) . ' </td>
                            </tr>
			    <?php if($_SESSION[\'sess_msg\']){?>
				<tr>
                                    <td colspan="2" align="center"  class="warning"><?php print $_SESSION[\'sess_msg\']; $_SESSION[\'sess_msg\']="";?></td>
				</tr>
				<?php }?>
				<tr class="evenRow">
                                    <td class="txt" align="right" colspan="2"><span class="warning">*</span> - Required Fields</td>
				</tr> <?php //some dynamic fields from database;?>';

    $sql = "show tables from $DBName where Tables_in_rnmysqli = '$prefix$table' ";
    $result = executeQuery($sql, $conn);
    $num = $result->num_rows;

    if ($num) {
        $sql = "show columns from $prefix$table where Extra != 'auto_increment'";
        $result = executeQuery($sql, $conn);
        $num2 = $result->num_rows;
        $cl = 'evenRow';

        if ($num2) {
$valid = '<script type="text/javascript">
function validate(obj){
    
';

            $flag = 0;
            $number = 0;
            $double = 0;
            $showelse = 0;
            $date=0;
            $datetime=0;
            $fields = array();
            $fieldType = array();
            $tt = 1;

            while ($r = $result->fetch_assoc()) {
                // echo "<pre>";print_r($r);
                $cl = ($cl == 'evenRow' ? 'oddRow' : 'evenRow');
                $addf.='<tr class="' . $cl . '">
                            <td class="bldTxt" align="right" width="25%">' . ucwords(str_replace("_", " ", $r['Field'])) . ' :</td>
                            <td align="left" width="75%" class="txt">';
                if ($r['Key'] == 'MUL' && ( preg_match("/^int/", $r['Type']) || preg_match("/^smallint/", $r['Type']) || preg_match("/^tinyint/", $r['Type']) || preg_match("/^bigint/", $r['Type']))) {
                    executeQuery("use  information_schema", $conn);
                    $sql3 = "select REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME from information_schema.KEY_COLUMN_USAGE where TABLE_SCHEMA = '";
                    $sql3.= $DBName;
                    $sql3.="' and TABLE_NAME = '";
                    $sql3.= $prefix . $table;
                    $sql3.="' and COLUMN_NAME = '";
                    $sql3.=$r['Field'];
                    $sql3.="' "; //echo $sql3;exit;
                    $result3 = executeQuery($sql3, $conn);
                    $num3 = $result3->num_rows;

                    if ($num3) {
                        $r3 = $result3->fetch_assoc();
                        $addf.='<select name="' . $r['Field'] . '" class="txtfld" id="' . $r['Field'] . '">
                        <option value="">Select ' . ucwords(str_replace("_", " ", $r['Field'])) . '</option>';
                        $addf.='
                <?php //as we guess you have used a foreign key, here set here the name of column from referenced table to be showed in dropdown;
                $column_Name = "";//add comma before column name to be fetch from db eg. , title
                $column_show = "id";//replace with column name to be shown  eg. title 
                $sqlQuery = "select ';
                        $addf.= $r3['REFERENCED_COLUMN_NAME'];
                        $addf.=' $column_Name from ';
                        $addf.=$r3['REFERENCED_TABLE_NAME'];
                        $addf.=' where 1 =1 order by ';
                        $addf.=$r3['REFERENCED_COLUMN_NAME'];
                        $addf.=' asc ";';
                        $addf.='
                $resultQuery = executeQuery($sqlQuery,$conn);//$conn is connection object
                $numResults = $resultQuery->num_rows;
                if( $numResults ){              
            ';
                        $addf.= '         
                    while( $getResults = $resultQuery->fetch_assoc()){?>
                            <option value="<?php echo $getResults[' . $r3[REFERENCED_COLUMN_NAME] . '];?>" <?php if($';
                        $addf.= $r["Field"];
                        $addf.=' == ';
                        $addf.= '$getResults["' . $r3["REFERENCED_COLUMN_NAME"] . '"]';
                        $addf.=') echo "selected=\'selected\'";?>><?php echo $getResults[$column_show];?></option>
                <?php }
                }?>
                </select>';
                        $params[] = 'i';
                    }
                } else if ($r['Field'] == 'status') {
                    $addf.=' <select name="' . $r['Field'] . '" class="txtfld" id="' . $r['Field'] . '">
                    <option value="1" <?php if($' . $r['Field'] . ' == 1) echo "selected=\'selected\'";?>>Activate</option>
                    <option value="0"  <?php if($' . $r['Field'] . ' == 0) echo "selected=\'selected\'";?>>Deactivate</option>
                    </select>';
                    $params[] = 'i';
                } else {
                     if (strtolower($r['Field']) == 'password') {
                        $addf.=' <input name="' . $r['Field'] . '" type="password" class="txtfld password" id="' . $r['Field'] . '" value="<?php echo $' . $r['Field'] . ';?>" size="40">';
                        $double = 1;
                         $params[] = 's';
                    } else if (strtolower($r['Field']) == 'image' || strtolower($r['Field']) == 'banner') {
                        $addf.=' <input name="' . $r['Field'] . '" type="file" class="txtfld image" id="' . $r['Field'] . '" size="40">';
                        $double = 1;
                         $params[] = 's';
                    } else if (preg_match("/^varchar/", $r['Type'])) {
                        $addf.=' <input name="' . $r['Field'] . '" type="text" class="txtfld" id="' . $r['Field'] . '" value="<?php echo $' . $r['Field'] . ';?>" size="40" maxlength="' . substr(str_replace(")", "", $r['Type']), 8, (strlen(str_replace(")", "", $r['Type'])))) . '">';

                        $params[] = 's';
                    } else if ($r['Type'] == 'tinytext') {
                        $addf.=' <textarea name="' . $r['Field'] . '" class="txtfld" id="' . $r['Field'] . '" rows="2" cols="45"><?php echo $' . $r['Field'] . ';?></textarea>';
                        $params[] = 's';
                    } else if ($r['Type'] == 'mediumtext') {
                        $addf.=' <textarea name="' . $r['Field'] . '" class="txtfld" id="' . $r['Field'] . '" rows="4" cols="55"><?php echo $' . $r['Field'] . ';?></textarea>';
                        $params[] = 's';
                    } else if ($r['Type'] == 'text') {
                        $addf.=' <textarea name="' . $r['Field'] . '" class="txtfld editor" id="' . $r['Field'] . '" rows="6" cols="65"><?php echo $' . $r['Field'] . ';?></textarea>';
                        $editor=1;
                        $params[] = 's';
                    } else if ($r['Type'] == 'datetime') {
                        $addf.=' <input name="' . $r['Field'] . '" type="text" class="txtfld datetimepicker" id="' . $r['Field'] . '" value="<?php echo format_date_time($' . $r['Field'] . ',1);?>" size="30">';
                        $datetime=1;
                        $params[] = 's';
                    } else if ($r['Type'] == 'date') {
                        $addf.=' <input name="' . $r['Field'] . '" type="text" class="txtfld datepicker" id="' . $r['Field'] . '" value="<?php echo user_date($' . $r['Field'] . ');?>" size="20">';
                        $params[] = 's';
                        $date=1;
                    } else if (preg_match("/^int/", $r['Type']) || preg_match("/^tinyint/", $r['Type']) || preg_match("/^mediumint/", $r['Type']) || preg_match("/^bigint/", $r['Type'])) {
                        $addf.=' <input name="' . $r['Field'] . '" type="text" class="txtfld date" id="' . $r['Field'] . '" value="<?php echo $' . $r['Field'] . ';?>" onkeypress="return isNumberKey(event)" size="30">';
                        $number = 1;
                        $params[] = 'i';
                    } else if (preg_match("/^decimal/", $r['Type']) || preg_match("/^float/", $r['Type']) || preg_match("/^double/", $r['Type'])) {
                        $addf.=' <input name="' . $r['Field'] . '" type="text" class="txtfld date" id="' . $r['Field'] . '" value="<?php echo $' . $r['Field'] . ';?>" onblur="extractNumber(this,2,true);" onkeyup="extractNumber(this,2,true);" onkeypress="return blockNonNumbers(this, event, true, true);" size="30">';
                        $double = 1;
                        $params[] = 'd';
                    } else {
                        $addf.=' <input name="' . $r['Field'] . '" type="text" class="txtfld" id="' . $r['Field'] . '" value="<?php echo $' . $r['Field'] . ';?>" size="40">';
                        $double = 1;
                        $params[] = 's';
                    }
                }

                $fields[] = $r['Field'];
                $fieldType[] = $r['Type'];

if ($r['Null'] == 'NO') {
    $addf.='<span class="warning">*</span>';
    if ($flag == 1)
        $valid.=' else ';
    $showelse = 1;

$valid.='if(obj.' . $r['Field'] . '.value==""){
    alert("Please enter ' . ucwords(str_replace("_", " ", $r['Field'])) . '");
    obj.' . $r['Field'] . '.focus();
    return false;
}
';
if ($tt == 1) {
$phpcode.='
/**
*@author RN Kushwaha
*@email at Rn.kushwaha022@gmail.com
*@created 5th April 2014
*/

    @extract($_REQUEST);
    validate_admin();
    if( $_POST["submitForm"]=="yes"){
   
    $_SESSION["sess_error_msg"] = array();
';
}
$tt = 0;
$phpcode.='
    if($' . $r['Field'] . '==""){
        $_SESSION["sess_error_msg"][] = "Please enter ' . ucwords(str_replace("_", " ", $r['Field'])) . '";
    }
';
}
//echo "<pre>";print_r($r);
                $flag = 1;
                $addf.='</td>
		</tr>';
            }
        }
    }

$phpcode.='
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
            ';
            $kk=0;
            foreach ($fields as $aa) {
                if($fieldType[$kk]=="date"){
                    $phpcode.= "$".$aa." = mysql_date($".$aa.");";
                }
                if($fieldType[$kk]=="datetime"){
                   $phpcode.="$".$aa." = format_date_time_mysql($".$aa.");";
                }
                 $kk++;
             }
           
            $phpcode.='
            if(!$id){//insert query
            
            $sql = "insert into ';
            $phpcode.=$prefix . $table;
            $phpcode.=' (';
            $phpcode.= implode(", ", $fields);
            $phpcode.=')  values( ';
            $tr = 0;
            
            foreach ($fields as $aa) {
                if ($tr) {
                    $phpcode.=", ";
                }
                $phpcode.="?";
                $tr = 1;
               }
            $phpcode.=')";
            $stmt = $conn->prepare($sql);
           if($stmt === false) {
             trigger_error("Wrong SQL: " . $sql . " Error: " . $conn->error, E_USER_ERROR);
           }
           $stmt->bind_param("' . implode("", $params);
            $phpcode.='",';
            $tr = 0;
            foreach ($fields as $f) {
                if ($tr) {
                    $phpcode.=', ';
                }
                $phpcode.='$' . $f;
                $tr = 1;
            }
            $phpcode.=');
                $stmt->execute();
                if($stmt->affected_rows){
                     $_SESSION["sess_msg"] = $stmt->affected_rows." ' . ucwords($table) . ' inserted Successfully with id: ".$stmt->insert_id;
                     $stmt->close();
                     
                     header("Location: ' . strtolower($table) . '_addf.php");
                     exit();
                } else {
                     $stmt->close();
                     $_SESSION["sess_msg"] ="No ' . ucwords($table) . ' inserted!";
                }
            } else {//update Query
           
                    $sql = "update ';
                    $phpcode.=$prefix . $table;
                    $phpcode.=' set ';
                    $phpcode.= implode(" =?, ", $fields);
                    $phpcode.=' ';

                    $phpcode.=' =? where id=?";
                    $stmt = $conn->prepare($sql);
                  
                    if($stmt === false) {
                     trigger_error("Wrong SQL: " . $sql . " Error: " . $conn->error, E_USER_ERROR);
                   }
                   
                   $stmt->bind_param("' . implode("", $params);
                    $phpcode.='i",';
                    $tr = 0;
                    foreach ($fields as $f) {
                        if ($tr) {
                            $phpcode.=', ';
                        }
                        $phpcode.='$' . $f;
                        $tr = 1;
                    }
                    $phpcode.=', $id);
                        $stmt->execute();
                        if($stmt->affected_rows){
                             $_SESSION["sess_msg"] = "Record successfully updated! ";
                             $stmt->close();
                              
                             header("Location: ' . strtolower($table) . '_list.php");
                             exit();
                        } else {
                             $stmt->close();
                             $_SESSION["sess_msg"] ="No ' . ucwords($table) . ' updated!";
                        }
            }
                     
    }       
}
if($_GET["id"]){
	$sql="select * from '.$prefix.$table.' where id=\'".$_GET[\'id\']."\'";
	$result=executeQuery($sql,$conn);
	$num= $result->num_rows;
	$row =$result->fetch_assoc();
	@extract($row);
	$result->free();
}
?>';
    //exit;

    $result->free();
    if ($showelse) {
        $valid.='else {
            document.getElementById("submitbtn1").value="Sending..";
            document.getElementById("submitbtn1").setAttribute("disabled","disabled");
            return true;
            }
         }';
    } else {
        $valid.='}';
    }
    if ($number) {
        $valid.="
           
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
	}";
    }

    if ($double) {
        $valid.="
    
function extractNumber(obj, decimalPlaces, allowNegative){
    var temp = obj.value;
    
    // avoid changing things if already formatted correctly
    var reg0Str = '[0-9]*';
    if (decimalPlaces > 0) {
        reg0Str += '\\.?[0-9]{0,' + decimalPlaces + '}';
    } else if (decimalPlaces < 0) {
        reg0Str += '\\.?[0-9]*';
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
}";
    }
    $valid.=' 
</script>';
if($date || $datetime){
  $valid.='
<!----- this code is for datetime picker, change it if you do not want to use it -->
<link rel="stylesheet" media="all" type="text/css" href="codelibrary/js/dateandtime/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="codelibrary/js/dateandtime/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="codelibrary/js/dateandtime/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="codelibrary/js/dateandtime/jquery-ui.min.js"></script>
<script type="text/javascript" src="codelibrary/js/dateandtime/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="codelibrary/js/dateandtime/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript">
    $jq=jQuery.noConflict();';
    if($date){
    $valid.='
    $jq(".datepicker").datetimepicker({
        timeFormat:"",
        showTime:false,
        changeMonth:true,
         onSelect:function(){
            $jq("#ui-datepicker-div").hide();
        },
        changeYear:true,
        dateFormat: "dd/mm/yy"
    })';
    }
    if($datetime){
    $valid.='
    $jq(".datetimepicker").datetimepicker({
        timeFormat: "HH:mm",
        changeMonth:true,
        changeYear:true,
        dateFormat: "dd/mm/yy"
    })';
    }
$valid.='
</script>
';
}
if($editor){
$valid.='
<!---- this is for jce editor, change it if you do not want to use it ---->
<script type="text/javascript" src="codelibrary/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="codelibrary/js/tiny_mce/include_mce.js"> </script>
';
}
    $cl = ($cl == 'evenRow' ? 'oddRow' : 'evenRow');
    $addf.='<tr class="' . $cl . '">
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
' . $valid . '
</body>
</html>';
    file_put_contents("tests/" . $table . "/" . $table . "_addf.php", $phpcode . $addf);
//now code for del page
$phpcode='<?php require_once("codelibrary/inc/db.php");
      require_once("codelibrary/inc/functions.php");
                   
/**
*@author RN Kushwaha
*@email at Rn.kushwaha022@gmail.com
*@created 5th April 2014
*/

validate_admin();
$arr =$_POST["ids"];
$Submit =$_POST["Submit"];

if(count($arr)>0){
	$str_rest_refs=implode(",",$arr);
	if($Submit == "Delete"){
		$sql="delete from '.$prefix.$table.' where id in ($str_rest_refs) "; 
		executeQuery($sql,$conn);
		$conn->close();
		$_SESSION["sess_msg"] = "Selected record(s) deleted successfully!";
         } else if($Submit == "Activate"){
		$sql="update '.$prefix.$table.' set status=1 where id in ($str_rest_refs)";
		executeQuery($sql,$conn);
		$conn->close();
		$_SESSION["sess_msg"] = "Selected record(s) activated successfully!";
	} else if($Submit == "Deactivate"){
		$sql="update '.$prefix.$table.' set status=0 where id in ($str_rest_refs) ";
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

';
file_put_contents("tests/" . $table . "/" . $table . "_del.php", $phpcode);
// now code for list page
$list = '<?php   require_once("codelibrary/inc/db.php");
        require_once("codelibrary/inc/functions.php");
        validate_admin();
        
       if($_POST["download"]){ //made by R.N.Kushwaha dated 6th April 2014 14:25
	   $where=" where 1=1 ";';
           foreach( $fields as $f ){
		$list.='
                
                if($_REQUEST["'.$f.'"]){
		  $where.=" and '.$f.'  like \'%".$_REQUEST["'.$f.'"]."%\' ";
		}
               /* 
                if($_REQUEST["'.$f.'"]){
		  $where.=" and '.$f.'  = \'".$_REQUEST["'.$f.'"]."\' ";
		}
                */
                ';
           }
	$list.='
        $output="";
	$line_termineted="\n";
	
        if( $_POST["download"] =="CSV") $field_termineted=","; else $field_termineted="\t"; 
            $enclosed=\'"\';
            $escaped="\\\";
            
            $export_schema="ID"';
            $ct = count($fields);
            $oo=1;
            foreach( $fields as $f){
                
              $list.= '.$field_termineted."'. ucwords(str_replace("_"," ",$f)); if($oo < $ct) $list.='"';
              $oo++;
            }
           $list.='";
            $dataQuery=executeQuery("select * from '.$prefix.$table.' $where ",$conn);
            $output.=$export_schema;
            
            while($data=$dataQuery->fetch_assoc()) {
	
                $output.= $line_termineted.$data["id"].$field_termineted;
                ';
                 foreach( $fields as  $f){

                $list.='$output.=$enclosed.$data["'.$f.'"].$enclosed.$field_termineted;
                ';
                
                 }
                
	$list.='}
	
    header("Content-Description: File Transfer");
   if( $_POST["download"] =="CSV"){
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment; filename='.$table.'_list_'.date("d_m_Y_H_i_s").'.csv");
	} else {
		header("Content-Type: application/vnd.ms-excel");
		header("Content-disposition: attachment; filename='.$table.'_list_'.date("d_m_Y_H_i_s").'.xls");
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
 
?>';

$list.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>List | ' . ucwords(str_replace("_", " ", $table)) . ' :: <?php echo SITE_ADMIN_TITLE;?></title>
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
                                        <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage ' . ucwords(str_replace("_", " ", $table)) . '</td>
                                        <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Add ';
$list.= ucwords(str_replace("_", " ", $table));
$list.= '" onClick="location.href = ';
$list.="'".$table;
$list.="_addf.php'";
$list.='">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $start = 0;

                        $where = " where 1=1 ";';
                        
                    foreach ($fields as $f) {
                        $list.='
                        if ($_REQUEST["'.$f.'"]) {
                            $where.=" and '.$f.' like \'%" . $_REQUEST["'.$f.'"] . "%\'";
                        }
                        
                        /* for exact match
                        if ($_REQUEST["'.$f.'"]) {
                            $where.=" and '.$f.'  =\'" . $_REQUEST["'.$f.'"] . "\' ";
                        }
                        */
                        ';
                    }
                        $list.='
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

                        $sql = executeQuery("select '.$prefix.$table.'.* from '.$prefix.$table.' $where order by $order_by $order_by2 limit $start, $pagesize", $conn);
                        $ret = executeQuery("select '.$prefix.$table.'.id from '.$prefix.$table.' $where", $conn);
                        $reccnt = $ret->num_rows;
                        ?>
                        <tr>
                            <td height="400" align="center" valign="top"><br>
                                    <table width="98%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td height="347" align="center" valign="top">
                                                <span class="warning"><?php print $_SESSION[\'sess_msg\']; $_SESSION[\'sess_msg\'] = ""; ?></span> <br />
                                                <form action="" name="frm_search" method="post">
                                                    <table width="98%" border="0" align=center cellpadding="4" cellspacing="1" class="greyBorder">
                                                        <tr class="blueBackground">
                                                            <td align="right" colspan="100%">Search '.$table.'
                                                           
                                                            <a href="'.$table.'_list.php" class="bigWhite" style="text-align:left;">View All Records</a>
                                                            <input type="submit" name="search" value="Search" class="button" />
                                                            <input type="reset" name="reset" value="Reset" class="button" onclick="document.frm_search.reset();">
                                                            <input type="submit" name="download" value="CSV" class="button" />
                                                            <input type="submit" name="download" value="EXCEL" class="button" />
                                                            </td>
                                                                
                                                        </tr>
                                                        <tr>';
                                                        foreach ($fields as $f) {
                                                           $list.=' 
                                                             <td align="right" class="bldTxt">'.ucwords(str_replace("_"," ",$f)).' :</td>
                                                             <td width="19%" align="left" class="txt"><input type="text"  name="'.$f.'"  value="<?php echo $_REQUEST["'.$f.'"]; ?>" class="txtfld" size="20"></td>
                                                            ';
                                                        }
                                                      $list.=' </tr>
                                                       
                                                    </table>
                                                </form>
                                                <br/>
                                                <form name="frm_list" method="post" >
                                                    <table width="98%" border="0" align=center cellpadding="4" cellspacing="1" class="greyBorder">
                                                            <?php if ($reccnt > 0) { ?>
                                                            <tr class="blueBackground">
                                                                <td width="5%" align="center">ID<?php echo sort_arrows("'.$prefix.$table.'.id") ?></td>';
                                                                $yyy=0;
                                                                foreach ($fields as $f) {
                                                                if( $fieldType[$yyy]=='text' || $fieldType[$yyy]=='mediumtext'  ) {
                                                                    
                                                                }else{
                                                                    $list.='<td width="14%" align="center">'.ucwords(str_replace("_"," ",$f)).'<?php echo sort_arrows("'.$prefix.$table.'.'.$f.'") ?></td>';
                                                                }
                                                                $yyy++;
                                                                }
                                                               $list.=' <td width="9%" align="center">Action</td>
                                                                <td width="4%" align="center"><input name="check_all" type="checkbox" id="check_all" value="check_all" onclick="checkall(this.form)" /></td>
                                                            </tr>
                                                        <?php
                                                        $i = 0;
                                                        while ($line = $sql->fetch_array()) {
                                                            $className = ($className == "evenRow") ? "oddRow" : "evenRow";
                                                            $i++;
                                                            ?>
                                                                <tr class="<?php print $className ?>">
                                                                    <td align="center" class="txt" ><?php echo $line["id"]; ?></td>';
                                                                    $yyy=0;
                                                                    foreach ($fields as $f) {
                                                                        if( $fieldType[$yyy]=='text' || $fieldType[$yyy]=='mediumtext'  ) {
                                                                            
                                                                        } else if( $fieldType[$yyy]=='date' ){
                                                                        $list.='
                                                                       <td align="center" class="txt" ><?php echo user_date($line["'.$f.'"]); ?></td>
                                                                       ';
                                                                        } else  if( $fieldType[$yyy]=='datetime' ){
                                                                        $list.='
                                                                       <td align="center" class="txt" ><?php echo format_date_time($line["'.$f.'"]); ?></td>
                                                                       ';
                                                                        } else{
                                                                          $list.='
                                                                       <td align="center" class="txt" ><?php echo $line["'.$f.'"]; ?></td>
                                                                       ';  
                                                                        }
                                                                        $yyy++;
                                                                     }
                                                                   $list.=' 
                                                                       <td valign="middle" class="txt" align="center"><a href="'.$table.'_addf.php?id=<?php echo $line["id"]; ?>" class="orangetxt">Edit</a> </td>
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
                                                                                <input type="submit" name="Submit" value="Activate" class="button" onclick="return del_prompt(this.form, this.value, ';$list.="'".$table;$list.='_del.php\')" />
                                                                                <input type="submit" name="Submit" value="Deactivate" class="button" onclick="return del_prompt(this.form, this.value, ';$list.="'".$table;$list.='_del.php\')" />
                                                                                <input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form, this.value, ';$list.="'".$table;$list.='_del.php\')" /></td>
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
</html>';
 file_put_contents("tests/" . $table . "/" . $table . "_list.php", $list);                                                                               
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo ucwords(SITE_ADMIN_TITLE); ?></title>
        <link href="codelibrary/css/style.css" rel="stylesheet" type="text/css" />
        <script src="codelibrary/js/script_tmt_validator.js" type="text/javascript"></script>
        <script type="text/javascript">
            function validate(obj) {
                if (obj.name.value == '') {
                    alert("Please Enter Table Name");
                    obj.name.focus();
                    return false;
                }

                else
                {
                    return true;
                }
            }


        </script>
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
                                        <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage Generator </td>
                                        <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Manage Generator" onClick="location.href = 'generator_list.php'">
                                            &nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="400" align="center" valign="top"><br>
                                <form action="generator_addf.php" method="post" enctype="multipart/form-data" name="frm" onSubmit="return validate(this)">
                                    <table width="94%" border="0" align="center" cellpadding="4" cellspacing="0" class="greyBorder">
                                        <input type="hidden" name="submitForm" value="yes">
                                        <input type="hidden" name="id" class="txtfld" value="<?php echo $_GET['id']; ?>">
                                        <tr align="left"> 
                                            <td height="25" colspan="2" class="blueBackground">
                                        <?php if ($_GET['id']) { ?>Edit&nbsp;<?php } else { ?>&nbsp;Add&nbsp;<?php } ?>  Generator </td>
                                        </tr>
<?php if ($_SESSION['sess_msg2'] != '') { ?>
                                            <tr>
                                                <td colspan="2" align="center"  class="warning"><?php
    print $_SESSION['sess_msg2'];
    $_SESSION['sess_msg2']= '';
    ?></td>
                                            </tr>
<?php } ?>
                                        <tr class="evenRow">
                                            <td class="txt" align="right" colspan="2"><span class="warning">*</span> - Required Fields</td>
                                        </tr>

                                        <tr class="oddRow">
                                            <td class="bldTxt" align="right" width="26%">Table Name :</td>
                                            <td align="left" width="74%" class="txt"><input name="name" placeholder="eg. products" type="text" class="txtfld"  value="<?php echo $name; ?>" size="40"></td>
                                        </tr>
                                         <tr class="evenRow">
                                            <td class="bldTxt" align="right" width="26%">Table Prefix :</td>
                                            <td align="left" width="74%" class="txt"><input name="prefix" placeholder="eg. tbl_" type="text" class="txtfld" id="name" value="<?php echo $prefix; ?>" size="40"><span class="warning">*</span></td>
                                        </tr>

                                        <tr class="oddRow">
                                            <td align=center colspan=100%>
                                                <input type="submit" name="submit" class="button1" value="Submit"/>
                                                <input type="reset" name="reset" class="button1" value="Reset" />
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
<?php include("footer.inc.php"); ?>
    </body>
</html>