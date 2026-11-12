<?php
class Conjuntos
{
    private function normalizar(array $valores): array
    {
        $limpios = array_map('intval', $valores);
        return array_values(array_unique($limpios));
    }

    public function operar(array $a, array $b): array
    {
        $a = $this->normalizar($a);
        $b = $this->normalizar($b);
        return [
            'A' => $a,
            'B' => $b,
            'union' => array_values(array_unique(array_merge($a, $b))),
            'interseccion' => array_values(array_intersect($a, $b)),
            'AmenosB' => array_values(array_diff($a, $b)),
            'BmenosA' => array_values(array_diff($b, $a))
        ];
    }
}