<?php
include 'theme.php';
$subm=0;

if($_POST['Submit']){
    $profile=$_POST['profile'];
    $subm=1;  
    }
if($_POST['new']){ 
css();
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo "Nama Profile <input type=\"text\" name=\"profile\" size=\"6\" value=\"\"/>";
echo "<input name=\"Submit\" type=\"submit\" value=\"Open\" />";
echo "<input name=\"new\" type=\"submit\" value=\"New profile\" />";
echo "<input name=\"update\" type=\"submit\" value=\"Save\" /><br><br>";
echo "Ip Rule :<input type=\"text\" name=\"ip_rule\" size=\"25\" value=\"\"/>";
echo '<input type="checkbox" name="e_iprule" value="yes" >Enable Ip hunter';
echo '<br><br>';
echo "Apn :<input type=\"text\" name=\"apn\" size=\"12\" value=\"internet\"/>";
echo '<input type="checkbox" name="kodok" value="yes" >Auto Kodok';
echo '<input type="checkbox" name="use_vpn" value="yes" checked>Openvpn';
echo '<input type="checkbox" name="use_inject" value="yes" checked>Inject';
echo '<br><br>';
echo "Proxy :<input type=\"text\" name=\"proxy\" size=\"17\" value=\"^server^\"/>";
echo "Port :<input type=\"text\" name=\"port\" size=\"6\" value=\"80\"/>";
echo '<br>Payload :<br>';
echo "<textarea name=\"payload\" rows=\"4\" cols=\"55\"></textarea><br>Info:<br>";
echo "<textarea name=\"text-info\" rows=\"2\" cols=\"55\">Update </textarea>";
echo '
</form>
</div>';
foot();
echo '
</div>
</body>
</div>
</html>';
exit;
    }

if($_POST['update']){
    $profile=$_POST['profile'];
    exec('echo '.$profile.'> /tmp/pf');
    $payload=$_POST['payload'];
    $ip_rule=$_POST['ip_rule'];
    $e_iprule=$_POST['e_iprule'];    
    $apn=$_POST['apn'];
    $kodok=$_POST['kodok'];
    $use_vpn=$_POST['use_vpn'];
    $use_inject=$_POST['use_inject'];
    $proxy=$_POST['proxy'];
    $port=$_POST['port'];
    $text_info=$_POST['text-info'];
    if ($e_iprule <> 'yes'){$e_iprule='no';}
    if ($use_vpn <> 'yes' ){$use_vpn='no';}
    if ($kodok <> 'yes') {$kodok='no';}
    if ($use_inject<>'yes'){$use_inject='no';}
    exec('echo "enable_iprule \''.$e_iprule.'\'" > /root/profiles/'.$profile);     
    exec('echo "ip_rule \''.$ip_rule.'\'" >> /root/profiles/'.$profile);
    exec('echo "apn_modem \''.$apn.'\'" >> /root/profiles/'.$profile);
    exec('echo "auto_kodok \''.$kodok.'\'" >> /root/profiles/'.$profile);
    exec('echo "use_vpn \''.$use_vpn.'\'" >> /root/profiles/'.$profile);
    exec('echo "use_inject \''.$use_inject.'\'" >> /root/profiles/'.$profile);
    exec('echo "proxy_ip \''.$proxy.'\'" >> /root/profiles/'.$profile);
    exec('echo "proxy_port \''.$port.'\'" >> /root/profiles/'.$profile);
    exec('echo "payload_inject \''.$payload.'\'" >> /root/profiles/'.$profile);
    $text=explode(PHP_EOL,$text_info);
    $x=0;
    while($x<(count($text)))
    {     
       $str="#info ".$text[$x];       
       if ($str <> "#info " ){
          $str=str_replace(PHP_EOL,'',$str,$i);
           exec('echo "'.$str.'" >>  /root/profiles/'.$profile);
       }
       $x++;
     }
    header( "refresh:0;url=edit_profile.php" );
    exit;
    }

echo '
<script>
function get_payload()
{
var x = document.getElementById("payload").value;
}
</script>';
css();


exec('ls /root/profiles',$list);
if ($subm == 0){
exec('cat /tmp/pf',$o);
$profile=$o[0];
}
exec('profile show-config '.$profile,$listx);
exec('profile info '.$profile,$info);
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo 'Profile :<select name="profile">';
$x=0;
while($x<count($list))
  {
if ( $profile == $list[$x] ){

   echo "
   <option value=\"$list[$x]\" selected>$list[$x]</option>";}
else {

   echo "
   <option value=\"$list[$x]\">$list[$x]</option>";}
   $x++;
}
echo "<input name=\"Submit\" type=\"submit\" value=\"Open\" />";
echo "<input name=\"new\" type=\"submit\" value=\"New profile\" />";
echo "<input name=\"update\" type=\"submit\" value=\"Save\" /><br><br>";
echo "Ip Rule :<input type=\"text\" name=\"ip_rule\" size=\"25\" value=\"$listx[1]\"/>";
if ($listx[0]=='yes'){
echo '<input type="checkbox" name="e_iprule" value="yes" checked>Enable Ip hunter';}
else{echo '<input type="checkbox" name="e_iprule" value="yes" >Enable Ip hunter';}
echo '<br><br>';
echo "Apn :<input type=\"text\" name=\"apn\" size=\"12\" value=\"$listx[2]\"/>";
if ($listx[8]=='yes'){
echo '<input type="checkbox" name="kodok" value="yes" checked>Auto Kodok';}
else{echo '<input type="checkbox" name="kodok" value="yes" >Auto Kodok';}
if ($listx[9]=='yes'){
echo '<input type="checkbox" name="use_vpn" value="yes" checked>Openvpn';}
else{echo '<input type="checkbox" name="use_vpn" value="yes" >Openvpn';}
if ($listx[10]=='yes'){
echo '<input type="checkbox" name="use_inject" value="yes" checked>Inject';}
else{echo '<input type="checkbox" name="use_inject" value="yes" >Inject';}

echo '<br><br>';
echo "Proxy :<input type=\"text\" name=\"proxy\" size=\"17\" value=\"$listx[5]\"/>";
echo "Port :<input type=\"text\" name=\"port\" size=\"6\" value=\"$listx[6]\"/>";
echo '<br>Payload :<br>';
echo "<textarea name=\"payload\" rows=\"4\" cols=\"50\">$listx[7]</textarea><br>Info:<br>";
echo "<textarea name=\"text-info\" rows=\"2\" cols=\"50\">";
$x=0;
while($x<count($info)-1){
   echo $info[$x].PHP_EOL;
   $x++;
}
echo $info[$x];
echo ' 
</textarea>
</form>
</div>';
foot();
echo '
</div>
</body>
</div>
</html>';
?>
