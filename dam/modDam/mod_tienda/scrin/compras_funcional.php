<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../../index.html');
    exit();
}
$id_usuario = $_SESSION['id_usuario'];
?>

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>🚚 Gestión de Compras</h5>
        </div>
        <div class="card-body">
            <div class="btn-group" role="group">
                <button class="btn btn-primary" onclick="cargarFocus('modDam/mod_tienda/scrin/nueva_compra.php','DivContenido','carga','');">➕ Nueva Compra</button>
                <button class="btn btn-outline-primary" onclick="cargarFocus('modDam/mod_tienda/scrin/lista_compras.php','DivContenido','carga','');">📋 Lista de Compras</button>
                <button class="btn btn-outline-primary" onclick="cargarFocus('modDam/mod_tienda/scrin/proveedores.php','DivContenido','carga','');">🚚 Proveedores</button>
            </div>
        </div>
    </div>
</div>
 