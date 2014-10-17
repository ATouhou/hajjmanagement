<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Internet Dreams</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen" title="default" />
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->

<!--  jquery core -->
	<link rel="stylesheet" href="../css/smoothness/jquery.ui.all.css">
	<script src="../js/jquery-1.7.1.js"></script>
	<script src="../js/jquery/jquery.ui.core.js"></script>
	<script src="../js/jquery/jquery.ui.widget.js"></script>
	<script src="../js/jquery/jquery.ui.position.js"></script>
	<script src="../js/jquery/jquery.ui.autocomplete.js"></script>
	<script src="../js/jquery/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../css/demos.css">


 
<!--  checkbox styling script -->



<![if !IE 7]>
<!--jquery to pick dates -->	
<script>
	$(function() {
    var yearRange = $( ".selector" ).datepicker( "option", "yearRange" );
    //setter
		$( "#datepicker" ).datepicker({
			yearRange: "c-60:c" ,						  
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
		});	
		$( "#date1" ).datepicker({
			yearRange: "c:c+1" ,						  
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
		});	
		$( "#date2" ).datepicker({
			yearRange: "c:c+1" ,						  
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
		});	
	});
	</script> 
<![endif]>



<!--  styled file upload script --> 
<script src="../js/jquery/jquery.filestyle.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
$(function() {
	$("input.file_1").filestyle({ 
	image: "images/forms/upload_file.gif",
	imageheight : 29,
	imagewidth : 78,
	width : 300
	});
});
</script>

<!-- Custom jquery scripts -->
<script src="../js/jquery/custom_jquery.js" type="text/javascript"></script>
 
<!-- Tooltips -->
<script src="../js/jquery/jquery.tooltip.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
});
</script> 

<!--  date picker script -->


<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="../js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
<!--***********script to include autocomplete******-->

	<script>
	$(function() {
		var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];
		$( "#state" ).autocomplete({
			source: availableTags
		});
	});
	</script>
<!--START FOR PRINT BUTTON-->    
<script type="text/javascript">
function printContent(id){
str=document.getElementById(id).innerHTML
newwin=window.open('','printwin','left=100,top=100,width=500,height=600')
newwin.document.write('<HTML>\n<HEAD>\n<style>h5{margin-bottom:0px;}</style>')
newwin.document.write('<TITLE>Print Page</TITLE>\n')
newwin.document.write('<script>\n')
newwin.document.write('function chkstate(){\n')
newwin.document.write('if(document.readyState=="complete"){\n')
newwin.document.write('window.close()\n')
newwin.document.write('}\n')
newwin.document.write('else{\n')
newwin.document.write('setTimeout("chkstate()",2000)\n')
newwin.document.write('}\n')
newwin.document.write('}\n')
newwin.document.write('function print_win(){\n')
newwin.document.write('window.print();\n')
newwin.document.write('chkstate();\n')
newwin.document.write('}\n')
newwin.document.write('<\/script>\n')
newwin.document.write('</HEAD>\n')
newwin.document.write('<BODY onload="print_win()">\n')
newwin.document.write(str)
newwin.document.write('</BODY>\n')
newwin.document.write('</HTML>\n')
newwin.document.close()
}
</script>
<!--END OF PRINT BUTTON-->
</head>
<body> 
<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo">
	<a href=""><!--<img src="../images/shared/logo.png" width="40" height="40" alt="" />--><font color="#FFFFFF" size="+1"> ASK AIR SERVICES NIG LTD</font></a>
	</div>
	<!-- end logo -->
	
	<!--  start top-search -->
	<div id="top-search">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td><input type="text" value="Search" onblur="if (this.value=='') { this.value='Search'; }" onfocus="if (this.value=='Search') { this.value=''; }" class="top-search-inp" /></td>
		<td>
		 
		<select  class="styledselect">
			<option value="">All</option>
			<option value="">Products</option>
			<option value="">Categories</option>
			<option value="">Clients</option>
			<option value="">News</option>
		</select> 
		 
		</td>
		<td>
		<input type="image" src="../images/shared/top_search_btn.gif"  />
		</td>
		</tr>
		</table>
	</div>
 	<!--  end top-search -->
 	<div class="clear"></div>

</div>
<!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
	
<div class="clear">&nbsp;</div>