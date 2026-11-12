<?php
require_once __DIR__ . '/inicio.php';
require_once __DIR__ . '/../clases/Conjuntos.php';
encabezado('Operaciones con conjuntos', 'Ingresa enteros separados por comas o espacios. Los valores repetidos se eliminan.');
$res = null; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $parsear = function(string $texto): array {
            $partes = preg_split('/[\s,;]+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
            if (!$partes) throw new InvalidArgumentException('Ingresa al menos un entero en cada conjunto.');
            foreach ($partes as $p) if (!preg_match('/^-?\d+$/', $p)) throw new InvalidArgumentException('Los conjuntos solo aceptan números enteros.');
            return array_map('intval', $partes);
        };
        $a = $parsear($_POST['a'] ?? ''); $b = $parsear($_POST['b'] ?? '');
        $d = (new Conjuntos())->operar($a, $b);
        $fmt = fn($v) => '{ '.implode(', ', $v).' }';
        $res = '<ul><li>A = '.e($fmt($d['A'])).'</li><li>B = '.e($fmt($d['B'])).'</li><li>Unión A ∪ B = '.e($fmt($d['union'])).'</li><li>Intersección A ∩ B = '.e($fmt($d['interseccion'])).'</li><li>Diferencia A − B = '.e($fmt($d['AmenosB'])).'</li><li>Diferencia B − A = '.e($fmt($d['BmenosA'])).'</li></ul>';
    } catch (Throwable $ex) { $error = $ex->getMessage(); }
}
?>
<form method="post">
    <label for="a">Conjunto A</label>
    <input id="a" name="a" required value="<?= e($_POST['a'] ?? '1, 2, 3, 4') ?>" placeholder="1, 2, 3, 4">
    <label for="b">Conjunto B</label>
    <input id="b" name="b" required value="<?= e($_POST['b'] ?? '3, 4, 5, 6') ?>" placeholder="3, 4, 5, 6">
    <button type="submit">Calcular operaciones</button>
</form>
<?php if ($error) resultado(e($error), true); if ($res !== null) resultado($res); ?>
<?php pie(); ?>
