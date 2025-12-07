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
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
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
        .stock-bajo {
            background-color: #fee2e2 !important;
        }
        .stock-normal {
            background-color: #d1fae5 !important;
        }
        .stock-alto {
            background-color: #dbeafe !important;
        }
        .badge-stock {
            font-size: 0.9rem;
            padding: 8px 12px;
        }
    </style>
<div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-hover">
                    <div class="card-header gradient-bg text-white">
                        <h5 class="mb-0">📦 Gestión de Inventario</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="inventarioTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock" type="button">
                                    🏘️ Stock Actual
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="productos-tab" data-bs-toggle="tab" data-bs-target="#productos" type="button">
                                    📦 Productos
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="movimientos-tab" data-bs-toggle="tab" data-bs-target="#movimientos" type="button">
                                    🔄 Movimientos
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ajustes-tab" data-bs-toggle="tab" data-bs-target="#ajustes" type="button">
                                    🔧 Ajuste de Stock
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="inventarioTabContent">
            <!-- Tab Stock Actual -->
            <div class="tab-pane fade show active" id="stock" role="tabpanel">
                <div class="row mb-3">
                    <!-- Tarjetas de Resumen -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-hover text-white bg-primary">
                            <div class="card-body">
                                <h6 class="card-title">📦 Total Productos</h6>
                                <h3 id="totalProductos">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-hover text-white bg-success">
                            <div class="card-body">
                                <h6 class="card-title">💰 Valor Inventario</h6>
                                <h3 id="valorInventario">$0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-hover text-white bg-warning">
                            <div class="card-body">
                                <h6 class="card-title">⚠️ Stock Bajo</h6>
                                <h3 id="stockBajo">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-hover text-white bg-danger">
                            <div class="card-body">
                                <h6 class="card-title">❌ Sin Stock</h6>
                                <h3 id="sinStock">0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-hover">
                    <div class="card-header bg-dark text-white">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">📋 Inventario por Producto</h6>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-light btn-sm" onclick="cargarInventario()">
                                    🔄 Actualizar
                                </button>
                                <button class="btn btn-success btn-sm" onclick="exportarInventario()">
                                    📄 Exportar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="filtroInventario" placeholder="Buscar producto..." onkeyup="filtrarInventario()">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="filtroEstadoStock" onchange="filtrarInventario()">
                                    <option value="">Todos</option>
                                    <option value="bajo">Stock Bajo</option>
                                    <option value="normal">Stock Normal</option>
                                    <option value="sin">Sin Stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>SKU</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Unidad</th>
                                        <th>Mín/Máx</th>
                                        <th>Costo Prom.</th>
                                        <th>Valor Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listaInventario">
                                    <tr><td colspan="9" class="text-center">Cargando...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Productos -->
            <div class="tab-pane fade" id="productos" role="tabpanel">
                <div class="card card-hover">
                    <div class="card-header bg-primary text-white">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">📦 Catálogo de Productos</h6>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-light btn-sm" onclick="mostrarModalProducto()">
                                    ➕ Nuevo Producto
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="filtroProducto" placeholder="Buscar producto..." onkeyup="filtrarProductos()">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>SKU</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Precio Costo</th>
                                        <th>Precio Venta</th>
                                        <th>IVA %</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listaProductos">
                                    <tr><td colspan="8" class="text-center">Cargando...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Movimientos -->
            <div class="tab-pane fade" id="movimientos" role="tabpanel">
                <div class="card card-hover">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">📅 Historial de Movimientos</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="fechaDesde" value="<?php echo date('Y-m-01'); ?>">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="fechaHasta" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="tipoMovimiento">
                                    <option value="">Todos los movimientos</option>
                                    <option value="entrada">Entradas</option>
                                    <option value="salida">Salidas</option>
                                    <option value="ajuste">Ajustes</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100" onclick="cargarMovimientos()">
                                    🔍 Buscar
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-info">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Producto</th>
                                        <th>Tipo</th>
                                        <th>Cantidad</th>
                                        <th>Referencia</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody id="listaMovimientos">
                                    <tr><td colspan="6" class="text-center text-muted">Seleccione fechas y presione Buscar</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Ajustes -->
            <div class="tab-pane fade" id="ajustes" role="tabpanel">
                <div class="card card-hover">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">🔧 Ajuste Manual de Stock</h6>
                    </div>
                    <div class="card-body">
                        <form id="formAjuste" onsubmit="return guardarAjuste(event)">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Producto <span class="text-danger">*</span></label>
                                    <select class="form-select" id="producto_ajuste" name="id_producto" required>
                                        <option value="">Seleccione...</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Stock Actual</label>
                                    <input type="text" class="form-control" id="stock_actual" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Tipo Ajuste <span class="text-danger">*</span></label>
                                    <select class="form-select" id="tipo_ajuste" name="tipo" required>
                                        <option value="entrada">Entrada</option>
                                        <option value="salida">Salida</option>
                                        <option value="ajuste">Ajuste</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="cantidad_ajuste" name="cantidad" required min="0.01" step="0.01">
                                </div>
                                <div class="col-md-9 mb-3">
                                    <label class="form-label">Motivo <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="motivo_ajuste" name="motivo" rows="2" required placeholder="Describa el motivo del ajuste..."></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-warning">
                                        💾 Guardar Ajuste
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="limpiarFormAjuste()">
                                        🧹 Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Producto -->
    <div class="modal fade" id="modalProducto" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header gradient-bg text-white">
                    <h5 class="modal-title">📦 Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formProducto">
                        <input type="hidden" id="id_producto_edit" name="id_producto">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="Código único">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre_producto" name="nombre" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Unidad Medida</label>
                                <input type="text" class="form-control" id="unidad_medida" name="unidad_medida" placeholder="Ej: UND, KG">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Precio Costo</label>
                                <input type="number" class="form-control" id="precio_costo" name="precio_costo" min="0" step="0.01">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Precio Venta</label>
                                <input type="number" class="form-control" id="precio_venta" name="precio_venta" min="0" step="0.01">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">IVA (%)</label>
                                <input type="number" class="form-control" id="tasa_iva" name="tasa_iva" min="0" max="100" step="0.01" value="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Código de Barras</label>
                                <input type="text" class="form-control" id="codigo_barra" name="codigo_barra">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" id="activo" name="activo">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarProducto()">Guardar</button>
                </div>
            </div>
        </div>
</div>

<script>
    if (typeof cargarInventario === 'function') {
        cargarInventario();
        cargarProductosParaAjuste();
    }
</script>
