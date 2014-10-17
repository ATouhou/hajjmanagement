<?php
session_start();
ob_start();
include("../database/db.class.php");
//$_SESSION['uid']=3;
//$_SESSION['cid']=3;
$patient_status = array('I'=>'Incomplete','A'=>'Active','D'=>'Deactive','C'=>'Complete',);
$arr_month=array('01'=>"Jan",'02'=>"Feb",'03'=>"Mar",'04'=>"Apr",'05'=>"May",'06'=>"Jun",'07'=>"Jul",'08'=>"Aug",'09'=>"Sep",'10'=>"Oct",'11'=>"Nov",'12'=>"Dec");			
$month_num=array('Jan'=>"01",'Feb'=>"02",'Mar'=>"03",'Apr'=>"04",'May'=>"05",'Jun'=>"06",'Jul'=>"07",'Aug'=>"08",'Sep'=>"09",'Oct'=>"10",'Nov'=>"11",'Dec'=>"12");			
$albhates=array(1=>"A",2=>"B",3=>"C",4=>"D",5=>"E",6=>"F",7=>"G",8=>"H",9=>"I",10=>"J",11=>"K",12=>"L",13=>"M",14=>"N",15=>"O",16=>"P",17=>"Q",18=>"R",19=>"S",20=>"T",21=>"U",22=>"V",23=>"W",24=>"X",25=>"Y",26=>"Z");
if(!isset($_SESSION['nationality']))
{
	$_SESSION['nationality']= array('Afghan','Albanian','Algerian','American','Andorran','Angolan','Antiguans','Argentinean','Armenian','Australian','Austrian','Azerbaijani','Bahamian','Bahraini','Bangladeshi','Barbadian','Barbudans','Batswana','Belarusian','Belgian','Belizean','Beninese','Bhutanese','Bolivian','Bosnian','Brazilian','British','Bruneian','Bulgarian','Burkinabe','Burmese','Burundian','Cambodian','Cameroonian','Canadian','Cape Verdean','Central African','Chadian','Chilean','Chinese','Colombian','Comoran','Congolese','Costa Rican','Croatian','Cuban','Cypriot','Czech','Danish','Djibouti','Dominican','Dutch','East Timorese','Ecuadorean','Egyptian','Emirian','Equatorial Guinean','Eritrean','Estonian','Ethiopian','Fijian','Filipino','Finnish','French','Gabonese','Gambian','Georgian','German','Ghanaian','Greek','Grenadian','Guatemalan','Guinea-Bissauan','Guinean','Guyanese','Haitian','Herzegovinian','Honduran','Hungarian','I-Kiribati','Icelander','Indian','Indonesian','Iranian','Iraqi','Irish','Israeli','Italian','Ivorian','Jamaican','Japanese','Jordanian','Kazakhstani','Kenyan','Kittian and Nevisian','Kuwaiti','Kyrgyz','Laotian','Latvian','Lebanese','Liberian','Libyan','Liechtensteiner','Lithuanian','Luxembourger','Macedonian','Malagasy','Malawian','Malaysian','Maldivan','Malian','Maltese','Marshallese','Mauritanian','Mauritian','Mexican','Micronesian','Moldovan','Monacan','Mongolian','Moroccan','Mosotho','Motswana','Mozambican','Namibian','Nauruan','Nepalese','New Zealander','Nicaraguan','Nigerian','Nigerien','North Korean','Northern Irish','Norwegian','Omani','Pakistani','Palauan','Panamanian','Papua New Guinean','Paraguayan','Peruvian','Polish','Portuguese','Qatari','Romanian','Russian','Rwandan','Saint Lucian','Salvadoran','Samoan','San Marinese','Sao Tomean','Saudi','Scottish','Senegalese','Serbian','Seychellois','Sierra Leonean','Singaporean','Slovakian','Slovenian','Solomon Islander','Somali','South African','South Korean','Spanish','Sri Lankan','Sudanese','Surinamer','Swazi','Swedish','Swiss','Syrian','Taiwanese','Tajik','Tanzanian','Thai','Togolese','Tongan','Trinidadian/Tobagonian','Tunisian','Turkish','Tuvaluan','Ugandan','Ukrainian','Uruguayan','Uzbekistani','Venezuelan','Vietnamese','Welsh','Yemenite','Zambian','Zimbabwean');		
}




