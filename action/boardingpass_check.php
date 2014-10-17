<?php
include("../common/functions.php");

if(!isset($_SESSION['passport_no'])){ $_SESSION['passport_no']=$_POST['passport_no'];}
$db = new Database();
if(isset($_SESSION['passport_no'])){

$run_check = $db->query("SELECT bno FROM boardingpass LEFT JOIN pilgrims USING (pilgrim_id) WHERE passport_no='".$_SESSION['passport_no']."'");
	if($db->total()>0)
	{
		$row_check = $db->fetch($run_check);
		$bno = 'id1='.base64_encode($row_check['bno']);
		if($db->total()==2)
		{
			$row_check = $db->fetch($run_check);
			$bno .= '&id2='.base64_encode($row_check['bno']);			
		}		
		$link ='boardingpass.php?'.$bno;
		notify('success','Boarding Pass Generated successfully');
	}else
	{
		notify('fail','Boarding Pass Does Not Exist. Check the passport no.');		
		$link ='gboardingpass.php';	
	}
}

header('Location:'.$_SESSION['basemodule'].$link);

?>