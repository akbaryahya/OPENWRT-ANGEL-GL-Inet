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
                url: "sms-gateway.log",
                success: function(result) {
                    $("#status").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("status");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "outbox.log",
                success: function(result) {
                    $("#outbox").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("outbox");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
if(isset($_POST['sms-send'])){
    {
	$show="send sms";
    }
	}
if(isset($_POST['send-now'])){
	{
	$number=$_POST['number'];
	$pesan=$_POST['pesan'];
	exec('gsm sms send '.$number.' '.$pesan,$out);
	if (strpos($out[2],'sms sukses terkirim ke') !== false) {
		exec('echo "<b>DATE:</b>$(date +%d-%m-%Y_%H:%M:%S)<br><b>NOMER:</b>'.$number.'<br><b><b>ISI PESAN:</b></b><br>'.$pesan.'<br>===============<br>" >> /www/profile/outbox.log');
	}
	echo "<font color=blue><b>".$out[2]."</b></font>";
	$show="outbox";
	}
	}
if(isset($_POST['send-bulk-now'])){
	{
	$bulknomer=$_POST['bulknomer'];
	$bulkpesan=$_POST['bulkpesan'];
	$count = explode(" ", $bulknomer);
	if (count($count) > 10){
		exit("<font color=red><b>Maksimal pengiriman SMS hanya ke 10 nomer saja</b></font>");
	}
	exec('killall sms_gateway');
	exec("echo $bulknomer > /tmp/bulknomer");
	exec("echo $bulkpesan > /tmp/bulkpesan");
	exec('sms_gateway bulk_sms > /dev/null 2>&1 &');
	$show="log";
	}
	}
if(isset($_POST['inbox'])){
    {
	exec('gsm sms read unread',$out);
	$show="inbox";
    }
	}
if(isset($_POST['delete-inbox'])){
	{
	exec('gsm sms del all',$out);
	$show="inbox";
	}
	}
if(isset($_POST['sms-read-all'])){
	{
	exec('gsm sms read all',$out);
	$show="inbox";
	}
	}
if(isset($_POST['outbox'])){
    {
	$show="outbox";
    }
	}
if(isset($_POST['bulk-sms'])){
    {
	$show="send bulk sms";
    }
	}
if(isset($_POST['delete-outbox'])){
    {
	$show="outbox";
	exec('echo "Outbox kosong..." > /www/profile/outbox.log');
    }
	}
if(isset($_POST['start-auto-responder'])){
	{
	exec('echo "SMS Auto Responder dihidupkan" >> /www/profile/sms-gateway.log');
	exec('bash sms_gateway > /dev/null 2>&1 &');
	$show="log";
	}
	}
if(isset($_POST['reset-modem'])){
	{
	exec('gsm at ATZ0');
	exec('gsm status');
	$show="log";
	echo '<b><font color="blue">The modem has been reset...</font></b>';
	}
	}
if(isset($_POST['stop-auto-responder'])){
	{
	exec('killall bash');
	exec('echo "SMS Auto Responder dihentikan" >> /www/profile/sms-gateway.log');
	$show="log";
	}
	}
if(isset($_POST['sms-gateway-log'])){
	{
	$show="log";
	}
	}
if(isset($_POST['setting-sms-gateway'])){
	{
	$show="setting";
	}
	}
if(isset($_POST['status-sms-gateway'])){
	{
	$show="status";
	}
	}
if(isset($_POST['update-sms-gateway'])){
	{
	$show="status";
	exec('sms_gateway update');
	}
	}
if(isset($_POST['apply-setting'])){
	{
	$singlequote="'";
	$activatefilter=$singlequote.$_POST['activate-filter'].$singlequote;
	$filterphonenumbers=$_POST['filter-phone-numbers'];
	$filterphonenumbers = trim(preg_replace('/\s+/', ' ', $filterphonenumbers));
	$filterphonenumbers=$singlequote.$filterphonenumbers.$singlequote;
	$interval=$singlequote.$_POST['interval'].$singlequote;
	exec('sed -i "s/option filter.*/option filter '.$activatefilter.'/g" /etc/config/sms_gateway');
	exec('sed -i "s/option phonenumbers.*/option phonenumbers '.$filterphonenumbers.'/g" /etc/config/sms_gateway');
	exec('sed -i "s/option interval.*/option interval '.$interval.'/g" /etc/config/sms_gateway');
	exec('killall bash');
	exec('bash sms_gateway > /dev/null 2>&1 &');
	$show="setting";
	$apply="<b><font color='blue'>Settings applied, SMS Gateway Direstart</font></b>";
	}
	}
echo '
<form action='.$_SERVER['PHP_SELF'].' method="post">
<input type="submit" name="sms-send" value="Send SMS">
<input type="submit" name="inbox" value="Inbox SMS">
<input type="submit" name="outbox" value="Outbox SMS">
<input type="submit" name="bulk-sms" value="Send Bulk SMS">
</form>
<br>';
if ( $show == "home" )
	{
	echo '
	<div class="ConnectionBox">
	<div align="center" style="font-size: 16px;"><b>Format SMS yang tersedia:</b></div>
	<div id="show" style="font-size: 13px;  word-wrap: break-word; width:550px;height:195px;border:0px solid #000;text-align:left; overflow-y: scroll;">
	<ol>
	<li><b>status router</b>: mengecek status router anda, seperti: uptime, load average, IP address, dan free memory di router</li>
	<li><b>reboot router</b>: perintah ini digunakan untuk mereboot router anda.</li>
	<li><b>restart internet</b>: perintah ini digunakan untuk merestart internet anda dengan nama profile yang terakhir digunakan.</li>
	<li><b>stop internet</b>: perintah ini digunakan untuk mematikan internet di modem anda, ketik "restart internet" untuk menyalakan kembali.</li>
	<li><b>cek pulsa [telkomsel/xl/three/axis/indosat]</b>: perintah ini digunakan untuk mengetahui sisa pulsa modem anda. Contoh: cek pulsa telkomsel</li>
	<li><b>cek kuota three</b>: perintah ini digunakan untuk cek kuota internet kartu three di router.
	<li><b>httpxxx</b>: paste link download anda, perintah ini digunakan untuk mendownload file dengan wget lewat SMS. Contoh: http://namasitus.com/namafile.exe</li>
	<li><b>status download</b>: perintah ini digunakan untuk mengecek status download anda.</li>
	<li><b>continue download</b>: perintah ini digunakan untuk melanjutkan download yang terhenti.</li>
	<li><b>stop download</b>: perintah ini digunakan untuk menghentikan proses download yang sedang berlangsung.</li>
	<li><b>wifi up</b>: perintah ini digunakan untuk menghidupkan wifi di router.</li>
	<li><b>wifi down</b>: perintah ini digunakan untuk mematikan wifi di router.</li>
	<li><b>who\'s connected</b>: perintah ini digunakan untuk mengetahui siapa saja yang terkoneksi ke hotspot router anda.</li>
	</ol>
	<div align="center">
	Pengetikan format SMS bisa dengan huruf besar atau huruf kecil, tidak case sensitive. 
	Pastikan settingan port modemnya benar, kalau salah sms gateway tidak akan berfungsi, 
	cara mengetahui jika port modem benar adalah dengan cek lewat menu "Status Modem".
	<br><br>
	Jika ingin ditambahkan format SMS baru silakan kontak: <a href="https://www.facebook.com/galihpa" target="_blank"><b>https://www.facebook.com/galihpa</b></a>
	</div>
	</div>
	</div>';
	}
if ( $show == "inbox" )
	{
	echo '
	<div style="border:1px solid #000;">
	<div class="ConnectionBox">
	<pre>
	<div id="show" style="font-size: 13px; margin-left:10px; word-wrap: break-word; width:550px;height:195px;border:0px solid #000;text-align:left; overflow-y: scroll;">';
	$arrlength=count($out);
	for($x=0;$x<$arrlength;$x++)
		{
		echo $out[$x]."\n";
		}
	echo '</pre></div>
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	<input type="submit" name="sms-read-all" value="Read All Inbox">
	<input type="submit" name="delete-inbox" value="Delete Inbox">
	</font>
	</div>
	<br>';
	}
if ( $show == "outbox" )
	{
	echo '
	<div style="border:1px solid #000;">
	<div class="ConnectionBox">
	<pre>
	<div id="outbox" style="font-size: 13px; margin-left:10px; word-wrap: break-word; width:550px;height:195px;border:0px solid #000;text-align:left; overflow-y: scroll;">
	</div>
	</pre>
	</div>
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	<input type="submit" name="delete-outbox" value="Delete Outbox">
	</form>
	</div>';
	}
if ( $show == "send sms" )
	{
	echo '
	<div style="border:1px solid #000;">
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	Destination Number:<br> <input type="text" autofocus name="number" size="15"><br>
	<br>Message :<br>
	<textarea name="pesan" rows="10" cols="70"></textarea><br><br>
	<input type="submit" name="send-now" value="Send Now">
	</form>
	</div>';
	}
if ( $show == "send bulk sms" )
	{
	echo '
	<div style="border:1px solid #000;">
	<b>SEND BULK SMS</b><br>
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	Destination Numbers: (separated by a space)<br> <textarea name="bulknomer" rows="7" cols="70" autofocus></textarea><br>
	<br>Message :<br>
	<textarea name="bulkpesan" rows="3" cols="70"></textarea><br><br>
	<input type="submit" name="send-bulk-now" value="Send Now">
	</form>
	'.$error.'
	</div>';
	}
if ( $show == "log" )
	{
	exec('if pidof bash sms_gateway > /tmp/status.txt; then echo SMS Auto Responder \(On\); else echo SMS Auto Responder \(Off\); fi', $sms);
	echo "<b>".$sms[0]."</b>";
	echo '
	<div style="border:1px solid #000;">
	<div class="ConnectionBox">
	<pre style="white-space:pre-line;">
	<div id="status" style="margin-left:5px; display: inline-block; font-size: 13px;  word-wrap: break-word; width:550px;height:195px;border:0px solid #000;text-align:left; overflow-y: scroll;">
	</div>
	</pre>
	</div>
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	<input type="submit" name="start-auto-responder" value="Start Auto Responder">
	<input type="submit" name="reset-modem" value="Reset Modem">
	<input type="submit" name="stop-auto-responder" value="Stop Auto Responder">
	</form>
	</div>';
	}
if ( $show == "setting" )
	{
	exec('uci get sms_gateway.setting.phonenumbers',$phn);
	exec('uci get sms_gateway.setting.interval',$int);
	exec('uci get sms_gateway.setting.filter',$filt);
	echo '
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	<div style="border:1px solid #000;">';
	echo '
	If the filter is activated, sms gateway will only respond to the allowed phone numbers
	<br>
	<div id="setting" style="margin-left:10px;  word-wrap: break-word; width:550px;height:195px;border:0px solid #000;text-align:left; overflow-y: scroll;">
	<ol>
	<li><b>Activate Filter:</b>
	<select name="activate-filter">';
	foreach ($filt as $value){

	if ($value == "yes"){
		echo '<option value="'.$value.'" selected>Yes</option><br>
          <option value="no">No</option>';}
	else {
		echo '<option value="yes">Yes</option><br>
          <option value="'.$value.'" selected>No</option>';}
	}
	echo '
	</select></li>
	<li><b>Allowed Phone Numbers:</b> 
	<div align="center" style="font-size: 13px;"><br><textarea name="filter-phone-numbers" rows="3" cols="55">';
	foreach ($phn as $phonenumbers) {echo "$phonenumbers";}
	echo '</textarea><br>
	(Format: +628xxx. Each phone number is separated by a space)</div></li><br>
	<li><b>Refresh Interval:</b> <input type="text" name="interval" size="1" value="';
	foreach ($int as $interval) {echo "$interval";}
	echo'"> (in seconds)</li>
	</ol>
	</div>
	<input type="submit" name="apply-setting" value="Apply Setting">
	</form>
	<br>'.$apply.'
	</div>';
	}
if ( $show == "status" )
	{
	exec('uci get sms_gateway.setting.phonenumbers',$phn);
	exec('uci get sms_gateway.setting.interval',$int);
	exec('uci get sms_gateway.setting.filter',$filt);
	exec('uci get sms_gateway.setting.version',$version);
	echo '
	<div style="border:1px solid #000;">';
	echo '
	<b> STATUS SMS GATEWAY </b>
	<div id="setting" style="margin-left:10px; word-wrap: break-word; width:550px;height:195px;border:0px solid #000;text-align:left; overflow-y: scroll;">
	<ol>
	<li><b>Filter Phone Numbers:';
	foreach ($filt as $filter) {echo " $filter</b>";}
	echo '
	<li><b>Allowed Phone Numbers:</b> 
	<div align="center" style="font-size: 13px;"><br><textarea name="filter-phone-numbers" rows="5" cols="55" readonly>';
	foreach ($phn as $phonenumbers) {echo "$phonenumbers";}
	echo '</textarea>
	</div></li>
	<li><b>Refresh Interval:</b> <input type="text" name="interval" size="1" readonly value="';
	foreach ($int as $interval) {echo "$interval ";}
	echo'"> (in seconds)</li>
	<li><b>SMS Gateway Version: '.$version[0].'</b></li>
	</ol>
	</div>
	</div>';
	}
echo '
<br>
<form action='.$_SERVER['PHP_SELF'].' method="post">
<input type="submit" name="sms-gateway-log" value="Log SMS Gateway">
<input type="submit" name="setting-sms-gateway" value="Setting SMS Gateway">
<input type="submit" name="status-sms-gateway" value="Status SMS Gateway">
</form></div>';
foot();
echo '
</body>
</html>';
?>