function notify($type,$message)
{

	$_SESSION['type']=$type;
	$_SESSION['notify'] = $message;
	
}
function notification()
{
	if(isset($_SESSION['notify']))
	{
		if($_SESSION['type']=='fail')
		{
			$msg = $_SESSION['notify'];
			unset($_SESSION['notify']);
			echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
				<tr><td class=\"red-left\">
".$msg."</td>
					<td class=\"red-right\"><a class=\"close-red\"><img src=\"../images/table/icon_close_red.gif\"   alt=\"\" /></a></td>
				</tr>
				</table>";
		}else
		{
			$msg = $_SESSION['notify'];
			unset($_SESSION['notify']);
			echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
				<tr><td class=\"green-left\">
".$msg."</td>
					<td class=\"green-right\"><a class=\"close-green\"><img src=\"../images/table/icon_close_green.gif\"   alt=\"\" /></a></td>
				</tr>
				</table>";
		}
	}
}
function generateid()
{
	$db = new Database();
	$run = $db->query("SELECT MAX(CAST(SUBSTR( pilgrim_id , -5 ) AS SIGNED)) id FROM `pilgrims`");
	$row = $db->fetch($run);
	$id = 'P'.str_pad($row['id']+1,5,0,STR_PAD_LEFT);
	return $id;
}

function generateeid()
{
	$db = new Database();
	$run = $db->query("SELECT MAX(CAST(SUBSTR( eid , -4 ) AS SIGNED)) id FROM `users`");
	$row = $db->fetch($run);
	$id = 'EMP'.str_pad($row['id']+1,4,0,STR_PAD_LEFT);
	return $id;
}
/***********FUNCTIONS FOR USER************/
function getuserstatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT status FROM users WHERE uid='".$id."'");
	$row = $db->fetch($run);
	return $row['status'];
}
function getusername($id)
{
	$db = new Database();
	$run = $db->query("SELECT username FROM users WHERE uid='".$id."'");
	$row = $db->fetch($run);
	return $row['username'];
}

/*********FUNCITONS FOR PILGRIMS ***********/


function getpilgrimstatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT status FROM pilgrims WHERE pilgrim_id='".$id."'");
	$row = $db->fetch($run);
	return $row['status'];
}

function getpilgrimmno($id)
{
	$db = new Database();
	$run = $db->query("SELECT mno FROM pilgrims WHERE pilgrim_id='".$id."'");
	$row = $db->fetch($run);
	return $row['mno'];
}


function getlgastatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT status FROM lga WHERE lga_id='".$id."'");
	$row = $db->fetch($run);
	return $row['status'];
}

function getlganame($id)
{
	$db = new Database();
	$run = $db->query("SELECT lga_name FROM lga WHERE lga_id='".$id."'");
	$row = $db->fetch($run);
	return $row['lga_name'];
}
function getagencystatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT agency_status FROM agency WHERE agency_id='".$id."'");
	$row = $db->fetch($run);
	return $row['agency_status'];
}
function getcarriersstatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT carriers_status FROM carriers WHERE carriers_id='".$id."'");
	$row = $db->fetch($run);
	return $row['carriers_status'];
}

function getstatename($id)
{
	$db = new Database();
	$run = $db->query("SELECT state_name FROM state WHERE state_id='".$id."'");
	$row = $db->fetch($run);
	return $row['state_name'];
}
function getstatestatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT status FROM state WHERE state_id='".$id."'");
	$row = $db->fetch($run);
	return $row['status'];
}
function getcategoryname($id)
{
	$db = new Database();
	$run = $db->query("SELECT cname FROM category WHERE cid='".$id."'");
	$row = $db->fetch($run);
	return $row['cname'];
}

/*********FUNCITONS FOR FLIGHTS ***********/

function getcarriername($id)
{
	$db = new Database();
	$run = $db->query("SELECT carriers_name FROM carriers WHERE carriers_id='".$id."'");
	$row = $db->fetch($run);
	return $row['carriers_name'];	
}

