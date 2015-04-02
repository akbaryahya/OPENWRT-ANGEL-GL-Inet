<?php
include 'theme.php';
ceklogin();
css();
$show="home";
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "failed-login-attempt.log",
                success: function(result) {
                    $("#failed-login-attempt").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
        }, 1000);
    });
</script>';
if(isset($_POST['failed-login-attempt'])){
	{
	$show="failed-login-attempt";
	}
	}
if(isset($_POST['delete-failed-login-attempt'])){
	{
	exec('echo "" > /www/profile/failed-login-attempt.log');
	$show="failed-login-attempt";
	}
	}
echo '
<div style="width:355px;height:auto;padding-top:15px;padding-bottom:15px;border:1px solid #000;text-align:center;">';
if ($show == "home"){
exec('profile hw-info',$out);
exec('df -h / | tail -1 | awk \'{print $4}\'',$rom);
exec('cat /proc/meminfo | awk \'/MemFree/ {print $2,$3}\'',$ram);
exec('df -h /mnt/DATA | tail -1 | awk \'{print $4}\'',$mem);
exec('uptime | sed "s/^.*load/Load/"',$load);
exec('uptime | sed \'s/^.*up//;s/\([0-9][0-9]*\):\([0-9][0-9]\)*/\1 hours and \2 minutes/;s/,  load.*//\'',$uptime);
exec('uci get network.lan.ipaddr',$ip); 
$out = str_replace('Scrypt version','Script Version',$out);
$out = str_replace('Model CPU','CPU Model',$out);
$out = str_replace('Clock CPU','CPU Clock',$out);
$out = str_replace('Ram','Total RAM',$out);
$out = str_replace('Operating system','Operating System',$out);
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
echo "Free ROM : $rom[0]<br>";
echo "Free RAM : $ram[0]<br>";
echo "Free Mem (/mnt/DATA/) : $mem[0]<br>";
echo "$load[0]<br>";
echo "Uptime :$uptime[0]<br>";
echo "IP Router : $ip[0]<br><br>";
echo '
<form action='.$_SERVER['PHP_SELF'].' method="post">
	<input type="submit" name="failed-login-attempt" value="Failed Login Attempt">
</form>';
}
if ($show == "failed-login-attempt"){
	echo '
	<b>If someone else tries to log in to your router, their data will be shown here</b>
	<code>
	<div id="failed-login-attempt" class="ConnectionBox" style="font-size: 12px; padding-left: 5px; white-space: pre-wrap; word-break: break-all; word-wrap: break-word; width:350px;height:225px;border:0px solid #000;text-align:left; overflow-y: scroll;"></div>
	</code>
	<br>
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	<input type="submit" name="delete-failed-login-attempt" value="Delete Log">
	</form>';
}
echo '
</div>
</div>
</div>';
foot();
echo '
</div>
</div>
</body>
</div>
</html>';
?>
