<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_common.php');
	$db= new Database();
	$run = $db->query("SELECT * FROM carriers WHERE carriers_id='".$_SESSION['agency_id']."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
	}



?>
<script type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options

		mode : "exact",
		elements :"tc",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,",
//		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

 <script type="text/javascript">
 function pagination(val)
{
	var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		    document.getElementById('create_pilgrim_table').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/aircraft_table.php?val="+val,true);
xmlhttp.send();
}
/*******SCRIPT FOR CHAGNING THE STATUS OF PILGRIM********/
function changepilgrimstatus(action,pilgrim_id,pilgrim_status)
{
	var xmlhttp;
	var res =true;

	if(action=='status')
	{
		if(pilgrim_status=='Active')
		{
			 res = window.confirm('Deactivate Pilgrim Status.\n    Are you sure?');
		}else
		{
			 res = window.confirm('Activate Pilgrim Status.\n    Are you sure?');
		}
	}
	if(res==true)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
//		alert('final');
		document.getElementById(panel).innerHTML=xmlhttp.responseText;
    }
  }
//  alert('before finale');
   var panel = 'status_'+pilgrim_id;
//	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" /></center></div>';  
xmlhttp.open("GET","../ajax/changepilgrimstatus.php?pilgrim_id="+pilgrim_id+"&action="+action,true);
xmlhttp.send();
}
	
}

function displayinfo(id)
{
	
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {		
		document.getElementById(panel).innerHTML=xmlhttp.responseText;
    }
  }
//  alert('before finale');
  var panel = 'display_pilgriminfo';
//	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" /></center></div>';  
xmlhttp.open("GET","../common/pilgrim_latestactivity.php?latestid="+id+"&action=disp",true);
xmlhttp.send();
	

}
 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Setting</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="../images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="../images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
        <?php notification(); ?>

		<!-- start id-form -->
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/carriers_details_transact.php?action=<?php if(isset($_REQUEST['user_id'])){ echo "add";}else { echo "edit"; }?>" id="regisfrm" onSubmit="return checkfrm(this);" >
<?php
//	echo "<input type='hidden' name='user_id' value='".$_REQUEST['user_id']."'>";
//	echo "<input type='hidden' name='eid' value='".$row['eid']."'>";
?>
<input type="hidden" name="category" id="category" value="<?php echo $_SESSION['cid']; ?>" />
<input type="hidden" name="agency_id" id="agency_id" value="<?php echo $_SESSION['agency_id']; ?>" />
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  <tr>
    <th valign="top">Admin Name:</th>
    <td><?php echo $row['carriers_adminname']; ?> </td>
    <td></td>
  </tr>
	    <tr>
			<th valign="top">IATA Code:</th>
			<td><input name="iata" type="text" class="input-medium" id="iata" value="<?php echo $row['iata_code']; ?>"  /></td>
			<td><div id="error_full_name"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Address:</th>
		  <td><label>
		    <textarea name="address" id="address" cols="40" rows="3"><?php echo $row['carriers_address']; ?></textarea>
		  </label></td>
		  <td><div id="error_username"></div></td>
		  </tr>	
	    <tr>
	      <th valign="top">Email Id:</th>
	      <td><input name="email" type="text" class="input-medium" id="email"  value="<?php echo $row['email']; ?>" /></td>
	      <td><div id="error_password"></div></td>
	      </tr>
	    <tr>
	      <th valign="top">Ticket Validity</th>
	      <td><input name="validity" type="text" class="input-medium" id="validity" value="<?php echo $row['validity']; ?>" /></td>
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <th valign="top">Terms &amp; Conditions:</th>
	      <td><label>
	        <textarea name="tc" id="tc" cols="40" rows="4"><?php echo $row['terms_conditions']; ?></textarea>
	      </label></td>
	      <td><div id="error_cpassword"></div></td>
	      </tr>
	    <tr>
	      <th>Logo :</th>
	      <td><label>
	        <input type="file" name="carriers_image" id="carriers_image" />
	        </label></td>
	      <td><div class="bubble-left"></div>
	        <div class="bubble-inner">JPEG, GIF 5MB max per image</div>
	        <div class="bubble-right"></div>
          </td>
        </tr>  
		<tr>
	  <th>&nbsp;</th>
	  <td valign="top">
	    <input type="submit" value="Submit" class="form-submit" />
	    <input type="reset" value="" class="form-reset"  />
	    </td>
	  <td></td>
	  </tr>
	</table>
        </form>

		<!-- end id-form  -->















	</td>
	<td>
    <div id="display_pilgriminfo">
       <?php include('../common/pilgrim_latestactivity.php'); ?>
    </div>    
</td>
</tr>
<tr>
<td><img src="../images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>









 





<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->

 

<div class="clear">&nbsp;</div>

<?php include('../common/footer.php'); ?>