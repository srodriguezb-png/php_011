<?php
class ArbolBinario
{
    private function separar(string $recorrido): array
    {
        $partes = preg_split('/[\s,;→]+/u', trim($recorrido), -1, PREG_SPLIT_NO_EMPTY);
        if (!$partes) {
            throw new InvalidArgumentException('Escribe los nodos separados por espacios, comas o flechas.');
        }
        if (count($partes) !== count(array_unique($partes))) {
            throw new InvalidArgumentException('Cada nodo debe ser único para poder reconstruir el árbol.');
        }
        return array_values($partes);
    }

    public function reconstruir(string $tipo1, string $texto1, string $tipo2, string $texto2): array
    {
        $tipo1 = strtolower($tipo1); $tipo2 = strtolower($tipo2);
        $permitidos = ['preorden', 'inorden', 'postorden'];
        if (!in_array($tipo1, $permitidos, true) || !in_array($tipo2, $permitidos, true) || $tipo1 === $tipo2) {
            throw new InvalidArgumentException('Selecciona dos recorridos diferentes.');
        }
        $r1 = $this->separar($texto1); $r2 = $this->separar($texto2);
        if (count($r1) !== count($r2) || count(array_diff($r1, $r2)) || count(array_diff($r2, $r1))) {
            throw new InvalidArgumentException('Los dos recorridos deben contener exactamente los mismos nodos, sin repetir.');
        }
        $rec = [$tipo1 => $r1, $tipo2 => $r2];
        if (isset($rec['preorden'], $rec['inorden'])) {
            $arbol = $this->desdePreIn($rec['preorden'], $rec['inorden']);
        } elseif (isset($rec['postorden'], $rec['inorden'])) {
            $arbol = $this->desdePostIn($rec['postorden'], $rec['inorden']);
        } else {
            $arbol = $this->desdePrePost($rec['preorden'], $rec['postorden']);
        }
        return $arbol;
    }

    private function desdePreIn(array $pre, array $in): ?array
    {
        if (!$pre) return null;
        $raiz = $pre[0];
        $pos = array_search($raiz, $in, true);
        if ($pos === false) throw new InvalidArgumentException('Recorridos incompatibles.');
        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);
        $izqPre = array_slice($pre, 1, count($izqIn));
        $derPre = array_slice($pre, 1 + count($izqIn));
        return ['valor'=>$raiz, 'izquierda'=>$this->desdePreIn($izqPre, $izqIn), 'derecha'=>$this->desdePreIn($derPre, $derIn)];
    }

    private function desdePostIn(array $post, array $in): ?array
    {
        if (!$post) return null;
        $raiz = $post[count($post)-1];
        $pos = array_search($raiz, $in, true);
        if ($pos === false) throw new InvalidArgumentException('Recorridos incompatibles.');
        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);
        $izqPost = array_slice($post, 0, count($izqIn));
        $derPost = array_slice($post, count($izqIn), count($derIn));
        return ['valor'=>$raiz, 'izquierda'=>$this->desdePostIn($izqPost, $izqIn), 'derecha'=>$this->desdePostIn($derPost, $derIn)];
    }

    private function desdePrePost(array $pre, array $post): ?array
    {
        if (!$pre) return null;
        $raiz = $pre[0];
        if (count($pre) === 1) return ['valor'=>$raiz, 'izquierda'=>null, 'derecha'=>null];
        // Preorden + postorden no siempre determina un árbol único. Se asume un árbol binario lleno.
        $siguiente = $pre[1];
        $pos = array_search($siguiente, $post, true);
        if ($pos === false || $pos >= count($post)-1) throw new InvalidArgumentException('Recorridos preorden/postorden incompatibles.');
        $tamIzq = $pos + 1;
        $izqPre = array_slice($pre, 1, $tamIzq);
        $derPre = array_slice($pre, 1 + $tamIzq);
        $izqPost = array_slice($post, 0, $tamIzq);
        $derPost = array_slice($post, $tamIzq, count($post) - $tamIzq - 1);
        if (count($izqPre) !== count($izqPost) || count($derPre) !== count($derPost)) {
            throw new InvalidArgumentException('No se pudo reconstruir el árbol con esos recorridos.');
        }
        return ['valor'=>$raiz, 'izquierda'=>$this->desdePrePost($izqPre, $izqPost), 'derecha'=>$this->desdePrePost($derPre, $derPost)];
    }

    public function recorridos(?array $nodo): array
    {
        if ($nodo === null) return ['preorden'=>[], 'inorden'=>[], 'postorden'=>[]];
        $i = $this->recorridos($nodo['izquierda']);
        $d = $this->recorridos($nodo['derecha']);
        return [
            'preorden'=>array_merge([$nodo['valor']], $i['preorden'], $d['preorden']),
            'inorden'=>array_merge($i['inorden'], [$nodo['valor']], $d['inorden']),
            'postorden'=>array_merge($i['postorden'], $d['postorden'], [$nodo['valor']])
        ];
    }
}