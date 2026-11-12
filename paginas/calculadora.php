<?php
require_once __DIR__ . '/inicio.php';
require_once __DIR__ . '/../clases/Claculadora.php';
encabezado('Calculadora con historial', 'Admite enteros y decimales. En porcentaje, calcula el primer número por ciento del segundo.');
if (!isset($_SESSION['historial'])) $_SESSION['historial'] = [];
$res = null; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['borrar'])) {
        $_SESSION['historial'] = [];
        $res = '<strong>Historial borrado.</strong>';
    } else {
        try {
            $a = filter_var($_POST['a'] ?? null, FILTER_VALIDATE_FLOAT);
            $b = filter_var($_POST['b'] ?? null, FILTER_VALIDATE_FLOAT);
            if ($a === false || $a === null || $b === false || $b === null) throw new InvalidArgumentException('Ingresa dos números válidos.');
            $datos = (new Calculadora())->calcular((float)$a, (float)$b, $_POST['operacion'] ?? '');
            $res = '<strong>'.e($datos['expresion']).' = '.e($datos['resultado']).'</strong>';
            array_unshift($_SESSION['historial'], ['expresion'=>$datos['expresion'], 'resultado'=>$datos['resultado']]);
            $_SESSION['historial'] = array_slice($_SESSION['historial'], 0, 50);
        } catch (Throwable $ex) { $error = $ex->getMessage(); }
    }
}
?>
<form method="post">
    <label for="a">Primer número</label>
    <input type="number" step="any" id="a" name="a" required value="<?= e($_POST['a'] ?? '10') ?>">
    <label for="b">Segundo número</label>
    <input type="number" step="any" id="b" name="b" required value="<?= e($_POST['b'] ?? '5') ?>">
    <label for="operacion">Operación</label>
    <select id="operacion" name="operacion">
        <?php foreach (['suma'=>'Suma (+)','resta'=>'Resta (−)','multiplicacion'=>'Multiplicación (×)','division'=>'División (÷)','porcentaje'=>'Porcentaje (% de)'] as $v=>$t): ?>
            <option value="<?= e($v) ?>" <?= ($_POST['operacion'] ?? 'suma') === $v ? 'selected' : '' ?>><?= e($t) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Calcular</button>
</form>
<?php if ($error) resultado(e($error), true); if ($res !== null) resultado($res); ?>
<h2>Historial</h2>
<?php if (!$_SESSION['historial']): ?>
    <p class="hint">Todavía no hay operaciones guardadas.</p>
<?php else: ?>
    <table><thead><tr><th>Operación</th><th>Resultado</th></tr></thead><tbody>
    <?php foreach ($_SESSION['historial'] as $item): ?><tr><td><?= e($item['expresion']) ?></td><td><?= e($item['resultado']) ?></td></tr><?php endforeach; ?>
    </tbody></table>
<?php endif; ?>
<form method="post"><button class="secondary" type="submit" name="borrar" value="1" onclick="return confirm('¿Borrar todo el historial?')">Borrar historial</button></form>
<?php pie(); ?>