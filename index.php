<?php
$aplicaciones = [
    ["acronimos", "Generador de acrónimos", "Convierte frases en sus iniciales."],
    ["sucesiones", "Fibonacci y factorial", "Calcula una sucesión o el factorial."],
    ["estadistica", "Estadística", "Calcula promedio, mediana y moda."],
    ["conjuntos", "Operaciones con conjuntos", "Unión, intersección y diferencias."],
    ["binario", "Conversor a binario", "Convierte enteros a base 2."],
    ["arbol", "Árbol binario", "Reconstruye un árbol desde recorridos."],
    ["calculadora", "Calculadora", "Operaciones básicas con historial."]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herramientas de programación</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header class="hero">
    <div class="container">
        <p class="eyebrow">PROYECTO ACADÉMICO · PHP Y POO</p>
        <h1>Herramientas de programación</h1>
        <p>Una colección de siete aplicaciones para practicar lógica, algoritmos y programación orientada a objetos.</p>
    </div>
</header>
<main class="container">
    <h2>Selecciona una aplicación</h2>
    <section class="cards">
        <?php foreach ($aplicaciones as $app): ?>
            <article class="card">
                <h3><?= htmlspecialchars($app[1], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?= htmlspecialchars($app[2], ENT_QUOTES, 'UTF-8') ?></p>
                <a class="button"
                    href="paginas/<?= htmlspecialchars($app[0], ENT_QUOTES, 'UTF-8') ?>.php">
                        Abrir aplicación
</a>
            </article>
        <?php endforeach; ?>
    </section>
</main>
<footer class="container footer">Proyecto académico · HTML, CSS, PHP y POO</footer>
</body>
</html>
