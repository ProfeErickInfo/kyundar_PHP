<?PHP
@session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  
//if (!$ref || $ref != 'una_url.php')  



if ((!$Xrefer) || ($id_usu==0)){
  ?> 
  <script languaje="JavaScript">
  location.href='../index.html';
  </script>
  
  <?php
  }else{
    // Se ejecuta el ajax normalmente  
 
include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

/////////////////////////////////////////////////
$opbusca = $_GET['opbusca'];
	$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    $vBusca = $_GET['vbusca'];
   
	////////////////////////////////////////////////////
	

	////////////////////////////////////////////////////
	//echo"opb: ".$opbusca;
//	echo"vbu: ".$vBusca;
	$fec_actual=date('Y-m-d');	
 // Consulta preparada para obtener socios
 
$query = "SELECT a.id, a.nombres, a.apellidos, a.film, a.cod_int, a.documento, a.fecha_nac, a.tipo_socio, a.celular, a.email,
                 (SELECT g.nombre FROM trn25_genero g WHERE g.id = a.sexo) AS genero,
                 (SELECT t.descripcion FROM trn25_tipo_socio t WHERE t.id = a.tipo_socio) AS tSocio
          from trn25_socios a where a.id_Club=".$id_usu." and concat(a.nombres,' ',a.apellidos) like '%".$vBusca."%' order by ".$OrderBy;	
   $sqlSoc = mysqli_query($conexion, $query);
 

  
	
	$CantSoc = mysqli_num_rows($sqlSoc);
   

if($CantSoc!=0){



//////////////////////////////////////////////
?>
 <!--------------------CODIGO NUEVO--------------------------------------->
<div class="table-responsive">
        
      <table class="table table-bordered table-hover" id="tablaSocios">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Documento</th>
            <th>Nombre completo</th>
            <th>Fecha Nac.</th>
            <th>Celular</th>
            <th>Email</th>
            <th>Tipo de Socio</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargan los socios -->
   
           <?php
           $conSoc=0;
            while ($fila = mysqli_fetch_array($sqlSoc, MYSQLI_ASSOC)): 
            $conSoc++;
            ?>
          <tr>
            <td><?php echo htmlspecialchars($conSoc); ?></td>
            <td><?php echo htmlspecialchars($fila['documento']); ?></td>
            <td><?php echo htmlspecialchars($fila['nombres'] . ' ' . $fila['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($fila['fecha_nac']); ?></td>
            <td><?php echo htmlspecialchars($fila['celular'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($fila['email'] ?? ''); ?></td>
             <td>
            <?php
             
              // Por ejemplo, si es titular o beneficiario
             echo  htmlspecialchars($fila['tSocio'] ?? 'N/A'); 
              ?>
            </td>
          </tr>
          <?php endwhile; ?>
          </div>
        </tbody>
      </table>
    </div>
<hr class="new1">
<div class="row mt-2">
  <div class="col-8 text-left">Total Socios:</div>
  <div class="col-4 text-right"><?php echo $CantAth; ?></div>
</div>
   
<!------------------------------------------------------------------>

    <?php 

  



}else{
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
   <div>
   <strong>Alerta!</strong> Socio no encontrado.
   
   </div>
 </div>
 <?
    exit();
 }

  }
?>