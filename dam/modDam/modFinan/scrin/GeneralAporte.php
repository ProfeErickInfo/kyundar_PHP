<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$idClub=$id_usu;
?>

  <div class="row">
    <div class="col-sm-4">
        <div class="row">
          <div class="col-sm-12">

            <form class="d-flex">
             <input type="search" placeholder="Escribe el nombre..." aria-label="Search" class="form-control me-2" name="txtBuscar" id="txtBuscar" onkeyup="cargarB('modDam/modFinan/ejec/lista-sociosP.php?opbusca=1&oby=&vbusca='+this.value+'&idTipo=1&esta=1','dvLista');">
             <button style="cursor: pointer;" class="btn btn-outline-success" type="button" onclick="cargarB('modDam/modFinan/ejec/lista-sociosP.php?opbusca=1&oby=&vbusca='+document.getElementById('txtBuscar').value+'&idTipo=1&esta=1','dvLista');">Buscar</button>
      
            </form>
          </div>    
       </div>
       <br>
    <div id="dvLista"  style=" overflow:200px; text-align: left;"> <!----------Div #14--------->

         <? include('../ejec/lista-sociosP.php');?></div>

    </div>
    <div id="DvPago" class="col-sm-8"></div>
  </div>

