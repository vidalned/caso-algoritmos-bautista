<?php
set_time_limit(0);               
ini_set('memory_limit', '512M');

const CORRIDAS_MEDIDAS = 3;

function insercion(array &$a): void
{
    $n = count($a);
    for ($i = 1; $i < $n; $i++) {
        $actual = $a[$i];
        $j = $i - 1;
        while ($j >= 0 && $a[$j] > $actual) {
            $a[$j + 1] = $a[$j];
            $j--;
        }
        $a[$j + 1] = $actual;
    }
}

function mergeSort(array &$a): void
{
    $aux = $a;
    mergeSortRec($a, $aux, 0, count($a) - 1);
}

function mergeSortRec(array &$a, array &$aux, int $izq, int $der): void
{
    if ($izq >= $der) return;
    $medio = intdiv($izq + $der, 2);
    mergeSortRec($a, $aux, $izq, $medio);
    mergeSortRec($a, $aux, $medio + 1, $der);
    mezclar($a, $aux, $izq, $medio, $der);
}

function mezclar(array &$a, array &$aux, int $izq, int $medio, int $der): void
{
    for ($x = $izq; $x <= $der; $x++) $aux[$x] = $a[$x];

    $i = $izq;
    $j = $medio + 1;
    $k = $izq;
    while ($i <= $medio && $j <= $der) {
        if ($aux[$i] <= $aux[$j]) {
            $a[$k++] = $aux[$i++];
        } else {
            $a[$k++] = $aux[$j++];
        }
    }
    while ($i <= $medio) $a[$k++] = $aux[$i++];
  
}

function quickSort(array &$a): void
{
    quickSortRec($a, 0, count($a) - 1);
}

function quickSortRec(array &$a, int $izq, int $der): void
{
    if ($izq >= $der) return;
    $pivote = $a[intdiv($izq + $der, 2)];
    $i = $izq;
    $j = $der;
    while ($i <= $j) {
        while ($a[$i] < $pivote) $i++;
        while ($a[$j] > $pivote) $j--;
        if ($i <= $j) {
            $tmp = $a[$i];
            $a[$i] = $a[$j];
            $a[$j] = $tmp;
            $i++;
            $j--;
        }
    }
    quickSortRec($a, $izq, $j);
    quickSortRec($a, $i, $der);
}

function sortDePhp(array &$a): void
{
    sort($a);
}

function estaOrdenado(array $a): bool
{
    $n = count($a);
    for ($i = 1; $i < $n; $i++) {
        if ($a[$i - 1] > $a[$i]) return false;
    }
    return true;
}
function medir(array $datos, callable $ordenar): float
{
    $prueba = $datos;            
    $ordenar($prueba);
    if (!estaOrdenado($prueba)) {
        throw new Exception("El algoritmo no ordeno bien los datos.");
    }

    $total = 0;
    for ($c = 0; $c < CORRIDAS_MEDIDAS; $c++) {
        $copia = $datos;
        $copia[0] = $copia[0];   
        $inicio = hrtime(true);
        $ordenar($copia);
        $total += (hrtime(true) - $inicio) / 1e6;   
    }
    return $total / CORRIDAS_MEDIDAS;
}

$tamanos = [10000, 20000, 40000, 80000];
mt_srand(42);   

echo "PROTOCOLO: 1 corrida de calentamiento + 3 corridas medidas + promedio.\n\n";
echo "| n | Insercion (ms) | MergeSort (ms) | QuickSort (ms) | sort() de PHP (ms) |\n";
echo "|---|----------------|----------------|----------------|--------------------|\n";

foreach ($tamanos as $n) {
    $datos = [];
    for ($i = 0; $i < $n; $i++) $datos[] = mt_rand(0, 999999);

    $tIns = medir($datos, 'insercion');
    $tMer = medir($datos, 'mergeSort');
    $tQui = medir($datos, 'quickSort');
    $tPhp = medir($datos, 'sortDePhp');

    printf("| %d | %.1f | %.1f | %.1f | %.1f |\n", $n, $tIns, $tMer, $tQui, $tPhp);
}