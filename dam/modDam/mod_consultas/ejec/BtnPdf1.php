<?php
$cat = $_GET['cat'];
$pes = $_GET['pes'];
$niv = $_GET['niv'];
$orden1 = $_GET['orden1'];
//echo $cat."-".$pes."-".$niv."-".$orden1;
?>
<a id="link" title="Descargar lista en Excel" target="_blank"    href="modDam/mod_consultas/Rpdf/ejec/listaxpeso_xls.php?cat=<?=base64_encode($cat)?>&pes=<?=base64_encode($pes)?>&niv=<?=base64_encode($niv)?>&orden1=<?=base64_encode($orden1)?>" onclick = " if (( <?php echo $cat;?> < 0)or( <?php echo $pes;?> < 0) ) event.preventDefault();"><img src="imag/Down_excel.png"  id="btnXls" style="width:70px; height:70px"/></a> 


 <a title="Descargar lista en PDF" target="_blank"   href="modDam/mod_consultas/Rpdf/ejec/listaxpeso_pdf.php?cat=<?=base64_encode($cat)?>&pes=<?=base64_encode($pes)?>&niv=<?=base64_encode($niv)?>&orden1=<?=base64_encode($orden1)?>"><img src="imag/pdf_red.png"  id="btnbusca" style="width:70px; height:70px"/></a> 
 
 
 
 