<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];

$Xrefer = getenv('HTTP_REFERER');  
//if (!$ref || $ref != 'una_url.php')  
if (!$Xrefer) 
{  
    // Mostrar el error y redireccionar
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/salida.html" />
     <?php
}  
else  
{  
    include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";
	} 

	require('../pdf/fpdf.php');
	//Creación del objeto de la clase heredada
$pdf=new FPDF('P','mm','Letter');
$pdf->SetLeftMargin(4);
$pdf->SetRightMargin(1);

	 $sqlClub = mysqli_query($conexion,"select escudo, nombre  from tbx_club a where id=".$id_usu);
	 $res=mysqli_fetch_array($sqlClub, MYSQLI_ASSOC);
	$idAsA=@$_GET["idAsA"] or exit("Usted no ha seleccionado estudiantes.");
	//echo"id: ".$idAsA;
$str = $idAsA;	
$idAsA2 = explode("-",$str);
$aux = $idAsA2;
$num = count($aux);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,5);

if($num>0){
	$x=5;
	$x2=20;
	$x3=20;
	$cn=0;
   for($k=0 ;$k<$num; $k++ ){// INICIO DEL CICLO PARA RECORRER LOS ESTUDIANTES DE LA LISTA
   ///////////////////////////////////////////////
   $sqlDep = mysqli_query($conexion,"select id, nombres, film, apellidos, tipo_doc, documento, fecha_nac, lugar_nac, sexo, barrio, direccion, nombreEps, celular, email, servsalud, cod_int  from tbx_deportistas a where id=".$idAsA2[$k]);
	  
$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);
	 $codi=(int)$resultados['cod_int'];
	 $genero=(int)$resultados['sexo'];
	 if($genero==2){
		 $gen='FEMENINO';
	 }else{
		  $gen='MASCULINO';
		 
		 }
	 
   ///////////////////////////////////////////////
   $cn=$cn+1;
  $pdf->Image('fondo_c.png','10',$x,'85','50','PNG');
  $pdf->Image('attras_c.png','100',$x,'85','50','PNG');
  $pdf->SetFont('Arial','B',14);
   $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(95,5,utf8_decode($res['nombre']),0,0,'C');
  $pdf->Ln(5);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(10);
  $pdf->Cell(5,35,utf8_decode('Nombres: '.strtoupper($resultados['nombres'])),0,0,'L');
  $pdf->Ln(4);
  $pdf->Cell(10);
  $pdf->Cell(5,35,utf8_decode('Apellidos: '.strtoupper($resultados['apellidos'])),0,0,'L');
  $pdf->Ln(4);
  $pdf->Cell(10);
  $pdf->Cell(5,35,utf8_decode('Genero: '.$gen),0,0,'L');
  $pdf->Ln(4);
  $pdf->Cell(10);
  $pdf->Cell(5,35,utf8_decode('Documento: '.$resultados['documento']),0,0,'L');
  $pdf->Ln(4);
  $pdf->Cell(10);
  $pdf->Cell(5,35,utf8_decode('ID: '.$codi),0,0,'L');
 
 $pdf->Image('../../../../sub_img/uploads/1/'.$resultados['film'],'72',$x2,'20','27','');
 $pdf->Image('../../../../sub_img/uploads/1/'.$res['escudo'],'14',($x2-2),'12','12');
 $pdf->Image('../../../../sub_img/uploads/1/'.$res['escudo'],'108',($x2-10),'35','35');
  
  $x=$x+60;
  $x2=$x2+60;
  $x3=$x3+92;
  $pdf->Ln(40);
  if(($cn &  4)){
	  $pdf->AddPage();
	  $x=5;
	$x2=20;
	$x3=20;
	  $cn=0;
  }
   }
}
$pdf->Output();
}
   ?>