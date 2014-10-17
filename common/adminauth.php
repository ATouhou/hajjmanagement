<?php
if($_SESSION['auth'] !='admin')
{
	header("Location:".BASEURL);
}
?>