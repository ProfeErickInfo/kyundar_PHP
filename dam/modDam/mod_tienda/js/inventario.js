// Variables globales
let modalProducto;

document.addEventListener('DOMContentLoaded', function() {
    modalProducto = new bootstrap.Modal(document.getElementById('modalProducto'));
});

// Cargar inventario
function cargarInventario() {
    fetch('/dam/modDam/mod_tienda/ejec/obtener_inventario.php')
        .then(response => response.json())
        .then(data => {
            actualizarResumen(data);
            mostrarInventario(data);
        })
        .catch(error => console.error('Error:', error));
}

function actualizarResumen(data) {
    let totalProductos = data.length;
    let valorTotal = 0;
    let stockBajo = 0;
    let sinStock = 0;
    
    data.forEach(item => {
        valorTotal += parseFloat(item.valor_total || 0);
        if (parseFloat(item.cantidad) <= 0) sinStock++;
        else if (parseFloat(item.cantidad) <= parseFloat(item.cantidad_minima || 0)) stockBajo++;
    });
    
    document.getElementById('totalProductos').textContent = totalProductos;
    document.getElementById('valorInventario').textContent = '$' + valorTotal.toLocaleString('es-CO', {minimumFractionDigits: 0});
    document.getElementById('stockBajo').textContent = stockBajo;
    document.getElementById('sinStock').textContent = sinStock;
}

function mostrarInventario(data) {
    const tbody = document.getElementById('listaInventario');
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">No hay productos en inventario</td></tr>';
        return;
    }
    
    tbody.innerHTML = data.map(item => {
        let claseStock = 'stock-normal';
        let estadoStock = '<span class="badge bg-success">Normal</span>';
        const cantidad = parseFloat(item.cantidad || 0);
        const minimo = parseFloat(item.cantidad_minima || 0);
        
        if (cantidad <= 0) {
            claseStock = 'stock-bajo';
            estadoStock = '<span class="badge bg-danger">Sin Stock</span>';
        } else if (cantidad <= minimo) {
            claseStock = 'stock-bajo';
            estadoStock = '<span class="badge bg-warning text-dark">Stock Bajo</span>';
        } else if (cantidad > minimo * 3) {
            claseStock = 'stock-alto';
            estadoStock = '<span class="badge bg-info">Stock Alto</span>';
        }
        
        return `
            <tr class="${claseStock}">
                <td>${item.sku || 'N/A'}</td>
                <td><strong>${item.nombre}</strong></td>
                <td class="text-center"><span class="badge badge-stock bg-dark">${item.cantidad}</span></td>
                <td>${item.unidad_medida || 'UND'}</td>
                <td class="text-center">${minimo} / ${item.cantidad_maxima || '-'}</td>
                <td class="text-end">$${parseFloat(item.costo_promedio || 0).toLocaleString('es-CO', {minimumFractionDigits: 2})}</td>
                <td class="text-end fw-bold text-success">$${parseFloat(item.valor_total || 0).toLocaleString('es-CO', {minimumFractionDigits: 2})}</td>
                <td>${estadoStock}</td>
                <td>
                    <button class="btn btn-sm btn-info btn-action" onclick="verDetalleProducto(${item.id_producto})" title="Ver">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning btn-action" onclick="ajustarStockRapido(${item.id_producto}, '${item.nombre.replace(/'/g, "\\'")}', ${item.cantidad})" title="Ajustar">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

function filtrarInventario() {
    const filtro = document.getElementById('filtroInventario').value.toLowerCase();
    const estado = document.getElementById('filtroEstadoStock').value;
    const filas = document.querySelectorAll('#listaInventario tr');
    
    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        let cumpleEstado = true;
        
        if (estado === 'bajo') cumpleEstado = fila.classList.contains('stock-bajo');
        else if (estado === 'normal') cumpleEstado = fila.classList.contains('stock-normal');
        else if (estado === 'sin') cumpleEstado = fila.querySelector('.bg-danger') !== null;
        
        fila.style.display = (texto.includes(filtro) && cumpleEstado) ? '' : 'none';
    });
}

// Productos
function cargarProductos() {
    fetch('/dam/modDam/mod_tienda/ejec/obtener_productos.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('listaProductos');
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">No hay productos registrados</td></tr>';
                return;
            }
            
            tbody.innerHTML = data.map(prod => `
                <tr>
                    <td>${prod.sku || 'N/A'}</td>
                    <td><strong>${prod.nombre}</strong></td>
                    <td><small>${prod.descripcion || ''}</small></td>
                    <td class="text-end">$${parseFloat(prod.precio_costo || 0).toLocaleString('es-CO', {minimumFractionDigits: 2})}</td>
                    <td class="text-end">$${parseFloat(prod.precio_venta || 0).toLocaleString('es-CO', {minimumFractionDigits: 2})}</td>
                    <td class="text-center">${prod.tasa_iva}%</td>
                    <td><span class="badge bg-${prod.activo == 1 ? 'success' : 'secondary'}">${prod.activo == 1 ? 'Activo' : 'Inactivo'}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary btn-action" onclick='editarProducto(${JSON.stringify(prod)})' title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        });
}

function filtrarProductos() {
    const filtro = document.getElementById('filtroProducto').value.toLowerCase();
    const filas = document.querySelectorAll('#listaProductos tr');
    
    filas.forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(filtro) ? '' : 'none';
    });
}

