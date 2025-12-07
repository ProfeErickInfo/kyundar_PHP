<?php
$clb = $_GET['clb'];
$gen = $_GET['gen'];
?>

 <a id="link" title="Descargar lista en Excel" target="_blank"    href="modDam/mod_consultas/Rpdf/ejec/listaxgenero_xls.php?clb=<?=base64_encode($clb)?>&gen=<?=base64_encode($gen)?>" onclick = " if (( <?php echo $clb;?> < 0)or( <?php echo $gen;?> < 0) ) event.preventDefault();"><img src="imag/Down_excel.png"  id="btnXls" style="width:70px; height:70px"/></a> 
 
 
 
