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
        .btn-action {
            padding: 6px 12px;
            font-size: 0.85rem;
            margin: 2px;
        }
        .item-row {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .total-section {
            background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
            color: white;
            border-radius: 8px;
            padding: 20px;
        }
    </style>
<div class="container-fluid py-4">
        <!-- Header con Tabs -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-hover">
                    <div class="card-header gradient-bg text-white">
                        <h5 class="mb-0">🚚 Gestión de Compras</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="comprasTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="nueva-tab" data-bs-toggle="tab" data-bs-target="#nueva" type="button">
                                    ➕ Nueva Compra
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista" type="button">
                                    📋 Lista de Compras
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="proveedores-tab" data-bs-toggle="tab" data-bs-target="#proveedores" type="button">
                                    🚚 Proveedores
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="comprasTabContent">
            <!-- Tab Nueva Compra -->
            <div class="tab-pane fade show active" id="nueva" role="tabpanel">
                <form id="formCompra" onsubmit="return guardarCompra(event)">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card card-hover mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">ℹ️ Información de la Compra</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Número Documento</label>
                                            <input type="text" class="form-control" id="numero_documento" name="numero_documento" placeholder="Auto-generado" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="fecha" name="fecha" required value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Fecha Recepción</label>
                                            <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Proveedor <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-select" id="id_proveedor" name="id_proveedor" required onchange="cargarInfoProveedor()">
                                                    <option value="">Seleccione...</option>
                                                </select>
                                                <button type="button" class="btn btn-outline-secondary" onclick="mostrarModalProveedor()">
                                                    ➕
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Notas</label>
                                            <textarea class="form-control" id="notas" name="notas" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Productos -->
                            <div class="card card-hover">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">📦 Productos a Comprar</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Buscar Producto</label>
                                            <div class="input-group">
                                                <span class="input-group-text">🔍</span>
                                                <input type="text" class="form-control" id="buscarProducto" placeholder="Escriba nombre o SKU..." onkeyup="buscarProductos(this.value)">
                                            </div>
                                            <div id="resultadosProductos" class="list-group mt-2" style="position:absolute; z-index:1000; max-height:300px; overflow-y:auto; display:none;"></div>
                                        </div>
                                    </div>
                                    <div id="itemsCompra" class="mb-3">
                                        <!-- Items dinámicos aquí -->
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="agregarItemManual()">
                                        ➕ Agregar Ítem Manual
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="col-lg-4">
                            <div class="card card-hover mb-3">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">🚚 Info Proveedor</h6>
                                </div>
                                <div class="card-body" id="infoProveedor">
                                    <p class="text-muted">Seleccione un proveedor</p>
                                </div>
                            </div>

                            <div class="total-section">
                                <h5 class="mb-3">🧮 Resumen</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong id="subtotalDisplay">$0.00</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>IVA:</span>
                                    <strong id="impuestosDisplay">$0.00</strong>
                                </div>
                                <hr style="border-color: rgba(255,255,255,0.3);">
                                <div class="d-flex justify-content-between">
                                    <h5>Total:</h5>
                                    <h4 id="totalDisplay">$0.00</h4>
                                </div>
                                <input type="hidden" id="subtotal" name="subtotal" value="0">
                                <input type="hidden" id="impuestos" name="impuestos" value="0">
                                <input type="hidden" id="total" name="total" value="0">
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-light btn-lg" name="estado" value="borrador">
                                    💾 Guardar Borrador
                                </button>
                                <button type="submit" class="btn btn-success btn-lg" name="estado" value="confirmado">
                                    ✅ Confirmar Compra
                                </button>
                                <button type="button" class="btn btn-outline-light" onclick="limpiarFormulario()">
                                    ❌ Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab Lista de Compras -->
            <div class="tab-pane fade" id="lista" role="tabpanel">
                <div class="card card-hover">
                    <div class="card-header bg-dark text-white">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">📋 Compras Registradas</h6>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-light btn-sm" onclick="cargarCompras()">
                                    🔄 Actualizar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="filtroCompra" placeholder="Buscar..." onkeyup="filtrarCompras()">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="filtroEstado" onchange="filtrarCompras()">
                                    <option value="">Todos los estados</option>
                                    <option value="borrador">Borrador</option>
                                    <option value="confirmado">Confirmado</option>
                                    <option value="anulado">Anulado</option>
                                    <option value="cerrado">Cerrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tablaCompras">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Documento</th>
                                        <th>Fecha</th>
                                        <th>Proveedor</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listaCompras">
                                    <tr>
                                        <td colspan="7" class="text-center">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Proveedores -->
            <div class="tab-pane fade" id="proveedores" role="tabpanel">
                <div class="card card-hover">
                    <div class="card-header bg-primary text-white">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">🚚 Proveedores</h6>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-light btn-sm" onclick="mostrarModalProveedor()">
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

    <!-- Modal Proveedor -->
    <div class="modal fade" id="modalProveedor" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header gradient-bg text-white">
                    <h5 class="modal-title">🚚 Proveedor</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formProveedor">
                        <input type="hidden" id="id_proveedor_edit" name="id_proveedor">
                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre_proveedor" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Identificación</label>
                            <input type="text" class="form-control" id="identificacion_proveedor" name="identificacion">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono_proveedor" name="telefono">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email_proveedor" name="email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion_proveedor" name="direccion" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contacto</label>
                            <input type="text" class="form-control" id="contacto_proveedor" name="contacto_nombre">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarProveedor()">Guardar</button>
                </div>
            </div>
        </div>
</div>

<script>
// Variables globales
var itemsCompra = [];
var contadorItems = 0;
var modalProveedor = null;

// Inicializar modal
function inicializarModal() {
    var modalEl = document.getElementById('modalProveedor');
    if (modalEl && !modalProveedor) {
        modalProveedor = new bootstrap.Modal(modalEl);
    }
}

// Mostrar modal proveedor
function mostrarModalProveedor() {
    inicializarModal();
    document.getElementById('formProveedor').reset();
    document.getElementById('id_proveedor_edit').value = '';
    if (modalProveedor) {
        modalProveedor.show();
    }
}

// Cargar proveedores
function cargarProveedores() {
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
                    select.appendChild(option);
                });
            }
            
            // Lista de proveedores
            const lista = document.getElementById('listaProveedores');
            if (lista) {
                if (data.length === 0) {
                    lista.innerHTML = '<p class="text-muted">No hay proveedores registrados</p>';
                } else {
                    lista.innerHTML = '<div class="row">' + data.map(p => `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">${p.nombre}</h6>
                                    ${p.identificacion ? `<p class="mb-1"><small>ID: ${p.identificacion}</small></p>` : ''}
                                    ${p.telefono ? `<p class="mb-1"><small>Tel: ${p.telefono}</small></p>` : ''}
                                    ${p.email ? `<p class="mb-1"><small>${p.email}</small></p>` : ''}
                                </div>
                            </div>
                        </div>
                    `).join('') + '</div>';
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

// Guardar proveedor
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
            if (modalProveedor) modalProveedor.hide();
            cargarProveedores();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar proveedor');
    });
}

// Generar número de documento
function generarNumeroDocumento() {
    fetch('/dam/modDam/mod_tienda/ejec/generar_numero_documento.php?tipo=compra')
        .then(response => response.json())
        .then(data => {
            const input = document.getElementById('numero_documento');
            if (input && data.numero) {
                input.value = data.numero;
            }
        });
}

// Ejecutar al cargar
setTimeout(function() {
    cargarProveedores();
    generarNumeroDocumento();
}, 100);
</script>
