<?php
if($_SESSION['auth'] !='agency')
{
	header("Location:".BASEURL);
}
?>