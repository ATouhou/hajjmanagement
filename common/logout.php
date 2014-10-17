<?php
session_start();
include("../config.inc.php");
session_destroy();
header("Location:".BASEURL);
?>