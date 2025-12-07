<!-----------M E N U --------------->  
<!------MENU PRINCIPAL DEL CLUB------->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-bottom: none;">
  
  <b class="navbar-brand" onClick="window.location.reload();" style="color: #1e293b; font-weight: 700; cursor: pointer;"> <img src="../images/logo_kyundar_3.png" alt="Kyundar Logo" width="143" height="35" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));"/></b>  <div id="carga" class="spinner-border" role="status" style="visibility:hidden; color: #3b82f6; width: 1.2rem; height: 1.2rem;">
    <span class="visually-hidden">Loading...</span>
  </div>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="border: 1px solid #cbd5e1;">
    <span class="navbar-toggler-icon" style="filter: opacity(0.7);"></span>
  </button>

<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent" >
      <ul class="navbar-nav ml-auto navbar-right-top">
   
   
   
    
    <li class="nav-item">
     
    </li>
 <!--------------------------------------------->   
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #1e293b; font-weight: 500; padding: 8px 12px;">
        <i class="fas fa-users me-1" style="color: #3b82f6;"></i>Socios
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px;">
            <li class="nav-item"> 
      <a class="dropdown-item" onClick="cargarFocus('modDam/mod_registro/scrin/r_socio_corto.php','DivContenido','carga','');" title="Deportistas Nuevos" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
        <i class="fas fa-user-plus me-2" style="color: #3b82f6; width: 16px;"></i>Registro Rápido de Socios</a>
    </li>
    <hr style="margin: 4px 0; border-color: #e2e8f0;">
        <li class="nav-item"> 
      <a class="dropdown-item" onClick="cargarFocus('modDam/mod_registro/scrin/reg_socios.php','DivContenido','carga','');" title="Deportistas Nuevos" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
        <i class="fas fa-user-pen me-2" style="color: #3b82f6; width: 16px;"></i>Registro Completo de Socios</a>
    </li>
  

   
          <li><a class="dropdown-item" onClick="cargarFocus('modDam/mod_consultas/scrin/consulta_socio.php','DivContenido','carga','');" title="Configurar Tests" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
            <i class="fas fa-user-gear me-2" style="color: #2563eb; width: 16px;"></i>Actualizar Información</a></li>
         
         <li><a class="dropdown-item" onClick="cargarFocus('modDam/mod_consultas/scrin/consuListas.php','DivContenido','carga','');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
           <i class="fas fa-list-ul me-2" style="color: #60a5fa; width: 16px;"></i>Listados</a></li>
      </ul>
      </li>

        

 


 <!--------------------------------------------->   
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownFinan" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #1e293b; font-weight: 500; padding: 8px 12px;">
         <i class="fas fa-chart-line me-1" style="color: #1e40af;"></i>Financiero
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownFinan" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px;">
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/modFinan/scrin/configMes.php','DivContenido','carga','Grados');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <i class="fas fa-cog me-2" style="color: #3b82f6; width: 16px;"></i>Configurar Aportes de Socios</a></li>
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/modFinan/scrin/configEgreso.php','DivContenido','carga','TipoDocumento');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <i class="fas fa-minus-circle me-2" style="color: #1e40af; width: 16px;"></i>Crear Egreso</a></li>
           
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/modFinan/scrin/ApliEgreso.php','DivContenido','carga','');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <i class="fas fa-money-bill-wave me-2" style="color: #60a5fa; width: 16px;"></i>Aplicar Egreso</a></li>
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/modFinan/scrin/GeneralAporte.php','DivContenido','carga','Grados');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <i class="fas fa-hand-holding-dollar me-2" style="color: #3b82f6; width: 16px;"></i>Aportes de Socios</a></li>
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/modFinan/scrin/ApliVenta.php','DivContenido','carga','');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <i class="fas fa-shopping-cart me-2" style="color: #1e40af; width: 16px;"></i>Zona de Ventas</a></li>
           <li><hr class="dropdown-divider" style="margin: 4px 0; border-color: #e2e8f0;"></li>
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/modFinan/Rpdf/scrin/busca_planilla.php','DivContenido','carga','');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <i class="fas fa-search me-2" style="color: #2563eb; width: 16px;"></i>Listas y Consultas</a></li>
        </ul>
      </li>
