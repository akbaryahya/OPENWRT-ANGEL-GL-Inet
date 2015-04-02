<?php
include 'theme.php';
ceklogin();
$show=1;
if($_POST['delete']){
    $file_config=$_POST['config'];
    exec('rm -f /root/crt/'.$file_config);
    header( "refresh:0;url=vpn.php" );
    exit;
    }

if($_POST['apply']){
    exec('grep use_config /root/config |awk -F"\'" \'{print $2}\'',$y);
    $use_config=$_POST['use_config'];
    $file_config=$_POST['config'];
    if ($use_config=='yes'){
	/*if (strpos($file_config,'.ovpn') == false) {
		header( "refresh:3;url=vpn.php" );
		css();
		echo "<font color=red><b>Apply failed, choose only *.ovpn</b></font>";
		exit();
	}*/
    exec('vpn use-config yes',$var);
    exec('vpn file-config '.$file_config,$var);
    header( "refresh:0;url=vpn.php" );
    exit;
    }
    else{
    exec('vpn use-config no',$var);
    exec('vpn file-config '.$file_config,$var);

    if($y[0]=='yes'){
    header( "refresh:0;url=vpn.php" );
    exit;
    }else{
    $server=$_POST['server'];
    $user=$_POST['user']; 
    $pass=$_POST['pass'];
    exec('vpn server '.$server,$var3);
    exec('vpn user-pass '.$user.' '.$pass,$var3);    
    header( "refresh:0;url=vpn.php" );
    exit;
    }}}

css();

    echo "
         <form action=\"upload_crt.php\" method=\"post\"
         enctype=\"multipart/form-data\">
        <label for=\"file\">File:</label>
        <input type=\"file\" name=\"file\" id=\"file\">
        <input type=\"submit\" name=\"upload\" value=\"Upload\">
        </form>";
  
    exec('cat /root/user.txt',$out);
    exec('vpn server show',$var1);
    exec('vpn config-show',$h);
    echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
    echo "</br>";
    exec('grep use_config /root/config |awk -F"\'" \'{print $2}\'',$y);
    if ($y[0]=='yes'){
    echo '<input type="checkbox" name="use_config" value="yes" checked>Use file Config<br><br>';
    exec('ls /root/crt |grep -i -e .ovpn -e .txt',$list);
    echo 'Config: <select name="config">';
    $x=0;
    while($x<count($list)){   
    if($list[$x]==$h[0]){
    echo "<option value=\"$list[$x]\" selected>$list[$x]</option>";}
    else{echo "<option value=\"$list[$x]\">$list[$x]</option>";}
    $x++;
    }
	echo '<input name="edit" type="submit" value="Edit">';
    echo "<input name=\"delete\" type=\"submit\" value=\"Delete\"/>";

}
    else{echo '<input type="checkbox" name="use_config" value="yes" >Use file Config';

    echo "<br><br>Server: <input type=\"text\" name=\"server\" value=\"$var1[0]\"/>";
    echo " <br><br>";
    echo "User--: <input type=\"text\" name=\"user\" value=\"$out[0]\"/>";
    echo "<br><br>";
    echo "Pass--: <input type=\"password\" name=\"pass\" value=\"$out[1]\"/>";}
    echo "<br><br><input name=\"apply\" type=\"submit\" value=\"Apply Settings\"/>";
    echo '</form>';
	echo $gagal;

if($_POST['edit']){
	$show=2;
    }
if ( $show == 1 )
{
if(isset($_POST["update"])) {
    file_put_contents($_POST['filename'], $_POST["akunvpn"]);
	$show=1;
	echo "<br><b><font color=\"green\">The file has been updated</font></b>";
 }
echo '<br><div style="font-size: 14px; word-wrap: break-word; width:400px;height:auto;padding-bottom:10px;border:0px solid #000; ">
<b><font align="center">NOTICE:</font></b><br> Use ping loop if your openvpn account gets frequently disconnected';
}
else {
	$dir = '/root/crt/';
	$filename = $dir . $_POST["config"];
    $filecontent = file_get_contents($filename);
    $nameonly = str_replace('/root/crt/', '', $filename);
    echo '<br><b><font color="green">Now editing: '.$nameonly.'</font></b>
	<br>
	<form action="" method="post">
	<textarea name="akunvpn" autofocus rows="12" cols="69" style="font-family: Arial;font-size: 9pt;">';
    echo htmlentities($filecontent);
    echo '</textarea><br><br>
    <input type="hidden" name="filename" value="'.$filename.'">
    <input name="update" type="submit" value="Update File">
	</form>
    '; //echos file content in textarea.
}
echo '
</div>
</div>';
foot();
echo '
</div>
</body>
</div>
</html>';
?>