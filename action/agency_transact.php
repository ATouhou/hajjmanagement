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
		$db->query("SELECT agency_id FROM agency WHERE agency_name='".mysql_real_escape_string($_POST['agency_name'])."'");
		if($db->total()==0)
		{
		//	$id = generateid();
			if($db->query("INSERT INTO `agency` (`agency_id` ,`agency_name` ,`agency_adminname` ,`agency_address` ,`agency_phoneno` ,`agency_url` ,`agency_status` ,`agency_date` ,`agency_logo`)VALUES (NULL , '".mysql_real_escape_string($_POST['agency_name'])."', '".mysql_real_escape_string($_POST['admin_name'])."', '".mysql_real_escape_string($_POST['address'])."', '".mysql_real_escape_string($_POST['mno'])."', '".mysql_real_escape_string($_POST['url'])."', 'Active',CURRENT_TIMESTAMP , '')"))
			{				
				notify('success','Agency has been registered successfully');
				$agency_id = $db->returnid();
	
				$image_status = 1;
				
			}else{
				notify('fail','Agency cannot able to get registered contact Administrator');	
				$agency_id=0;
			}
		}else
		{
			notify('fail','Agency Already exists');	
			$agency_id=0;
			
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{	
				if(isset($_POST['agency_id']))
				{
					$db->query("SELECT * FROM agency WHERE agency_name = '".mysql_real_escape_string(trim($_POST['agency_name']))."' AND agency_id !=('".$_POST['agency_id']."')");	
					if($db->total()==0)
					{
	
								
						$db->query("UPDATE `agency` SET `agency_name` = '".mysql_real_escape_string(trim($_POST['agency_name']))."',
	`agency_adminname` = '".mysql_real_escape_string(trim($_POST['admin_name']))."',
	`agency_address` = '".mysql_real_escape_string(trim($_POST['address']))."',
	`agency_phoneno` = '".mysql_real_escape_string(trim($_POST['mno']))."',
	`agency_url` = '".mysql_real_escape_string(trim($_POST['url']))."'
	 WHERE `agency_id` = '".$_POST['agency_id']."' ");
							notify('success', 'Agency has been Updated sucessfully');
							$agency_id = $_POST['agency_id'];
							$image_status = 1;
					}else
					{
						notify('fail','Agency Already exists');
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

// header("Location:".ADMIN.'completeregistration.php');

/*********** START OF SCRIPT TO UPLOAD IMAGES********/

if($image_status==1)
{


$savefolder = '../image_content/agency/agency_images';		// folder for upload
$savefolder_th = '../image_content/agency/agency_images_th';		// folder for upload
$savefolder_icon = '../image_content/agency/agency_images_icon';		// folder for upload
$max_size = 2500;			// maxim size for image file, in KiloBytes


//$link = $savefolder.'/'.$row['image'];

// Allowed image types
$allowtype = array('bmp', 'gif', 'jpg', 'jpeg', 'gif', 'png');

/** Uploading the image **/
$rezultat = '';
// if is received a valid file
if ($_FILES['agencys_image']['name']!='') {
	
 // checks to have the allowed extension
  $type = end(explode(".", strtolower($_FILES['agencys_image']['name'])));
  if (in_array($type, $allowtype)) {
    // check its size
	if ($_FILES['agencys_image']['size']<=$max_size*1000) {
      // if no errors
      if ($_FILES['agencys_image']['error'] == 0) {


/*****CHECK FOR THE EXISTING IMAGE**********/
		$run = $db->query("SELECT agency_logo FROM agency WHERE agency_id='".$agency_id."'");
		$row = $db->fetch($run);
		  
		$image_completename = $agency_id.'.'.$type;
//        $thefile = $savefolder . "/" . $_FILES['myfile']['name'];
        $thefile = $savefolder . "/".$image_completename;
		$db->query("UPDATE `agency` SET agency_logo='".$type."' WHERE `agency_id` ='".$agency_id."'");
		if($row['agency_logo']!='')
		{
			$path = $savefolder.'/'.$agency_id.'.'.$row['agency_logo'];
			$path_th = $savefolder_th.'/'.$agency_id.'.'.$row['agency_logo'];
			$path_icon = $savefolder_icon.'/'.$agency_id.'.'.$row['agency_logo'];
			unlink($path);
			unlink($path_th);
			unlink($path_icon);
		}
        // if the file can`t be uploaded, return a message
        if (!move_uploaded_file ($_FILES['agencys_image']['tmp_name'], $thefile)) {
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
    $image->target_path = '../image_content/agency/agency_images_th/'.$image_completename;
    $image_icon->target_path = '../image_content/agency/agency_images_icon/'.$image_completename;

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

/*********** END OF SCRIPT TO UPLOAD IMAGES********/

}else
{
	notify('fail','Agency cannot able to get registered contant Administrator');	

}
header('Location:'.ADMIN.'agency.php?latestid='.$agency_id);
?>