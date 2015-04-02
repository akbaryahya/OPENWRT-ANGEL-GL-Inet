<?php
include 'theme.php';
ceklogin();
css();
if($_POST['Submit']){
    $ssid=$_POST['ssid'];
    $key=$_POST['key'];
    exec('uci set wireless.@wifi-iface[0].ssid="'.$ssid.'"');
    exec('uci set wireless.@wifi-iface[0].key="'.$key.'"');
    exec('uci set wireless.@wifi-iface[0].encryption=psk');
    exec('uci commit wireless');
    exec('wifi');
    }

exec('uci show wireless.@wifi-iface[0].ssid |awk -F"=" \'{print $2}\'',$ssid);
exec('uci show wireless.@wifi-iface[0].key |awk -F"=" \'{print $2}\'',$key);
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo "SSID<input type=\"text\" name=\"ssid\" value=\"$ssid[0]\"/>";
echo "KEY<input type=\"Password\" name=\"key\" value=\"$key[0]\"/>";
echo "<input name=\"Submit\" type=\"submit\" value=\"Submit\" />
</form>";
echo '<br>
<div align="center" >
<div style="left:10px;width:455px;height:240px;border:1px solid #000;text-align:center;"><br>';
exec('profile wifi-clients',$out);
$search=array('IpAddress','MAC address');
$replace=array('IP Address','MAC Address');
$out=str_replace($search,$replace,$out);
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
echo '
</div>
</div>
</div>';
foot();
echo '
</div>
</body>
</div>
</html>';
?>
