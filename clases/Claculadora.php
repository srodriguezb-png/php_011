<?php
class Calculadora
{
    public function calcular(float $a, float $b, string $operacion): array
    {
        switch ($operacion) {
            case 'suma': $resultado = $a + $b; $simbolo = '+'; break;
            case 'resta': $resultado = $a - $b; $simbolo = '−'; break;
            case 'multiplicacion': $resultado = $a * $b; $simbolo = '×'; break;
            case 'division':
                if ($b == 0.0) throw new InvalidArgumentException('No se puede dividir entre cero.');
                $resultado = $a / $b; $simbolo = '÷'; break;
            case 'porcentaje':
                // Interpreta el porcentaje como "¿cuánto es A % de B?"
                $resultado = ($a / 100) * $b; $simbolo = '% de'; break;
            default: throw new InvalidArgumentException('Selecciona una operación válida.');
        }
        return ['expresion' => "$a $simbolo $b", 'resultado' => $resultado];
    }
}