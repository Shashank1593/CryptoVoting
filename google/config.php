<?php
// sarting seesion 
	session_start();
	// importing google api file to access google server
	require_once 'GoogleAPI/vendor/autoload.php';
	// creating gclient , gclient is owner to create auth 
	$gClient = new Google_Client();
	// client id is id generated by google while creating auth 
	$gClient->setClientId("692022961949-4s6jv3jbrdakru1tjvhpc43ceoctu91p.apps.googleusercontent.com");
	// secret is secret key to access id
	$gClient->setClientSecret("98KOV4iQ0_JpuBarFxS74y7G");
	// application is app name
	$gClient->setApplicationName("CryptoVoting Login");
	// redirecting url after returning from google auth
	$red=$gClient->setRedirectUri("http://192.168.43.146.xip.io/project/google/g-callback.php");
	
	//$gClient->setRedirectUri("http://localhost/google/g-callback.php");
	// scopes define user data acccesss level
	$gClient->addScope("https://www.googleapis.com/auth/plus.login");
	$gClient->addScope("https://www.googleapis.com/auth/userinfo.email");
	//$gClient->addScope("https://www.googleapis.com/auth/plus.me");
?>