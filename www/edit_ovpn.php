<?php
include 'theme.php';
ceklogin();
css();
echo '
<b> <font size="4">Edit OpenVPN Account </font></b><br><br>';
echo "<form action=\"\" method=\"post\">";
exec('ls /root/crt |grep -i -e .ovpn -e .txt',$list);
echo 'Account : <select name="config"><br>';
$x=0;

while($x<count($list)){   
    if($list[$x]==$h[0]){
    echo "<option value=\"/root/crt/$list[$x]\" selected>$list[$x]</option>";}
    else{
    echo "<option value=\"/root/crt/$list[$x]\">$list[$x]</option>";}
    $x++;
    }
echo '</select>';

echo '&nbsp;<input name="edit" type="submit" value="Edit"><br>';

if(isset($_POST["edit"])) 
{
    $filename = $_POST["config"];
    $filecontent = file_get_contents($filename);
    $nameonly = str_replace('/root/crt/', '', $filename);
    echo '<br><b><font color="green">Now editing: '.$nameonly.'</font></b>
	<br><textarea name="akunvpn" autofocus rows="16" cols="78" style="font-family: Arial;font-size: 9pt;">';
    echo htmlentities($filecontent);
    echo '</textarea><br><br>
    <input type="hidden" name="filename" value="'.$filename.'">
    <input name="update" onclick="update()" type="submit" value="Update">
    '; //echos file content in textarea.
 }

 //write to text file
 if(isset($_POST["update"])) {
    file_put_contents($_POST['filename'], $_POST["akunvpn"]);
	echo "<br><b><font color=\"green\">The file has been updated</font></b>";
 }

echo '</form></div>';
foot();
echo '
</body>
</html>';
?>