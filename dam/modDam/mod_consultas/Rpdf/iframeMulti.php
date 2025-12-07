<?php 
	
	$url= $_GET['url'];
	$h = $_GET['h'];
    
	$idEvent = $_GET['idEvent'];
	$idGen=$_GET['idGen'];
	$idCat=$_GET['idCat'];
    $idNivel=$_GET['idNivel'];
    $idTipo=$_GET['idTipo'];
    $idPeso=$_GET['idPeso'];
	$idClub=$_GET['idClub'];

   
	

?>
<body style="background-color:transparent;">
<iframe height="<?=$h.'px'?>" width="100%" frameborder="0" scrolling="yes" src="<?= $url."&idEvent=".$idEvent."&idGen=".$idGen."&idCat=".$idCat."&idNivel=".$idNivel."&idPeso=".$idPeso."&idTipo=".$idTipo."&idClub=".$idClub?>" allowtransparency="yes"></iframe>
</body>