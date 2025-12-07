<?php
$clb = $_GET['clb'];
$gen = $_GET['gen'];
?>
<a title="Buscar Deportista" style="cursor:pointer" onclick="cargarFocus('modDam/mod_consultas/ejec/listaxgenero.php?clb=<?=$clb?>&gen=<?=$gen?>','Dvisual','carga','');"><img src="imag/buscar1.png"  id="btnbusca" style="width:70px; height:70px"/></a> 
 <a title="Descargar lista en PDF"  target="_blank" href="modDam/mod_consultas/Rpdf/ejec/listaxgenero_pdf.php?clb=<?=base64_encode($clb)?>&gen=<?=base64_encode($gen)?>"><img src="imag/pdf_red.png"  id="btnbusca" style="width:70px; height:70px"/></a> 