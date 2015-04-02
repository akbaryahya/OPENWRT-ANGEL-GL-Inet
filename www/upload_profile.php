<?php


$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);


echo "<p>";

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
   echo "upload file profile sukses.\n";
   exec('cp -f '.$uploadfile.' /root/profiles');
} else {
   echo "Upload failed";
}
?> 