<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo '<div class="alert alert-danger">Sesión no válida</div>';
    exit();
}
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">➕ Nueva Compra</h6>
    </div>
    <div class="card-body">
        <p class="text-muted">Módulo de nueva compra en construcción...</p>
        <p>Este módulo permitirá:</p>
        <ul>
            <li>Seleccionar proveedor</li>
            <li>Buscar y agregar productos</li>
            <li>Calcular totales automáticamente</li>
            <li>Guardar la compra</li>
        </ul>
    </div>
</div>
