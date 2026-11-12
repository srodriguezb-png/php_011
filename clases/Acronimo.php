<?php
class Acronimo
{
    public function generar(string $frase): string
    {
        $frase = str_replace('-', ' ', $frase);
        $frase = preg_replace('/[^\p{L}\p{N}\s]/u', '', $frase) ?? '';
        $palabras = preg_split('/\s+/u', trim($frase), -1, PREG_SPLIT_NO_EMPTY);
        $resultado = '';

        foreach ($palabras as $palabra) {
            $resultado .= mb_substr($palabra, 0, 1, 'UTF-8');
        }
        return mb_strtoupper($resultado, 'UTF-8');
    }
}