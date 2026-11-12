<?php
require_once __DIR__ . '/inicio.php';
require_once __DIR__ . '/../clases/Suceciones.php';
encabezado('Fibonacci y factorial', 'Fibonacci muestra los primeros N términos. Factorial muestra los factores y el resultado.');
$res = null; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $n = filter_var($_POST['numero'] ?? null, FILTER_VALIDATE_INT);
        if ($n === false || $n === null) throw new InvalidArgumentException('Ingresa un número entero.');
        $operacion = $_POST['operacion'] ?? '';
        $obj = new Sucesiones();
        if ($operacion === 'fibonacci') {
            $serie = $obj->fibonacci($n);
            $res = '<strong>Serie de Fibonacci:</strong><p>'.e(implode(' → ', $serie)).'</p>';
        } elseif ($operacion === 'factorial') {
            $datos = $obj->factorial($n);
            $expresion = $n === 0 ? '0! = 1' : $n.'! = '.implode(' × ', array_reverse($datos['pasos']));
            $res = '<strong>'.e($expresion).'</strong><p>Resultado: '.e($datos['resultado']).'</p>';
        } else throw new InvalidArgumentException('Selecciona una operación.');
    } catch (Throwable $ex) { $error = $ex->getMessage(); }
}
?>
<form method="post">
    <label for="numero">Número entero</label>
    <input type="number" id="numero" name="numero" min="0" max="1000" required value="<?= e($_POST['numero'] ?? '8') ?>">
    <label for="operacion">Operación</label>
    <select id="operacion" name="operacion">
        <option value="fibonacci" <?= ($_POST['operacion'] ?? '') === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci (cantidad de términos)</option>
        <option value="factorial" <?= ($_POST['operacion'] ?? '') === 'factorial' ? 'selected' : '' ?>>Factorial (n!)</option>
    </select>
    <button type="submit">Calcular</button>
</form>
<?php if ($error) resultado(e($error), true); if ($res !== null) resultado($res); ?>
<p class="hint">Límites: Fibonacci admite de 1 a 1000 términos; factorial admite de 0 a 170.</p>
<?php pie(); ?>