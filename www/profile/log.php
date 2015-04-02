<?php
include 'theme.php';
ceklogin();
css();
//Javascript Untuk Dial Log
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "dial.log",
                success: function(result) {
                    $("#dial").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("dial");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
//Javascript Untuk Counter Log
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "counter.log",
                success: function(result) {
                    $("#counter").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("counter");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
//Javascript Untuk VPN Log
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "vpn.log",
                success: function(result) {
                    $("#vpn").html(result);
                }
            });
		var textarea = document.getElementById("vpn");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
//Javascript Untuk Wget Log
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "wget.log",
                success: function(result) {
                    $("#wget").html(result);
                }
            });
		var textarea = document.getElementById("wget");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
//Javascript Untuk SMS Gateway Log
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "sms-gateway.log",
                success: function(result) {
                    $("#sms-gateway").html(result);
                }
            });
		var textarea = document.getElementById("sms-gateway");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
if($_POST['restart-internet']){
    exec('profile start > /dev/null 2>&1 &');
}
if($_POST['restart-openvpn']){
	exec ('killall -9 openvpn');
    exec('cd /root/crt && openvpn /root/crt/client.conf > /dev/null &');
}
if(isset($_POST['continue-wget'])){
    {
	exec('mv /www/profile/wget/wget-download-link.done /www/profile/wget/wget-download-link.txt > /dev/null 2>&1 &');
	exec('killall wget > /dev/null 2>&1');
	exec('/etc/init.d/wgetui stop > /dev/null 2>&1');
	exec('/etc/init.d/wgetui start > /dev/null 2>&1 &');
    }
	}
if(isset($_POST['stop-wget'])){
    {
	exec('killall wget > /dev/null 2>&1');
	exec('/etc/init.d/wgetui stop > /dev/null 2>&1');
	exec('echo "<br><font color=black><b>Wget is not running...</b></font>" >> /www/profile/wget.log');
    }
	}
if(isset($_POST['start-auto-responder'])){
	{
	exec('echo "SMS Auto Responder dihidupkan" >> /www/profile/sms-gateway.log');
	exec('bash sms_gateway > /dev/null 2>&1 &');
	}
	}
if(isset($_POST['reset-modem'])){
	{
	exec('gsm at ATZ0');
	exec('gsm status');
	}
	}
if(isset($_POST['stop-auto-responder'])){
	{
	exec('killall bash');
	exec('echo "SMS Auto Responder dihentikan" >> /www/profile/sms-gateway.log');
	}
	}
exec('if pidof bash sms_gateway > /tmp/status.txt; then echo SMS Auto Responder \(On\); else echo SMS Auto Responder \(Off\); fi', $sms);
exec('uci get ping_loop.setting.status',$ping);
echo '
<div id="SideBySide">
    <div class="sub"><b>Dial Up Log</b>
	<br>
		<div class="ConnectionBox">
			<code>
			<div id="dial" style="font-size: 11px; white-space: pre-wrap; word-break: break-all; word-wrap: break-word; width:510px;height:115px;border:0px solid #000;text-align:left; overflow-y: scroll;"></div>
			</code>
		</div>
	<br>
		<form action='.$_SERVER['PHP_SELF'].' method="post">
		<input type="submit" name="restart-internet" value="Restart Internet">
		</form>
    </div>
</div>
<div id="SideBySide">
    <div class="sub"><strong>OpenVPN Log</strong>
	<br>
		<div class="ConnectionBox">
			<code>
			<div id="vpn" style="font-size: 11px; white-space: pre-wrap; word-break: break-all; word-wrap: break-word; width:510px;height:115px;border:0px solid #000;text-align:left; overflow-y: scroll;"></div>
			</code>
		</div>
	<br>
		<form action='.$_SERVER['PHP_SELF'].' method="post">
		<input type="submit" name="restart-openvpn" value="Restart OpenVPN">
		</form>
    </div>
</div>
<br><br>
<div id="SideBySide">
    <div class="sub"><strong>Wget Log</strong>
	<br>
		<div class="ConnectionBox">
			<code>
			<div id="wget" style="font-size: 11px; white-space: pre-wrap; word-break: break-all; word-wrap: break-word; width:510px;height:115px;border:0px solid #000;text-align:left; overflow-y: scroll;"></div>
			</code>
		</div>
	<br>
		<form action='.$_SERVER['PHP_SELF'].' method="post">
		<input type="submit" name="continue-wget" value="Continue Download">
		<input type="submit" name="stop-wget" value="Stop Download">
		</form>
    </div>
</div>
<div id="SideBySide">
	
    <div class="sub"><strong>'.$sms[0].'</b></strong>
	<br>
		<div class="ConnectionBox">
			<code>
			<div id="sms-gateway" style="font-size: 11px; white-space: pre-wrap; word-break: break-all; word-wrap: break-word; width:510px;height:115px;border:0px solid #000;text-align:left; overflow-y: scroll;"></div>
			</code>
		</div>
	<br>
		<form action='.$_SERVER['PHP_SELF'].' method="post">
		<input type="submit" name="start-auto-responder" value="Start Auto Responder">
		<input type="submit" name="reset-modem" value="Reset Modem">
		<input type="submit" name="stop-auto-responder" value="Stop Auto Responder">
		</form>
    </div>
</div>
<div style="font-size: 13px; color:blue;"><b>'.$ping[0].'</div>
<div id="counter" style="font-size: 13px;"></div>
</div>';
foot();
echo '

</div>
</body>
</div>
</html>';
?>