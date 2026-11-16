<?php
function busquedaBinaria($lista, $buscado) {

    $izq = 0;
    $der = count($lista) - 1;
    $pasos = 0;

    while ($izq <= $der) {
        $pasos++;
        $medio = intdiv($izq + $der, 2);

        if ($lista[$medio] == $buscado) {
            return [true, $pasos];
        }

        if ($lista[$medio] < $buscado) {
            $izq = $medio + 1;
        } else {
            $der = $medio - 1;
        }
    }

    return [false, $pasos];
}

foreach ([50000, 200000, 800000] as $n) {

    // La lista ya esta ordenada
    $lista = range(0, $n - 1);
    $buscado = $n; // no esta, peor caso

    // Calentamiento
    busquedaBinaria($lista, $buscado);

    // Cinco corridas
    $tiempos = [];
    $pasos = 0;

    for ($i = 0; $i < 5; $i++) {
        $inicio = hrtime(true);
        $r = busquedaBinaria($lista, $buscado);
        $fin = hrtime(true);
        $tiempos[] = ($fin - $inicio) / 1000000;
        $pasos = $r[1];
    }

    $promedio = array_sum($tiempos) / count($tiempos);

    echo "BUSQUEDA BINARIA - PHP\n";
    echo "Elementos: $n\n";
    echo "Pasos: $pasos\n";
    printf("Promedio: %.4f ms\n\n", $promedio);
}
?>
