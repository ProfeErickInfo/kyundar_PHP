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
        <div class="card-header bg-info text-white">
            <h5>🚚 Compras - Versión Simple</h5>
        </div>
        <div class="card-body">
            <button class="btn btn-primary" onclick="abrirModal()">Nuevo Proveedor</button>
            <button class="btn btn-secondary" onclick="cargarProveedores()">Cargar Proveedores</button>
            <div id="resultado" class="mt-3"></div>
        </div>
    </div>
</div>

<!-- Modal Simple -->
<div id="modalProveedor" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
    <div style="position:relative; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:0; border-radius:8px; max-width:500px; width:90%;">
        <div style="background:#0dcaf0; color:white; padding:15px; border-radius:8px 8px 0 0;">
            <h5 style="margin:0; display:inline-block;">Nuevo Proveedor</h5>
            <button onclick="cerrarModal()" style="float:right; background:none; border:none; color:white; font-size:24px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:20px; max-height:60vh; overflow-y:auto;">
            <form id="formProveedor" onsubmit="return false;">
                <input type="hidden" name="id_proveedor" id="id_proveedor">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Nombre <span style="color:red;">*</span></label>
                    <input type="text" name="nombre" id="nombre" required minlength="3" maxlength="255" 
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Mínimo 3 caracteres</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Identificación (NIT/CC)</label>
                    <input type="text" name="identificacion" id="identificacion" pattern="[0-9\-]+" maxlength="64"
                           title="Solo números y guiones"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Solo números y guiones</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" pattern="[0-9\+\-\s\(\)]+" maxlength="50"
                           title="Solo números, espacios, +, -, ( )"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Ej: +57 300 1234567</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Email</label>
                    <input type="email" name="email" id="email" maxlength="255"
                           pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
                           title="Email válido: ejemplo@dominio.com"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Formato: ejemplo@dominio.com</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Dirección</label>
                    <textarea name="direccion" id="direccion" rows="2" maxlength="500"
                              style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;"></textarea>
                    <small style="color:#666;">Máximo 500 caracteres</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Nombre de Contacto</label>
                    <input type="text" name="contacto_nombre" id="contacto_nombre" maxlength="255"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                </div>
            </form>
        </div>
        <div style="padding:15px; border-top:1px solid #ddd; text-align:right;">
            <button onclick="cerrarModal()" class="btn btn-secondary" style="margin-right:10px;">Cerrar</button>
            <button onclick="guardarProveedor()" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</div>

<script>
function abrirModal() {
    document.getElementById('formProveedor').reset();
    document.getElementById('modalProveedor').style.display = 'block';
}

function cerrarModal() {
    document.getElementById('modalProveedor').style.display = 'none';
}

function cargarProveedores() {
    document.getElementById('resultado').innerHTML = 'Cargando...';
    
    fetch('/dam/modDam/mod_tienda/ejec/obtener_proveedores.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('resultado').innerHTML = 
                '<h6>Proveedores encontrados: ' + data.length + '</h6>' +
                '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            document.getElementById('resultado').innerHTML = 
                '<div class="alert alert-danger">Error: ' + error.message + '</div>';
        });
}

function guardarProveedor() {
    const form = document.getElementById('formProveedor');
    
    // Validar formulario
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Validaciones adicionales
    const nombre = document.getElementById('nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const telefono = document.getElementById('telefono').value.trim();
    
    if (nombre.length < 3) {
        alert('El nombre debe tener al menos 3 caracteres');
        return;
    }
    
    if (email && !email.match(/^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/i)) {
        alert('El email no tiene un formato válido');
        return;
    }
    
    if (telefono && !telefono.match(/^[0-9\+\-\s\(\)]+$/)) {
        alert('El teléfono solo puede contener números, espacios y símbolos: + - ( )');
        return;
    }
    
    const formData = new FormData(form);
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_proveedor.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            cerrarModal();
            cargarProveedores();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

// Cargar al inicio
setTimeout(cargarProveedores, 500);
</script>
