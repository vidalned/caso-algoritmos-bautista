/*jose vidal bautista aruquipa*/
<?php

function hayRepetidosPorPares($carnets) {
    $n = count($carnets);

    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ($carnets[$i] == $carnets[$j]) {
                return true;
            }}}
    return false;
    }
function hayRepetidosCurado($carnets) {
    $vistos = [];

    foreach ($carnets as $carnet) {
        if (isset($vistos[$carnet])) {
            return true;
        }

        $vistos[$carnet] = true;
    }
    return false;
}

function generarSinRepetidos($n) {
    $datos = range(0, $n - 1);
    shuffle($datos);

    return $datos;}

    function medir($n) {
    $datos = generarSinRepetidos($n);

    /*Calentamiento*/
    hayRepetidosPorPares($datos);
    hayRepetidosCurado($datos);

    $tiemposLentos = [];
    $tiemposCurados = [];

    /*Tres corridas medidas*/
    for ($i = 0; $i < 3; $i++) {

    $inicio = microtime(true);
    hayRepetidosPorPares($datos);
    $fin = microtime(true);

    $tiemposLentos[] = $fin - $inicio;

    $inicio = microtime(true);
    hayRepetidosCurado($datos);
    $fin = microtime(true);

    $tiemposCurados[] = $fin - $inicio;
    }

    $promedioLento = array_sum($tiemposLentos) / 3;
    $promedioCurado = array_sum($tiemposCurados) / 3;

    return [$promedioLento, $promedioCurado];
}

/*Cuatro tamaños que se duplican*/
$tamanos = [2000, 4000, 8000, 16000];

$anteriorLento = null;
$anteriorCurado = null;

echo "TAMAÑO | POR PARES (s) | CURADO (s) | VECES MAS LENTO | VECES MAS CURADO\n";

foreach ($tamanos as $n) {

    [$lento, $curado] = medir($n);

    $relacionLento = $anteriorLento !== null
        ? $lento / $anteriorLento : 0;

    $relacionCurado = $anteriorCurado !== null
        ? $curado / $anteriorCurado : 0;

    printf(
        "%d | %.6f | %.6f | %.2f | %.2f\n",
        $n,
        $lento,
        $curado,
        $relacionLento,
        $relacionCurado
    );

    $anteriorLento = $lento;
    $anteriorCurado = $curado;
}

?>
