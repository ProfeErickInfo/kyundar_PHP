
<?php 
$id_estudiante=$_GET['id_estu'];
echo "estu: ".$id_estudiante;
if (is_uploaded_file($_FILES['im']['tmp_name']) ) { //recojo la imagen
///cambie aqui
$tamano = $_FILES [ 'im' ][ 'size' ]; // Leemos el tamaño del fichero 
$tamaño_max="80000000000"; // Tamaño maximo permitido
if( $tamano < $tamaño_max){
$sep=explode('image/',$_FILES['im']['type']); // Separamos image/ 
$tipo=$sep[1]; // Optenemos el tipo de imagen que es 
//$tipo=$HTTP_POST_FILES['im']['type'] // Optenemos el tipo de imagen que es 
if($tipo == "gif" || $tipo == "jpeg" || $tipo == "bmp" || $tipo == "png" || $tipo == "jpg"){ // Si el tipo de imagen a subir es el mismo de los permitidos, segimos. Puedes agregar mas tipos de imagen 
///------------------------------------------------------------------
$imagen = $_FILES['im']['name']; //Obtengo el nombre de la imagen y la extensión de la foto
$imagen1 = explode(".",$imagen); //Genero un nombre aleatorio con números y se asigno la extensión botenido anteriormente 
$imagen2 = rand(0,9).rand(100,9999).rand(100,9999).".".$imagen1[1]; //Coloco la iamgen del usuario en la carpeta correspondiente con el nuevo nombre


move_uploaded_file($_FILES['im']['tmp_name'], "pics/".$imagen2); //Asigno a la foto permisos
$ruta="pics/".$imagen2; chmod($ruta,0777);
////////////////////////////////////////////////////////////////////////////////////////////
include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}



 
 

 $sqlvacio = mysql_query("select count(id) from tbx_deportistas " ,$conexion);

 $sqlsivacio=mysql_result($sqlvacio,0,0);



 if ($sqlsivacio!=0){

 $sqlInfo = mysql_query("select * from tbx_deportistas where id=".$id_estudiante,$conexion);

 $CantInfo = mysql_num_rows($sqlInfo);
  $logo=mysql_result($sqlInfo , 0 , "film");
  echo "foto:".$logo;
   $editar ="UPDATE tbx_deportistas SET film='".$imagen2."' where id=".$id_estudiante;
   mysql_query($editar,$conexion);
 }else{

 $CantInfo=0;

 }


////////////////////////////////////////////////////////////////////////////////////////////
//////A partir de aqui sólo si quiero eliminar una foto //
//$resultArchivos = mysql_query("Selecciono el nombre de la foto antigua"); 
//$rowArchivos= mysql_fetch_array($resultArchivos); 
if($logo!='0.png'){
   unlink("pics/". $logo); echo "Tu nueva imagen ha sido subida.";
   }
} 
}

}
?>