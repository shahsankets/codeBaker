<?php
/**
 * @author RN Kushwaha
 * @email at Rn.kushwaha022@gmail.com
 * @date 6th April 2014
 */

//error_reporting(E_ALL);

function watermark_image($oldimage_name, $new_image_name) { //echo $oldimage_name, $new_image_name;exit;
    global $image_path;
    $image_path="/images/logo.png";
    list($owidth, $oheight) = getimagesize($oldimage_name);
    $width = $owidth;
    $height = $oheight; //300;    
    $im = imagecreatetruecolor($width, $height);
    
    $img_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
    $watermark = imagecreatefrompng($image_path);
    list($w_width, $w_height) = getimagesize($image_path);
    $pos_x = $width - $w_width;
    $pos_y = $height - $w_height;
    $watx = ( $width - $w_width)/2;
    $waty = ( $height - $w_height) /2;
    imagecopy($im, $watermark, $watx, $waty, 0, 0, $w_width, $w_height);
    imagejpeg($im, $new_image_name, 100);
    imagedestroy($im);
    return true;
}

function watermark_text($oldimage_name, $new_image_name,$font_size=20, $water_mark_text_1='', $water_mark_text_2='') {
    global $font_path;
    $font_path = "images/GILSANUB.TTF";
    //echo $oldimage_name;exit;
    list($owidth, $oheight) = getimagesize($oldimage_name);
    $width = $owidth;
    $height = $oheight;
    $image = imagecreatetruecolor($width, $height);
    $image_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
    $black = imagecolorallocate($image, 0, 0, 0);
    $blue = imagecolorallocate($image, 79, 166, 185);
    //echo $oldimage_name, $new_image_name,$font_size, $water_mark_text_1, $water_mark_text_2;exit;
    imagettftext($image, $font_size, 0, 30, 150, $black, $font_path, $water_mark_text_1);
    imagettftext($image, $font_size, 0, 68, 190, $blue, $font_path, $water_mark_text_2);
    imagejpeg($image, $new_image_name, 100);
    imagedestroy($image);
    //unlink($oldimage_name);
    return true;
}

function pr($array, $die = 0) {
    echo "<pre>";
    print_r($array);
    echo "<pre>";
    if ($die)
        exit;
}

function format_date_time($date,$t='') {
    if ($date && trim($date) != '0000-00-00 00:00:00') {
        if($t) return date('d/m/Y H:i', strtotime(trim($date)));
        else
        return date('d/m/Y h:iA', strtotime(trim($date)));
    }
}
function format_date_time_mysql($date) {
    if (trim($date)) {
        list($fff,$sss) = explode(" ",$date);
        $ddd= mysql_date($fff);
        return $ddd." ".$sss.":00";
    }
}

function user_date($date) {
    if ($date && trim($date) != '0000-00-00') {
        return date('d/m/Y', strtotime(trim($date)));
    }
}

function mysql_date($date) {
    return implode('-', array_reverse(explode('/',trim($date))));
}

// For Executing Query. This function returns a argument which contain recordset 
// object through it user can retrieve values of table.
function executeQuery2($sql) {
    $result = $conn->query($sql);
    if ($result === false) {
        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
    }
    return $result;
}

// It returns the path of current file.
function getCurrentPath() {
    global $_SERVER;
    return "http://" . $_SERVER['HTTP_HOST'] . getFolder($_SERVER['PHP_SELF']);
}

// This function adjusts the decimal point of argumented parameter and return the adjusted value.
function adjustAfterDecimal($param) {
    if (strpos($param, '.') == "") {
        $final_value = $param . ".00";
        return $final_value;
    }
    $after_decimal = substr($param, strpos($param, '.') + 1, strlen($param));
    $before_decimal = substr($param, 0, strpos($param, '.'));
    if (strlen($after_decimal) < 2) {
        if (strlen($after_decimal) == 1) {
            $final_value = $param . "0";
        }
        if (strlen($after_decimal) == 0) {
            $final_value.="$param.00";
        }
    } else {
        $trim_value = substr($after_decimal, 0, 2);
        $final_value.=$before_decimal . "." . $trim_value;
    }
    return $final_value;
}

