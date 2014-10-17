			<div class="account-content">
			<div class="account-drop-inner">
				<a href="<?php echo $_SESSION['basemodule'].'carriersettings.php'; ?>" id="acc-settings">Settings</a>
				<div class="clear">&nbsp;</div>
        <?php if($_SESSION['admin_previlage']==1){ ?>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo $_SESSION['basemodule'].'details.php'; ?>" id="acc-details">Account Details </a>
				<div class="clear">&nbsp;</div>
		<?php } ?>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo $_SESSION['basemodule'].'terminals.php'; ?>" id="acc-details">Terminal</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo $_SESSION['basemodule'].'locations.php'; ?>" id="acc-details">Locations</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo $_SESSION['basemodule'].'aircraft.php'; ?>" id="acc-details">Aircraft</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-inbox">Inbox</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-stats">Reports</a> 
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="<?php echo BASEURL.'common/cpasswd.php'; ?>" id="acc-settings">Change Password</a>
			</div>
			</div>
