<?php if(isset($_REQUEST['ajax'])){ include('functions.php'); } ?>
<?php if(isset($_REQUEST['id']) && (base64_decode($_REQUEST['id'])!=0)){ ?>


<?php 

	$db = new Database();
	$carrier_info = $db->query("SELECT * FROM carriers WHERE carriers_id='".$_SESSION['agency_id']."'");
	$row_carrierinfo = $db->fetch($carrier_info);
    $logo = '../image_content/carriers/carriers_images_th/'.$_SESSION['agency_id'].'.'.$row_carrierinfo['carriers_logo'];

$db = new Database();// $image_th = BASEURL.'image_content/agency/agency_images_th/';
$run_latest = $db->query("SELECT * FROM eticket e RIGHT JOIN luggage l ON l.eticket_id = e.id LEFT JOIN pilgrims p USING(pilgrim_id) WHERE l.id='".base64_decode($_REQUEST['id'])."'"); 




?>
<?php $row_latest = $db->fetch($run_latest); ?>
<?php
$run_flight_info = $db->query("SELECT * FROM flights WHERE flight_id='".$row_latest['flight_id']."'");
$row_flight_info = $db->fetch($run_flight_info);

?>
<?php $luggage = explode('@',$row_latest['luggage']); ?>
	<!--  start related-activities -->
	<div id="related-activities" style="width:360px;">
		
		<!--  start related-act-top -->
		<div id="related-act-top" style="width:360px;">
		<img src="../images/forms/header_related_act.gif" width="360" height="43" alt="" />
		</div>
		<!-- end related-act-top -->
		
		<!--  start related-act-bottom -->
		<div  style="width:350px;">
		
			<!--  start related-act-inner -->
			<div id="related-act-inner" style="width:340px;">
            

            
            
			<?php for($i=1; $i<=count($luggage); $i++){ ?>
				<div class="right" style="width:344px; padding-left:2px;">
                   <div id="print_area_<?php echo $i; ?>" style=" width:340px;font-size:16px;padding:4px;"> 
                   <table border="2" width="340" height="380">
                   	<tr>
                    	<td colspan="2"  style="padding:4px;">        <table>
        	<tr>
            	<td rowspan="2"><img src="<?php echo $logo; ?>" width="80" /></td>
				<td align="center"><?php echo getcarriername($_SESSION['agency_id']); ?></td>
            </tr>
            <tr>
            	<td style="padding-top:4px;"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $row_latest['passport_no']; ?>" width="240" height="70" align="right" /></td>
            </tr>
            </table>
                        </td>
                    </tr> 
                    <tr>
                    	<td colspan="2" style="padding:4px;" align="center"> <?php echo $row_latest['full_name']; ?></td>
                    </tr>
                    <tr>
                    	<td colspan="2"  style="padding:4px;" align="center">DESTINATION</td>
                    </tr>
                    <tr>
                    	<td colspan="2"  style="padding:4px;font-size:18px;" align="center"><?php echo getflightlocationname($row_flight_info['destination']); ?></td>
                    </tr>
                    <tr>
                    	<td  style="padding:4px;">FLIGHT NO.</td>
                        <td  style="padding:4px;"><?php echo getflightno($row_latest['flight_id']); ?></td>
                    </tr>
                    <tr>
                    	<td  style="padding:4px;">TICKET NO.</td>
                        <td  style="padding:4px;"><?php echo $row_latest['eno']; ?></td>
                    </tr>
                    <tr>
                    	<td  style="padding:4px;">WEIGHT</td>
                        <td  style="padding:4px;"><?php echo $luggage[$i-1].' KG '.$i.'/'.count($luggage); ?></td>
                    </tr>
                    <tr>
                    	<td  style="padding:4px;">TAG NO.</td>
                        <td><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $row_latest['passport_no'];// echo $row_latest['passport_no']; ?>" width="240" height="70" /></td>
                    </tr>
                   
                   </table>
              <!--     
                   <img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $row_latest['passport_no'];// echo $row_latest['passport_no']; ?>" width="240" height="70" /><br /><br />
                    <?php echo $row_latest['full_name']; ?><br />
                    Passport No: <?php echo $row_latest['passport_no']; ?><br />
                    Flight No:<?php echo getflightno($row_latest['flight_id']); ?><br />
                    From <?php echo getflightlocationname($row_flight_info['source']); ?> To <?php echo getflightlocationname($row_flight_info['destination']); ?><br />
                    <?php echo 'Weight '.$luggage[$i-1].' KG '.$i.'/'.count($luggage); ?><br />
                    <p>&nbsp;</p>
                    
                    -->
                    </div>
				</div>
                   <input type="button" value="PRINT" onclick="printContent('print_area_<?php echo $i; ?>')" style="padding:5px;"  />	 
                    <p>&nbsp;</p>

				<div class="clear"></div>
				<?php } ?>   
			</div>
 		<!-- end related-act-bottom -->
	
	</div>
	<!-- end related-activities -->
 <?php } ?>  