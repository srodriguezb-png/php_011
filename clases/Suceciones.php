<?php
class Sucesiones
{
    public function fibonacci(int $cantidad): array
    {
        if ($cantidad < 1 || $cantidad > 1000) {
            throw new InvalidArgumentException('La cantidad debe estar entre 1 y 1000.');
        }
        $serie = [];
        $a = 0; $b = 1;
        for ($i = 0; $i < $cantidad; $i++) {
            $serie[] = $a;
            [$a, $b] = [$b, $a + $b];
        }
        return $serie;
    }

    public function factorial(int $n): array
    {
        if ($n < 0 || $n > 170) {
            throw new InvalidArgumentException('El factorial debe estar entre 0 y 170.');
        }
        $pasos = [];
        $resultado = 1;
        for ($i = 1; $i <= $n; $i++) {
            $resultado *= $i;
            $pasos[] = $i;
        }
        return ['pasos' => $pasos, 'resultado' => $resultado];
    }
}