<?php
include 'theme.php';
css();
if($_POST['cancel']){

     echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
     echo "USSD :<input type=\"text\" autofocus name=\"ussd\" size=\"14\" value=\"$ssid[0]\"/>";
     echo "<input name=\"send\" type=\"submit\" value=\"Send Ussd\" />
     <input name=\"cancel\" type=\"submit\" value=\"Cancel Ussd\" />
     </form>";
     echo "<br>";
     echo '
     <div align="center" >
     <div style="left:10px;width:350px;height:210px;border:1px solid #000;text-align:center; font-size: 14px;  word-wrap: break-word; overflow-y: scroll;">';
     exec('gsm ussd -e',$out);  
     $notend=0;
     $arrlength=count($out);
     for($x=0;$x<$arrlength;$x++)
     {
        if ($out[$x] == "NOTEND"){
        $notend=1;
        }else{
        echo $out[$x]. "<br>";}
     }
     echo '
    </div>
    </div>';
    if ($notend == 1){
     echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
     echo "<input name=\"cancel\" type=\"submit\" value=\"Batalkan Sesi\" />
     </form>";}
    echo '
    </div>';
    foot();
    echo '
    </div>
 
    </body>
    </html>';
    exit;

}
if($_POST['send']){
    $ussd=$_POST['ussd'];

     echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
     echo "USSD :<input type=\"text\" autofocus name=\"ussd\" size=\"14\" value=\"$ssid[0]\"/>";
     echo "<input name=\"send\" type=\"submit\" value=\"Send Ussd\" />
     <input name=\"cancel\" type=\"submit\" value=\"Cancel Ussd\" />
     </form>";
     echo "<br>";
     echo '
     <div align="center" >
     <div style="width:350px;height:210px;border:1px solid #000;text-align:center; font-size: 14px;  word-wrap: break-word; overflow-y: scroll;">
     <div align="center">
     <div style="width:320px;height:210px;text-align:left;">';
     exec('gsm ussd '.$ussd,$out);  
     $notend=0;
     $arrlength=count($out);
     for($x=0;$x<$arrlength;$x++)
     {
        if ($out[$x] == "NOTEND"){
        $notend=1;
        }else{
        echo $out[$x]. "<br>";}
     }  
     echo '
    </div>
    </div>
    </div>
    </div>';
    if ($notend == 1){
     echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
     echo "<input name=\"cancel\" type=\"submit\" value=\"Batalkan Sesi\" />
     </form>";}
    echo '
    </div>';
    foot();
    echo '
    </div>
 
    </body>
    </html>';
    exit;

    }

echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo "USSD :<input type=\"text\" autofocus name=\"ussd\" size=\"14\" value=\"$ssid[0]\"/>";
echo "<input name=\"send\" type=\"submit\" value=\"Send Ussd\" />
     <input name=\"cancel\" type=\"submit\" value=\"Cancel Ussd\" />
</form>";
echo "<br>";
echo '
<div align="center" >
<div style="width:380px;height:210px;border:1px solid #000; font-size: 14px;  word-wrap: break-word; overflow-y: scroll;">
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
