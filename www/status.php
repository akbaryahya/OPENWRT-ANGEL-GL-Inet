<?php
include 'theme.php';
ceklogin();
    $event=0;
    $st=0;
if($_POST['start']){
    $pf=$_POST['profile'];
    exec('profile start '.$pf.' > /dev/null 2>&1 &');
   $list="Profile Started .. OK";
    $event=1;    
    $st=2;
    header( "refresh:1;url=log.php" );
}
if($_POST['stop']){
	exec('DATE=`eval date +%Y-%m-%d-%H:%M:%S` && echo "$DATE Koneksi internet dimatikan secara manual" >> /www/profile/dial.log');
	exec('killall restart-internet.sh');
    exec('profile stop');
    $list="Profile Stoped .. OK";

    $event=1;
    $st=2;    
    header( "refresh:1;url=status.php" );
}
if($_POST['restart']){
    exec('profile start > /dev/null 2>&1 &');
    $event=1;    
    $st=2;
    $list="Profile restarted .. OK";
    header( "refresh:1;url=log.php" );
}

if($_POST['info']){
    $pf=$_POST['profile'];
    $st=3;
}

if($_POST['reg']){
    $param=$_POST['network'];
    exec('gsm set network '.$param);
    sleep(3);
    $st=1;
}

if($_POST['logout']){
    session_destroy();
	header("location:status.php");
	exit();
}

css();
if ( $event == 1 )
{
echo $list;
echo '
	<br>
    Harap Menunggu.... 
	<br>
	</div>';

foot();
echo '
</div>
</body>
</html>';
exit;
}
if ( $event == 0 )
{
exec('cat /tmp/prf',$o);
if ( $o[0] == 'started' ) {
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo '
<input type="submit" name="refresh" value="Refresh Status" />
<input type="submit" name="restart" value="Restart Profile" />
<input type="submit" name="stop" value="Stop Profile" />
</form>';
}
else
{
exec('ls /root/profiles',$list);
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo '
Profile :
<select name="profile">';
$x=0;
while($x<count($list))
  {
   echo "
   <option value=\"$list[$x]\">$list[$x]</option>";
   $x++;
  }
echo '
</select>
<input type="submit" name="start" value="Start Profile" />
<input type="submit" name="info" value="Info Profile" />
</form>';
}

echo "<br>";
if($_POST['all-status']){
$st=1;
}

if($_POST['edge-only']){
$st=1;
exec('gsm jump edge',$ot);
exec('uci set network.3g.service=gprs_only',$ot);
sleep(10);
}

if($_POST['tigag-only']){
$st=1;
exec('gsm jump 3g',$ot);
exec('uci set network.3g.service=umts_only',$ot);
sleep(10);
}


if ( $st == 3 ){
   exec('profile info '.$pf,$out);
   $st=0;
}else{
if ( $st == 1){ 
exec('gsm status',$out);
}else{
$st=0;
exec('profile status-koneksi',$out);
}}
if ($st <> 2){
echo '
<div align="center" >
<div style="left:10px;width:380px;height:auto; padding-top:10px; padding-bottom:10px; border:1px solid #000;text-align:center;">';
}
$search=array('Waktu','Traffiq : RX',' - TX','GiB','MiB','KiB','Config vpn','APN modem','Rssi','Rat','Cell id','Qos up','Qos down');
$replace=array('Time','Download :',' | Upload :','GB','MB','KB','VPN Account','APN Modem','Signal Strength','Network','Cell ID','QoS Upload','QoS Download');
$out = str_replace($search,$replace,$out);
$out = str_replace('tdk terkonek ke server','Disconnected from server',$out);
$out = str_replace('terkonek ke server','Connected to server',$out);
$out = str_replace('==============================','====================================',$out);
array_splice($out, array_search('====', $out) +2, 0, 'Auto Logout: 30 Minutes');
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
}
if ($st <> 2){
echo '</div></div>';
}
if ($st == 0){
echo "<br><form action=\"".$PHP_SELF."\" method=\"post\">";
echo '
<input type="submit" name="all-status" value="Status Modem" />
<input type="submit" name="logout" value="Logout" />
</form>';
}else{
if ($st == 1){
echo "<br><form action=\"".$PHP_SELF."\" method=\"post\">";
echo '
<input type="submit" name="edge-only" value="Edge Only" />
<input type="submit" name="tigag-only" value="3G Only" />
Network:
<select name="network">
<option value=\"auto\">Auto</option>\"
<option value=\"51001\">Indosat</option>\"
<option value=\"51011\">XL</option>\"
<option value=\"51089\">3</option>\"
<option value=\"51010\">Telkomsel</option>\"
</select>
<input type="submit" name="reg" value="Register" />
</form>';
}}
echo '
</div>';

foot();
echo '
</body>
</html>';
?>
