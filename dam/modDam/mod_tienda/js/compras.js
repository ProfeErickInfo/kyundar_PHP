// Variables globales para compras
if (typeof itemsCompra === 'undefined') var itemsCompra = [];
if (typeof contadorItems === 'undefined') var contadorItems = 0;
if (typeof modalProveedor === 'undefined') var modalProveedor;

// Función para inicializar el modal cuando esté disponible
function inicializarModalProveedor() {
    const modalElement = document.getElementById('modalProveedor');
    if (modalElement && !modalProveedor) {
        modalProveedor = new bootstrap.Modal(modalElement);
    }
}

// Cargar proveedores
function cargarProveedores() {
    fetch('/dam/modDam/mod_tienda/ejec/obtener_proveedores.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_proveedor');
            select.innerHTML = '<option value="">Seleccione...</option>';
            data.forEach(proveedor => {
                const option = document.createElement('option');
                option.value = proveedor.id_proveedor;
                option.textContent = proveedor.nombre;
                option.dataset.info = JSON.stringify(proveedor);
                select.appendChild(option);
            });
            
            // Actualizar lista en tab de proveedores
            actualizarListaProveedores(data);
        });
}

function actualizarListaProveedores(proveedores) {
    const lista = document.getElementById('listaProveedores');
    if (proveedores.length === 0) {
        lista.innerHTML = '<p class="text-muted">No hay proveedores registrados</p>';
        return;
    }
    
    lista.innerHTML = '<div class="row">' + proveedores.map(p => `
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">${p.nombre}</h6>
                    ${p.identificacion ? `<p class="mb-1"><small class="text-muted">ID: ${p.identificacion}</small></p>` : ''}
                    ${p.telefono ? `<p class="mb-1"><small><i class="fas fa-phone me-1"></i>${p.telefono}</small></p>` : ''}
                    ${p.email ? `<p class="mb-1"><small><i class="fas fa-envelope me-1"></i>${p.email}</small></p>` : ''}
                    ${p.contacto_nombre ? `<p class="mb-1"><small><i class="fas fa-user me-1"></i>${p.contacto_nombre}</small></p>` : ''}
                    <div class="mt-2">
                        <button class="btn btn-sm btn-primary" onclick='editarProveedor(${JSON.stringify(p)})'>
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `).join('') + '</div>';
}

function cargarInfoProveedor() {
    const select = document.getElementById('id_proveedor');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('infoProveedor');
    
    if (option.value) {
        const proveedor = JSON.parse(option.dataset.info);
        infoDiv.innerHTML = `
            ${proveedor.identificacion ? `<div class="mb-2"><small class="text-muted">ID:</small><br><strong>${proveedor.identificacion}</strong></div>` : ''}
            ${proveedor.telefono ? `<div class="mb-2"><small class="text-muted">Teléfono:</small><br>${proveedor.telefono}</div>` : ''}
            ${proveedor.email ? `<div class="mb-2"><small class="text-muted">Email:</small><br>${proveedor.email}</div>` : ''}
            ${proveedor.contacto_nombre ? `<div class="mb-2"><small class="text-muted">Contacto:</small><br>${proveedor.contacto_nombre}</div>` : ''}
        `;
    } else {
        infoDiv.innerHTML = '<p class="text-muted">Seleccione un proveedor</p>';
    }
}

function mostrarModalProveedor() {
    inicializarModalProveedor();
    document.getElementById('formProveedor').reset();
    document.getElementById('id_proveedor_edit').value = '';
    if (modalProveedor) {
        modalProveedor.show();
    }
}

function editarProveedor(proveedor) {
    inicializarModalProveedor();
    document.getElementById('id_proveedor_edit').value = proveedor.id_proveedor;
    document.getElementById('nombre_proveedor').value = proveedor.nombre;
    document.getElementById('identificacion_proveedor').value = proveedor.identificacion || '';
    document.getElementById('telefono_proveedor').value = proveedor.telefono || '';
    document.getElementById('email_proveedor').value = proveedor.email || '';
    document.getElementById('direccion_proveedor').value = proveedor.direccion || '';
    document.getElementById('contacto_proveedor').value = proveedor.contacto_nombre || '';
    modalProveedor.show();
}

function guardarProveedor() {
    const formData = new FormData(document.getElementById('formProveedor'));
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_proveedor.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            modalProveedor.hide();
            cargarProveedores();
        } else {
            alert('Error: ' + data.message);
        }
    });
}

