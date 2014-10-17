<?php include('../common/agencyauth.php'); ?>
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
            <?php include('agency_settings.php'); ?>
			<!--  end account-content -->
		
		</div>
		<!-- end nav-right -->


		<!--  start nav -->
		<div class="nav">
		<div class="table">
		
		<ul class="select"><li><a href='<?php echo $_SESSION['basemodule'];?>'><b>Dashboard</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href='#nogo'>&nbsp;</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		
        <?php if($_SESSION['admin_previlage']==1){ ?>
		<div class="nav-divider">&nbsp;</div>
		                    
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'user.php'; ?>"><b>Users</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="<?php echo $_SESSION['basemodule'].'adduser.php'; ?>">Add</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		<?php } ?>

		<div class="nav-divider">&nbsp;</div>
		                    
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'pilgrim.php';?>"><b>Pilgrim</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="<?php echo $_SESSION['basemodule'].'newpilgrim.php'; ?>">Add</a></li>
				<li><a href="<?php echo $_SESSION['basemodule'].'pilgrimupload.php'; ?>">Upload CSV</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		
<!--		<div class="nav-divider">&nbsp;</div>
		
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'carriers.php'; ?>"><b>Carrier</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
<!--		<div class="select_sub">
			<ul class="sub">
				<li>&nbsp;</li>
			</ul>
		</div>
-->		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
<!--		</li>
		</ul>
-->
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="current"><li><a href="<?php echo $_SESSION['basemodule'].'book.php'; ?>"><b>Eticket</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
		<?php 	if($_SESSION['access_right']!=3){ ?>
				<li><a href="<?php echo $_SESSION['basemodule'].'edit_eticket.php'; ?>">Edit Eticket</a></li>
        <?php  } ?>        
				<li>&nbsp;</li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>

		<div class="nav-divider">&nbsp;</div>
		
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'boardingpass.php'; ?>"><b>Boarding Pass</b><!--[if IE 7]><!--></a><!--<![endif]-->
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
		
		<ul class="select"><li><a href="<?php echo $_SESSION['basemodule'].'registerpilgrimaccomodation.php'; ?>"><b>Accomodation</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li>&nbsp;</li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>


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
