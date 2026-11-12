<?php
class Estadistica
{
    public function calcular(array $numeros): array
    {
        if (count($numeros) === 0) {
            throw new InvalidArgumentException('Ingresa al menos un número.');
        }
        $numeros = array_map('floatval', $numeros);
        $cantidad = count($numeros);
        $promedio = array_sum($numeros) / $cantidad;

        $ordenados = $numeros;
        sort($ordenados, SORT_NUMERIC);
        $mitad = intdiv($cantidad, 2);
        $mediana = ($cantidad % 2 === 1)
            ? $ordenados[$mitad]
            : ($ordenados[$mitad - 1] + $ordenados[$mitad]) / 2;

        $frecuencias = [];
        foreach ($numeros as $numero) {
            $clave = (string)$numero;
            $frecuencias[$clave] = ($frecuencias[$clave] ?? 0) + 1;
        }
        $maxFrecuencia = max($frecuencias);
        $moda = [];
        if ($maxFrecuencia > 1) {
            foreach ($frecuencias as $valor => $frecuencia) {
                if ($frecuencia === $maxFrecuencia) {
                    $moda[] = (float)$valor;
                }
            }
        }

        return [
            'promedio' => $promedio,
            'mediana' => $mediana,
            'moda' => $moda,
            'frecuenciaModa' => $maxFrecuencia,
            'cantidad' => $cantidad
        ];
    }
}