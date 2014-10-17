<?php
if($_SESSION['auth'] !='saudi')
{
	header("Location:".BASEURL);
}
?>