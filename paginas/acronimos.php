<?php
require_once __DIR__ . '/inicio.php';
require_once __DIR__ . '/../clases/Acronimo.php';
encabezado('Generador de acrónimos', 'Escribe una frase. Los espacios y guiones separan palabras; se ignoran los demás signos de puntuación.');
$res = null; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = trim($_POST['frase'] ?? '');
    if ($frase === '') $error = 'Escribe una frase.';
    else { $obj = new Acronimo(); $res = $obj->generar($frase); }
}
?>
<form method="post">
    <label for="frase">Frase</label>
    <input id="frase" name="frase" maxlength="500" required value="<?= e($_POST['frase'] ?? '') ?>" placeholder="Portable Network Graphics">
    <button type="submit">Generar acrónimo</button>
</form>
<?php if ($error) resultado(e($error), true); if ($res !== null) resultado('<strong>Acrónimo:</strong> '.e($res)); ?>
<p class="hint">Ejemplo: Thank George It's Friday! → TGIF.</p>
<?php pie(); ?>