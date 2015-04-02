<?php
include 'theme.php';
ceklogin();
function getFiles($path = 'mnt') {
   
    // Open the path set
    if ($handle = opendir($path)){
       
        // Loop through each file in the directory
        while ( false !== ($file = readdir($handle)) ) {
           
            // Remove the . and .. directories
            if ( $file != "." && $file != ".." ) {
               
                // Check to see if the file is a directory
                if( is_dir($path . '/' . $file) ) {
                   
                    // The file is a directory, therefore run a dir check again
                    getFiles($path . '/' . $file);
                   
                }
               
                // Get the information about the file
                $fileInfo = pathinfo($file);
               
                // Set multiple extension types that are allowed
                $allowedExtensions = array('mkv', 'mp4','MKV','MP4');
               
                // Check to ensure the file is allowed before returning the results
                if( in_array($fileInfo['extension'], $allowedExtensions) ) {
					echo '<li class="active"><a href="' . $path . '/' . $file . '">' . $file . '</a></li>';
                }
               
            }
        }
       
        // Close the handle
        closedir($handle);
    }
}
css();
echo '
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" type="image/png" href="favicon.png">
<script type="text/javascript">
var msg = "OpenWrt Angel Beats! Edition";
msg = " | " + msg;pos = 0;
function scrollTitle() {
document.title = msg.substring(pos, msg.length) + msg.substring(0, pos); pos++;
if (pos > msg.length) pos = 0
window.setTimeout("scrollTitle()",300);
}
scrollTitle();
</script>
<style type="text/css">
#videoarea {
 float: left;
   width:630px;
   height:350px;
   border:1px solid #EBEBFA;
   
}
#playlist {
		margin-top: 0px;
        float: left;
        width: 300px;
		height:350px;
		list-style-type: none;
		padding:0px;
		font-size: 13px; 
		word-wrap: break-word; 
		border:0px solid #000; 
		text-align:left; 
		overflow-y: scroll;
		background:rgba(0, 0, 0, 0.0);
		border:1px solid #EBEBFA;
}
.active a{color:#00FF00;text-decoration:none;}
li a{color:#FFFFFF;background:rgba(0, 0, 0, 0.5);padding:0px;display:block;text-decoration: none;}
li a:hover{color:#FFFF00; text-decoration:none;}
</style>
   <script type="text/javascript" src="jquery-2.1.3.min.js"></script>
   <script type="text/javascript">
var video;
var playlist;
var tracks;
var current;
 
$(document).ready(function() {
 init();
});
function init(){
   current = 0;
   video = $("video");
   playlist = $("#playlist");
   tracks = playlist.find("li a");
   len = tracks.length - 1;
   video[0].volume = .50;
   video[0].play();
   playlist.find("a").click(function(e){
       e.preventDefault();
       link = $(this);
       current = link.parent().index();
       run(link, video[0]);
   });
   video[0].addEventListener("ended",function(e){
       current++;
       if(current == len){
           current = 0;
           link = playlist.find("a")[0];
       }else{
           link = playlist.find("a")[current];    
       }
       run($(link),video[0]);
   });
}
function run(link, player){
       player.src = link.attr("href");
       par = link.parent();
       par.addClass("active").siblings().removeClass("active");
       video[0].load();
       video[0].play();
}
</script>
</head>
<body>
<video id="videoarea" controls="controls" poster="/images/video-poster.jpg" src="" ></video>
<ul id="playlist">';
getFiles();
echo '
</ul>
<br>
<b>Supported file formats: *.mkv and *.mp4 | Supported browser: Google Chrome</b>
</div>';
foot();
echo '
</body>
</html>';
?>