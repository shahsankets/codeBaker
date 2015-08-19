<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="624" valign="middle" height="70" style="font-size:35px; margin-left:10px; font-family: Tahoma, Arial; ">&nbsp;&nbsp;Using MySQLi
	<?php if(preg_match('/^index.php/',end(explode('/',$_SERVER['REQUEST_URI']))) || end(explode('/',$_SERVER['REQUEST_URI']))=='' || $_REQUEST['back']){} else{?>
	<div style="float:right; width:300px; margin-right:45px; ">
		<span style="font-size:14px; color:#0099FF; font-family:'Trebuchet MS', Tahoma;">
		<font style="font-size:12px; color:#999; ">Welcome </font><?php echo substr($_SESSION['sess_username'],0,15); ?>!</span>
		 <a href="logout.php" style="font-size:11px; color:#FF0000; font-family:Arial, Helvetica, sans-serif; text-decoration:none; text-align:right; float:right; ">Log Out</a>
		<br/><span id="servertime" style="font-size:12px; color:#999; font-family:Arial, Helvetica, sans-serif; "></span>
	</div>
	<?php }?>
	</td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="21" align="left" valign="middle" class="adminGrey"><img src="images/securedAdminSuite.jpg" width="147" height="5" /></td>
  </tr>
</table>
<script type="text/javascript"  src="codelibrary/js/jquery1.7.js"></script>
<script type="text/javascript">
$().ready(function(e){
$(document).keypress(function(e){
var c= e.keyCode || e.which; 
	if(c==27){
		$("td.rightBorder").fadeIn(100);
		$("table.title").find('img[src$="images/heading_icon.gif"]').attr("title","Click for Full Screen");
	}
})
	$("table.title").find('img[src$="images/heading_icon.gif"]').attr("title","Click for Full Screen");
	$("table.title").find('img[src$="images/heading_icon.gif"]').click(function(){
		var ds=$("td.rightBorder").css("display");
		if(ds=='none'){
			$("td.rightBorder").fadeIn(100);
			$(this).attr("title","Click for Full Screen");
		} else{
			$("td.rightBorder").fadeOut(500);
			$(this).attr("title","Click for Original Screen(esc)");
		}
	});
	})
var currenttime = '<?php echo date("M d, Y H:i:s");?>' //PHP method of getting server date
var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
var serverdate=new Date(currenttime);

function padlength(what){
	var output=(what.toString().length==1)? "0"+what : what
	return output
}

function displaytime(){
	serverdate.setSeconds(serverdate.getSeconds()+1)
	var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
	var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
	document.getElementById("servertime").innerHTML=datestring+" "+timestring
}

window.onload=function(){
	setInterval("displaytime()", 1000)
}
</script>
