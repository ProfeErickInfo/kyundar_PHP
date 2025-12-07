<?php
session_start();
//$session_id='1'; //$session id
//echo"Entre";
$idClub=(int)@$_SESSION['id_usuario'];
$path = "uploads/".$idClub."/";
include("../../enlace/conexion.php");
$idDep=$_GET['rudp'];

//echo"Nomb-1: ".  $nuevoNombre;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photoimg'])) {


   // if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    // Configuraciones
    $directorioDestino = $path; // Carpeta donde guardarás la imagen
    $maxWidth = 800;  // Ancho máximo
    $maxHeight = 600; // Altura máxima
   // echo"Nomb-2: ".  $nuevoNombre;
    // Obtener información de la imagen subida
    $nombreArchivo = $_FILES['photoimg']['name'];
    $rutaTemporal = $_FILES['photoimg']['tmp_name'];
    $tipoArchivo = $_FILES['photoimg']['type'];
    $tamanoArchivo = $_FILES['photoimg']['size'];
//echo "File: ".$nombreArchivo;
    // Verificar si la imagen es válida
    $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($tipoArchivo, $extensionesPermitidas)) {
        die("Solo se permiten imágenes JPG, PNG y GIF.");
    }

    // Crear un nombre único para la imagen
    $codigoSeg=uniqid();
    $nuevoNombre = $directorioDestino . $codigoSeg . '-' . basename($nombreArchivo);
    
    $NomFileFinal=$codigoSeg.'-'.$nombreArchivo;
    //echo"Archivo: ".  $NomFileFinal;
    // Verificar que el directorio de destino exista
    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }
    /////////////////////////BORRO ARCHIVO EN DISCO///////////////////////////////////////77
        $findFile=mysqli_query($conexion,"select film from tbx_deportistas  WHERE id=".$idDep);
        $resFile=mysqli_fetch_array($findFile, MYSQLI_ASSOC);
        $nameFile=$resFile["film"];
        unlink($path.$nameFile);
									
    ///////////////////////////////////////////////////////////////////////////////////
    // Subir la imagen al servidor
    if (move_uploaded_file($rutaTemporal, $nuevoNombre)) {
       // echo "La imagen se ha subido correctamente.<br>";

        // Redimensionar la imagen
        redimensionarImagen($nuevoNombre, $maxWidth, $maxHeight);
       // echo "La imagen ha sido redimensionada.";
    } else {
        echo "Hubo un error al subir la imagen.";
    }
}

// Función para redimensionar la imagen manteniendo la calidad
function redimensionarImagen($rutaImagen, $maxWidth, $maxHeight) {
    // Obtener las dimensiones originales de la imagen
    list($width, $height, $tipo) = getimagesize($rutaImagen);

    // Calcular la relación de aspecto
    $aspectRatio = $width / $height;

    // Redimensionar según el tamaño máximo
    if ($width > $maxWidth || $height > $maxHeight) {
        if ($width / $maxWidth > $height / $maxHeight) {
            $nuevoAncho = $maxWidth;
            $nuevoAlto = $maxWidth / $aspectRatio;
        } else {
            $nuevoAlto = $maxHeight;
            $nuevoAncho = $maxHeight * $aspectRatio;
        }
    } else {
        // Si la imagen no excede los límites, no se redimensiona
        return;
    }

    // Crear una nueva imagen con las dimensiones redimensionadas
    $imagenRedimensionada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

    // Cargar la imagen según su tipo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagenOriginal = imagecreatefromjpeg($rutaImagen);
            break;
        case IMAGETYPE_PNG:
            $imagenOriginal = imagecreatefrompng($rutaImagen);
            break;
        case IMAGETYPE_GIF:
            $imagenOriginal = imagecreatefromgif($rutaImagen);
            break;
        default:
            die("Formato de imagen no soportado.");
    }

    // Copiar la imagen original a la nueva imagen redimensionada
    imagecopyresampled($imagenRedimensionada, $imagenOriginal, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $width, $height);

    // Guardar la imagen redimensionada
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            imagejpeg($imagenRedimensionada, $rutaImagen, 90); // Calidad 90 (alta calidad)
            break;
        case IMAGETYPE_PNG:
            imagepng($imagenRedimensionada, $rutaImagen);
            break;
        case IMAGETYPE_GIF:
            imagegif($imagenRedimensionada, $rutaImagen);
            break;
    }

    // Liberar memoria
    imagedestroy($imagenOriginal);
    imagedestroy($imagenRedimensionada);



}

$actual_image_name=$NomFileFinal;
//echo "UPDATE tbx_deportistas SET film='$actual_image_name' WHERE id=".$idDep;
mysqli_query($conexion,"UPDATE tbx_deportistas SET film='$actual_image_name' WHERE id=".$idDep);
                                                         
	echo "<img  id='fotoPerfil' src='sub_img/uploads/".$idClub."/".$actual_image_name."' height='250' width='200' class='rounded'>";
									
	echo "<input type='text' name='nomFile' id='nomFile' value='".$actual_image_name."'  style='visibility:hidden' >";
									
					
?>
