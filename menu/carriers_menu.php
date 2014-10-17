<?php include('../common/carrierauth.php');  ?>
<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat"> 
<!--  start nav-outer -->
<div class="nav-outer"> 

		<!-- start nav-right -->
		<div id="nav-right">
		
			<div class="nav-divider">&nbsp;</div>
			<div class="showhide-account"><img src="../images/shared/nav/nav_myaccount.gif" width="93" height="14" alt="" /></div>
			<div class="nav-divider">&nbsp;</div>
			<a href="<?php echo COMMON.'logout.php'; ?>" id="logout"><img src="../images/shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
			<div class="clear">&nbsp;</div>
		
			<!--  start account-content -->	
            <?php include('carriers_settings.php'); ?>
			<!--  end account-content -->
		
		</div>
		<!-- end nav-right -->

		<!--  start nav -->
		<div class="nav">
		<div class="table">

<?php if($_SESSION['cid']==2){ ?>
		
		<ul class="current"><li><a href="<?php echo $_SESSION['basemodule']; ?>"><b>Dashboard</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="<?php echo $_SESSION['basemodule'].'geticket.php'; ?>">Generate E-ticket</a></li>
				<li><a href="<?php echo $_SESSION['basemodule'].'gboardingpass.php'; ?>">Generate Boarding Pass</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		
        <?php if($_SESSION['admin_previlage']==1){ ?>
		<div class="nav-divider">&nbsp;</div>
		                    
		<ul class="select"><li><a href="<?php echo CARRIERS.'user.php';?>"><b>Users</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="<?php echo CARRIERS.'adduser.php'; ?>">Add</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		<?php } ?>
	
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="select"><li><a href="<?php echo CARRIERS.'flights.php'; ?>"><b>Flights</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="<?php echo CARRIERS.'addflights.php'; ?>">New</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="select"><li><a href="<?php echo CARRIERS.'agency.php'; ?>"><b>Agency</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li>&nbsp;</li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>


		<div class="nav-divider">&nbsp;</div>
		
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'reports.php'; ?>"><b>Reports</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="<?php echo $_SESSION['basemodule'].'manifest.php'; ?>">Manifest</a></li>
				<li><a href="<?php echo $_SESSION['basemodule'].'boardingreport.php'; ?>">Boarding Confirmation</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>

		<div class="nav-divider">&nbsp;</div>
<?php } ?>
<?php if(($_SESSION['cid']==2)|| ($_SESSION['cid']==5)){ ?>
		
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'luggage.php'; ?>"><b>Luggage</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="<?php echo $_SESSION['basemodule'].'registeredluggage.php'; ?>">Registered</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>

		<div class="nav-divider">&nbsp;</div>		
<?php } ?>
<?php if(($_SESSION['cid']==2)|| ($_SESSION['cid']==6)){ ?>
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'bconfirmation.php'; ?>"><b>Confirm </b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="<?php echo $_SESSION['basemodule'].'confirmationlist.php'; ?>">Confirmation List</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
<?php } ?>

		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div>
		<!--  start nav -->

</div>
<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->
 
 <div class="clear"></div>