// Buscar productos (reutiliza lógica de ventas)
let timeoutBusqueda = null;
function buscarProductos(termino) {
    clearTimeout(timeoutBusqueda);
    const resultados = document.getElementById('resultadosProductos');
    
    if (termino.length < 2) {
        resultados.style.display = 'none';
        return;
    }
    
    timeoutBusqueda = setTimeout(() => {
        fetch(`/dam/modDam/mod_tienda/ejec/buscar_productos.php?q=${encodeURIComponent(termino)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    resultados.innerHTML = data.map(producto => `
                        <a href="#" class="list-group-item list-group-item-action" onclick="agregarProducto(${producto.id_producto}, '${producto.nombre.replace(/'/g, "\\'")}', ${producto.precio_costo || 0}, ${producto.tasa_iva}); return false;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>${producto.nombre}</strong>
                                    ${producto.sku ? `<br><small class="text-muted">SKU: ${producto.sku}</small>` : ''}
                                </div>
                                <div class="text-end">
                                    <strong class="text-info">$${parseFloat(producto.precio_costo || 0).toLocaleString('es-CO', {minimumFractionDigits: 2})}</strong>
                                </div>
                            </div>
                        </a>
                    `).join('');
                    resultados.style.display = 'block';
                } else {
                    resultados.innerHTML = '<div class="list-group-item text-muted">No se encontraron productos</div>';
                    resultados.style.display = 'block';
                }
            });
    }, 300);
}

function agregarProducto(id, nombre, precio, iva) {
    document.getElementById('resultadosProductos').style.display = 'none';
    document.getElementById('buscarProducto').value = '';
    
    const existente = itemsCompra.find(item => item.id_producto === id);
    if (existente) {
        existente.cantidad++;
        actualizarItemCompra(itemsCompra.indexOf(existente));
        return;
    }
    
    contadorItems++;
    const item = {
        id_temp: contadorItems,
        id_producto: id,
        nombre: nombre,
        cantidad: 1,
        precio_unitario: parseFloat(precio),
        descuento: 0,
        tasa_iva: parseFloat(iva)
    };
    
    itemsCompra.push(item);
    renderizarItems();
    calcularTotales();
}

function agregarItemManual() {
    contadorItems++;
    itemsCompra.push({
        id_temp: contadorItems,
        id_producto: null,
        nombre: '',
        cantidad: 1,
        precio_unitario: 0,
        descuento: 0,
        tasa_iva: 0
    });
    renderizarItems();
}

function renderizarItems() {
    const container = document.getElementById('itemsCompra');
    
    if (itemsCompra.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">No hay productos agregados</p>';
        return;
    }
    
    container.innerHTML = itemsCompra.map((item, index) => `
        <div class="item-row">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label class="form-label small">Producto</label>
                    <input type="text" class="form-control form-control-sm" value="${item.nombre}" 
                           onchange="itemsCompra[${index}].nombre = this.value" ${item.id_producto ? 'readonly' : ''}>
                    <input type="hidden" name="items[${index}][id_producto]" value="${item.id_producto || ''}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Cantidad</label>
                    <input type="number" class="form-control form-control-sm" value="${item.cantidad}" min="0.01" step="0.01"
                           onchange="itemsCompra[${index}].cantidad = parseFloat(this.value); actualizarItemCompra(${index})">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Precio Unit.</label>
                    <input type="number" class="form-control form-control-sm" value="${item.precio_unitario}" min="0" step="0.01"
                           onchange="itemsCompra[${index}].precio_unitario = parseFloat(this.value); actualizarItemCompra(${index})">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Descuento</label>
                    <input type="number" class="form-control form-control-sm" value="${item.descuento}" min="0" step="0.01"
                           onchange="itemsCompra[${index}].descuento = parseFloat(this.value); actualizarItemCompra(${index})">
                </div>
                <div class="col-md-1 text-end">
                    <label class="form-label small">Subtotal</label>
                    <div class="fw-bold text-info" id="subtotal_${index}">$0.00</div>
                </div>
                <div class="col-md-1 text-end">
                    <label class="form-label small">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarItem(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    
    itemsCompra.forEach((item, index) => actualizarItemCompra(index));
}

function actualizarItemCompra(index) {
    const item = itemsCompra[index];
    const subtotalItem = (item.cantidad * item.precio_unitario) - item.descuento;
    const subtotalElement = document.getElementById(`subtotal_${index}`);
    if (subtotalElement) {
        subtotalElement.textContent = `$${subtotalItem.toLocaleString('es-CO', {minimumFractionDigits: 2})}`;
    }
    calcularTotales();
}

function eliminarItem(index) {
    itemsCompra.splice(index, 1);
    renderizarItems();
    calcularTotales();
}

function calcularTotales() {
    let subtotal = 0;
    let impuestos = 0;
    
    itemsCompra.forEach(item => {
        const subtotalItem = (item.cantidad * item.precio_unitario) - item.descuento;
        subtotal += subtotalItem;
        impuestos += subtotalItem * (item.tasa_iva / 100);
    });
    
    const total = subtotal + impuestos;
    
    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('impuestos').value = impuestos.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
    
    document.getElementById('subtotalDisplay').textContent = `$${subtotal.toLocaleString('es-CO', {minimumFractionDigits: 2})}`;
    document.getElementById('impuestosDisplay').textContent = `$${impuestos.toLocaleString('es-CO', {minimumFractionDigits: 2})}`;
    document.getElementById('totalDisplay').textContent = `$${total.toLocaleString('es-CO', {minimumFractionDigits: 2})}`;
}

function generarNumeroDocumento() {
    fetch('/dam/modDam/mod_tienda/ejec/generar_numero_documento.php?tipo=compra')
        .then(response => response.json())
        .then(data => {
            document.getElementById('numero_documento').value = data.numero;
        });
}

function guardarCompra(event) {
    event.preventDefault();
    
    if (itemsCompra.length === 0) {
        alert('Debe agregar al menos un producto');
        return false;
    }
    
    const formData = new FormData(event.target);
    const estado = event.submitter.value;
    formData.append('estado', estado);
    formData.append('items', JSON.stringify(itemsCompra));
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_compra.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            limpiarFormulario();
            document.getElementById('lista-tab').click();
            cargarCompras();
        } else {
            alert('Error: ' + data.message);
        }
    });
    
    return false;
}

