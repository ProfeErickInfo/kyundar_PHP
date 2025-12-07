<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER'); 
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<!----------------------------------------------------------------->
 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


<!-- Bootstrap ya está cargado en el menú principal - Comentado para evitar conflictos
-->
<!--------------------------------------------------->

</head>
<?php  

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
    // Se ejecuta el ajax normalmente  
 
?>  

<?php 

	include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

//echo "tipo:".$_SESSION['tipo_U'];
//connexion 


	//$sqlGrados=mysqli_query($conexion,"select * from tbx_grados");

	$sqlTD=mysqli_query($conexion,"select * from tbx_tipo_documento order by descripcion");
	$sqlTD2=mysqli_query($conexion,"select * from tbx_tipo_documento order by descripcion");
 
	$sqlGrados=mysqli_query($conexion,"select * from tbx_grados order by id");

	$sqlLugar=mysqli_query($conexion,"select * from tbx_municipios order by nombre");

	$sqlSexo=mysqli_query($conexion,"select * from tbx_genero where id<3");
	
	$sqlSalud=mysqli_query($conexion,"select * from tbx_ssalud");

	$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios order by nombre");
	//echo "id:".$id_usu;
	$sqlClub=mysqli_query($conexion,"select * from tbx_club order by nombre");
  
	$sqlClub2=mysqli_query($conexion,"select * from tbx_club where id=".$id_usu." order by nombre");
	$reg2=mysqli_fetch_array($sqlClub2, MYSQLI_NUM);

	

		//VERIFICO EL METODO DE ASIGNACION DE ID_ALUMNO [AUTO] [MANUAL]

	//	$sqlConfig = mysqli_query($conexion,"select auto_id_alumno from tbx_config_valores");

		//$autoId = @mysql_result($sqlConfig,0,"auto_id_alumno");
?>
<!--INICIO FORM DEL REGISTRO DE FORMULARIO DEPORTISTA-->
<div class="container-fluid" style="color:#333; height: 550px; overflow: visible;">


<h5>Registro de Deportistas</h5>
<form id="formRE" name="formRE" method="post"  action="Javascript:SendFormSocio('modDam/mod_registro/ejec/r_deportista.php?idusu=<?= $_SESSION['id_usuario'] ?>','formRE',1,'modDam/mod_registro/scrin/reg_directo.php?idusu=<?= $_SESSION['id_usuario'] ?>','carga','DivContenido','nomClub');">  
<!--FILA DEL CLUB-->
<div class="form-row">
 <div class="form-group col-md-4"><label>
 Club al cual pertenece:</label>
      <select autofocus class="custom-select mr-sm-2"  name="nomClub" id="nomClub"  onKeyPress="return focusNext(this.form,'txtNombres',event);">
                        <?php 						
if($_SESSION['tipo_U']!=1){
						while ($reg=mysqli_fetch_array($sqlClub, MYSQLI_NUM)){
                 		echo "<option value=".$reg[0].">".$reg[1]."</option>";
				}
 }else{
	echo "<option value=".$reg2[0].">".$reg2[1]."</option>";
}
?>
</select>
</div>
</div>
 
  <!------------SEGUNDA FILA-------------->  
    <div class="form-row">
  
             
  <div class="form-group col-md-3"><label> Tipo de Documento</label>  <select class="custom-select mr-sm-2" name="TipoDocumento" id="TipoDocumento"  onKeyPress="return focusNext(this.form,'txtDocumento',event);" required >
                   <?php 						
					 while ($reg=mysqli_fetch_array($sqlTD, MYSQLI_NUM)){
				echo "<option value=".$reg[0].">".$reg[1]."</option>";
				}
				?>
                 </select>            
  </div>              
  <div class="form-group col-md-3"><label>Documento</label>
   <input type="number" name="txtDocumento" placeholder="Documento" id="txtDocumento" class="form-control" onKeyPress="return focusNextNum(this.form,'txtFechaNac',event);" required /></div>  
        <div class="form-group col-md-3">
     <label>
	 Nombre (s)</label>
     <input type="text" autofocus name="txtNombres" id="txtNombres" placeholder="Nombres" class="form-control" onkeydown="return sololetras(event,'txtNombres')" onKeyPress="return focusNext(this.form,'txtApellidos',event);"/>
     
     
   </div>
    
    <div class="form-group col-md-3">     
     
     <label> Apellido (s)</label>
<input type="text" name="txtApellidos" placeholder="Apellidos" id="txtApellidos" class="form-control" onkeydown="return sololetras(event,'txtApellidos')"  onKeyPress="return focusNext(this.form,'TipoDocumento',event);"/>
   </div>
</div>
      <!------------TERCERA FILA-------------->  
      
  <div class="form-row">              
          <div class="form-group col-md-3"><label>  Fecha de Nacimiento</label>       
                
    <input size="12" placeholder="00/00/0000" type="date"   value="<? echo(date('Y-m-d'));?>"     name="txtFechaNac" class="form-control"  id="txtFechaNac" onKeyPress="return focusNext(this.form,'LugarNac',event);" required >           
                
                
         </div>
            


       
          
 <div class="form-group col-md-3">    <label> Lugar de Nacimiento</label> 

