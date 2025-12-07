<?php
$opbusca = 1;
	$tpc = $_GET['tpc'];
	$dto = $_GET['dto'];
?>
<a title="Descargar lista en PDF" target="_blank"   href="modDam/mod_consultas/Rpdf/ejec/listaZ_pdf.php?tpc=<?=base64_encode($tpc)?>&dto=<?=base64_encode($dto)?>"><img src="imag/pdf_red.png"  id="btnbusca" style="width:30px; height:30px"/></a> 
 

 