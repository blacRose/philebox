<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript">
	function setCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	</script>
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<?php
		if (isset($_COOKIE["bg"]))
		{
			echo '<style type="text/css"> body { background-image: url(uploads/';
			echo $_COOKIE["bg"];
			echo '.jpg); } </style>';
		}
		else
		{
			echo '<style type="text/css"> body { background-image: url(uploads/1.jpg); } </style>';
		}
		function bgs($input)
		{
			if (isset($_COOKIE["bg"]))
			{
				if ($_COOKIE["bg"] == $input)
				{
					echo "selected";
				}
			} else {
				if($input=="1")
				{
					echo "selected";
				} 
			}
		}
	?>
</head>
<body style="cursor: auto;">
<script type="text/javascript">
var display = true;

$(document).ready(function(){
	$(".1").click(function(){
		$("body").css("background-image", "url(uploads/1.jpg)");
		$("ul.wall").children().removeClass("selected");
		$(".1").addClass("selected");
		setCookie("bg", "1", 3600);
	});
	$(".2").click(function(){
		$("body").css("background-image", "url(uploads/2.jpg)");
		$("ul.wall").children().removeClass("selected");
		$(".2").addClass("selected");
		setCookie("bg", "2", 3600);
	});
	$(".3").click(function(){
		$("body").css("background-image", "url(uploads/3.jpg)");
		$("ul.wall").children().removeClass("selected");
		$(".3").addClass("selected");
		setCookie("bg", "3", 3600);
	});
	$(".4").click(function(){
		$("body").css("background-image", "url(uploads/4.jpg)");
		$("ul.wall").children().removeClass("selected");
		$(".4").addClass("selected");
		setCookie("bg", "4", 3600);
	});
});

</script>
<div class="title" id="title">
	<h1>Files... upload/browse</h1>
</div>
<div class="block">
	<div class="cell" id="cell" style="display: block; ">
		<div id="file-uploader">
			<noscript>          
				<p>Please enable JavaScript to use file uploader.</p>
			</noscript>
		</div>
		<div class="content" id="content"></div>
	</div>
</div>
<br><br>

<div class="block">
	<div id="browse">
		<?php
			function prettySize($size){
				$units = array(' B', ' KB', ' MB', ' GB', ' TB');
			    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
			    return round($size, 2).$units[$i];
			}
				function tangoIcon($ext, $size = "32"){
					$images = array("jpg", "png", "jpeg", "gif", "tiff");
					$video  = array("mkv", "mp4", "m4v", "mov");
					$text   = array("txt", "mdown", "md", "markdown");
					$web    = array("html", "php", "css", "js");
					if (in_array(strtolower($ext), $images))
					{
						$out = "http://shelbymunsch.com/img/tango-icons/".$size."x".$size."/mimetypes/image-x-generic.png";
					}
					elseif (in_array(strtolower($ext), $video))
					{
						$out = "http://shelbymunsch.com/img/tango-icons/".$size."x".$size."/mimetypes/video-x-generic.png";
					}
					elseif (in_array(strtolower($ext), $text))
					{
						$out = "http://shelbymunsch.com/img/tango-icons/".$size."x".$size."/mimetypes/text-x-generic.png";
					}
					elseif (in_array(strtolower($ext), $web))
					{
						$out = "http://shelbymunsch.com/img/tango-icons/".$size."x".$size."/mimetypes/text-html.png";
					}
					else
					{
						$out = "http://shelbymunsch.com/img/tango-icons/".$size."x".$size."/mimetypes/generic-icon.png";
					}
					return $out;
				}
				function showContent($path){
					if ($handle = opendir($path))
					{
						$up = substr($path, 0, (strrpos(dirname($path."/."),"/")));
						$count = 0;
						$files = "";
						$images= "";
						while (false !== ($file = readdir($handle)))
						{
							if ($file != "." && $file != "..")
							{
								$fName  = $file;
								$file   = $path.'/'.$file;
								$fSize  = prettySize(filesize($file));
								$ext = substr($fName, strrpos($fName, '.') + 1);
								$fImage = tangoIcon($ext);
								$imagexts = array("jpg", "png", "jpeg", "gif");
								
								if (!is_dir($file)) {
									if (in_array(strtolower($ext), $imagexts)) {
										// Image handler!
										$images .= "<div id='img'><a href='".$file."' class='img'><img src='".$file."'><p class='caption'>".$fName."</p></a></div>";
										$count++;
										if ( $count == 4 ) { $images .= "<br style=\"clear:both;\">"; $count = 0; }
									} else {
										if(is_file($file) && $fName != ".DS_Store" && $ext != "php" && "." . $ext != $fName) {
											$files .= "<div class='file' style=\"background:url('".$fImage."') bottom left no-repeat; line-height: 32px; padding-left: 36px; clear: both;\"><a href='".$file."'>".$fName."</a>: ".$fSize."</div>\n";
										}
									}
								}
							}
						}
						closedir($handle);
						echo $files;
						echo $images;
					}    
				}
			showContent("uploads");
		?>
		<br style="clear:both;">
	</div>
</div>

<ul class="wall">
	<li>wall:</li>
	<li class="1 <?php bgs("1"); ?>">1</li>
	<li class="2 <?php bgs("2"); ?>">2</li>
	<li class="3 <?php bgs("3"); ?>">3</li>
	<li class="4 <?php bgs("4"); ?>">4</li>
</ul>

<script src="js/fileuploader.js" type="text/javascript"></script>
<script>        
function createUploader(){            
	var uploader = new qq.FileUploader({
		element: document.getElementById('file-uploader'),
		action: 'fileuploader.php',
		debug: true
	});           
}

// in your app create uploader as soon as the DOM is ready
// don't wait for the window to load  
window.onload = createUploader;     
</script>

</body></html>
