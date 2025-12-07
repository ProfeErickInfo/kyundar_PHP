<?php 
	
	$url= $_GET['url'];
	$h = $_GET['h'];
	$p = $_GET['idper'];
	$f = $_GET['Fec1'];
	$f2=$_GET['Fec2'];
	//$o = $_GET['orden'];
	//$g = $_GET['idgrupo'];
	

?>
<body style="background-color:transparent;">
<iframe height="<?=$h.'px'?>" width="100%" frameborder="0" scrolling="yes" src="<?= $url."&idper=".$p."&Fec1=".$f."&Fec2=".$f2?>" allowtransparency="yes"></iframe>
</body>