// This funtion is used for validating the front side users that he is logged in or not.
function validate_user() {
    if ($_SESSION['sess_user_id'] == '') {
        ms_redirect("log-in.php?back=".urlencode($_SERVER['REQUEST_URI']));
    }
}

// This funtion is used for validating the admin side users that he is logged in or not.
function validate_admin() {
    if ($_SESSION['sess_admin_id'] == '') {
        ms_redirect("index.php?back=".urlencode($_SERVER['REQUEST_URI']));
    }
}

// This function is used for redirecting the file on desired file.
function ms_redirect($file, $exit = true, $sess_msg = '') {
    header("Location: $file");
    exit();
}

// This function is used by the paging functions.
function get_qry_str($over_write_key = array(), $over_write_value = array()) {
    global $_GET;
    $m = $_GET;
    if (is_array($over_write_key)) {
        $i = 0;
        foreach ($over_write_key as $key) {
            $m[$key] = $over_write_value[$i];
            $i++;
        }
    } else {
        $m[$over_write_key] = $over_write_value;
    }
    $qry_str = qry_str($m);
    return $qry_str;
}

// This function is used by the paging functions.
function qry_str($arr, $skip = '') {
    $s = "?";
    $i = 0;
    foreach ($arr as $key => $value) {
        if ($key != $skip) {
            if (is_array($value)) {
                foreach ($value as $value2) {
                    if ($i == 0) {
                        $s .= "$key%5B%5D=$value2";
                        $i = 1;
                    } else {
                        $s .= "&$key%5B%5D=$value2";
                    }
                }
            } else {
                if ($i == 0) {
                    $s .= "$key=$value";
                    $i = 1;
                } else {
                    $s .= "&$key=$value";
                }
            }
        }
    }
    return $s;
}

function cust_send_mail($email_to, $emailto_name, $email_subject, $email_body, $email_from, $reply_to, $html = true) {
    require_once "class.phpmailer.php";
    global $SITE_NAME;
    $mail = new PHPMailer();
    $mail->IsSMTP(); // send via SMTP
    $mail->Mailer = "mail"; // SMTP servers

    $mail->From = $email_from;
    $mail->FromName = $SITE_NAME;
    $mail->AddAddress($email_to, $emailto_name);
    $mail->AddReplyTo($reply_to, $SITE_NAME);
    $mail->WordWrap = 50;                              // set word wrap
    $mail->IsHTML($html);                               // send as HTML
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;
    $mail->Send();
    return true;
}


// This function is used to add slashes to a variable.
function add_slashes($param) {
    $k_param = addslashes(stripslashes($param));
    return $k_param;
}

// This function is used to strip slashes to a whole array.
function ms_stripslashes($text) {
    if (is_array($text)) {
        $tmp_array = Array();
        foreach ($text as $key => $value) {
            $tmp_array[$key] = ms_stripslashes($value);
        }
        return $tmp_array;
    } else {
        return stripslashes($text);
    }
}

// This function is used to add slashes to whole array.
function ms_addslashes($text) {
    if (is_array($text)) {
        $tmp_array = Array();
        foreach ($text as $key => $value) {
            $tmp_array[$key] = ms_addslashes($value);
        }
        return $tmp_array;
    } else {
        return addslashes(stripslashes($text));
    }
}

// This function is used to add strip html.
function html2text($html) {
    $search = array("'<head[^>]*?>.*?</head>'si", // Strip out javascript
        "'<script[^>]*?>.*?</script>'si", // Strip out javascript
        "'<[\/\!]*?[^<>]*?>'si", // Strip out html tags
        "'([\r\n])[\s]+'", // Strip out white space
        "'&(quot|#34);'i", // Replace html entities
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
        "'&#(\d+);'e"); // evaluate as php
    $replace = array("",
        "",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)");
    $text = preg_replace($search, $replace, $html);
    return $text;
}

// This function is used to generate sorting arrow in a listing.
function sort_arrows($column) {
    global $_SERVER;
    return '<A HREF="' . $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column, 'asc')) . '"><IMG SRC="images/white_up.gif" BORDER="0"></A> <A HREF="' . $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column, 'desc')) . '"><IMG SRC="images/white_down.gif" BORDER="0"></A>';
}

