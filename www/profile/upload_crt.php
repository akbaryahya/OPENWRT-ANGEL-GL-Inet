<?php

include 'theme.php';
ceklogin();
css();
echo '';

exec('mkdir /tmp/upload');
exec('chmod 666 /tmp/upload');
$uploaddir = '/tmp/upload/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);
$name=basename($_FILES['file']['name']);

$pos=strpos($uploadfile,'.crt');
if ($pos==false){
$pos=strpos($uploadfile,'.ovpn');
if ($pos==false){
$pos=strpos($uploadfile,'.txt');
if ($pos==false){
$pos=strpos($uploadfile,'.key');
if ($pos==false){
echo " Error... type file yang di perbolehkan crt,ovpn,key,txt";
 exit; 
}}}}
echo "";

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
   echo "upload ".$name." sukses";
   exec('cp -f '.$uploadfile.' /root/crt');
} else {
   echo "Upload ".$name." failed";
}
echo '
</div>';
foot();
echo '
</div>
</body>
</div>
</html>';
?>
