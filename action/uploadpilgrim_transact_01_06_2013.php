<?php
include("../common/functions.php");

$db = new Database();

if(isset($_REQUEST['action']))
{

if($_POST['submit']=="Submit")
{	
$success=0;
$total = 0;
$errordata = array();
$error = array();


     $fname = $_FILES['pilgrimfile']['name'];
     
     $chk_ext = explode(".",$fname);
     
     if(strtolower($chk_ext[1]) == "csv")
     {
 
         $filename = $_FILES['pilgrimfile']['tmp_name'];
 		 $handle = fopen($filename, "r");
		 
 
         
//		 echo '<table>';
//		 while($data = fgetcsv($handle, NULL, ",")) {
// echo '<TR>';
// foreach($data as $d) {
//  echo '<TD>'.$d.'</TD>';
// }
// echo '</TR>';
//		 }
//		 
//		 echo '</table>';
		 
		 
   		
//		$data = fgetcsv($handle, 1000, ";");	
	//	print_r($data);
         while (($data = fgetcsv($handle, NULL, ",")) !== FALSE)
         {
			 print_r($data);

			$full_name = $data[0];
			$passport_no = $data[1];
			$agency = $data[2];
			$state = $data[3];
			$lga = $data[4];
			$nationality = $data[5];
			$pstatus = $data[6];
//			$dob = $data[7];
			$mno = $data[7];
			$gender = $data[8];
//CLASSES ID ARE MATCHED
			$run = $db->query("SELECT passport_no FROM pilgrims WHERE passport_no ='$data[1]' LIMIT 1");
			if($db->total()==0)
			{
				$id = generateid();			
				$data_dob = explode('-',$data[7]);
				$dob = $data_dob[2].'-'.$data_dob[1].'-'.$data_dob[0];
				if($db->query("INSERT INTO `pilgrims` (`pilgrim_id`, `full_name`, `passport_no`, `lga`, `state`, `sex`, `dob`, `registration_date`, `zone`, `agency`, `image`, `mno`, `pilgrim_status`, `status`, `nationality`) VALUES ('".$id."', '".$data[0]."', '".$data[1]."', '".$data[4]."', '".$_SESSION['agency_id']."', '".$data[8]."', '2012-10-12', CURRENT_TIMESTAMP, ' ', '".$_SESSION['agency_id']."', '', '".$data[7]."', '".$data[6]."', 'Active', '".$data[5]."')"))
				{
						
				}else
				{
					$errordata[] = $data[0]."@".$data[1]."@".$data[2]."@".$data[3]."@".$data[4];
					
				}
				
				$total ++;
			}else
			{
				$total ++;
					$errordata[] = $data[0]."@".$data[1]."@".$data[2]."@".$data[3]."@".$data[4];
			}
        }
	    notify('success',' Pilgrim Uploaded successfully');

         fclose($handle);
	}else
	{
		notify('fail','Kindly Upload it in CSV File Format');			
	}
}



}else
{
	notify('fail','Pilgrim cannot able to get registered contant Administrator');	

}

//header('Location:'.$_SESSION['basemodule'].'pilgrimupload.php?error_data='.serialize($errordata));
?>