function sort_arrows_front($column, $heading) {
    global $_SERVER;
    return '<A HREF="' . $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column, 'asc')) . '"><img src="images/sort_up.gif" alt="Sort Up" border="0" title="Sort Up"></A>&nbsp;' . $heading . '&nbsp;<A HREF="' . $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column, 'desc')) . '"><img src="images/sort_down.gif" alt="Sort Down" border="0" title="Sort Down"></A>';
}

// This function is used to unlink a file.
function unlink_file($file_name, $folder_name) {
    $file_path = $folder_name . "/" . $file_name;
    if(file_exists($file_path)){
        @chmod($folder_name, 0777);
        @touch($file_path);
        @unlink($file_path);
        return true;
    }
}


function dd_date_format($date) {
    if ($date) {
        list($y, $m, $d) = explode("-", $date);
        return "$m/$d/$y";
    }
}

function getDateWithTimeInSec($dateTime) {
    if ($dateTime && $dateTime != '0000-00-00' && $dateTime != '0000-00-00 00:00:00') {
        return date('d-M-Y H:i:s', strtotime($dateTime));
    }
}

function resize_img($imgPath, $maxWidth, $maxHeight, $directOutput = true, $quality = 90, $verbose, $imageType) {
    // get image size infos (0 width and 1 height,
    //     2 is (1 = GIF, 2 = JPG, 3 = PNG)

    $size = getimagesize($imgPath);
    $arr = explode(".", $imgPath);
    // break and return false if failed to read image infos
    if (!$size) {
        if ($verbose && !$directOutput)
            echo "<br />Not able to read image infos.<br />";
        return false;
    }

    // relation: width/height
    $relation = $size[0] / $size[1];

    $relation_original = $relation;


    // maximal size (if parameter == false, no resizing will be made)
    $maxSize = array($maxWidth ? $maxWidth : $size[0], $maxHeight ? $maxHeight : $size[1]);
    // declaring array for new size (initial value = original size)
    $newSize = $size;
    // width/height relation
    $relation = array($size[1] / $size[0], $size[0] / $size[1]);


    if (($newSize[1] > $maxHeight)) {
        $newSize[1] = $maxSize[1];
        $newSize[0] = $newSize[1] * $relation[1];
        $newSize[1] = $maxHeight;
        $newSize[0] = $newSize[1] * $relation[1];
    }

    if (($newSize[0] > $maxWidth)) {
        $newSize[0] = $maxSize[1];
        $newSize[1] = $newSize[0] * $relation[0];
        $newSize[0] = $maxWidth;
        $newSize[1] = $newSize[0] * $relation[0];
    }

    //$newSize[0]=$maxWidth;
    //$newSize[1]=$newSize[0]*$relation[0];
    //$newSize[1]=$maxHeight;		
    // create image
    switch ($size[2]) {
        case 1:
            if (function_exists("imagecreatefromgif")) {
                $originalImage = imagecreatefromgif($imgPath);
            } else {
                if ($verbose && !$directOutput)
                    echo "<br />No GIF support in this php installation, sorry.<br />";
                return false;
            }
            break;
        case 2: $originalImage = imagecreatefromjpeg($imgPath);
            break;
        case 3: $originalImage = imagecreatefrompng($imgPath);
            break;
        default:
            if ($verbose && !$directOutput)
                echo "<br />No valid image type.<br />";
            return false;
    }


    // create new image

    $resizedImage = imagecreatetruecolor($newSize[0], $newSize[1]);

    imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $newSize[0], $newSize[1], $size[0], $size[1]);
    $rz = $imgPath;
    // output or save
    if ($directOutput) {
        imagejpeg($resizedImage);
    } else {

        $rz = preg_replace("/\.([a-zA-Z]{3,4})$/", "" . $imageType . "." . $arr[count($arr) - 1], $imgPath);
        imagejpeg($resizedImage, $rz, $quality);
    }
    // return true if successfull
    return $rz;
}

// to search the result based on the argument
function search_result($field, $criteria, $keyword) {
    $criteria = strtolower($criteria);
    if ( $criteria == 'exact') { // exact word
        $sql = " and $field = '$keyword' ";
    } else if ( $criteria == 'any') { // any word starting from it
        $sql = " and $field like '%$keyword%'";
    }
    return $sql;
}
