			<div class="account-content">
			<div class="account-drop-inner">
				<a href="" id="acc-settings">Settings</a>
				<div class="clear">&nbsp;</div>
<!--				<div class="acc-line">&nbsp;</div>
				<a href="<?php // echo ADMIN.'agency.php'; ?>" id="acc-details">Agency details </a>
				<div class="clear">&nbsp;</div>
-->				
				<?php if($_SESSION['access_right']!=3){ ?>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo ADMIN.'carriers.php'; ?>" id="acc-details">Carriers details </a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo ADMIN.'state.php'; ?>" id="acc-project">State details</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo ADMIN.'lga.php'; ?>" id="acc-project">Lga details</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-inbox">Inbox</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-stats">Reports</a> 
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
                <?php } ?>
				<a href="<?php echo BASEURL.'common/cpasswd.php'; ?>" id="acc-settings">Change Password</a>
			</div>
			</div>