<!---------------------------------------------->  
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownTienda" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #1e293b; font-weight: 500; padding: 8px 12px;">
         <span class="me-1" style="color: #059669;">🛒</span>Tienda
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownTienda" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px;">
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/mod_tienda/scrin/ventas.php','DivContenido','carga','');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <span class="me-2" style="color: #059669; display: inline-block; width: 16px;">💰</span>Ventas</a></li>
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/mod_tienda/scrin/compras_funcional.php','DivContenido','carga','');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <span class="me-2" style="color: #0891b2; display: inline-block; width: 16px;">🚚</span>Compras</a></li>
           <li><a class="dropdown-item" href="#" onClick="cargarFocus('modDam/mod_tienda/scrin/inventario.php','DivContenido','carga','');" style="color: #374151; padding: 8px 16px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
             <span class="me-2" style="color: #0284c7; display: inline-block; width: 16px;">📦</span>Inventario</a></li>
        </ul>
      </li>
<!---------------------------------------------->  
      <li class="nav-item">
     <a class="nav-link" aria-current="page" onClick="cargarFocus('modDam/mod_consultas/scrin/LestApp.php','DivContenido','carga','');" title="Generar Carnet" style="color: #1e293b; font-weight: 500; padding: 8px 12px; border-radius: 6px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.color='#3b82f6';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#1e293b';">
       <i class="fas fa-camera me-1" style="color: #3b82f6;"></i>Foto</a>
    </li>

     <li class="nav-item">
     <a class="nav-link" aria-current="page" onClick="cargarFocus('modDam/mod_consultas/Rpdf/scrin/carnet.php','DivContenido','carga','');" title="Generar Carnet" style="color: #1e293b; font-weight: 500; padding: 8px 12px; border-radius: 6px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.color='#1e40af';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#1e293b';">
       <i class="fas fa-id-card me-1" style="color: #1e40af;"></i>Generar Carnet</a>
    </li>
    <li class="nav-item">
     <a class="nav-link" aria-current="page" style="vertical-align:middle; color: #1e293b; font-weight: 500; padding: 8px 12px; border-radius: 6px; transition: all 0.2s;" onClick="cargarFocus('modDam/mod_consultas/Rpdf/scrin/consulta_gen.php','DivContenido','carga','');" title="Configurar Tests" onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.color='#2563eb';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#1e293b';">
       <i class="fas fa-file-alt me-1" style="color: #2563eb;"></i>Generar Listas</a>
    </li>
    
<!---------------------------------------------->  

 


 <!--------------------------------------------->   
 <!-- User Account: style can be found in dropdown.less -->
 <li class="nav-item dropdown dropstart">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="color: #1e293b; font-weight: 500; padding: 8px 12px; border-radius: 6px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9';" onmouseout="this.style.backgroundColor='transparent';">
                  <i class="fas fa-circle-user me-1" style="color: #60a5fa;"></i>
                  <span style="color: #374151;">Mi Club</span>
                  <img src="<?=$ruta_img.$mifoto?>" height="24px" width="24px" alt="..." style="border-radius: 50%; margin-left: 8px; border: 2px solid #e2e8f0;">
                </a>

                <div class="dropdown-menu dropdown-menu-end" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; min-width: 280px; right: 0; left: auto;">
                  <!-- Menu Body -->
                  <div class="card" style="padding: 16px; border: none; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                     <img src="<?=$ruta_img.$mifoto?>" height="60px" width="60px" class="img-fluid mx-auto" alt="..." style="border-radius: 50%; border: 3px solid #cbd5e1; margin-bottom: 12px;">
                  
                    <div class="text-center" style="color: #1e293b; font-weight: 600; font-size: 16px; margin-bottom: 16px;"><? echo $minombre2;?></div>
                      
                       <ul class="list-group list-group-flush" style="background: transparent;">
                        <li class="list-group-item" style="background: transparent; border: none; padding: 8px 12px; color: #6b7280; font-size: 14px;"><i class="fas fa-shield-alt me-2" style="color: #60a5fa;"></i>Seguridad</li>
                        <li class="list-group-item" onClick="cargarFocus('modDam/mod_registro/scrin/m_entidad.php?idClub=<?=$id_usu?>','DivContenido','carga','');" title="Registro de entidad deportiva" style="background: transparent; border: none; padding: 8px 12px; color: #374151; cursor: pointer; border-radius: 6px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#e2e8f0'; this.style.color='#1e293b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';"><i class="fas fa-building me-2" style="color: #3b82f6;"></i>Mi Club</li>
                       </ul>
                    <div class="text-center mt-3" onClick="if(confirm('Deseas cerrar la sesión actual?')){window.location='cerrarsesion.php';}" style="background: linear-gradient(135deg, #dc2626, #ef4444); color: white; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(220, 38, 38, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">Salida Segura</div>
                   </div>
                </div>
              </li>

  </ul>
  </div>
</nav>
<!-----------FIN MENU PRINCIPAL DEL CLUB---------->