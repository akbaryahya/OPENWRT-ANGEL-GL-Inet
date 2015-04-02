<?php
include 'theme.php';
ceklogin();
css();
echo '<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "result.txt",
                success: function(result) {
                    $("#show").html(result);
                }
            });
	$(document).ready(function() {
		$.ajaxSetup({ cache: false });
			});
		var textarea = document.getElementById("show");
		textarea.scrollTop = textarea.scrollHeight;
        }, 1000);
    });
</script>';
exec('echo "" > /www/profile/result.txt');
if($_POST['command'])
{
$kill = file_get_contents("/www/profile/command.txt");
exec("killall $kill > /www/profile/result.txt");
$command = $_POST['command'];
exec("$command > /www/profile/result.txt &");
exec("echo $command > /www/profile/command.txt");
}
?>
<form action="" method="post">
Terminal Command:<br><input type="text" autofocus name="command" size="75" value="" placeholder="For multiple commands, use: && For instace: cd /mnt && pwd"><br>
<pre>
<div id="show" style="font-size: 11px;  word-wrap: break-word; width:550px;height:310px;border:0px solid #000;text-align:left; overflow-y: scroll;"></div>
</pre>
</form>
</div>
<?php
foot();

echo '
</body>
</html>';
?>