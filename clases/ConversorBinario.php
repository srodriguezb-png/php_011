<?php
class Conversorbinario
{
    public function convertir(int $numero): string
    {
        if ($numero >= 0) {
            return decbin($numero);
        }
        // Para negativos se muestra el signo menos y el valor absoluto en binario.
        return '-' . decbin(abs($numero));
    }
}