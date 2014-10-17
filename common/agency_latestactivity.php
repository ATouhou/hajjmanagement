<?php if(isset($_REQUEST['latestid']) && ($_REQUEST['latestid']!=0)){ ?>
<?php $image_th = BASEURL.'image_content/agency/agency_images_th/';
$run_latest = $db->query("SELECT * FROM agency WHERE agency_id='".$_REQUEST['latestid']."'"); ?>
<?php $row_latest = $db->fetch($run_latest); ?>

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
			
				<div class="left"><a href=""><img src="../images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<img src="<?php echo $image_th.$row_latest['agency_id'].'.'.$row_latest['agency_logo'];  ?>" />
					<h5>Angency Name</h5><?php echo $row_latest['agency_name']; ?>
					<h5>Admin Name</h5><?php echo $row_latest['agency_adminname']; ?>
					<h5>Address</h5><?php echo $row_latest['agency_address']; ?>
					<h5>Phone No.</h5><?php echo $row_latest['agency_phoneno']; ?>
					<h5>Website</h5><?php echo $row_latest['agency_url']; ?>
				</div>
				<div class="clear"></div>
				
			</div>
			<!-- end related-act-inner -->
			<div class="clear"></div>
		
		</div>
		<!-- end related-act-bottom -->
	
	</div>
	<!-- end related-activities -->
<?php } ?>    