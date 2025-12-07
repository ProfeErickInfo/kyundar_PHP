<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    die('No autorizado');
}

include("../../../../enlace/conexion.php");

if (!$conexion) {
    die('Error de conexión');
}

// Configurar headers para descarga Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="inventario_' . date('Y-m-d') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

echo "\xEF\xBB\xBF"; // UTF-8 BOM

$sql = "SELECT p.sku, p.nombre, p.descripcion, p.unidad_medida,
        COALESCE(SUM(i.cantidad), 0) as cantidad,
        COALESCE(AVG(i.cantidad_minima), 0) as cantidad_minima,
        COALESCE(AVG(i.costo_promedio), p.precio_costo, 0) as costo_promedio,
        p.precio_venta,
        COALESCE(SUM(i.cantidad * i.costo_promedio), 0) as valor_total
        FROM trn25_productos p
        LEFT JOIN trn25_inventario i ON p.id_producto = i.id_producto
        WHERE p.activo = 1
        GROUP BY p.id_producto
        ORDER BY p.nombre";

$result = mysqli_query($conexion, $sql);

// Encabezados
echo "SKU\tProducto\tDescripción\tUnidad\tCantidad\tMínimo\tCosto Promedio\tPrecio Venta\tValor Total\n";

// Datos
while ($row = mysqli_fetch_assoc($result)) {
    echo implode("\t", [
        $row['sku'] ?? '',
        $row['nombre'],
        $row['descripcion'] ?? '',
        $row['unidad_medida'] ?? 'UND',
        $row['cantidad'],
        $row['cantidad_minima'],
        number_format($row['costo_promedio'], 2, '.', ''),
        number_format($row['precio_venta'], 2, '.', ''),
        number_format($row['valor_total'], 2, '.', '')
    ]) . "\n";
}

mysqli_close($conexion);
?>