function mostrarModalProducto() {
    document.getElementById('formProducto').reset();
    document.getElementById('id_producto_edit').value = '';
    modalProducto.show();
}

function editarProducto(producto) {
    document.getElementById('id_producto_edit').value = producto.id_producto;
    document.getElementById('sku').value = producto.sku || '';
    document.getElementById('nombre_producto').value = producto.nombre;
    document.getElementById('descripcion').value = producto.descripcion || '';
    document.getElementById('unidad_medida').value = producto.unidad_medida || '';
    document.getElementById('precio_costo').value = producto.precio_costo || '';
    document.getElementById('precio_venta').value = producto.precio_venta || '';
    document.getElementById('tasa_iva').value = producto.tasa_iva || 0;
    document.getElementById('codigo_barra').value = producto.codigo_barra || '';
    document.getElementById('activo').value = producto.activo;
    modalProducto.show();
}

function guardarProducto() {
    const formData = new FormData(document.getElementById('formProducto'));
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_producto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            modalProducto.hide();
            cargarProductos();
            cargarInventario();
            cargarProductosParaAjuste();
        } else {
            alert('Error: ' + data.message);
        }
    });
}

// Movimientos
function cargarMovimientos() {
    const fechaDesde = document.getElementById('fechaDesde').value;
    const fechaHasta = document.getElementById('fechaHasta').value;
    const tipo = document.getElementById('tipoMovimiento').value;
    
    fetch(`/dam/modDam/mod_tienda/ejec/obtener_movimientos.php?desde=${fechaDesde}&hasta=${fechaHasta}&tipo=${tipo}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('listaMovimientos');
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay movimientos en este período</td></tr>';
                return;
            }
            
            tbody.innerHTML = data.map(mov => {
                const tipoColors = {
                    'entrada': 'success',
                    'salida': 'danger',
                    'ajuste': 'warning'
                };
                
                return `
                    <tr>
                        <td>${new Date(mov.fecha).toLocaleString('es-CO')}</td>
                        <td>${mov.producto_nombre}</td>
                        <td><span class="badge bg-${tipoColors[mov.tipo]}">${mov.tipo.toUpperCase()}</span></td>
                        <td class="text-center"><strong>${mov.cantidad}</strong></td>
                        <td>${mov.referencia || '-'}</td>
                        <td>${mov.usuario || '-'}</td>
                    </tr>
                `;
            }).join('');
        });
}

// Ajustes
function cargarProductosParaAjuste() {
    fetch('/dam/modDam/mod_tienda/ejec/obtener_productos.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('producto_ajuste');
            select.innerHTML = '<option value="">Seleccione...</option>';
            
            data.forEach(prod => {
                const option = document.createElement('option');
                option.value = prod.id_producto;
                option.textContent = `${prod.nombre} ${prod.sku ? '(' + prod.sku + ')' : ''}`;
                select.appendChild(option);
            });
        });
}

document.getElementById('producto_ajuste')?.addEventListener('change', function() {
    if (this.value) {
        fetch(`/dam/modDam/mod_tienda/ejec/obtener_inventario.php?id_producto=${this.value}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('stock_actual').value = data[0]?.cantidad || 0;
            });
    } else {
        document.getElementById('stock_actual').value = '';
    }
});

function guardarAjuste(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    fetch('/dam/modDam/mod_tienda/ejec/guardar_ajuste.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            limpiarFormAjuste();
            cargarInventario();
        } else {
            alert('Error: ' + data.message);
        }
    });
    
    return false;
}

function limpiarFormAjuste() {
    document.getElementById('formAjuste').reset();
    document.getElementById('stock_actual').value = '';
}

function ajustarStockRapido(id, nombre, stockActual) {
    document.getElementById('ajustes-tab').click();
    document.getElementById('producto_ajuste').value = id;
    document.getElementById('stock_actual').value = stockActual;
}

function verDetalleProducto(id) {
    alert('Ver detalle del producto ' + id);
}

function exportarInventario() {
    window.open('/dam/modDam/mod_tienda/ejec/exportar_inventario.php', '_blank');
}

// Cargar datos al cambiar de tab
document.getElementById('productos-tab')?.addEventListener('click', cargarProductos);
document.getElementById('stock-tab')?.addEventListener('click', cargarInventario);
