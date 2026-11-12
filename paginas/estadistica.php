<?php
require_once __DIR__ . '/inicio.php';
require_once __DIR__ . '/../clases/Estadistica.php';
encabezado('Estadística', 'Ingresa números reales separados por comas, espacios o saltos de línea.');
$res = null; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $texto = trim($_POST['numeros'] ?? '');
        if ($texto === '') throw new InvalidArgumentException('Ingresa al menos un número.');
        $partes = preg_split('/[\s,;]+/', $texto, -1, PREG_SPLIT_NO_EMPTY);
        $numeros = [];
        foreach ($partes as $p) {
            if (!is_numeric($p)) throw new InvalidArgumentException('Todos los valores deben ser números reales.');
            $numeros[] = (float)$p;
        }
        $datos = (new Estadistica())->calcular($numeros);
        $moda = $datos['moda'] ? implode(', ', $datos['moda']) : 'No hay moda (todos aparecen una sola vez).';
        $res = '<strong>Resultados</strong><ul><li>Cantidad de datos: '.e($datos['cantidad']).'</li><li>Promedio / media aritmética: '.e($datos['promedio']).'</li><li>Mediana: '.e($datos['mediana']).'</li><li>Moda: '.e($moda).'</li></ul>';
    } catch (Throwable $ex) { $error = $ex->getMessage(); }
}
?>
<form method="post">
    <label for="numeros">Números</label>
    <textarea id="numeros" name="numeros" required placeholder="2.5, 3, 3, 7, 9"><?= e($_POST['numeros'] ?? '') ?></textarea>
    <button type="submit">Calcular estadística</button>
</form>
<?php if ($error) resultado(e($error), true); if ($res !== null) resultado($res); ?>
<p class="hint">Nota: promedio y media aritmética son el mismo cálculo. Se incluye la mediana porque suele acompañar a la moda en este tipo de ejercicio.</p>
<?php pie(); ?>
