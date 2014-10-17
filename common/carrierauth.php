<?php
if($_SESSION['auth'] !='air-carriers')
{
	header("Location:".BASEURL);
}
?>