<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../../index.html');
    exit();
}
$id_usuario = $_SESSION['id_usuario'];
?>
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .item-row {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="container-fluid mt-4">
    <div class="card shadow-lg">
        <div class="card-header gradient-bg text-white">
            <h5 class="mb-0">🚚 Gestión de Compras</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-primary" onclick="mostrarTab('nueva-compra')" id="btn-nueva-compra">➕ Nueva Compra</button>
                <button class="btn btn-outline-primary" onclick="mostrarTab('lista-compras'); cargarCompras();" id="btn-lista-compras">📋 Lista de Compras</button>
                <button class="btn btn-outline-primary" onclick="mostrarTab('proveedores-tab'); cargarProveedores();" id="btn-proveedores-tab">🚚 Proveedores</button>
            </div>

            <div class="tab-content">
                <!-- NUEVA COMPRA -->
                <div id="nueva-compra" style="display:block;">
                    <form id="formCompra">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-hover mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">ℹ️ Información de la Compra</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Número Documento</label>
                                                <input type="text" class="form-control" id="numero_documento" name="numero_documento" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Fecha <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="fecha_compra" required 
                                                       value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Estado</label>
                                                <select class="form-select" name="estado">
                                                    <option value="borrador">Borrador</option>
                                                    <option value="confirmado">Confirmado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Proveedor <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-select" id="id_proveedor" name="id_proveedor" required onchange="mostrarInfoProveedor()">
                                                        <option value="">Seleccione...</option>
                                                    </select>
                                                    <button type="button" class="btn btn-outline-secondary" onclick="mostrarModalProveedor()">
                                                        ➕
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-hover mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">📦 Productos a Comprar</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Buscar Producto</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control" id="buscarProducto" 
                                                       placeholder="Escriba nombre o SKU..." onkeyup="buscarProductos(this.value)">
                                                <div id="resultadosProductos" style="display:none; position:absolute; z-index:1000; width:100%; max-height:300px; overflow-y:auto; background:white; border:1px solid #ddd; border-radius:4px;"></div>
                                            </div>
                                        </div>
                                        <div id="window.itemsCompra"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card card-hover mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">🚚 Info Proveedor</h6>
                                    </div>
                                    <div class="card-body" id="infoProveedor">
                                        <p class="text-muted">Seleccione un proveedor</p>
                                    </div>
                                </div>

                                <div class="card card-hover">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-3">🧮 Resumen</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <strong id="subtotal">$0.00</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>IVA:</span>
                                            <strong id="iva">$0.00</strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <h5>TOTAL:</h5>
                                            <h5 class="text-primary" id="total">$0.00</h5>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-success w-100 mb-2" onclick="guardarCompra('confirmado')">
                                                ✅ Confirmar Compra
                                            </button>
                                            <button type="button" class="btn btn-secondary w-100" onclick="limpiarFormulario()">
                                                ❌ Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- LISTA COMPRAS -->
                <div id="lista-compras" style="display:none;">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">📋 Compras Registradas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Número</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaCompras">
                                        <tr><td colspan="6" class="text-center">Cargando...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROVEEDORES -->
                <div id="proveedores-tab" style="display:none;">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0">🚚 Proveedores</h6>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-sm" onclick="mostrarModalProveedor()">
                                        ➕ Nuevo Proveedor
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="listaProveedores">Cargando...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Proveedor -->
<div id="modalProveedor" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
    <div style="position:relative; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:0; border-radius:8px; max-width:500px; width:90%; max-height:90vh; overflow:hidden;">
        <div style="background:#0dcaf0; color:white; padding:15px; border-radius:8px 8px 0 0;">
            <h5 style="margin:0; display:inline-block;">🚚 Proveedor</h5>
            <button onclick="cerrarModalProveedor()" style="float:right; background:none; border:none; color:white; font-size:24px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:20px; max-height:calc(90vh - 140px); overflow-y:auto;">
            <form id="formProveedor" onsubmit="return false;">
                <input type="hidden" name="id_proveedor" id="prov_id">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Nombre <span style="color:red;">*</span></label>
                    <input type="text" name="nombre" id="prov_nombre" required minlength="3" maxlength="255" 
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Mínimo 3 caracteres</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Identificación (NIT/CC)</label>
                    <input type="text" name="identificacion" id="prov_identificacion" pattern="[0-9\-]+" maxlength="64"
                           title="Solo números y guiones"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Solo números y guiones</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Teléfono</label>
                    <input type="tel" name="telefono" id="prov_telefono" pattern="[0-9\+\-\s\(\)]+" maxlength="50"
                           title="Solo números, espacios, +, -, ( )"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Ej: +57 300 1234567</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Email</label>
                    <input type="email" name="email" id="prov_email" maxlength="255"
                           pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
                           title="Email válido: ejemplo@dominio.com"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    <small style="color:#666;">Formato: ejemplo@dominio.com</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Dirección</label>
                    <textarea name="direccion" id="prov_direccion" rows="2" maxlength="500"
                              style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;"></textarea>
                    <small style="color:#666;">Máximo 500 caracteres</small>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Nombre de Contacto</label>
                    <input type="text" name="contacto_nombre" id="prov_contacto" maxlength="255"
                           style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                </div>
            </form>
        </div>
        <div style="padding:15px; border-top:1px solid #ddd; text-align:right;">
            <button onclick="cerrarModalProveedor()" class="btn btn-secondary" style="margin-right:10px;">Cerrar</button>
            <button onclick="guardarProveedor()" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</div>

<script>
// Variables globales
if(typeof window.itemsCompra === 'undefined') window.itemsCompra = [];
if(typeof window.contadorItems === 'undefined') window.contadorItems = 0;

// Función para cambiar entre tabs
window.mostrarTab = function(tabId) {
    try {
        // Ocultar todos los tabs
        var tabs = ['nueva-compra', 'lista-compras', 'proveedores-tab'];
        for(var i = 0; i < tabs.length; i++) {
            var tab = document.getElementById(tabs[i]);
            if(tab) tab.style.display = 'none';
            
            var btn = document.getElementById('btn-' + tabs[i]);
            if(btn) btn.className = 'btn btn-outline-primary';
        }
        
        // Mostrar el tab seleccionado
        var tabSeleccionado = document.getElementById(tabId);
        if(tabSeleccionado) tabSeleccionado.style.display = 'block';
        
        // Activar el botón correspondiente
        var btnSeleccionado = document.getElementById('btn-' + tabId);
        if(btnSeleccionado) btnSeleccionado.className = 'btn btn-primary';
    } catch(e) {
        console.error('Error al cambiar tab:', e);
    }
};
if(typeof window.timeoutBusqueda === 'undefined') window.timeoutBusqueda = null;

// Proveedores
window.cargarProveedores = function() {
    fetch('/dam/modDam/mod_tienda/ejec/obtener_proveedores.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_proveedor');
            if (select) {
                select.innerHTML = '<option value="">Seleccione...</option>';
                data.forEach(proveedor => {
                    const option = document.createElement('option');
                    option.value = proveedor.id_proveedor;
                    option.textContent = proveedor.nombre;
                    option.dataset.info = JSON.stringify(proveedor);
                    select.appendChild(option);
                });
            }
            
            const lista = document.getElementById('listaProveedores');
            if (lista) {
                if (data.length === 0) {
                    lista.innerHTML = '<p class="text-muted">No hay proveedores registrados</p>';
                } else {
                    lista.innerHTML = '<div class="row">' + data.map(p => `
                        <div class="col-md-6 mb-3">
                            <div class="card card-hover">
                                <div class="card-body">
                                    <h6 class="card-title">${p.nombre}</h6>
                                    ${p.identificacion ? `<p class="mb-1"><small>NIT/CC: ${p.identificacion}</small></p>` : ''}
                                    ${p.telefono ? `<p class="mb-1"><small>📞 ${p.telefono}</small></p>` : ''}
                                    ${p.email ? `<p class="mb-1"><small>📧 ${p.email}</small></p>` : ''}
                                    ${p.contacto_nombre ? `<p class="mb-1"><small>👤 ${p.contacto_nombre}</small></p>` : ''}
                                </div>
                            </div>
                        </div>
                    `).join('') + '</div>';
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

window.mostrarInfoProveedor = function() {
    const select = document.getElementById('id_proveedor');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('infoProveedor');
    
    if (option.value && option.dataset.info) {
        const proveedor = JSON.parse(option.dataset.info);
        infoDiv.innerHTML = `
            ${proveedor.identificacion ? `<div class="mb-2"><small class="text-muted">NIT/CC:</small><br><strong>${proveedor.identificacion}</strong></div>` : ''}
            ${proveedor.telefono ? `<div class="mb-2"><small class="text-muted">Teléfono:</small><br>${proveedor.telefono}</div>` : ''}
            ${proveedor.email ? `<div class="mb-2"><small class="text-muted">Email:</small><br>${proveedor.email}</div>` : ''}
            ${proveedor.contacto_nombre ? `<div class="mb-2"><small class="text-muted">Contacto:</small><br>${proveedor.contacto_nombre}</div>` : ''}
        `;
    } else {
        infoDiv.innerHTML = '<p class="text-muted">Seleccione un proveedor</p>';
    }
}

window.mostrarModalProveedor = function() {
    document.getElementById('formProveedor').reset();
    document.getElementById('modalProveedor').style.display = 'block';
}

window.cerrarModalProveedor = function() {
    document.getElementById('modalProveedor').style.display = 'none';
}

window.guardarProveedor = function() {
    const form = document.getElementById('formProveedor');
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const nombre = document.getElementById('prov_nombre').value.trim();
    const email = document.getElementById('prov_email').value.trim();
    const telefono = document.getElementById('prov_telefono').value.trim();
    
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
            cerrarModalProveedor();
            cargarProveedores();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

// Búsqueda de productos
window.buscarProductos = function(termino) {
    clearTimeout(window.timeoutBusqueda);
    const resultados = document.getElementById('resultadosProductos');
    
    if (termino.length < 2) {
        resultados.style.display = 'none';
        return;
    }
    
    window.timeoutBusqueda = setTimeout(() => {
        fetch(`/dam/modDam/mod_tienda/ejec/buscar_productos.php?q=${encodeURIComponent(termino)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    resultados.innerHTML = data.map(producto => `
                        <div onclick="agregarProducto(${producto.id_producto}, '${producto.nombre.replace(/'/g, "\\'")}', ${producto.precio_costo || 0}, ${producto.tasa_iva}); document.getElementById('resultadosProductos').style.display='none'; document.getElementById('buscarProducto').value='';" 
                             style="padding:10px; cursor:pointer; border-bottom:1px solid #eee;">
                            <div><strong>${producto.nombre}</strong></div>
                            <div style="font-size:12px; color:#666;">
                                ${producto.sku ? `SKU: ${producto.sku} | ` : ''}
                                Precio: $${parseFloat(producto.precio_costo || 0).toLocaleString('es-CO', {minimumFractionDigits: 2})}
                            </div>
                        </div>
                    `).join('');
                    resultados.style.display = 'block';
                } else {
                    resultados.innerHTML = '<div style="padding:10px; color:#999;">No se encontraron productos</div>';
                    resultados.style.display = 'block';
                }
            });
    }, 300);
}

window.agregarProducto = function(id, nombre, precio, iva) {
    const existente = window.itemsCompra.find(item => item.id_producto === id);
    if (existente) {
        existente.cantidad++;
        calcularTotales();
        renderizarItems();
        return;
    }
    
    const item = {
        id: window.contadorItems++,
        id_producto: id,
        nombre: nombre,
        cantidad: 1,
        precio_unitario: precio,
        tasa_iva: iva,
        subtotal: 0,
        iva_monto: 0,
        total: 0
    };
    
    window.itemsCompra.push(item);
    calcularTotales();
    renderizarItems();
}

window.renderizarItems = function() {
    const container = document.getElementById('window.itemsCompra');
    
    if (window.itemsCompra.length === 0) {
        container.innerHTML = '<p class="text-muted">No hay productos agregados</p>';
        return;
    }
    
    container.innerHTML = window.itemsCompra.map((item, index) => `
        <div class="item-row">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <strong>${item.nombre}</strong>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm" value="${item.cantidad}" min="1" 
                           onchange="window.itemsCompra[${index}].cantidad = parseFloat(this.value); calcularTotales(); renderizarItems();">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm" value="${item.precio_unitario}" min="0" step="0.01"
                           onchange="window.itemsCompra[${index}].precio_unitario = parseFloat(this.value); calcularTotales(); renderizarItems();">
                </div>
                <div class="col-md-3 text-end">
                    <strong>$${item.total.toLocaleString('es-CO', {minimumFractionDigits: 2})}</strong>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarItem(${index})">🗑️</button>
                </div>
            </div>
        </div>
    `).join('');
}

window.calcularTotales = function() {
    let subtotal = 0;
    let ivaTotal = 0;
    
    window.itemsCompra.forEach(item => {
        item.subtotal = item.cantidad * item.precio_unitario;
        item.iva_monto = item.subtotal * (item.tasa_iva / 100);
        item.total = item.subtotal + item.iva_monto;
        
        subtotal += item.subtotal;
        ivaTotal += item.iva_monto;
    });
    
    const total = subtotal + ivaTotal;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toLocaleString('es-CO', {minimumFractionDigits: 2});
    document.getElementById('iva').textContent = '$' + ivaTotal.toLocaleString('es-CO', {minimumFractionDigits: 2});
    document.getElementById('total').textContent = '$' + total.toLocaleString('es-CO', {minimumFractionDigits: 2});
}

window.eliminarItem = function(index) {
    window.itemsCompra.splice(index, 1);
    calcularTotales();
    renderizarItems();
}

window.generarNumeroDocumento = function() {
    fetch('/dam/modDam/mod_tienda/ejec/generar_numero_documento.php?tipo=compra')
        .then(response => response.json())
        .then(data => {
            if (data.numero) {
                document.getElementById('numero_documento').value = data.numero;
            }
        });
}

window.guardarCompra = function(estadoFinal) {
    if (window.itemsCompra.length === 0) {
        alert('Debe agregar al menos un producto');
        return;
    }
    
    const idProveedor = document.getElementById('id_proveedor').value;
    if (!idProveedor) {
        alert('Debe seleccionar un proveedor');
        return;
    }
    
    const formData = new FormData(document.getElementById('formCompra'));
    formData.set('estado', estadoFinal);
    formData.append('items', JSON.stringify(window.itemsCompra));
    formData.append('id_usuario', <?php echo $id_usuario; ?>);
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_compra.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            limpiarFormulario();
            cargarCompras();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

window.limpiarFormulario = function() {
    document.getElementById('formCompra').reset();
    window.itemsCompra = [];
    window.contadorItems = 0;
    renderizarItems();
    calcularTotales();
    generarNumeroDocumento();
}

window.cargarCompras = function() {
    fetch('/dam/modDam/mod_tienda/ejec/listar_compras.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tablaCompras');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay compras registradas</td></tr>';
                return;
            }
            
            tbody.innerHTML = data.map(compra => `
                <tr>
                    <td>${compra.numero_documento}</td>
                    <td>${compra.fecha_compra}</td>
                    <td>${compra.proveedor_nombre || 'N/A'}</td>
                    <td>$${parseFloat(compra.total).toLocaleString('es-CO', {minimumFractionDigits: 2})}</td>
                    <td><span class="badge bg-${compra.estado === 'confirmado' ? 'success' : 'secondary'}">${compra.estado}</span></td>
                    <td>
                        ${compra.estado !== 'anulado' ? `<button class="btn btn-sm btn-danger" onclick="anularCompra(${compra.id_compra})">Anular</button>` : ''}
                    </td>
                </tr>
            `).join('');
        });
}

window.anularCompra = function(id) {
    if (!confirm('¿Está seguro de anular esta compra?')) return;
    
    fetch('/dam/modDam/mod_tienda/ejec/anular_compra.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id_compra=' + id
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) cargarCompras();
    });
}

// Inicializar
setTimeout(function() {
    cargarProveedores();
    generarNumeroDocumento();
}, 100);
</script>
