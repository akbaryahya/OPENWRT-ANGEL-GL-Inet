<?php
function ceklogin(){
    session_start();
if (($_SESSION['loggedin'] != 1) || isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
	header("Location: login.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}
?>
<?php function css(){ ?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" type="image/png" href="favicon.png">
<script type="text/javascript"> 
var msg = "OpenWrt Angel Beats! Edition";
msg = " | " + msg;pos = 0;
function scrollTitle() {
document.title = msg.substring(pos, msg.length) + msg.substring(0, pos); pos++;
if (pos > msg.length) pos = 0
window.setTimeout("scrollTitle()",100);
}
scrollTitle();
</script>
<style type="text/css">
body {
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	background-image: url(images/angel-beats-bg1.jpg);
	background-repeat: no-repeat;
	margin: auto;
	width: auto;
	height: auto;
	display: table;
	text-align:center;
}
.MenuBox {
	-moz-border-radius:30px;
	-webkit-border-radius:30px;
	border-radius:30px;
	border: #solid 10px #000;
	background-color: rgba(255,255,255,0.5);
	width:auto;
	height:auto;
	margin-left: auto ;
	margin-right: auto ;
	padding:10px;
	display: inline-block
}
.glow{
	font-size:16px;
	font-color:black;
	color:black;
    transition: all 0.3s ease-in;
    text-decoration:none;
}
.glow:hover{
	-webkit-stroke-width: 5.3px;
    -webkit-stroke-color: #FFFFFF;
    -webkit-fill-color: #FFFFFF;
    text-shadow: 1px 0px 20px purple;
	color: #FF0000;
}
.wordwrap { 
   white-space: pre-wrap;      /* CSS3 */   
   white-space: -moz-pre-wrap; /* Firefox */    
   white-space: -pre-wrap;     /* Opera <7 */   
   white-space: -o-pre-wrap;   /* Opera 7 */    
   word-wrap: break-word;      /* IE */
}
input {
    border: 0px solid white; 
    -webkit-box-shadow: 
      inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
    -moz-box-shadow: 
      inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
    box-shadow: 
      inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
    padding: 5px;
    background: rgba(255,255,255,0.5);
}
input, textarea {
    border: 0px solid purple; 
    -webkit-box-shadow: 
      inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 6px rgba(0,0,0,0.1); 
    -moz-box-shadow: 
      inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
    box-shadow: 
      inset 0 0 8px  rgba(0,0,0,0.1),
            0 0 16px rgba(0,0,0,0.1); 
	background-color: rgba(255, 255, 255, 0.5);
}
input[type=submit] {
	padding:5px 15px; 
	background-color: rgba(255, 255, 255, 0.5);
	border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
}
input[type=submit]:hover {
	padding:5px 15px; 
	background-color: rgba(255, 255, 255, 1);
	border: #solid 5px #FF0000;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
}
#SideBySide 
{
    text-align:center;
    display:inline-block;
}
#SideBySide .sub
{
    float:left;
    margin-right:10px;
}
.ConnectionBox
{

}
.ConnectionBox:hover
{
	background-color: rgba(255, 255, 255, 0.7);
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	border: #solid 5px #000;
}
</style> 
</head>
<body>
<a href="http://www.facebook.com/galihpa" target="_blank">
  <img src="/images/header.png" alt="OpenWrt Angel Beats! Edition">
</a>
<strong> 
<div class="glow">
<p>
<a href="status.php" style="text-decoration:none;"><font color="black">Status</font></a> | 
<a href="wget.php" style="text-decoration:none;"><font color="black">Wget WebUI</font></a> | 
<a href="terminal.php" style="text-decoration:none;"><font color="black">Terminal</font></a> | 
<a href="wifi.php" style="text-decoration:none;"><font color="black">WiFi</font></a> | 
<a href="ch_pass.php" style="text-decoration:none;"><font color="black">Password</font></a> | 
<a href="profile.php" style="text-decoration:none;"><font color="black">Profile</font></a> | 
<a href="vpn.php" style="text-decoration:none;"><font color="black">OpenVPN</font></a> | 
<a href="ussd.php" style="text-decoration:none;"><font color="black">USSD</font></a> | 
<a href="sms.php" style="text-decoration:none;"><font color="black">SMS</font></a> | 
<a href="ping.php" style="text-decoration:none;"><font color="black">Ping Loop</font></a>
</p>
<p>
<a href="#" style="text-decoration:none;" id="agbe"><font color="black">GL-inet</font></a> | 
<a href="video.php" style="text-decoration:none;"><font color="black">Video Player</font></a> | 
<a href="mp3.php" style="text-decoration:none;"><font color="black">MP3 Player</font></a> | 
<a href="log.php" style="text-decoration:none;"><font color="black">Log</font></a> | 
<a href="about.php" style="text-decoration:none;"><font color="black">About</font></a>
</p>
</div>
<script>
var ip = location.host;	
var del80 = ip.replace(/:81/g,'');	
var abgb = document.getElementById("agbe");
abgb.href = "http://"+del80+""
</script>
</strong>
<div class="MenuBox">
<?php } ?>
<?php
function foot() {
echo '<div class="glow"><strong>OpenWrt Angel Beats! Edition (v1.6.6)<br>Dibuat Mikodemos,Diedit oleh Galih dan Siakbary</strong></div>';
}
?>