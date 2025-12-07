<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  
include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
//////////////////////////////////////////////////////////////////////////
extract($_REQUEST);
$selGrados=$_GET['idGrado'];
$txtFecha=$_GET['fec'];


$str = $idgAtleta;	

$codsOfAtleta = explode("-",$str);
$aux = $codsOfAtleta;
$num = count($aux);

////////////////////////////////////////////
$ciclo=1;
$pos=0;
$idUltimo=0;
if(($num>0)){

    while ($num>=$ciclo){
  
        ////-----------verificar grado existente para el atleta------------>
       $buscar = "SELECT * FROM tbx_infoxgrado WHERE id_deportista=".$codsOfAtleta[$pos]." and id_info=".$selGrados;
       $buscaReg =mysqli_query($conexion,$buscar);
       $encontrado=mysqli_num_rows($buscaReg);


        /////--------------------------->
        if($encontrado==0){
                
            $insertar = "INSERT INTO tbx_infoxgrado(id_deportista, id_info, fecha, ultimo)  VALUES (".$codsOfAtleta[$pos].",".$selGrados.",'".$txtFecha."',".$idUltimo.")";
            $insertarReg =mysqli_query($conexion,$insertar);
           /////////////////////////////////////////////////////////
                $buscarMax=mysqli_query($conexion,"select MAX(id) AS mayor from tbx_infoxgrado where id_deportista=".$codsOfAtleta[$pos]);
                $fila=mysqli_fetch_array($buscarMax, MYSQLI_ASSOC);

                $editar =mysqli_query($conexion,"UPDATE tbx_infoxgrado SET  ultimo=0 where id_deportista=".$codsOfAtleta[$pos]." and id<>".$fila['mayor']);
 
                $editar2 =mysqli_query($conexion,"UPDATE tbx_deportistas SET  id_grado=".$selGrados." where id=".$codsOfAtleta[$pos]);
   
 		
//////////////////////////////////////////////////////////	
        
        }
     
        $ciclo++;
        $pos++;
    }
   
    
}

////////////////////////////////////////////
if(($num==$ciclo)){
echo"Proceso Terminado";
}else{
    echo"Algunos atletas ya tenian asignado el grado seleccionado."; 
}

?>