# Módulo de Tienda - KYUNDAR

## Descripción General
Sistema completo de gestión de tienda para el club KYUNDAR, incluyendo inventario, compras, ventas y gestión de clientes/proveedores.

## Estructura del Módulo

```
mod_tienda/
├── scrin/              # Frontend (Interfaces de usuario)
│   ├── ventas.php      # Gestión de ventas
│   ├── compras.php     # Gestión de compras
│   └── inventario.php  # Gestión de inventario y productos
├── ejec/               # Backend (Procesamiento de datos)
│   ├── ventas/
│   │   ├── guardar_venta.php
│   │   ├── listar_ventas.php
│   │   ├── anular_venta.php
│   │   └── obtener_clientes.php
│   ├── compras/
│   │   ├── guardar_compra.php
│   │   ├── listar_compras.php
│   │   ├── anular_compra.php
│   │   ├── obtener_proveedores.php
│   │   └── guardar_proveedor.php
│   ├── inventario/
│   │   ├── obtener_inventario.php
│   │   ├── obtener_productos.php
│   │   ├── guardar_producto.php
│   │   ├── obtener_movimientos.php
│   │   ├── guardar_ajuste.php
│   │   └── exportar_inventario.php
│   ├── buscar_productos.php
│   ├── generar_numero_documento.php
│   └── guardar_cliente.php
└── js/                 # JavaScript
    ├── ventas.js       # Lógica de ventas
    ├── compras.js      # Lógica de compras
    └── inventario.js   # Lógica de inventario
```

## Características Principales

### 1. Gestión de Ventas
- **Nueva Venta**: Interfaz para crear ventas con búsqueda dinámica de productos
- **Clientes**: Soporte para socios del club y clientes externos
- **Estados**: Borrador, Confirmado, Anulado, Cerrado
- **Cálculos**: Subtotal, IVA (por producto), Total
- **Numeración**: Auto-generación de número de documento (V-YYYYMMDD-XXX)
- **Gestión de Items**: Agregar productos por búsqueda o manual
- **Lista de Ventas**: Filtrado por documento, cliente, estado
- **Acciones**: Ver detalle, editar (borrador), anular, imprimir

### 2. Gestión de Compras
- **Nueva Compra**: Interfaz para registrar compras a proveedores
- **Proveedores**: CRUD completo con datos de contacto
- **Fechas**: Fecha de compra y fecha de recepción
- **Estados**: Borrador, Confirmado, Anulado, Cerrado
- **Actualización de Inventario**: Automática al confirmar compra (via triggers)
- **Numeración**: Auto-generación (C-YYYYMMDD-XXX)
- **Lista de Compras**: Filtrado y gestión de compras registradas

### 3. Gestión de Inventario
- **Dashboard**: Resumen con totales, valor, productos con stock bajo
- **Stock Actual**: Vista de inventario por producto con indicadores visuales
  - Stock bajo (rojo)
  - Stock normal (verde)
  - Stock alto (azul)
- **Productos**: CRUD completo
  - SKU, nombre, descripción
  - Unidad de medida
  - Precio costo y venta
  - Tasa de IVA
  - Código de barras
  - Estado activo/inactivo
- **Movimientos**: Historial de entradas/salidas/ajustes
- **Ajuste de Stock**: Herramienta para ajustes manuales con motivo
- **Exportación**: Descarga de inventario a Excel

### 4. Gestión de Clientes
- **Tipos**: Socios (vinculados a trn25_socios) y Externos
- **Datos**: Nombre, documento, teléfono, email, dirección
- **Integración**: Automática con módulo de socios

## Tablas de Base de Datos

### Principales
- `trn25_productos`: Catálogo de productos
- `trn25_inventario`: Stock por producto y almacén
- `trn25_proveedores`: Proveedores
- `trn25_clientes`: Clientes (socios y externos)
- `trn25_ventas` / `trn25_ventas_items`: Ventas y detalle
- `trn25_compras` / `trn25_compras_items`: Compras y detalle
- `trn25_stock_movimientos`: Historial de movimientos
- `trn25_almacenes`: Almacenes/bodegas

### Triggers Automáticos
Las tablas tienen triggers que automáticamente:
- Actualizan inventario al insertar items de compra/venta
- Registran movimientos de stock
- Calculan costo promedio

## Diseño y UX