<select name="LugarNac" id="LugarNac" class="form-control" onKeyPress="return focusNext(this.form,'Sexo',event);" required>

                    

                    <?php 						

					 while ($reg=mysqli_fetch_array($sqlLugar)){

					

					echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";

				}

					?>

                  

                  	</select>
                    </div>
                    <div class="form-group col-md-3">
 <label>
 Genero</label>

                  

                  <select name="Sexo" id="Sexo"  class="form-control" onKeyPress="return focusNext(this.form,'Barrio',event);" required>

                    <?php 						

					 while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}

					?>

                  </select>

                  </div>
                  
                  
                  <div class="form-group col-md-3">
<div style="font-weight:bolder">Lugar de residencia</div>
<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" value="1"  name="OpLugar" onClick="cargarFocus('modDam/mod_registro/scrin/PhpLugar.php?tipo='+this.value,'Dvlugar','carga','Barrio');" required><label class="form-check-label" for="flexRadioDefault1">Municipal</label>
 </div>
 
 <div class="form-check form-check-inline">
        <input type="radio" value="2" class="form-check-input" name="OpLugar" onClick="cargarFocus('modDam/mod_registro/scrin/PhpLugar.php?tipo='+this.value,'Dvlugar','carga','Barrio');" required>
<label class="form-check-label" for="flexRadioDefault1">Distrital</label>
 </div>
 
 </div>
         
</div>     
 <!------------TERCERA FILA-------------->   

     
<div class="form-row">     
  <div class="form-group col-md-3">
          <label>Barrio.</label>
                 <div id="Dvlugar" ><select name="Barrio" id="Barrio" class="form-control"  disabled onKeyPress="return focusNext(this.form,'txtDireccion',event);" required>

                 
                  </select></div>

                  </div>

 <div class="form-group col-md-3"><label>Digite la Direcci&oacute;n.</label>
                  <input type="text" name="txtDireccion" placeholder="DirecciÃ³n" id="txtDireccion" class="form-control" onKeyPress="return focusNext(this.form,'Tpsalud',event);" required />
             
    </div>          
          <div class="form-group col-md-3">     
    <label>Tipo. Serv</label>
    <select name="Tpsalud" id="Tpsalud" class="form-control" onKeyPress="return focusNext(this.form,'txtSalud',event);" required>
                    <?php 						
						while ($reg=mysqli_fetch_array($sqlSalud, MYSQLI_NUM)){
				echo "<option value=".$reg[0].">".$reg[1]."</option>";
				}
					?>
                      </select>
 </div>
  <div class="form-group col-md-3">                   
      <label>Serv. de salud</label>
       
                      <input type="text" name="txtSalud" placeholder="Escribe tu EPS " id="txtSalud" class="form-control" onKeyPress="return focusNext(this.form,'txtCelular',event);" required/>
                                   </div>    
            </div>       
      <!--------------CUARTA FILA---------------->
      <div class="form-row">
<div class="form-group col-md-3">
<div style="font-weight:bolder">Tipo de Socio Registrado</div>
<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" value="1"  name="OpSocio" onClick="javascript:nohabilita()" required><label class="form-check-label" for="flexRadioDefault1">Adulto</label>
 </div>
 <div class="form-check form-check-inline">
        <input type="radio" value="2" class="form-check-input" name="OpSocio" onClick="javascript:habilita()" required>
<label class="form-check-label" for="flexRadioDefault1">Menor</label>
 </div>
 </div>
 
     <div class="form-group col-md-9"></div>  
    </div>
     <!--------------FILA 4.1---------------->
      <div class="form-row">
      
      <div class="form-group col-md-3">
 <label>Acudiente</label>
                  <input type="text" disabled name="txtAcudiente" placeholder="Nombre Completo" id="txtAcudiente" class="form-control" onKeyPress="return focusNext(this.form,'TipoDocumento2',event);" required />
 
    </div>
    
    
    <div class="form-group col-md-2"><label>Tipo de Documento</label>
    <select class="custom-select mr-sm-2" name="TipoDocumento2" disabled id="TipoDocumento2"  onKeyPress="return focusNext(this.form,'txtDocumento2',event);" required >
                   <?php 						
					 while ($reg2=mysqli_fetch_array($sqlTD2, MYSQLI_NUM)){
				echo "<option value=".$reg2[0].">".$reg2[1]."</option>";
				}
				?>
                 </select> 
                 </div>
                 
                 
                 <div class="form-group col-md-2"><label>Documento</label> 
   <input type="number" disabled name="txtDocumento2" placeholder="Documento" id="txtDocumento2" class="form-control" onKeyPress="return focusNextNum(this.form,'txtCelular',event);" required /></div>  
   
   
   
    <div class="form-group col-md-2"> 
                    <label>Celular.</label>
                    <input type="text" name="txtCelular" placeholder="Telefono Movil" id="txtCelular" class="form-control"  onKeyPress="return focusNextNum(this.form,'txtEmail',event);" required />
                    </div>
                    
                    
                    
             
                    
     <div class="form-group col-md-3"> 
                 
                    <label>Email.</label>

                 <input type="text" name="txtEmail" placeholder="micorreo@servidor.com" id="txtEmail" class="form-control" onKeyPress="return focusNext(this.form,'btnRegistrar2',event);" required/></div>
  
                  </div> 
     <!------------QUINTA FILA-------------->        
<div class="form-row"  > 
<div class="form-group col-md-10 " style="align-items: flex-start;"  > </div>


 <div class="form-group col-md-2"  >  
              
    <button class="btn btn-success" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="valid_athlet(this.form);" >Registrar</button>
                                
            
           
   
</div>
    
</div>            
           
 
  </form>  
<!--FINAL FORM DEL REGISTRO DE FORMULARIO DEPORTISTA-->
</div>


<?php
}
?>

</html>