function getflightno($id)
{
	$db = new Database();
	$run = $db->query("SELECT flight_no FROM flights WHERE flight_id='".$id."'");
	$row = $db->fetch($run);
	return $row['flight_no'];	
}
function getflightlocationname($id)
{
	$db = new Database();
	$run = $db->query("SELECT location_name FROM carriers_location WHERE location_id='".$id."'");
	$row = $db->fetch($run);
	return $row['location_name'];
}
function getlocationstatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT status FROM carriers_location WHERE location_id='".$id."'");
	$row = $db->fetch($run);
	return $row['status'];
}
function getterminalname($id)
{
	$db = new Database();
	$run = $db->query("SELECT name FROM terminals WHERE id='".$id."'");
	$row = $db->fetch($run);
	return $row['name'];
}

function getterminalstatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT status FROM terminals WHERE id='".$id."'");
	$row = $db->fetch($run);
	return $row['status'];
}
function getflightstatus($id)
{
	$db = new Database();
	$run = $db->query("SELECT status FROM flights WHERE flight_id='".$id."'");
	$row = $db->fetch($run);
	return $row['status'];
}
function getflightseats($id)
{
	$seats = array();
	$db = new Database();
	$run = $db->query("SELECT seats FROM aircraft WHERE aircraft_id=(SELECT aircraft_id FROM flights WHERE flight_id='".$id."')");
	$row = $db->fetch($run);
	$seats = explode(',',$row['seats']); 
	return count($seats);
}
function getflightmodel($id)
{
	$db = new Database();
	$run = $db->query("SELECT model FROM aircraft WHERE aircraft_id=(SELECT aircraft_id FROM flights WHERE flight_id='".$id."')");
	$row = $db->fetch($run);
	return $row['model'];
}

function getcustomcarriername($flight_no,$iata_code)
{
	$db = new Database();
	$run = $db->query("SELECT * FROM flights LEFT JOIN carriers ON flights.agency_id=carriers.carriers_id WHERE flight_no='".$flight_no."'");
	$row = $db->fetch($run);
	return serialize($row);
		
	
}


function getremaningseats($id)
{
	$sum =0;
	$db = new Database();
	$total_seats = getflightseats($id);
	$run = $db->query("SELECT SUM(seat_allocated) seat_allocated FROM agency_seat_allocation WHERE flight_id=".$id."");
	//while($row = $db->fetch($run))
//	{
//		$sum += $row['seat_allocated'];	
//	}
	$row = $db->fetch($run);
	$sum = $row['seat_allocated'];
	$left = $total_seats - $sum;
	return $left;
}



function sendsms($mno,$type,$eno)
{
	$db = new Database();
	$run = $db->query("SELECT * FROM eticket LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE eno='".$eno."'");
	$row = $db->fetch($run);
	$carrier_id = $row['carrier_id'];
	$flight_id = $row['flight_id'];
	$run = $db->query("SELECT date1, flight_no FROM flights WHERE flight_id='".$row['flight_id']."' LIMIT 1");
	$row_flight = $db->fetch($run);
	$flight_no = $row_flight['flight_no'];
	$date = $row_flight['date1'];
	
	$owneremail="Sorondinki128@yahoo.com";
	$subacct="Almuhrim";
	$subacctpwd="123456";
	$sendto=$mno; /* destination number */
	$sender="Almuhrim"; /* sender id */
	if($type='eticket')
	{
		$msg = "Your e-ticket ".$eno." is valid for travel on ".$date.".Any change must be notified within 24hours. Thank you for chosen ".getcarriername($carrier_id);
	//	$msg="The E-ticket number is ".$eno; /* message to be sent */
		
	}
/* create the required URL */
$url = "http://www.smslive247.com/http/index.aspx?"."cmd=sendquickmsg"."&owneremail=".urlencode($owneremail)."&subacct=".urlencode($subacct). "&subacctpwd=".urlencode($subacctpwd)."&message=".urlencode($msg)."&sender=".urlencode('Almuhrim')."&sendto=".urlencode($mno)."&msgtype=0";

/* call the URL */
if ($f = @fopen($url, "r"))
{
$answer = fgets($f, 255);
if (substr($answer, 0, 1) == "+")
{
	$error = "SMS to $dnr was successful.";
}
else
{
	$error = "an error has occurred: [$answer].";
}
}
else
{
 	$error = "Error: URL could not be opened.";
}	
		
}



?>