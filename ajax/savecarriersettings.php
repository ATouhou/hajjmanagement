<?php 
include('../common/functions.php');
$db = new Database();
$data = array();

if($db->query("UPDATE  `carriers` SET  `weight` =  '".$_REQUEST['luggage']."',`amount` =  '".$_REQUEST['amount']."' WHERE `carriers_id` ='".$_SESSION['agency_id']."'"))
{
		$msg ='Settings saved successfully';
				echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
				<tr><td class=\"green-left\">
".$msg."</td>
					<td class=\"green-right\"><a class=\"close-green\"><img src=\"../images/table/icon_close_green.gif\"   alt=\"\" /></a></td>
				</tr>
				</table>";	
}else{
		$msg ='Settings cannot be saved please try again later';
	
			echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
				<tr><td class=\"red-left\">
".$msg."</td>
					<td class=\"red-right\"><a class=\"close-red\"><img src=\"../images/table/icon_close_red.gif\"   alt=\"\" /></a></td>
				</tr>
				</table>";

	
}


?>