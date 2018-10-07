<?php 
// getting config file data access to check 
	require_once 'config.php';
	// releasing session access token 
	unset($_SESSION['access_token']);
	// revoking token from gclien
	$gClient->revokeToken();
	// destroy seesion and redirect to login page+
	session_destroy();
	header("Location:../index.php");
	exit();

 ?>