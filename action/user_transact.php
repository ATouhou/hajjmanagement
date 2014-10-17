<?php
include("../common/functions.php");
//require("../database/db.class.php");
require('../imagelibrary/Zebra_Image.php');
$image_status=0;

$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT uid FROM users WHERE username='".mysql_real_escape_string($_POST['username'])."'");
		if($db->total()==0)
		{
			$id = $_POST['eid'];
			if(($_POST['category'] ==1) || ($_POST['category'] ==4) || ($_POST['category'] ==7)){   $agency_id=0; $access_right=1;  }else{ $agency_id = $_POST['agency_id']; $access_right = $_POST['access_right']; }
			if($_SESSION['cid']==1){ $admin = 1; }else{ $admin=0; }
			
			
			if($db->query("INSERT INTO `users` (`uid` ,`username` ,`password` ,`cid` ,`status` ,`eid` ,`name` ,`image` ,`admin`,`createdby`,`agency_id`,`access_right`)VALUES (NULL , '".mysql_real_escape_string($_POST['username'])."', SHA1( '".mysql_real_escape_string($_POST['password'])."' ), '".mysql_real_escape_string($_POST['category'])."', 'Active', '".mysql_real_escape_string($_POST['eid'])."', '".mysql_real_escape_string($_POST['full_name'])."', '', '".$admin."','".$_SESSION['uid']."' , ".$agency_id.",'".$access_right."')")){
				notify('success','User has been registered successfully');
				$user_id = $id;
	
				$image_status = 1;
				
			}else{
				notify('fail','User cannot able to get registered contact Administrator');	
				$user_id='';
			}
		}else
		{
			notify('fail','User Already exists');	
			$user_id='';		
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['user_id']))
				{
					$db->query("SELECT * FROM users WHERE username = '".mysql_real_escape_string(trim($_POST['username']))."' AND uid !=('".$_POST['user_id']."')");	
					if($db->total()==0)
					{
	
	//			if($_POST['category'] !=2){   $agency_id=0;  }else{ $agency_id = $_POST['agency_id']; }
				if($_POST['category'] ==1){ $agency_id=0; $access_right=1; }else{ $agency_id = $_POST['agency_id']; $access_right= $_POST['access_right']; }
	
	$run_check = $db->query("SELECT password FROM users WHERE uid='".$_POST['user_id']."'");					
	$row_check = $db->fetch($run_check);
	$password = $row_check['password'];
	if($password != $_POST['password'])
	{
	$password = sha1($_POST['password']);	
	}
								
								$db->query("UPDATE `users` SET `username` = '".mysql_real_escape_string(trim($_POST['username']))."',
	`password` = '".$password."',
	`cid` = '".mysql_real_escape_string(trim($_POST['category']))."',
	`name` = '".mysql_real_escape_string(trim($_POST['full_name']))."',
	`agency_id` ='".$agency_id."',
	`access_right` ='".$access_right."',
	`createdby` = '".$_SESSION['uid']."' WHERE `users`.`uid` = '".$_POST['user_id']."' ");
								
							notify('success', 'User has been Updated sucessfully');
							$user_id = $_POST['eid'];
							$image_status = 1;
							
							
					}else
					{
						notify('fail','user Already exists');
					}
				}else
				{
					notify('fail',"Cannnot be updated contact administrator");	
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");		
			}
	break;
	default:
			echo "default";
	break;
}

/*********** START OF SCRIPT TO UPLOAD IMAGES********/

if($image_status==1)
{


$savefolder = '../image_content/user/user_images';		// folder for upload
$savefolder_th = '../image_content/user/user_images_th';		// folder for upload
$savefolder_icon = '../image_content/user/user_images_icon';		// folder for upload
$max_size = 2500;			// maxim size for image file, in KiloBytes


//$link = $savefolder.'/'.$row['image'];

// Allowed image types
$allowtype = array('bmp', 'gif', 'jpg', 'jpeg', 'gif', 'png');

/** Uploading the image **/
$rezultat = '';
// if is received a valid file
if ($_FILES['users_image']['name']!='') {
	
 // checks to have the allowed extension
  $type = end(explode(".", strtolower($_FILES['users_image']['name'])));
  if (in_array($type, $allowtype)) {
    // check its size
	if ($_FILES['users_image']['size']<=$max_size*1000) {
      // if no errors
      if ($_FILES['users_image']['error'] == 0) {


/*****CHECK FOR THE EXISTING IMAGE**********/
		$run = $db->query("SELECT image FROM users WHERE eid='".$user_id."'");
		$row = $db->fetch($run);
		  
		$image_completename = $user_id.'.'.$type;
//        $thefile = $savefolder . "/" . $_FILES['myfile']['name'];
        $thefile = $savefolder . "/".$image_completename;
		$db->query("UPDATE `users` SET image='".$type."' WHERE `eid` ='".$user_id."'");
		if($row['image']!='')
		{
			$path = $savefolder.'/'.$user_id.'.'.$row['image'];
			$path_th = $savefolder_th.'/'.$user_id.'.'.$row['image'];
			$path_icon = $savefolder_icon.'/'.$user_id.'.'.$row['image'];
			unlink($path);
			unlink($path_th);
			unlink($path_icon);
		}
		
		//echo 'the file path is'.$thefile;
        // if the file can`t be uploaded, return a message
        if (!move_uploaded_file ($_FILES['users_image']['tmp_name'], $thefile)) {
          $msg = 'The file can`t be uploaded, try again';
        }
        else {
			
/********SCRIPT TO CREATE THUMBNAIL*************/
    $image = new Zebra_Image();
	$image_icon = new Zebra_Image();
    // indicate a source image (a GIF, PNG or JPEG file)
    $image->source_path = $thefile;
    $image_icon->source_path = $thefile;

    // indicate a target image
    // note that there's no extra property to set in order to specify the target
    // image's type -simply by writing '.jpg' as extension will instruct the script
    // to create a 'jpg' file
    $image->target_path = '../image_content/user/user_images_th/'.$image_completename;
    $image_icon->target_path = '../image_content/user/user_images_icon/'.$image_completename;

    // since in this example we're going to have a jpeg file, let's set the output
    // image's quality
    $image->jpeg_quality = 100;
    $image_icon->jpeg_quality = 100;

    // some additional properties that can be set
    // read about them in the documentation
    $image->preserve_aspect_ratio = true;
    $image->enlarge_smaller_images = true;
    $image->preserve_time = true;
    $image_icon->preserve_aspect_ratio = true;
    $image_icon->enlarge_smaller_images = true;
    $image_icon->preserve_time = true;

    // resize the image to exactly 100x100 pixels by using the "crop from center" method
    // (read more in the overview section or in the documentation)
    //  and if there is an error, check what the error is about
//	 $image->flip_horizontal();
     $image->resize(200, 135, ZEBRA_IMAGE_CROP_CENTER);
     $image_icon->resize(35, 25, ZEBRA_IMAGE_CROP_CENTER);
          // Return the img tag with uploaded image.
          $msg = 'The profile has been updated successfully';
        }
      }
    }
	else {  $msg = 'Image File exceed the Mazimum permitted size'; }
  }
  else { $msg = 'Image File has not an allowed extension'; }
}

}
//echo $msg;
	
/*********** END OF SCRIPT TO UPLOAD IMAGES********/

}else
{
	notify('fail','user cannot able to get registered contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].'user.php?latestid='.$user_id);
?>