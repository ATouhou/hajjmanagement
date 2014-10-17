<?php if(isset($_REQUEST['ajax'])){ include('functions.php'); } ?>
<?php if(isset($_REQUEST['id']) && (base64_decode($_REQUEST['id'])!=0)){ ?>


<?php $db = new Database();// $image_th = BASEURL.'image_content/agency/agency_images_th/';
$run_latest = $db->query("SELECT * FROM eticket e RIGHT JOIN luggage l ON l.eticket_id = e.id LEFT JOIN pilgrims p USING(pilgrim_id) WHERE l.id='".base64_decode($_REQUEST['id'])."'"); 
?>
<?php $row_latest = $db->fetch($run_latest); ?>
<?php
$run_flight_info = $db->query("SELECT * FROM flights WHERE flight_id='".$row_latest['flight_id']."'");
$row_flight_info = $db->fetch($run_flight_info);

?>
<?php $luggage = explode('@',$row_latest['luggage']); ?>
	<!--  start related-activities -->
	<div id="related-activities">
		
		<!--  start related-act-top -->
		<div id="related-act-top">
		<img src="../images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<!-- end related-act-top -->
		
		<!--  start related-act-bottom -->
		<div id="related-act-bottom">
		
			<!--  start related-act-inner -->
			<div id="related-act-inner">
            
			<?php for($i=1; $i<=count($luggage); $i++){ ?>
				<div class="right">
                   <div id="print_area_<?php echo $i; ?>" style="font-size:18px;"> <img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $row_latest['passport_no'];// echo $row_latest['passport_no']; ?>" width="240" height="70" /><br /><br />
                    <?php echo $row_latest['full_name']; ?><br />
                    Passport No: <?php echo $row_latest['passport_no']; ?><br />
                    Flight No:<?php echo getflightno($row_latest['flight_id']); ?><br />
                    From <?php echo getflightlocationname($row_flight_info['source']); ?> To <?php echo getflightlocationname($row_flight_info['destination']); ?><br />
                    <?php echo 'Weight '.$luggage[$i-1].' KG '.$i.'/'.count($luggage); ?><br />
                    <p>&nbsp;</p>
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