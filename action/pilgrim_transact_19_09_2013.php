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
		$db->query("SELECT pilgrim_id FROM pilgrims WHERE passport_no='".mysql_real_escape_string($_POST['passport_no'])."'");
		if($db->total()==0)
		{
			$id = generateid();			
			if($db->query("INSERT INTO `pilgrims` (`pilgrim_id` ,`full_name` ,`passport_no` ,`lga` ,`state` ,`sex` ,`dob` ,`registration_date` ,`zone`,`agency`,`mno`,`pilgrim_status`,`status`,`nationality`)VALUES ('".$id."', '".mysql_real_escape_string($_POST['full_name'])."', '".mysql_real_escape_string($_POST['passport_no'])."', '".$_POST['lga']."', '".$_POST['state']."', '".$_POST['sex']."', '".$_POST['dob']."' ,CURRENT_TIMESTAMP , '', '".mysql_real_escape_string($_POST['agency'])."', '".mysql_real_escape_string($_POST['mno'])."', '".mysql_real_escape_string($_POST['pilgrim_status'])."','Active', '".$_POST['nationality']."')
	")){
				notify('success','Pilgrim has been registered successfully');
				$pilgrim_id = $id;
	
				$image_status = 1;
				
			}else{
				notify('fail','Pilgrim cannot able to get registered contact Administrator');	
				$pilgrim_id='';
			}
		}else
		{
			notify('fail','Pilgrim Already exists');	
			$pilgrim_id='';		
		}
	break;
	case 'edit':
	
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['pilgrim_id']))
				{
					if($_POST['submit']=='Update')
					{						
						$db->query("SELECT * FROM pilgrims WHERE passport_no = '".mysql_real_escape_string(trim($_POST['passport_no']))."' AND pilgrim_id !=('".$_POST['pilgrim_id']."')");	
						if($db->total()==0)
						{							
									$db->query("UPDATE `pilgrims` SET `full_name` = '".mysql_real_escape_string(trim($_POST['full_name']))."',
		`passport_no` = '".mysql_real_escape_string(trim($_POST['passport_no']))."',
		`lga` = '".mysql_real_escape_string(trim($_POST['lga']))."',
		`agency` = '".mysql_real_escape_string(trim($_POST['agency']))."',
		`mno` = '".mysql_real_escape_string(trim($_POST['mno']))."',
		`state` = '".mysql_real_escape_string(trim($_POST['state']))."',
		`sex` = '".mysql_real_escape_string(trim($_POST['sex']))."',
		`pilgrim_status` = '".mysql_real_escape_string(trim($_POST['pilgrim_status']))."',
		`dob` = '".mysql_real_escape_string(trim($_POST['dob']))."' WHERE `pilgrims`.`pilgrim_id` = '".$_POST['pilgrim_id']."' ");							
								notify('success', 'Piigrim has been Updated sucessfully');
								$pilgrim_id = $_POST['pilgrim_id'];	
								$image_status = 1;						
						}else
						{
							notify('fail','Pilgrim Already exists');
						}
					}else{
						
						$db->query("DELETE FROM pilgrims WHERE `pilgrims`.`pilgrim_id` = '".$_POST['pilgrim_id']."'");
						notify('success','Pilgrim has been deleted successfully');
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


$savefolder = '../image_content/pilgrim/pilgrim_images';		// folder for upload
$savefolder_th = '../image_content/pilgrim/pilgrim_images_th';		// folder for upload
$savefolder_icon = '../image_content/pilgrim/pilgrim_images_icon';		// folder for upload
$max_size = 2500;			// maxim size for image file, in KiloBytes


//$link = $savefolder.'/'.$row['image'];

// Allowed image types
$allowtype = array('bmp', 'gif', 'jpg', 'jpeg', 'gif', 'png');

/** Uploading the image **/
$rezultat = '';
// if is received a valid file
if ($_FILES['pilgrims_image']['name']!='') {
	
 // checks to have the allowed extension
  $type = end(explode(".", strtolower($_FILES['pilgrims_image']['name'])));
  if (in_array($type, $allowtype)) {
    // check its size
	if ($_FILES['pilgrims_image']['size']<=$max_size*1000) {
      // if no errors
      if ($_FILES['pilgrims_image']['error'] == 0) {


/*****CHECK FOR THE EXISTING IMAGE**********/
		$run = $db->query("SELECT image FROM pilgrims WHERE pilgrim_id='".$pilgrim_id."'");
		$row = $db->fetch($run);
		  
		$image_completename = $pilgrim_id.'.'.$type;
//        $thefile = $savefolder . "/" . $_FILES['myfile']['name'];
        $thefile = $savefolder . "/".$image_completename;
		$db->query("UPDATE `pilgrims` SET image='".$type."' WHERE `pilgrim_id` ='".$pilgrim_id."'");
		if($row['image']!='')
		{
			$path = $savefolder.'/'.$pilgrim_id.'.'.$row['image'];
			$path_th = $savefolder_th.'/'.$pilgrim_id.'.'.$row['image'];
			$path_icon = $savefolder_icon.'/'.$pilgrim_id.'.'.$row['image'];
			unlink($path);
			unlink($path_th);
			unlink($path_icon);
		}
        // if the file can`t be uploaded, return a message
        if (!move_uploaded_file ($_FILES['pilgrims_image']['tmp_name'], $thefile)) {
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
    $image->target_path = '../image_content/pilgrim/pilgrim_images_th/'.$image_completename;
    $image_icon->target_path = '../image_content/pilgrim/pilgrim_images_icon/'.$image_completename;

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
header('Location:'.$_SESSION['basemodule'].'pilgrim.php?latestid='.$pilgrim_id);
?>