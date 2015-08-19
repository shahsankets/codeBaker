<?php 
	require_once("codelibrary/inc/db.php");
	require_once("codelibrary/inc/functions.php");
        validate_admin();
		session_destroy();
		
		header("Location: index.php");
                exit();
?>