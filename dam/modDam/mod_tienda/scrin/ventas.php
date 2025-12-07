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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        .badge-estado {
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .item-row {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .total-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                        <h5 class="mb-0">🛒 Gestión de Ventas</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="ventasTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="nueva-tab" data-bs-toggle="tab" data-bs-target="#nueva" type="button">
                                    ➕ Nueva Venta
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista" type="button">
                                    📋 Lista de Ventas
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="ventasTabContent">
            <!-- Tab Nueva Venta -->
            <div class="tab-pane fade show active" id="nueva" role="tabpanel">
                <form id="formVenta" onsubmit="return guardarVenta(event)">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-lg-8">
                            <div class="card card-hover mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">ℹ️ Información de la Venta</h6>
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
                                            <label class="form-label">Cliente <span class="text-danger">*</span></label>
                                            <select class="form-select" id="id_cliente" name="id_cliente" required onchange="cargarInfoCliente()">
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Notas</label>
                                            <textarea class="form-control" id="notas" name="notas" rows="2" placeholder="Observaciones adicionales..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Productos -->
                            <div class="card card-hover">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">🛒 Productos</h6>
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
                                    <div id="itemsVenta" class="mb-3">
                                        <!-- Items dinámicos aquí -->
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="agregarItemManual()">
                                        ➕ Agregar Ítem Manual
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha - Resumen -->
                        <div class="col-lg-4">
                            <div class="card card-hover mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">👤 Info Cliente</h6>
                                </div>
                                <div class="card-body" id="infoCliente">
                                    <p class="text-muted">Seleccione un cliente</p>
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
                                    ✅ Confirmar Venta
                                </button>
                                <button type="button" class="btn btn-outline-light" onclick="limpiarFormulario()">
                                    ❌ Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab Lista de Ventas -->
            <div class="tab-pane fade" id="lista" role="tabpanel">
                <div class="card card-hover">
                    <div class="card-header bg-dark text-white">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">📋 Ventas Registradas</h6>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-light btn-sm" onclick="cargarVentas()">
                                    🔄 Actualizar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="filtroVenta" placeholder="Buscar por documento o cliente..." onkeyup="filtrarVentas()">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="filtroEstado" onchange="filtrarVentas()">
                                    <option value="">Todos los estados</option>
                                    <option value="borrador">Borrador</option>
                                    <option value="confirmado">Confirmado</option>
                                    <option value="anulado">Anulado</option>
                                    <option value="cerrado">Cerrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tablaVentas">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Documento</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listaVentas">
                                    <tr>
                                        <td colspan="7" class="text-center">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    // Cargar datos iniciales
    if (typeof cargarClientes === 'function') {
        cargarClientes();
        generarNumeroDocumento();
    }
</script>
