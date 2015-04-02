<?php
include 'theme.php';
ceklogin();
css();
//Javascript Untuk Ping Loop
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "ping.log",
                success: function(result) {
                    $("#ping").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("ping");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
if(isset($_POST['start'])){
	$address=$_POST['address'];
	$packet=$_POST['packet'];
	$exscript=$_POST['exscript'];
	$selected_radio=$_POST['option'];
	exec('sed -i "s/option address.*/option address '.$address.'/g" /etc/config/ping_loop');
	exec('sed -i "s/option packet.*/option packet '.$packet.'/g" /etc/config/ping_loop');
	exec('sed -i "s/option exscript.*/option exscript '.$exscript.'/g" /etc/config/ping_loop');
	if ($selected_radio == "do-nothing"){
		exec('sed -i "s/option status.*/option status \'Pinging '.$address.' (Do Nothing)\'/g" /etc/config/ping_loop');
		exec('ping_loop do_nothing > /dev/null 2>&1 &');
	}
	elseif ($selected_radio == "restart-internet"){
		exec('sed -i "s/option status.*/option status \'Pinging '.$address.' (Restart Internet)\'/g" /etc/config/ping_loop');
		exec('ping_loop restart_internet > /dev/null 2>&1 &');
	}
	elseif ($selected_radio == "restart-openvpn"){
		exec('sed -i "s/option status.*/option status \'Pinging '.$address.' (Restart OpenVPN)\'/g" /etc/config/ping_loop');
		exec('ping_loop restart_openvpn > /dev/null 2>&1 &');
	}
	elseif ($selected_radio == "ex-script"){
		$check="/usr/bin/".$exscript;
		if(empty($exscript)){
			exit("<font color=red><b>The script field can't be empty</b></font>");
		}
		if (!file_exists($check)) {
			exit("<font color=red><b>I can't find $exscript in /usr/bin/</b></font>");
		}
		exec('sed -i "s/option status.*/option status \'Pinging '.$address.' (Run '.$exscript.')\'/g" /etc/config/ping_loop');
		exec('ping_loop ex_script > /dev/null 2>&1 &');
	}
}
if(isset($_POST['stop'])){
	exec('ping_loop stop');
	clearstatcache();
}
exec('uci get ping_loop.setting.address',$adr);
exec('uci get ping_loop.setting.packet',$pac);
exec('uci get ping_loop.setting.status',$stat);
exec('uci get ping_loop.setting.exscript',$exs);
?>
<div align="justify">
<form action="ping.php" method="post">
	Ping Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="address" size="20" autofocus value="<?php echo $adr[0]; ?>"><br>
	Number of Packets:
	<input type="text" name="packet" size="20" value="<?php echo $pac[0]; ?>"><br><br>
	</div>
	<div align="left">
	When the ping is down:
	<br><input type="radio" name="option" value="do-nothing" checked>Do nothing
	<br><input type="radio" name="option" value="restart-internet">Restart the internet
	<br><input type="radio" name="option" value="restart-openvpn">Restart OpenVPN
	<br><input type="radio" name="option" value="ex-script">Run external script (/usr/bin):<input type="text" name="exscript" size="10" value="<?php echo $exs[0]; ?>">
	</div>
    <br><input type="submit" name="start" value="Start Ping" />
	<input type="submit" name="stop" value="Stop Ping" />
</form><br><br><strong><?php echo $stat[0]; ?></strong>
<pre>
	<div id="ping" style="font-size: 11px; white-space: pre-wrap; word-break: break-all; word-wrap: break-word; width:450px;height:65px;border:0px solid #000;text-align:left; overflow-y: scroll;"></div>
</pre>
</div>
<?php
foot();
echo '
</body>
</html>';
?>