<?php 
	
	$url= $_GET['url'];
	$h = $_GET['h'];
	$p = $_GET['idper'];
	$p2=$_GET['idper'];
	$o = $_GET['orden'];
	$g = $_GET['idevent'];
	$nRonda = $_GET['nRonda'];
	

?>
<body style="background-color:transparent;">
<iframe height="<?=$h.'px'?>" width="100%" frameborder="0" scrolling="yes" src="<?= $url."&idper=".$p."&orden=".$o."&idevent=".$g."&idper=".$p2. "&nRonda=".$nRonda ?>" allowtransparency="yes" style="width:100%; height:700px;" frameborder="0"></iframe>
</body>