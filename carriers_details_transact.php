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


	break;
	case 'edit':
	
		$db->query("UPDATE `carriers` SET `iata_code` = '".mysql_real_escape_string($_POST['iata'])."',
`carriers_address` = '".mysql_real_escape_string($_POST['address'])."',
`email` = '".mysql_real_escape_string($_POST['email'])."',
`validity` = '".mysql_real_escape_string($_POST['validity'])."',
`terms_conditions` = '".mysql_real_escape_string($_POST['tc'])."' WHERE `carriers`.`carriers_id` =".$_SESSION['agency_id']." LIMIT 1
");
		$carriers_id= $_SESSION['agency_id'];
		$image_status = 1;
	break;
	default:
			echo "default";
	break;
}

/*********** START OF SCRIPT TO UPLOAD IMAGES********/


if($image_status==1)
{


$savefolder = '../image_content/carriers/carriers_images';		// folder for upload
$savefolder_th = '../image_content/carriers/carriers_images_th';		// folder for upload
$savefolder_icon = '../image_content/carriers/carriers_images_icon';		// folder for upload
$max_size = 2500;			// maxim size for image file, in KiloBytes


//$link = $savefolder.'/'.$row['image'];

// Allowed image types
$allowtype = array('bmp', 'gif', 'jpg', 'jpeg', 'gif', 'png');

/** Uploading the image **/
$rezultat = '';
// if is received a valid file
if ($_FILES['carriers_image']['name']!='') {
	
 // checks to have the allowed extension
  $type = end(explode(".", strtolower($_FILES['carriers_image']['name'])));
  if (in_array($type, $allowtype)) {
    // check its size
	if ($_FILES['carriers_image']['size']<=$max_size*1000) {
      // if no errors
      if ($_FILES['carriers_image']['error'] == 0) {


/*****CHECK FOR THE EXISTING IMAGE**********/
		$run = $db->query("SELECT carriers_logo FROM carriers WHERE carriers_id='".$carriers_id."'");
		$row = $db->fetch($run);
		  
		$image_completename = $carriers_id.'.'.$type;
//        $thefile = $savefolder . "/" . $_FILES['myfile']['name'];
        $thefile = $savefolder . "/".$image_completename;
		$db->query("UPDATE `carriers` SET carriers_logo='".$type."' WHERE `carriers_id` ='".$carriers_id."'");
		if($row['image']!='')
		{
			$path = $savefolder.'/'.$carriers_id.'.'.$row['image'];
			$path_th = $savefolder_th.'/'.$carriers_id.'.'.$row['image'];
			$path_icon = $savefolder_icon.'/'.$carriers_id.'.'.$row['image'];
			unlink($path);
			unlink($path_th);
			unlink($path_icon);
		}
        // if the file can`t be uploaded, return a message
        if (!move_uploaded_file ($_FILES['carriers_image']['tmp_name'], $thefile)) {
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
    $image->target_path = '../image_content/carriers/carriers_images_th/'.$image_completename;
    $image_icon->target_path = '../image_content/carriers/carriers_images_icon/'.$image_completename;

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
	notify('fail','Pilgrim cannot able to get registered contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].'details.php?latestid='.$pilgrim_id);
?>