<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo '<div class="alert alert-danger">Sesión no válida</div>';
    exit();
}
?>

<div class="card">
    <div class="card-header bg-success text-white">
        <h6 class="mb-0">🚚 Gestión de Proveedores</h6>
    </div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" onclick="abrirModalProv()">➕ Nuevo Proveedor</button>
        <div id="listaProveedores">Cargando...</div>
    </div>
</div>

<!-- Modal -->
<div id="modalProv" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
    <div style="position:relative; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:0; border-radius:8px; max-width:500px; width:90%;">
        <div style="background:#198754; color:white; padding:15px; border-radius:8px 8px 0 0;">
            <h5 style="margin:0; display:inline-block;">Proveedor</h5>
            <button onclick="cerrarModalProv()" style="float:right; background:none; border:none; color:white; font-size:24px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:20px;">
            <form id="formProv">
                <input type="hidden" name="id_proveedor">
                <div class="mb-3">
                    <label>Nombre *</label>
                    <input type="text" class="form-control" name="nombre" required minlength="3">
                </div>
                <div class="mb-3">
                    <label>Identificación</label>
                    <input type="text" class="form-control" name="identificacion" pattern="[0-9\-]+">
                </div>
                <div class="mb-3">
                    <label>Teléfono</label>
                    <input type="text" class="form-control" name="telefono">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label>Dirección</label>
                    <textarea class="form-control" name="direccion" rows="2"></textarea>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalProv()">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarProv()">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalProv() {
    document.getElementById('formProv').reset();
    document.getElementById('modalProv').style.display = 'block';
}

function cerrarModalProv() {
    document.getElementById('modalProv').style.display = 'none';
}

function cargarListaProveedores() {
    fetch('/dam/modDam/mod_tienda/ejec/obtener_proveedores.php')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var html = '';
            if(data.length === 0) {
                html = '<p class="text-muted">No hay proveedores registrados</p>';
            } else {
                html = '<div class="row">';
                for(var i = 0; i < data.length; i++) {
                    var p = data[i];
                    html += '<div class="col-md-6 mb-3">' +
                        '<div class="card">' +
                        '<div class="card-body">' +
                        '<h6>' + p.nombre + '</h6>' +
                        (p.identificacion ? '<p class="mb-1"><small>NIT: ' + p.identificacion + '</small></p>' : '') +
                        (p.telefono ? '<p class="mb-1"><small>📞 ' + p.telefono + '</small></p>' : '') +
                        (p.email ? '<p class="mb-1"><small>📧 ' + p.email + '</small></p>' : '') +
                        '</div></div></div>';
                }
                html += '</div>';
            }
            document.getElementById('listaProveedores').innerHTML = html;
        })
        .catch(function(e) {
            document.getElementById('listaProveedores').innerHTML = '<div class="alert alert-danger">Error al cargar</div>';
        });
}

function guardarProv() {
    var form = document.getElementById('formProv');
    if(!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_proveedor.php', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        alert(data.message);
        if(data.success) {
            cerrarModalProv();
            cargarListaProveedores();
        }
    })
    .catch(function(e) {
        alert('Error al guardar');
    });
}

// Cargar al inicio
setTimeout(cargarListaProveedores, 100);
</script>
