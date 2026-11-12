<?php
require_once __DIR__ . '/inicio.php';
require_once __DIR__ . '/../clases/ConversorBinario.php';
encabezado('Conversor a binario', 'Convierte un número entero decimal a su representación en base 2.');
$res = null; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = filter_var($_POST['numero'] ?? null, FILTER_VALIDATE_INT);
    if ($n === false || $n === null) $error = 'Ingresa un número entero válido.';
    else $res = (new ConversorBinario())->convertir($n);
}
?>
<form method="post">
    <label for="numero">Número entero</label>
    <input type="number" step="1" id="numero" name="numero" required value="<?= e($_POST['numero'] ?? '13') ?>">
    <button type="submit">Convertir a binario</button>
</form>
<?php if ($error) resultado(e($error), true); if ($res !== null) resultado('<strong>Binario:</strong> '.e($res)); ?>
<p class="hint">Para números negativos se muestra un signo menos seguido del binario del valor absoluto.</p>
<?php pie(); ?>
