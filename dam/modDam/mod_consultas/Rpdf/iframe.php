<?php 
	
	$url= $_GET['url'];
	$h = $_GET['h'];
	$p = $_GET['p'];
	$p2=$_GET['p2'];
	$p3=$_GET['p3'];
	

?>
<body style="background-color:transparent;">
<iframe height="<?=$h.'px'?>" width="100%" frameborder="0" scrolling="yes" src="<?= $url."&p=".$p."&p2=".$p2."&p3=".$p3 ?>" allowtransparency="yes"></iframe>
</body>