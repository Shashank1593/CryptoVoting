<?php 
//importing config file
	require_once 'config.php';
	// checkin if access token got or not
	include 'dbsele.php';
	if(isset($_SESSION['access_token']))
	{
		// setting access token to session array
		$gClient->setAccessToken($_SESSION['access_token']);
	}
	else if(isset($_GET['code']))
	{
		// else if not in session getting it from auth code from google and storing access token to session array
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token; 
	}
	else
	{
		// if no access token fetch means user has declined the authorization so send to login page
		header("Location:../index.php");
		exit();
	}
	

	// getting authrization done
	$oAuth = new Google_Service_oauth2($gClient);
	// creating userdata array with get function
	$userData = $oAuth->userinfo_v2_me->get();
	// echo "<pre>";
	// var_dump($userData);
	// storing data to session array fro further acces of data
	$_SESSION['email'] = $userData['email'];
	$_SESSION['gender'] = $userData['gender'];
	//$_SESSION['picture'] = $userData['picture'];
	$_SESSION['id'] = $userData['id'];
	$_SESSION['givenName']=$userData['givenName'];
	$id=$_SESSION['id'];
	//$_SESSION['birthday'] = $userData['birthday'];
	$name=$_SESSION['givenName'];
	$email= $_SESSION['email'];
	$gender= $_SESSION['gender'];
	$chk=mysql_query("SELECT email FROM google WHERE email='$email'");
	$nmrow=mysql_num_rows($chk);
	if($nmrow<=0 )
	{
		mysql_query("INSERT INTO google (email,gender,name) values ('$email','$gender','$name')") or die (mysql_error());
	}


// now as we have access token and also all the data we want so let the user access the site or any desire page
	header("Location:voter_dashboard.php?$email");
	exit();
?>