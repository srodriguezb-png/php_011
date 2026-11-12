<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
function e($valor): string {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
function encabezado(string $titulo, string $descripcion = ''): void {
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>'.e($titulo).'</title><link rel="stylesheet" href="../css/estilos.css"></head><body>';
    echo '<main class="container"><a class="breadcrumb" href="../index.php">← Volver al menú principal</a><section class="panel"><h1>'.e($titulo).'</h1>';
    if ($descripcion !== '') echo '<p class="hint">'.e($descripcion).'</p>';
}
function pie(): void { echo '</section></main></body></html>'; }
function resultado($contenido, bool $error = false): void {
    echo '<div class="result'.($error ? ' error' : '').'">'.$contenido.'</div>';
}