function limpiarFormulario() {
    document.getElementById('formCompra').reset();
    itemsCompra = [];
    contadorItems = 0;
    renderizarItems();
    calcularTotales();
    generarNumeroDocumento();
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('infoProveedor').innerHTML = '<p class="text-muted">Seleccione un proveedor</p>';
}

function cargarCompras() {
    fetch('/dam/modDam/mod_tienda/ejec/listar_compras.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('listaCompras');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No hay compras registradas</td></tr>';
                return;
            }
            
            tbody.innerHTML = data.map(compra => {
                const estadoColors = {
                    'borrador': 'secondary',
                    'confirmado': 'success',
                    'anulado': 'danger',
                    'cerrado': 'info'
                };
                
                return `
                    <tr>
                        <td>${compra.id_compra}</td>
                        <td>${compra.numero_documento || 'N/A'}</td>
                        <td>${new Date(compra.fecha).toLocaleDateString('es-CO')}</td>
                        <td>${compra.proveedor_nombre || 'N/A'}</td>
                        <td class="fw-bold text-info">$${parseFloat(compra.total).toLocaleString('es-CO', {minimumFractionDigits: 2})}</td>
                        <td><span class="badge bg-${estadoColors[compra.estado]}">${compra.estado.toUpperCase()}</span></td>
                        <td>
                            <button class="btn btn-info btn-action" onclick="verDetalleCompra(${compra.id_compra})" title="Ver">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${compra.estado === 'borrador' ? `
                                <button class="btn btn-danger btn-action" onclick="anularCompra(${compra.id_compra})" title="Anular">
                                    <i class="fas fa-ban"></i>
                                </button>
                            ` : ''}
                        </td>
                    </tr>
                `;
            }).join('');
        });
}

function filtrarCompras() {
    const filtro = document.getElementById('filtroCompra').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const filas = document.querySelectorAll('#listaCompras tr');
    
    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        const estadoFila = fila.querySelector('.badge')?.textContent.toLowerCase();
        fila.style.display = (texto.includes(filtro) && (!estado || estadoFila === estado)) ? '' : 'none';
    });
}

function verDetalleCompra(id) {
    alert('Ver detalle de compra ' + id);
}

function anularCompra(id) {
    if (confirm('¿Está seguro de anular esta compra?')) {
        fetch('/dam/modDam/mod_tienda/ejec/anular_compra.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id_compra: id})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                cargarCompras();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

document.getElementById('lista-tab').addEventListener('click', cargarCompras);
document.getElementById('proveedores-tab').addEventListener('click', cargarProveedores);
