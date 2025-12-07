<?php
//include('db.php');

session_start();
//$session_id='1'; //$session id
$idClub=$_GET['idc'];
$path = "uploads/".$idClub."/";
$uno=$_FILES['photoimg']['name'];
$dos=$_FILES['photoimg'];
//echo"Los datos: ".$idClub;
include("../../enlace/conexion.php");

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
					
					$NomFile=$txt.".".$ext;
					if(in_array($ext,$valid_formats))
					{
					if($size>(1))
						{
							//$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$actual_image_name=$name;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
									
///////////////////////////////////////////////////////////////////////////////////77									
				include("Imagen.php");  
$datos      = '{    "imgOrigen" : "'.$path.$actual_image_name.'",  
                    "imgDestino": "'.$path.$idClub.".".$ext.'",  
                    "ancho"     : "300",  
                    "alto"      : "300",  
                    "modo"      : 0,  
                    "filas"     : 6,  
                    "calidad"   : 1000,  
                    "columnas"  : 5,  
                    "centrado"  : 11,  
                    "borrar"    : true  
                 }';  
$obj_img    = new Imagen($datos);  
$obj_img    ->procesarImagen(); 
///////////////////////////////////////////////////////////////////////////7
$actual_image_name=$NomFile;

$actuaIMG=mysqli_query($conexion,"UPDATE tbx_club SET escudo='".$actual_image_name."' WHERE id=".$idClub);
//echo "UPDATE tbx_club SET escudo='".$actual_image_name."' WHERE id=".$idClub;
//echo"Confirmación".$actuaIMG;
									
			echo "<img src='sub_img/uploads/".$idClub."/".$actual_image_name."' height='200' width='150' class='preview'>";
									
									echo "<input type='text' name='nomFile' id='nomFile' value='".$actual_image_name."'  style='visibility:collapse' class='nombreF'>";
									
									
									
								}
							else
								echo "Error al subir, la carpeta no existe";
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