<?php
include("../common/functions.php");
$db = new Database();
$msg='';
$username ='';
//print_r($_POST);
//echo $_POST['username'];
//echo $_POST['password'];
if(isset($_POST['signin']))
{
	if(!empty($_POST['username']) || !empty($_POST['password']))
	{
//		$username = $_POST['username'];
		$run = $db->query("SELECT * FROM users WHERE username='".$_POST['username']."' AND password ='".sha1($_POST['password'])."' AND status='Active'")or die(mysql_error());
		$num = $db->total();
		if($num>0)
		{
			$row = mysql_fetch_assoc($run);
			$_SESSION['username'] = $row['username'];
			$_SESSION['cid']= $row['cid'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['uid'] = $row['uid'];
			$_SESSION['user_id'] = $row['uid'];
			$_SESSION['access_right'] = $row['access_right'];
			$_SESSION['admin_previlage'] = $row['admin'];
			if($_SESSION['cid']==1)
			{
				$_SESSION['auth'] ="admin";			
				$redirect = ADMIN;
			}elseif($_SESSION['cid']==2 || $_SESSION['cid']==5 || $_SESSION['cid']==6 )
			{	
				$_SESSION['agency_id'] = $row['agency_id'];
				$_SESSION['auth'] ="air-carriers";			
				$redirect = CARRIERS;				
			}elseif($_SESSION['cid']==3)
			{
				$_SESSION['agency_id'] = $row['agency_id'];
				$_SESSION['auth'] ="agency";			
				$redirect = AGENCY;
			}elseif($_SESSION['cid']==4)
			{
				$_SESSION['auth'] ="custom";			
				$redirect = CUSTOM;
			}elseif($_SESSION['cid']==7)
			{
				$_SESSION['auth'] ="saudi";			
				$redirect = SAUDI;
			}elseif($_SESSION['cid']==8)
			{
				$_SESSION['agency_id'] = $row['agency_id'];
				$_SESSION['auth'] ="movement";			
				$redirect = MOVEMENT;
			}else
			{
				$redirect = BASEURL;
			}
		}else
		{
			$msg = "Username/Password does not match";
			notify('fail',$msg);
			$redirect = BASEURL;
		}
	}else
	{
		$msg = "Please enter the required fields";
		notify('fail',$msg);
		$redirect = BASEURL;
	}

notification();
//print_r($_SESSION);

$_SESSION['basemodule'] = $redirect;

//echo $_SESSION['basemodule'];
header("Location:$redirect");

}


?>