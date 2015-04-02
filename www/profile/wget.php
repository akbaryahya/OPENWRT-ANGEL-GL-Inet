<?php
include 'theme.php';
ceklogin();
$show="home";
if(isset($_POST['wget-send'])){
	{
		$speedlimit = $_POST['speed-limit'];
		if(empty($speedlimit)){
			$speedlimit="0";
		}
		$singlequote="'";
		$speedlimit=$singlequote.$speedlimit.$singlequote;
		$mode = $_POST['dl-mode'];
			if ($mode == "download-immediately"){
				$dir=$singlequote.$_POST['directory'].$singlequote;
				$dir=str_replace('/','\/',$dir);
				$tout=$singlequote.$_POST['timeout'].$singlequote;
				$maxret=$singlequote.$_POST['maxretry'].$singlequote;
				$phnnumber=$singlequote.$_POST['phonenumber'].$singlequote;
				$formlink=$_POST['download-link'];
				$toSave = nl2br($_POST["download-link"]);
				$simpan = str_replace('<br />', '', $toSave);
				$filelink = fopen('/www/profile/wget/wget-download-link.txt',w);
				if(!empty($dir) && empty($formlink)) {
					header( "refresh:3;url=wget.php" );
					css();
					echo "<font color=red><b>Directory or link can't be empty</b></font>";
					exit();
				}
				fwrite($filelink, $simpan. "\n");
				exec('sed -i "s,option directory.*,option directory '.$dir.',g" /etc/config/wgetui');
				exec('sed -i "s/option maxretry.*/option maxretry '.$maxret.'/g" /etc/config/wgetui');
				exec('sed -i "s/option limit.*/option limit '.$speedlimit.'/g" /etc/config/wgetui');
				exec('sed -i "s/option timeout.*/option timeout '.$tout.'/g" /etc/config/wgetui');
				exec('sed -i "s/option phonenumber.*/option phonenumber '.$phnnumber.'/g" /etc/config/wgetui');
				exec('killall wget > /dev/null 2>&1');
				exec('/etc/init.d/wgetui stop > /dev/null 2>&1');
				exec('/etc/init.d/wgetui start > /dev/null 2>&1 &');
				$show="log";
			}
			else {
				$starthour = $_POST['starthour'];
				$startminute = $_POST['startminute'];
				$stophour = $_POST['stophour'];
				$stopminute = $_POST['stopminute'];
				$singlequote="'";
				$dir=$singlequote.$_POST['directory'].$singlequote;
				$dir=str_replace('/','\/',$dir);
				$tout=$singlequote.$_POST['timeout'].$singlequote;
				$maxret=$singlequote.$_POST['maxretry'].$singlequote;
				$phnnumber=$singlequote.$_POST['phonenumber'].$singlequote;
				$formlink=$_POST['download-link'];
				$toSave = nl2br($_POST["download-link"]);
				$simpan = str_replace('<br />', '', $toSave);
				$filelink = fopen('/www/profile/wget/schedule-link.txt',w);
				if(!empty($dir) && empty($formlink)) {
					header( "refresh:3;url=wget.php" );
					css();
					echo "<font color=red><b>Directory or link can't be empty</b></font>";
					exit();
				}
				if ($starthour >= 24 or $startminute >= 60 or $stophour >= 24 or $stopminute >= 60){
					header( "refresh:3;url=wget.php" );
					css();
					echo "<font color=red><b>Time schedule is incorrect</b></font>";
					exit();
				}
				fwrite($filelink, $simpan. "\n");
				exec('sed -i "s,option directory.*,option directory '.$dir.',g" /etc/config/wgetui');
				exec('sed -i "s/option maxretry.*/option maxretry '.$maxret.'/g" /etc/config/wgetui');
				exec('sed -i "s/option limit.*/option limit '.$speedlimit.'/g" /etc/config/wgetui');
				exec('sed -i "s/option timeout.*/option timeout '.$tout.'/g" /etc/config/wgetui');
				exec("sed -i \"s/option schedule.*/option schedule 'on'/g\" /etc/config/wgetui");
				exec('sed -i "s/option phonenumber.*/option phonenumber '.$phnnumber.'/g" /etc/config/wgetui');
				exec("sed -i 's/^.*wgetui schedule-on//g' /etc/crontabs/root");
				exec("sed -i 's/^.*wgetui schedule-off//g' /etc/crontabs/root");
				exec("sed -i '/^\s*$/d' /etc/crontabs/root");
				exec("echo '$startminute $starthour * * * wgetui schedule-on' >> /etc/crontabs/root");
				exec("echo '$stopminute $stophour * * * wgetui schedule-off' >> /etc/crontabs/root");
				exec('/etc/init.d/cron restart');
				$schedule = "<font color=blue><b>Your download will start at $starthour:$startminute and end at $stophour:$stopminute<b></font>";
			}
				
	}
}
if(isset($_POST['continue-wget'])){
    {
	exec('mv /www/profile/wget/wget-download-link.done /www/profile/wget/wget-download-link.txt > /dev/null 2>&1 &');
	exec('killall wget > /dev/null 2>&1');
	exec('/etc/init.d/wgetui stop > /dev/null 2>&1');
	exec('/etc/init.d/wgetui start > /dev/null 2>&1 &');
	$show="log";
    }
	}
