<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo '<div class="alert alert-danger">Sesión no válida</div>';
    exit();
}
?>

<div class="card">
    <div class="card-header bg-info text-white">
        <h6 class="mb-0">📋 Lista de Compras</h6>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tablaCompras">
                <tr><td colspan="5" class="text-center">Cargando...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
function cargarComprasList() {
    fetch('/dam/modDam/mod_tienda/ejec/listar_compras.php')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var html = '';
            if(data.length === 0) {
                html = '<tr><td colspan="5" class="text-center text-muted">No hay compras registradas</td></tr>';
            } else {
                for(var i = 0; i < data.length; i++) {
                    var c = data[i];
                    html += '<tr>' +
                        '<td>' + (c.numero_documento || '-') + '</td>' +
                        '<td>' + c.fecha_compra + '</td>' +
                        '<td>' + (c.proveedor_nombre || 'N/A') + '</td>' +
                        '<td>$' + parseFloat(c.total).toFixed(2) + '</td>' +
                        '<td><span class="badge bg-success">' + (c.estado || 'activo') + '</span></td>' +
                        '</tr>';
                }
            }
            document.getElementById('tablaCompras').innerHTML = html;
        })
        .catch(function(e) {
            document.getElementById('tablaCompras').innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar</td></tr>';
        });
}

setTimeout(cargarComprasList, 100);
</script>
