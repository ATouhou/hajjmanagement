<?php
if($_SESSION['auth'] !='custom')
{
	header("Location:".BASEURL);
}
?>