### Framework
- **Bootstrap 5.3.2**: Sistema de diseño responsivo
- **Font Awesome 6.4.0**: Iconografía
- **Gradientes**: Colores distintivos por módulo
  - Ventas: Púrpura (#667eea → #764ba2)
  - Compras: Cyan (#0891b2 → #0284c7)
  - Inventario: Azul (#0284c7 → #0369a1)

### Características UI
- **Tabs de Navegación**: Organización por funcionalidad
- **Cards con Hover**: Efectos de elevación
- **Badges de Estado**: Indicadores visuales de color
- **Búsqueda Dinámica**: Autocompletado de productos
- **Responsive**: Adaptable a móviles y tablets
- **Filtros en Tiempo Real**: Búsqueda sin recargar página

## Flujo de Trabajo

### Proceso de Venta
1. Seleccionar cliente (o crear nuevo)
2. Buscar y agregar productos
3. Ajustar cantidades, descuentos
4. Revisar totales calculados automáticamente
5. Guardar como borrador o confirmar
6. Al confirmar: actualiza inventario automáticamente

### Proceso de Compra
1. Seleccionar proveedor (o crear nuevo)
2. Agregar productos y cantidades
3. Indicar precios de compra
4. Guardar como borrador o confirmar
5. Al confirmar: incrementa inventario automáticamente

### Gestión de Inventario
1. Ver stock actual con alertas de bajo stock
2. Crear/editar productos
3. Ajustar stock manualmente cuando sea necesario
4. Revisar historial de movimientos
5. Exportar reportes

## Seguridad

### Implementada
- **Sesiones PHP**: Validación de usuario autenticado
- **Prepared Statements**: Todas las consultas SQL
- **Validación de Datos**: Frontend y backend
- **Transacciones**: Para operaciones críticas
- **Control de Acceso**: Por sesión de usuario

### Variables de Sesión
- `$_SESSION['id_usuario']`: ID del usuario logueado
- Se registra en `created_by` para auditoría

## API Backend (Endpoints)

### Ventas
- `POST /ejec/guardar_venta.php`: Crear/actualizar venta
- `GET /ejec/listar_ventas.php`: Listar ventas
- `POST /ejec/anular_venta.php`: Anular venta
- `GET /ejec/obtener_clientes.php`: Listar clientes

### Compras
- `POST /ejec/guardar_compra.php`: Crear/actualizar compra
- `GET /ejec/listar_compras.php`: Listar compras
- `POST /ejec/anular_compra.php`: Anular compra
- `GET /ejec/obtener_proveedores.php`: Listar proveedores
- `POST /ejec/guardar_proveedor.php`: Crear/actualizar proveedor

### Inventario
- `GET /ejec/obtener_inventario.php`: Stock actual
- `GET /ejec/obtener_productos.php`: Catálogo productos
- `POST /ejec/guardar_producto.php`: Crear/actualizar producto
- `GET /ejec/obtener_movimientos.php`: Historial movimientos
- `POST /ejec/guardar_ajuste.php`: Ajuste manual stock
- `GET /ejec/exportar_inventario.php`: Exportar a Excel

### Comunes
- `GET /ejec/buscar_productos.php?q={término}`: Búsqueda de productos
- `GET /ejec/generar_numero_documento.php?tipo={venta|compra}`: Generar número
- `POST /ejec/guardar_cliente.php`: Crear/actualizar cliente

## Configuración

### Requisitos
- PHP 7.4+
- MySQL/MariaDB 10.5+
- Bootstrap 5.3.2 (CDN)
- Font Awesome 6.4.0 (CDN)

### Conexión a BD
Utiliza el archivo estándar de conexión:
```php
include("../../../../../login/enlace/conexion.php");
```

### Variables de Configuración
- Base de datos: `edev_klubd3025`
- Usuario: Configurado en conexion.php
- Charset: UTF-8

## Integración con el Sistema

### Menú Principal
El módulo se integra al menú principal en `tb_menu.php`:
```html
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle">Tienda</a>
  <ul class="dropdown-menu">
    <li><a href="#" onClick="cargarFocus('modDam/mod_tienda/scrin/ventas.php',...)">Ventas</a></li>
    <li><a href="#" onClick="cargarFocus('modDam/mod_tienda/scrin/compras.php',...)">Compras</a></li>
    <li><a href="#" onClick="cargarFocus('modDam/mod_tienda/scrin/inventario.php',...)">Inventario</a></li>
  </ul>
</li>
```

### Función cargarFocus
Los módulos se cargan dinámicamente sin recargar la página mediante AJAX en el contenedor `DivContenido`.

## Próximas Mejoras Sugeridas

1. **Reportes Avanzados**
   - Ventas por período
   - Productos más vendidos
   - Rentabilidad por producto

2. **Funcionalidades Adicionales**
   - Devoluciones de venta
   - Devoluciones a proveedor
   - Cotizaciones
   - Órdenes de compra

3. **Mejoras UI/UX**
   - Gráficos y estadísticas (Chart.js)
   - Notificaciones en tiempo real
   - Impresión de facturas/tickets

4. **Integraciones**
   - Lector de código de barras
   - API de facturación electrónica
   - Sincronización con contabilidad

## Soporte y Mantenimiento

### Logs de Errores
Revisar logs de PHP para errores backend.

### Debugging
Los archivos JavaScript incluyen `console.error()` para debugging en navegador.

### Base de Datos
Realizar backups regulares de las tablas `trn25_*`.

## Autor
Desarrollado para KYUNDAR - Sistema de Gestión Deportiva
Fecha: Noviembre 2025
Versión: 1.0

## Licencia
Uso interno exclusivo de KYUNDAR