if(isset($_POST['stop-wget'])){
    {
	exec('killall wget > /dev/null 2>&1');
	exec('/etc/init.d/wgetui stop > /dev/null 2>&1');
	exec('echo "<br><font color=black><b>Wget is not running...</b></font>" >> /www/profile/wget.log');
	$show="log";
    }
	}
if(isset($_POST['delete-schedule'])){
    {
	exec('wgetui schedule-off');
	$show="schedule-list";
    }
	}
if(isset($_POST['wget-log'])){
    {
	$show="log";
    }
	}
if(isset($_POST['schedule-list'])){
    {
	$show="schedule-list";
    }
	}
if(isset($_POST['wget-webui'])){
    {
	$show="home";
    }
	}
css();
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "wget_status.txt",
                success: function(result) {
                    $("#status").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
        }, 1000);
    });
</script>';
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "wget.log",
                success: function(result) {
                    $("#show").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("show");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
exec('uci get wgetui.setting.directory',$directory);
exec('uci get wgetui.setting.maxretry',$maxretry);
exec('uci get wgetui.setting.limit',$limit);
exec('uci get wgetui.setting.timeout',$timeout);
exec('uci get wgetui.setting.phonenumber',$phonenumber);
echo '<form action='.$_SERVER['PHP_SELF'].' method="post">';
if ( $show == "home" ) {
exec('date +%H',$hour);
exec('date +%M',$minute);
echo '
<div id="SideBySide" style="margin-left:6px;">
	<div class="sub">Download Directory:<br>
		<input type="text" name="directory" size="15" value="'.$directory[0].'">
	</div>
	<div class="sub">Timeout:<br>
		<input type="text" name="timeout" size="5" placeholder="seconds" value="'.$timeout[0].'">
	</div>
	<div class="sub">Speed Limit:<br>
		<input type="text" name="speed-limit" size="5" placeholder="kBps" value="'.$limit[0].'">
	</div>
	<div class="sub">Max Retry:<br>
		<input type="text" name="maxretry" size="5" value="'.$maxretry[0].'">
	</div>
	<div class="sub">Phone Number:<br>
		<input type="text" name="phonenumber" size="15" value="'.$phonenumber[0].'">
	</div>
</div>
<br><br>Download link (one URL per line):<br>
<textarea name="download-link" placeholder="Paste your download links here, one URL per line for multiple URLs. 
If you put in your phone number, in the phone number field, you will be notified on download completion and download failure. 
Leave it blank if you don\'t want any download notifications
Download directory will be created automatically if it doesn\'t exist" autofocus rows="13" cols="90" style="font-family: Arial;font-size: 9pt;"></textarea><br>
<div align="left">
<input type="radio" name="dl-mode" value="download-immediately" checked>Download immediately<br>
<input type="radio" name="dl-mode" value="schedule-download">Schedule download 
(Start: <input type="text" name="starthour" size="1" value='.$hour[0].' placeholder="hour"><input type="text" name="startminute" size="2" value='.$minute[0].' placeholder="minute"> 
Stop: <input type="text" name="stophour" size="1" value='.$hour[0].' placeholder="hour"><input type="text" name="stopminute" size="2" value='.$minute[0].' placeholder="minute">)
</div>
<div style="font-size:9pt;">
<b>The schedule download is in 24 hours format. Use "00" to download at midnight.</b>
</div>';
}
if ( $show == "log" ){
echo '<font color="blue"><b>Wget Log:</b></font>
<div class="ConnectionBox">
	<code>
	<div id="show" style="font-size: 11px;  word-wrap: break-word; white-space: pre-wrap; word-break: break-all; width:550px;height:195px;border:0px solid #000;text-align:left; overflow-y: scroll;">
	</div>
	</code>
</div>';
}
if ( $show == "schedule-list" ){
exec('uci get wgetui.setting.schedule',$scheduleon);
exec('grep "wgetui schedule-on" /etc/crontabs/root | awk \'{ print $2 }\'',$mulaijam);
exec('grep "wgetui schedule-on" /etc/crontabs/root | awk \'{ print $1 }\'',$mulaimenit);
exec('grep "wgetui schedule-off" /etc/crontabs/root | awk \'{ print $2 }\'',$stopjam);
exec('grep "wgetui schedule-off" /etc/crontabs/root | awk \'{ print $1 }\'',$stopmenit);
echo '<font color="blue"><b>Schedule download is '.$scheduleon[0].'<br>';
echo '<div align="left">
Start: '.$mulaijam[0].':'.$mulaimenit[0].'<br>
Stop: '.$stopjam[0].':'.$stopmenit[0].'</b></font>
</div>
<br>Link List:<br>
<code>
<textarea name="download-link" readonly rows="10" cols="78" style="font-family: Arial;font-size: 9pt;">
';
echo file_get_contents( "/www/profile/wget/schedule-link.txt" );
echo '</textarea><br></code>
<input type="submit" name="delete-schedule" value="Delete Schedule Download"><br>';
}
echo $warning[0];
echo '
<br>
<input type="submit" name="wget-webui" value="Wget WebUI">
<input type="submit" name="continue-wget" value="Continue">
<input type="submit" name="wget-send" value="Start">
<input type="submit" name="stop-wget" value="Stop">
<input type="submit" name="wget-log" value="Log">
<input type="submit" name="schedule-list" value="Schedule List">
</form>
'.$schedule.'
</div>';
foot();
echo '
</body>
</html>';
?>