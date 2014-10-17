<?php
session_start();
//	header('Content-type: application/octet-stream');
//	header("Content-Disposition: attachment; filename=\"".substr($_REQUEST['file'], strpos($_REQUEST['file'], "/"))."\";"); 
//	$file_link = $_REQUEST['file'];
	
//FULL NAME	PASSPORT NO	AGENCY ID	STATE ID	LGA ID	NATIONALITY	PASSENGER STATUS	BIRTH DATE	MOBILE NUMBER	GENDER
	
		$filename = "pilgrim_sheet";
		$csv_output ='';
		$csv_output .="FULL NAME,";
		$csv_output .="PASSPORT NO,";
		$csv_output .="AGENCY ID,";
		$csv_output .="STATE ID,";
		$csv_output .="LGA ID,";	
		$csv_output .="NATIONALITY,";		
		$csv_output .="PASSENGER STATUS(Child/Adult/Infant),";		
//		$csv_output .="BIRTH DATE(DD-MM-YYYY),";		
		$csv_output .="MOBILE NUMBER,";		
		$csv_output .="GENDER(Male/Female),";		
		$csv_output .= "\n";
		
		
		$csv_output .=",";
		$csv_output .=",";
		$csv_output .=$_SESSION['agency_id'].",";
		$csv_output .=$_SESSION['agency_id'].",";
		$csv_output .="0,";	
		$csv_output .="Nigerian,";		
		$csv_output .=",";
//		$csv_output .=",";
		$csv_output .=",";
		$csv_output .=",";
	
	
	
	        header("Content-type: application/vnd.ms-excel");
            header("Content-disposition: csv" . date("Y-m-d") . ".csv");
            header( "Content-disposition: filename=".$filename.".csv");
            print $csv_output;
           exit;
	
	
	
	
//	$file = fopen($file_link, 'r');
//	
//	$theData = fread($file, filesize($file_link));
//	fclose($file);
//	echo $theData;
?>