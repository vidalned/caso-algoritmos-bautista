<?php
function busquedaLineal($lista, $buscado) {

    foreach ($lista as $elemento) {
        if ($elemento == $buscado) {
            return true;
        }
    }

    return false;
}
// Prueba inicial
$n = 50000;
$lista = range(0, $n - 1);
$buscado = -1;

// Calentamiento
busquedaLineal($lista, $buscado);

// Cinco corridas
$tiempos = [];

for ($i = 0; $i < 5; $i++) {

    $inicio = hrtime(true);

    busquedaLineal($lista, $buscado);

    $fin = hrtime(true);

    $tiempos[] = ($fin - $inicio) / 1000000;
}
// Promedio
$promedio = array_sum($tiempos) / count($tiempos);

echo "BUSQUEDA LINEAL - PHP\n";
echo "Elementos: $n\n";

foreach ($tiempos as $i => $tiempo) {
    printf("Corrida %d: %.4f ms\n", $i + 1, $tiempo);
}

printf("Promedio: %.4f ms\n", $promedio);

?>
