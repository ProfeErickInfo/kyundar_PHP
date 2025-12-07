<?php
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
session_start();


//$session_id='1'; //$session id
$idClub=(int)@$_SESSION['id_usuario'];
//$idClub=$_GET['idClub'];;
$path = "uploads/".$idClub."/";
$idDep=$_GET['rudp'];
include("../../enlace/conexion.php");
include "sub_img/scripts/class.upload.php";


	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}


	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					$fecha=date("Y-m-d");
					$txt=$_GET['rudp'].$fecha.time();
					$idRud=$txt.".".$ext;
					if(in_array($ext,$valid_formats))
					{
					if($size>(1))
						{
							//$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$actual_image_name=$name;
							$tmp = $_FILES['photoimg']['tmp_name'];
							//echo $path.$actual_image_name;
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
									
/////////////////////////BORRO ARCHIVO EN DISCO///////////////////////////////////////77
$findFile=mysqli_query($conexion,"select film from tbx_deportistas  WHERE id=".$idDep);
$resFile=mysqli_fetch_array($findFile, MYSQLI_ASSOC);
$nameFile=$resFile["film"];
unlink($path.$nameFile);
									
///////////////////////////////////////////////////////////////////////////////////
//////Funcion de comprimir imagen------------------------
/* 
 * Función personalizada para comprimir y 
 * subir una imagen mediante PHP
 */ 
$im = new imagick("01.jpg");
$imageprops = $im->getImageGeometry();
$width = $imageprops['width'];
$height = $imageprops['height'];
if($width > $height){
    $newHeight = 180;
    $newWidth = (150 / $height) * $width;
}else{
    $newWidth = 150;
    $newHeight = (180 / $width) * $height;
}
$im->resizeImage($newWidth,$newHeight, imagick::FILTER_LANCZOS, 0.9, true);
$im->cropImage (150,180,0,0);
$im->writeImage( "01_280x280_test.jpg" );
echo '<img src="01_280x280_test.jpg">';



////-----------------------------------------------------

////llamada
 
//	include("Imagen.php");  
									
									//echo "File: ".$path.$idRud;
/*									
$datos      = '{    "imgOrigen" : "'.$path.$actual_image_name.'",  
                    "imgDestino": "'.$path.$idRud.'",  
                    "ancho"     : "240",  
                    "alto"      : "300",  
                    "modo"      : 1,  
                    "filas"     : 6,  
                    "calidad"   : 1500,  
                    "columnas"  : 5,  
                    "centrado"  : 11,  
                    "borrar"    : true  
                 }';  
				

$obj_img    = new Imagen($datos);  
$obj_img    ->procesarImagen(); 
*/
 ////////////////////////////////////////////////////////////////////////////
list($width, $height, $type, $attr) = getimagesize($path.$idRud);

 //Imagen inicial horizontal
$image = $path.$idRud;
//Destino de la nueva imagen vertical
$image_rotate = $path.$idRud;
 
//Definimos los grados de rotacion
if($width > $height){
$degrees = -90;
}else{
	$degrees=0;
}
//Creamos una nueva imagen a partir del fichero inicial
$source = imagecreatefromjpeg($image);
 
//Rotamos la imagen 90 grados
$rotate = imagerotate($source, $degrees, 1);
 
//Creamos el archivo jpg vertical
imagejpeg($rotate, $image_rotate);
///////////////////////////////////////////////////////////////////////////7
 unlink($path.$actual_image_name);

$actual_image_name=$idRud;
mysqli_query($conexion,"UPDATE tbx_deportistas SET film='$actual_image_name' WHERE id=".$idDep);
//echo "UPDATE tbx_deportistas SET film='$actual_image_name' WHERE id=".$idDep;
									echo "<img src='sub_img/uploads/".$idClub."/".$actual_image_name."' height='250' width='200' class='preview'>";
									
									echo "<input type='text' name='nomFile' id='nomFile' value='".$actual_image_name."'  style='visibility:collapse' class='nombreF'>";
									
									
									
								}
							else
								echo "Error al subir";
						}
						else
					echo "Está intentando cargar un fichero que excede el tamaño de 50 Kilobytes.  \n ";
					
					//echo "\n El peso maximo de la imagen es de 50 Kilobytes.";					
						}
						else
						echo "Formato no valido..";	
				}
				
			else
				echo "Seleccione una imagen..!";
				
			exit;
		}
?>