<?php
include("../common/functions.php");

if(!isset($_SESSION['passport_no'])){ $_SESSION['passport_no']=$_POST['passport_no'];}
$db = new Database();
if(isset($_SESSION['passport_no'])){

$run_check = $db->query("SELECT eno FROM eticket LEFT JOIN pilgrims USING (pilgrim_id) WHERE passport_no='".$_SESSION['passport_no']."'");
	if($db->total()>0)
	{
		$row_check = $db->fetch($run_check);
		$eno = $row_check['eno'];
		$link ='eticket.php?id='.base64_encode($eno);
		notify('success','E-ticket Generated successfully');
	}else
	{
		notify('fail','E-ticket Does Not Exist. Check the passport no.');		
		$link ='geticket.php';	
	}
}

header('Location:'.$_SESSION['basemodule'].$link);

?>