<?php
include 'theme.php';
ceklogin();
if($_POST['edit']){
     $pf=$_POST['profile'];
     exec('echo '.$pf.'> /tmp/pf');
header( "refresh:0;url=edit_profile.php" );
}
css();
$show="home";
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "update.log",
                success: function(result) {
                    $("#update").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("update");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
if($_POST['update']){
    $pf=$_POST['profile'];
    exec('profile update list');
    exec('cat /tmp/update',$list);
    if ($list[0] != 'gagal'){       
     echo "Daftar profile yang ada di server:";
     echo "<br>";
     echo "<br>";
     echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
     echo '
     Pilih Profil:
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
     <input type="submit" name="install" value="Download" /><br>';
     echo "Masukan nama Profil :<input name=\"mprofile\" size=\"8\" value=\"$key[0]\"/>";
     echo '<input type="submit" name="install" value="Download" />';
     echo "</form>";
echo '
</div>';
foot();
echo '
</div>
 
</body>
</html>';

     exit;
 
    } else echo "update gagal";
}

if($_POST['install-scrypt']){
    $pf=$_POST['scrypt'];
    exec('profile scrypt-list');
    exec('cat /tmp/update',$list);
    if ($list[0] != 'gagal'){     
     echo "daftar scrypt yang ada di server";
     echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
     echo '
     nama script:
     <select name="scrypt">';
     $x=0;
     while($x<count($list))
    {
     echo "
     <option value=\"$list[$x]\">$list[$x]</option>";
      $x++;
     }
     echo '
     </select>
     <input type="submit" name="installsc" value="Install" />';
     echo "</form>";
echo '
</div>';
foot();
echo '
</div>
 
</body>
</html>';

     exit;
 
    } else echo "update gagal";
  }
if($_POST['installsc']){
    $pf=$_POST['scrypt'];
    exec('profile scrypt-install '.$pf,$out);
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
echo '
</div>';
foot();
exit;

  }

if($_POST['install']){
    $pf=$_POST['mprofile'];
    if ( "x".$pf == "x"){
    $pf=$_POST['profile'];
    $pf=explode(" ",$pf);
    $prof=$pf[0];
}else{
    $prof=$pf;}
    exec('profile update '.$prof,$out);
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
echo '
</div>';
foot();
exit;

  }

if($_POST['update-scrypt']){
    $pf=$_POST['profile'];
    exec('profile update',$out);
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
echo '
</div>';
foot();
exit;

  }
if($_POST['set-modem']){
    $pf=$_POST['port-modem'];
    exec('gsm set port '.$pf,$out);
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
echo '
</div>';
foot();
exit;

  }

if($_POST['set-iface']){
    $pf=$_POST['iface-gsm'];
    exec('gsm set interface '.$pf,$out);
$arrlength=count($out);
for($x=0;$x<$arrlength;$x++)
  {
  echo $out[$x]. "<br>";
  }
echo '
</div>';
foot();
exit;

  }


if($_POST['hapus']){
    $pf=$_POST['profile'];
    exec('rm -f /root/profiles/'.$pf,$out);
  }

exec('ls /root/profiles',$list);
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
exec('cat /root/config |grep -w \'profile \' |awk -F"\'" \'{print $2}\'',$o);
$profile=$o[0];
echo '
Profile :
<select name="profile">';
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
echo '
</select>
<input type="submit" name="update" value="Update list" />
<input type="submit" name="edit" value="Edit" />
<input type="submit" name="hapus" value="Hapus" />';
echo "</form>";

echo "<br>";
//echo "<br>";

    echo "
         <form action=\"upload_profile.php\" method=\"post\"
         enctype=\"multipart/form-data\">
        <label for=\"file\">Upload profile:</label>
        <input type=\"file\" name=\"file\" id=\"file\">
        <input type=\"submit\" name=\"upload\" value=\"Upload\">
        </form>";

echo "<br>";
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo '<input type="submit" name="install-scrypt" value="Install Script" />';
echo "</form><br>";
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
exec('cat /etc/config/gsm |grep ttyUSB |awk -F"\'" \'{print $2}\'',$def);
$cur=$def[0];
exec('ls /dev |grep ttyUSB',$out);
echo '
Port Modem :
<select name="port-modem">';
$x=0;
while($x<count($out)){
if ( $cur == $out[$x] ){

   echo "
   <option value=\"$out[$x]\" selected>$out[$x]</option>";}
else {

   echo "
   <option value=\"$out[$x]\">$out[$x]</option>";}
   $x++;
}
echo '
</select>
<input type="submit" name="set-modem" value="Set Port Modem" /><br>
Interface gsm :
<select name="iface-gsm">';
exec('cat /etc/config/gsm |grep IFACE |awk -F"\'" \'{print $2}\'',$def2);
$cur2=$def2[0];
exec('uci show network |grep proto=3g |awk -F"." \'{print $2}\'',$out2);
$x=0;
while($x<count($out2)){
if ( $cur2 == $out2[$x] ){

   echo "
   <option value=\"$out2[$x]\" selected>$out2[$x]</option>";}
else {

   echo "
   <option value=\"$out2[$x]\">$out2[$x]</option>";}
   $x++;
}

echo '
</select>
<input type="submit" name="set-iface" value="Set Interface" />';

echo "</form>";

echo '
</div>';
foot();
echo '
</div> 
</body>
</div>
</html>';
?>
