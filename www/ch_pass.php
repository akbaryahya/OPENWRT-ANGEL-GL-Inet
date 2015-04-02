<?php
include 'theme.php';
ceklogin();
css();
exec('grep user /root/passwd |awk -F" " \'{print $2}\'',$user);
exec('grep passwd /root/passwd |awk -F" " \'{print $2}\'',$pass);
if ($_GET['login']) {
 
     if ($_POST['username'] == $user[0]
         && $_POST['password'] == $pass[0]) {
         $new=$_POST['newpassword'];
         exec('echo "user root" > /root/passwd');
         exec('echo "passwd "'.$new.' >> /root/passwd');
         echo 'Ubah Password root Sukses...';
         $_SESSION['loggedin'] = 0;
 
     } else echo " Nama User atau password salah..";
 
}
 
echo '
<h2 style="margin-bottom:0;">UBAH PASSWORD</h2>
<br><br>
<form action="?login=1" method="post">
Username: <input type="text" autofocus name="username" />
</br>
</br>
Pass lama : <input type="password" name="password" />
</br>
</br>
Pass baru : <input type="password" name="newpassword" />
</br>
</br>
<input type="submit" value="Submit" /></br>

</form>
</div>';
foot();
echo '
</body>
</html>';