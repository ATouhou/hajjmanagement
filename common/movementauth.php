<?php
if($_SESSION['auth'] !='movement')
{
	header("Location:".BASEURL);
}
?>