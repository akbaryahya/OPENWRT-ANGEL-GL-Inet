<?php
session_start();
$show="home";
exec('grep user /root/passwd |awk -F" " \'{print $2}\'',$user);
exec('grep passwd /root/passwd |awk -F" " \'{print $2}\'',$pass);
 
if ($_GET['login']) {

     if ($_POST['username'] == $user[0]
         && $_POST['password'] == $pass[0]) {
 
         $_SESSION['loggedin'] = 1;
 
         header("Location: status.php");
         exit;

     } else 
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		$ip = $_SERVER['REMOTE_ADDR'];
		}
		$username = "Username: ".$_POST['username']."\r\n";
		$password = "Password: ".$_POST['password']."\r\n";
		$ip = "IP: ".$ip;
		$separator = "===============================================";
		$tanggal = "Tanggal: ".exec('date +%d-%m-%Y_%H:%M:%S',$date)."\r\n";
		$useragent = "\r\nUser Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
		exec("echo \"$tanggal$username$password$ip$useragent$separator\" >> /www/profile/failed-login-attempt.log");
		echo '
			<script type="text/javascript">
				alert("Username atau Password salah!");
			</script>';
}
/*if(isset($_POST['lanjutkan'])){
	$separator = "=======================================";
	$tanggal = "Tanggal: ".exec('date +%d-%m-%Y_%H:%M:%S',$date)."\r\n";
	$useragent = "User Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
	$ip = "IP: ".$_SERVER['REMOTE_ADDR']."\r\n";
	$name = "Nama: ".$_POST['name']."\r\n";
	$fb = "Facebook: ".$_POST['facebook']."\r\n";
	if (strpos($_POST['facebook'],'facebook.com') == false) {
		echo'<script type="text/javascript">
				alert("Format alamat facebook salah!");
			 </script>';
		exit();
	}
	$ip = "IP: ".$_SERVER['REMOTE_ADDR']."\r\n";
	exec("echo \"$tanggal$name$fb$useragent$ip$separator\" >> /www/profile/failed-login-attempt.log");
	exec('uci get sms_gateway.setting.failedlogin',$hp);
	exec("gsm sms send xxx \"FAILED LOGIN ATTEMPT: ".$_POST['name']."//".$_POST['facebook']."//".$_POST['ip']."\" & ");
	header("Location: http://s10.postimg.org/mrqjwtsah/image.jpg");
}*/

	echo '
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
window.setTimeout("scrollTitle()",300);
}
scrollTitle();
</script>
<style type="text/css">
body {
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	background-image: url(images/angel-beats-login.jpg);
	background-repeat: no-repeat;
	margin: auto;
	width: auto;
	height: auto;
	display: table;
	text-align:center;
}
.TextBox {
	-moz-border-radius:30px;
	-webkit-border-radius:30px;
	border-radius:30px;
	border: #solid 10px #000;
	background-color: rgba(255,255,255,0.5);
	width:auto;
	height:auto;
	margin-left: auto ;
	margin-right: auto ;
	display: inline-block
}
.TextBox:after {
    content:"\a \00a0 ";
}
.glow{
	font-size:16px;
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
</style>
</head>
<body>
<a href="http://www.facebook.com/galihpa" target="_blank">
  <img src="/images/header.png" alt="OpenWrt Angel Beats! Edition">
</a>
<br><br><br>
<div class="TextBox">';
if ($show == "home"){
	echo'
<h2>LOGIN</h2>
<br>
<br>
<form action="?login=1" method="post">
Username: <input type="text" autofocus name="username" />
</br>
</br>
Password: <input type="password" name="password" />
</br>
</br>
<input type="submit" value="Login" />
</div>';
}
/*if ($show == "login-gagal"){
	echo '
	<h2>LOGIN BERHASIL</h2>
	<br>
	<br>
	<b>Masukkan nama dan alamat facebook anda<br>untuk melanjutkan</b><br><br>
	<form action="" method="post">
	Nama:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" autofocus name="name" />
	</br>
	</br>
	Facebook: <input type="text" name="facebook" placeholder="http://www.facebook.com/xxx" />
	</br>
	</br>
	<input type="submit" name="lanjutkan" value="Lanjutkan" />
	</div>';
}*/

function foot() {
echo '<div class="glow"><strong>OpenWrt Angel Beats! Edition (v1.6.6)<br>Copyright © Mikodemos 2014 - Modified by Galih</strong></div>';
}
foot();
echo '
</div>
</body>
</html>';
?>