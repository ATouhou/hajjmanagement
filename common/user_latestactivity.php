<?php if(isset($_REQUEST['latestid']) && ($_REQUEST['latestid']!='')){ ?>
<?php $image_th = BASEURL.'image_content/user/user_images_th/';
$db = new Database();
$run_latest = $db->query("SELECT * FROM users WHERE eid='".$_REQUEST['latestid']."'"); ?>
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
					<img src="<?php echo $image_th.$row_latest['eid'].'.'.$row_latest['image'];  ?>" />
					<h5>Employee Id</h5><?php echo $row_latest['eid']; ?>
					<h5>User Name</h5><?php echo $row_latest['username']; ?>
					<h5>Name</h5><?php echo $row_latest['name']; ?>
					<h5>Category</h5><?php echo getcategoryname($row_latest['cid']); ?>
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