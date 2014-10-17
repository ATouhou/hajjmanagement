<?php
include('../config.inc.php');
 class Database
 {
   var  $conn;
  	var  $links;
  	var $result;
    public function Database()
    {
      $this->conn=mysql_pconnect(DB_SERVER,DB_USER,DB_PASS);
	  $this->links=mysql_select_db(DB_DATABASE,$this->conn);
    }
  
   public function fetchall($tbl,$conditon=1)
   {
  
     $this->result=mysql_query("select * from $tbl where ".$conditon."") or print mysql_error();
	 if($this->total()>0)
	 {
	  while($d=mysql_fetch_array($this->result))
	  {
	 	$data[]=$d;
	  }
      return $data;
	 }
	return array();
   }
   
   public function query($sql)
   {
     $this->result=mysql_query($sql) or print mysql_error();
	  return $this->result;
   }
   
   public function total()
   {
      $row=mysql_num_rows($this->result) or print mysql_error();
	  return $row;
   }
   
    public function fetch($res)
   {
      $row=mysql_fetch_assoc($res) or print mysql_error();
	  return $row;
   }
   
   public function fetchone($tbl,$cond)
   {
	  $sql="select * from $tbl where ".$cond;
      $this->result=mysql_query($sql) or print mysql_error();
	  if(mysql_num_rows($this->result) >0)
	  {
	  	$d=mysql_fetch_array($this->result);
	  	return $d;
	  } 	
   }
   
   public function insert($tbl,$data)
   {
  	
		foreach ($data as $key => $value)
		$items[]="$key='$value'";
		$str="Insert into ".$tbl." set ".implode(',',$items);
		mysql_query($str) or print mysql_error();
		return mysql_insert_id();
   }
   
   public function returnid()
   {
		return mysql_insert_id();
   }
   
   public  function update($tbl,$data,$cond)
   {
  		foreach ($data as $key => $value)
		$items[]="$key='$value'";
	    $str="Update ".$tbl." set ".implode(',',$items)." where ".$cond;
		mysql_query($str);
   }
   
   public  function delete($tbl,$cond)
   {
  	
	   $sqld="delete from $tbl where ".$cond;
	   mysql_query($sqld);
   } 	 
    
	public  function multidel($tbl,$cond) 
	{
	
    $sql = "DELETE FROM $tbl WHERE ".$cond;
       mysql_query($sql); 
   
    }
}
///////////////////////////////////////////////////////////

 function redirect($url)
   {
  	header('location:'.$url);	
   }
 
 // for SMS sending
// function sendsms($mobile,$mobile_message)
//	{
//		$url="http://122.166.5.17/desk2web/SendSMS.aspx";
//		
//		$fields="UserName=weforon123&";
//		$fields.="password=weforon123&";
//		$fields.="MobileNo=".$mobile."&";
//		$fields.="SenderID=WEFORON&CDMAHeader=WEFORON&";
//		$fields.="Message=".$mobile_message."&";
//		$fields.="isFlash=FALSE";
//		
//		$geturl=$url."?".$fields;
//		$request = curl_init(); // initiate curl object
//		curl_setopt($request, CURLOPT_URL, $geturl); // set to 0 to eliminate header info from response
//		$post_response = curl_exec($request); 
//		curl_close($request);
//	}
?>