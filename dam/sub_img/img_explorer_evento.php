<?
 
echo "<table width='100%'  border='0' cellspacing='0' cellpadding='0' class='table'>\n"; 

echo '<thead>
			<tr>
          <th width="20%"  align="left" >Imagen </th>
          <th width="40%"  align="left" >Nombre </th>
		  <th width="20%"  align="left" >Tamaño </th>
		   <th width="20%"  align="left" ></th>
          </tr> </thead>
		   <tbody>'; 
$directorio = opendir("uploads");  
while ($archivo = readdir($directorio))     
{   $nombreArch = ($archivo);
if(filetype($nombreArch)!="dir"){ 

if (file_exists('uploads/'.$nombreArch)) {
   $tamano=filesize('uploads/'.$nombreArch);
  
   $tamano=($tamano/1024);
    $tamano=round($tamano,2);
    // mostramos su peso ya modificado 
} else {
    $tamano=0;
}
?> 
 <?
 // get contents of a file into a string

 
 
 //$tamano = getimagesize("sub_img/uploads/'".$nombreArch."'");
 
//$nombreArch = str_replace("..", "Atras", $nombreArch);   
echo "<tr>\n<td style='cursor:pointer'>\n"?><a onClick="grupoFocus('sub_img/img_vista_evento.php?nombreArch=<?=$nombreArch?>','dvpreview','carga','','sub_img/img_text_oculto.php?nombreArch=<?=$nombreArch?>','DivImagen','');" title="Clic para visualizar"><? "\n";     
echo "<img src='sub_img/uploads/$nombreArch' alt='Ver $nombreArch'  height='30px' width='30px'";  
echo "</td>";
echo "<td><a><b>$nombreArch</b></a></td>";
echo "<td><a><b>$tamano KB</b></a></td>";
echo "<td style='cursor:pointer'></a></td>";

echo "\n</tr>\n";  
}
}  
closedir($directorio); 
echo '<tr class="headerLista">
          <td>&nbsp;</td>
		  <td>&nbsp;</td>
          <td></td>
		  <td>&nbsp;</td>
		  </tr>
		</tbody>
      </table>';  
?>
