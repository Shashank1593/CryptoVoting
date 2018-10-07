<?php
// immporting config file for session info and other
require_once 'config.php';
// checking if any session is start
if(!isset($_SESSION))
    {
        session_start();
    }
// checkin if access token is available in session or not, if not then redirect to login page else continue permission
if(!isset($_SESSION['access_token']))
{
    header("Location:../voterlgn.php");
    exit();
}
include 'dbsele.php';
$elcname=$_POST['elecnm'];
// $elcname=$_REQUEST['elcnm'];
$qrye="SELECT name,id FROM election WHERE elecname='$elcname'";

?>
<html>
<head>
    <link rel="icon" href="favicon.png" type="image/png" sizes="32x32" >
	<title>VOTER DASHBOARD</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/overwrite.css">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/new1.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet" />
    <style type="text/css">
    	.innerin{
        height:1000px ;
        width: 100%;
        border: 20px solid #0BA9F9;
    }
    	}
    </style>
</head>
<body><header id="header">
        <nav class="navbar navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../index.php">Crypto<b>VOTING</b></a>voter
                </div>              
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="voter_dashboard.php">Home</a></li> 
                        <li><a href="logout.php">Logout</a></li>                       
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->       
    </header>
    <!--/header-->
    
    <div class="innerin">
    	<div class="gaps"></div>
    	<div class="leftrow2">
    		<div class="row">
                <div class="text-center">
                    <h3 padding-top="330px"><?php echo "Voting for  $elcname" ;?></h3>
    		</div ></div>
    		<script type="text/javascript">
    			function formvalid() {

    						if(document.forms.votedto.value=='')
    						{
    							alert("PLEASE! MAKE A CHOICE");
    							return false;
    						}
    			}
    		</script>
    		<form class="form2" method="POST" action="" name="forms" onsubmit="return(formvalid())">
    				<?php 
                    $qrye="SELECT name,id FROM election WHERE elecname= '$elcname'";
                    $res9=mysql_query($qrye);
    					while($row=mysql_fetch_array($res9,MYSQL_BOTH))
    					{
    				?>
    				<input type="radio" name="votedto" value="<?php echo $row['id'] ?>">
    				<label class="lable"><?php echo $row['name'] ?></label>

 		  			<br><br>
    				<?php } ?>
    				<div class="sbmtbtn">
                    	<input type="submit" name="submit2" class="btn btn-primary btn-lg" value="VOTE" />
                     </div>
                     <input class="hiddeninput" type="text" name="elecnm" value="<?php echo $elcname ?>" readonly>
                     
    			</form>

    		</div>

    	</div>

</body>
</html>
<?php
	
	
if(isset($_POST['submit2']))
	{
        // getting election name from voter and storing in $elcnm1 to use further
        $elcnm1=$_POST['elecnm'];
        $em=$_SESSION['email'];
        //saving value from voted data by user this value is aadhar number of candidate
		$votedto=$_POST['votedto'];
		// selecting candidate id by users voted data and election name
		$elecvalue="SELECT $elcnm1 FROM google where email='$em'";
		$voteres=mysql_query($elecvalue); 
		// storing qry result for matching column to check if voted,,row2 is for voters table election name value
		$row2 =mysql_fetch_array($voteres,MYSQL_BOTH);
		// echo $row2["$elcnm1"];
		// $val=0;
		
		if($row2["$elcnm1"]==0 || $row2["$elcnm1"]=='')
			{	//voting and storing id of candidate in election name area in voter table
		 		$qry3 = "UPDATE google SET $elcnm1='$votedto' WHERE email ='$em'";
		 		$chk=mysql_query($qry3) or die("error updting voters ".mysql_error());
		 		if(!$chk)
                    {
                        echo "error";
                    }
                else
                    {
                        $qry4="UPDATE election SET votecount=votecount+1 WHERE id=$votedto";
		 		       mysql_query($qry4) or die ("error counting votes".mysql_error());
                    }
		 	$msg1="Voted ! Thank You For Voting";
			echo "<script type='text/javascript'>alert('$msg1');";
			echo "window.location='voter_dashboard.php'";
			echo "</script>";
			}
		else{
			$msg="You Have Alredy Voted";
            ?>
			<script type='text/javascript'>alert('<?php echo $msg ?>');;
			 window.location='voter_dashboard.php';
			 </script>
        <?php
			}
	
}


?>
