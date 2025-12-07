// Variables globales
if (typeof itemsVenta === 'undefined') var itemsVenta = [];
if (typeof contadorItems === 'undefined') var contadorItems = 0;
let productosCache = [];

// Cargar clientes
function cargarClientes() {
    fetch('/dam/modDam/mod_tienda/ejec/obtener_clientes.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_cliente');
            select.innerHTML = '<option value="">Seleccione...</option>';
            data.forEach(cliente => {
                const option = document.createElement('option');
                option.value = cliente.id_cliente;
                option.textContent = `${cliente.nombre} ${cliente.tipo === 'socio' ? '(Socio)' : ''}`;
                option.dataset.info = JSON.stringify(cliente);
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Cargar información del cliente
function cargarInfoCliente() {
    const select = document.getElementById('id_cliente');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('infoCliente');
    
    if (option.value) {
        const cliente = JSON.parse(option.dataset.info);
        infoDiv.innerHTML = `
            <div class="mb-2">
                <small class="text-muted">Tipo:</small><br>
                <span class="badge bg-${cliente.tipo === 'socio' ? 'primary' : 'secondary'}">${cliente.tipo.toUpperCase()}</span>
            </div>
            ${cliente.documento ? `<div class="mb-2"><small class="text-muted">Documento:</small><br><strong>${cliente.documento}</strong></div>` : ''}
            ${cliente.telefono ? `<div class="mb-2"><small class="text-muted">Teléfono:</small><br>${cliente.telefono}</div>` : ''}
            ${cliente.email ? `<div class="mb-2"><small class="text-muted">Email:</small><br>${cliente.email}</div>` : ''}
        `;
    } else {
        infoDiv.innerHTML = '<p class="text-muted">Seleccione un cliente</p>';
    }
}

// Buscar productos
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
                        <a href="#" class="list-group-item list-group-item-action" onclick="agregarProducto(${producto.id_producto}, '${producto.nombre.replace(/'/g, "\\'")}', ${producto.precio_venta}, ${producto.tasa_iva}); return false;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>${producto.nombre}</strong>
                                    ${producto.sku ? `<br><small class="text-muted">SKU: ${producto.sku}</small>` : ''}
                                </div>
                                <div class="text-end">
                                    <strong class="text-success">$${parseFloat(producto.precio_venta).toLocaleString('es-CO', {minimumFractionDigits: 2})}</strong>
                                    <br><small class="text-muted">Stock: ${producto.stock || 0}</small>
                                </div>
                            </div>
                        </a>
                    `).join('');
                    resultados.style.display = 'block';
                } else {
                    resultados.innerHTML = '<div class="list-group-item text-muted">No se encontraron productos</div>';
                    resultados.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultados.style.display = 'none';
            });
    }, 300);
}

// Agregar producto a la venta
function agregarProducto(id, nombre, precio, iva) {
    // Ocultar resultados
    document.getElementById('resultadosProductos').style.display = 'none';
    document.getElementById('buscarProducto').value = '';
    
    // Verificar si ya existe el producto
    const existente = itemsVenta.find(item => item.id_producto === id);
    if (existente) {
        existente.cantidad++;
        actualizarItemVenta(itemsVenta.indexOf(existente));
        return;
    }
    
    // Agregar nuevo item
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
    
    itemsVenta.push(item);
    renderizarItems();
    calcularTotales();
}

// Agregar item manual
function agregarItemManual() {
    contadorItems++;
    const item = {
        id_temp: contadorItems,
        id_producto: null,
        nombre: '',
        cantidad: 1,
        precio_unitario: 0,
        descuento: 0,
        tasa_iva: 0
    };
    
    itemsVenta.push(item);
    renderizarItems();
}

// Renderizar items
function renderizarItems() {
    const container = document.getElementById('itemsVenta');
    
    if (itemsVenta.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">No hay productos agregados</p>';
        return;
    }
    
    container.innerHTML = itemsVenta.map((item, index) => `
        <div class="item-row">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label class="form-label small">Producto</label>
                    <input type="text" class="form-control form-control-sm" value="${item.nombre}" 
                           onchange="itemsVenta[${index}].nombre = this.value" ${item.id_producto ? 'readonly' : ''}>
                    <input type="hidden" name="items[${index}][id_producto]" value="${item.id_producto || ''}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Cantidad</label>
                    <input type="number" class="form-control form-control-sm" value="${item.cantidad}" min="0.01" step="0.01"
                           name="items[${index}][cantidad]" onchange="itemsVenta[${index}].cantidad = parseFloat(this.value); actualizarItemVenta(${index})">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Precio Unit.</label>
                    <input type="number" class="form-control form-control-sm" value="${item.precio_unitario}" min="0" step="0.01"
                           name="items[${index}][precio_unitario]" onchange="itemsVenta[${index}].precio_unitario = parseFloat(this.value); actualizarItemVenta(${index})">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Descuento</label>
                    <input type="number" class="form-control form-control-sm" value="${item.descuento}" min="0" step="0.01"
                           name="items[${index}][descuento]" onchange="itemsVenta[${index}].descuento = parseFloat(this.value); actualizarItemVenta(${index})">
                </div>
                <div class="col-md-1 text-end">
                    <label class="form-label small">Subtotal</label>
                    <div class="fw-bold text-success" id="subtotal_${index}">$0.00</div>
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
    
    // Actualizar subtotales de cada item
    itemsVenta.forEach((item, index) => {
        actualizarItemVenta(index);
    });
}

// Actualizar item individual
function actualizarItemVenta(index) {
    const item = itemsVenta[index];
    const subtotalItem = (item.cantidad * item.precio_unitario) - item.descuento;
    const subtotalElement = document.getElementById(`subtotal_${index}`);
    if (subtotalElement) {
        subtotalElement.textContent = `$${subtotalItem.toLocaleString('es-CO', {minimumFractionDigits: 2})}`;
    }
    calcularTotales();
}

// Eliminar item
function eliminarItem(index) {
    itemsVenta.splice(index, 1);
    renderizarItems();
    calcularTotales();
}

// Calcular totales
function calcularTotales() {
    let subtotal = 0;
    let impuestos = 0;
    
    itemsVenta.forEach(item => {
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

// Generar número de documento
function generarNumeroDocumento() {
    fetch('/dam/modDam/mod_tienda/ejec/generar_numero_documento.php?tipo=venta')
        .then(response => response.json())
        .then(data => {
            document.getElementById('numero_documento').value = data.numero;
        });
}

// Guardar venta
function guardarVenta(event) {
    event.preventDefault();
    
    if (itemsVenta.length === 0) {
        alert('Debe agregar al menos un producto a la venta');
        return false;
    }
    
    const formData = new FormData(event.target);
    const estado = event.submitter.value;
    formData.append('estado', estado);
    formData.append('items', JSON.stringify(itemsVenta));
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_venta.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            limpiarFormulario();
            // Cambiar a pestaña de lista
            document.getElementById('lista-tab').click();
            cargarVentas();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la venta');
    });
    
    return false;
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById('formVenta').reset();
    itemsVenta = [];
    contadorItems = 0;
    renderizarItems();
    calcularTotales();
    generarNumeroDocumento();
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('infoCliente').innerHTML = '<p class="text-muted">Seleccione un cliente</p>';
}

// Cargar lista de ventas
function cargarVentas() {
    fetch('/dam/modDam/mod_tienda/ejec/listar_ventas.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('listaVentas');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No hay ventas registradas</td></tr>';
                return;
            }
            
            tbody.innerHTML = data.map(venta => {
                const estadoColors = {
                    'borrador': 'secondary',
                    'confirmado': 'success',
                    'anulado': 'danger',
                    'cerrado': 'info'
                };
                
                return `
                    <tr>
                        <td>${venta.id_venta}</td>
                        <td>${venta.numero_documento || 'N/A'}</td>
                        <td>${new Date(venta.fecha).toLocaleDateString('es-CO')}</td>
                        <td>${venta.cliente_nombre || 'Cliente General'}</td>
                        <td class="fw-bold text-success">$${parseFloat(venta.total).toLocaleString('es-CO', {minimumFractionDigits: 2})}</td>
                        <td><span class="badge badge-estado bg-${estadoColors[venta.estado]}">${venta.estado.toUpperCase()}</span></td>
                        <td>
                            <button class="btn btn-info btn-action" onclick="verDetalleVenta(${venta.id_venta})" title="Ver Detalle">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${venta.estado === 'borrador' ? `
                                <button class="btn btn-warning btn-action" onclick="editarVenta(${venta.id_venta})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-action" onclick="anularVenta(${venta.id_venta})" title="Anular">
                                    <i class="fas fa-ban"></i>
                                </button>
                            ` : ''}
                            <button class="btn btn-secondary btn-action" onclick="imprimirVenta(${venta.id_venta})" title="Imprimir">
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('listaVentas').innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error al cargar las ventas</td></tr>';
        });
}

// Filtrar ventas
function filtrarVentas() {
    const filtro = document.getElementById('filtroVenta').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const filas = document.querySelectorAll('#listaVentas tr');
    
    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        const estadoFila = fila.querySelector('.badge-estado')?.textContent.toLowerCase();
        const cumpleFiltro = texto.includes(filtro);
        const cumpleEstado = !estado || estadoFila === estado;
        
        fila.style.display = (cumpleFiltro && cumpleEstado) ? '' : 'none';
    });
}

// Ver detalle de venta
function verDetalleVenta(id) {
    // Implementar modal o ventana de detalle
    alert('Ver detalle de venta ' + id);
}

// Editar venta
function editarVenta(id) {
    // Cargar datos de la venta y llenar formulario
    alert('Editar venta ' + id);
}

// Anular venta
function anularVenta(id) {
    if (confirm('¿Está seguro de anular esta venta?')) {
        fetch('/dam/modDam/mod_tienda/ejec/anular_venta.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id_venta: id})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                cargarVentas();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

// Imprimir venta
function imprimirVenta(id) {
    window.open(`../ejec/imprimir_venta.php?id=${id}`, '_blank');
}

// Cargar ventas al cambiar a la pestaña
document.getElementById('lista-tab').addEventListener('click', function() {
    cargarVentas();
});
