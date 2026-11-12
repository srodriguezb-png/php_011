<?php
require_once __DIR__ . '/inicio.php';
require_once __DIR__ . '/../clases/ArbolBinario.php';
encabezado('Constructor de árbol binario', 'Introduce dos recorridos que contengan los mismos nodos únicos. Separa los nodos por comas, espacios o flechas.');
$res = null; $error = '';
function dibujarArbol(?array $nodo): string {
    if ($nodo === null) return '';
    $izq = dibujarArbol($nodo['izquierda']);
    $der = dibujarArbol($nodo['derecha']);
    if ($izq === '' && $der === '') return '<li><span class="node">'.e($nodo['valor']).'</span></li>';
    return '<li><span class="node">'.e($nodo['valor']).'</span><ul>'.($izq ?: '<li></li>').($der ?: '<li></li>').'</ul></li>';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $tipo1 = $_POST['tipo1'] ?? ''; $tipo2 = $_POST['tipo2'] ?? '';
        $arbol = (new ArbolBinario())->reconstruir($tipo1, $_POST['recorrido1'] ?? '', $tipo2, $_POST['recorrido2'] ?? '');
        $obj = new ArbolBinario(); $rec = $obj->recorridos($arbol);
        $res = '<strong>Árbol reconstruido</strong><div class="tree"><ul>'.dibujarArbol($arbol).'</ul></div>';
        foreach ($rec as $nombre => $valores) $res .= '<p><strong>'.e(ucfirst($nombre)).':</strong> '.e(implode(' → ', $valores)).'</p>';
    } catch (Throwable $ex) { $error = $ex->getMessage(); }
}
?>
<form method="post">
    <label for="tipo1">Primer recorrido</label>
    <select name="tipo1" id="tipo1">
        <?php foreach (['preorden'=>'Preorden','inorden'=>'Inorden','postorden'=>'Postorden'] as $v=>$t): ?>
            <option value="<?= e($v) ?>" <?= ($_POST['tipo1'] ?? 'preorden') === $v ? 'selected' : '' ?>><?= e($t) ?></option>
        <?php endforeach; ?>
    </select>
    <label for="recorrido1">Valores del primer recorrido</label>
    <input id="recorrido1" name="recorrido1" required value="<?= e($_POST['recorrido1'] ?? 'A, B, D, E, C') ?>">
    <label for="tipo2">Segundo recorrido</label>
    <select name="tipo2" id="tipo2">
        <?php foreach (['inorden'=>'Inorden','preorden'=>'Preorden','postorden'=>'Postorden'] as $v=>$t): ?>
            <option value="<?= e($v) ?>" <?= ($_POST['tipo2'] ?? 'inorden') === $v ? 'selected' : '' ?>><?= e($t) ?></option>
        <?php endforeach; ?>
    </select>
    <label for="recorrido2">Valores del segundo recorrido</label>
    <input id="recorrido2" name="recorrido2" required value="<?= e($_POST['recorrido2'] ?? 'D, B, E, A, C') ?>">
    <button type="submit">Construir árbol</button>
</form>
<?php if ($error) resultado(e($error), true); if ($res !== null) resultado($res); ?>
<p class="hint">Importante: preorden + inorden y postorden + inorden permiten reconstruir un árbol único con nodos distintos. Preorden + postorden por sí solos no siempre determinan un árbol único; en ese caso se asume un árbol binario lleno.</p>
<?php pie(); ?>