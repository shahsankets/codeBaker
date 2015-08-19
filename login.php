<?php

require_once("codelibrary/inc/db.php");
@extract($_POST);

if ($logged == "yes") {
    if (empty($username)) {
        $_SESSION['sess_msg'] = "Empty Username";
        header("Location: index.php");
        exit();
    } else if (empty($password)) {
        $_SESSION['sess_msg'] = "Empty Password";
        header("Location: index.php");
        exit();
    }

    $sql = "select * from tbl_admin where user_id= binary '$username' and password= binary '$password'";
    $rs = executeQuery($sql, $conn);
    if ($rs->num_rows > 0) {
        $rc = $rs->fetch_array();
        if ($rc['status'] == 1) {
            $_SESSION['sess_admin_id'] = $rc['id'];
            $_SESSION['sess_username'] = strtoupper($rc['name']);

            if ($_REQUEST['back']) {
                header("Location: " . $_REQUEST['back']);
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $str = "Your account is deactivated, please contact administrator.";
            $_SESSION['sess_msg'] = $str;
            header("Location: index.php");
            exit();
        }
    }
    $_SESSION['sess_msg'] = 'Invalid Username/Password';
    header("Location: index.php");
    exit();
}
?>