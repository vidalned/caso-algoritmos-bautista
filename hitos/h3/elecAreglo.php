<?php
function fuerzaBruta(array $costos, array $urgencias, int $fondo): int
{
    $n = count($costos);
    $mejor = 0;
    for ($mascara = 0; $mascara < (1 << $n); $mascara++) {
        $c = 0; $u = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($mascara & (1 << $i)) { $c += $costos[$i]; $u += $urgencias[$i]; }
        }
        if ($c <= $fondo && $u > $mejor) $mejor = $u;
    }
    return $mejor;
}

function voraz(array $costos, array $urgencias, int $fondo): array
{
    $orden = array_keys($costos);
    usort($orden, fn($a, $b) => $urgencias[$b] / $costos[$b] <=> $urgencias[$a] / $costos[$a]);
    $gastado = 0; $total = 0; $elegidos = [];
    foreach ($orden as $i) {
        if ($gastado + $costos[$i] <= $fondo) {
            $gastado += $costos[$i]; $total += $urgencias[$i]; $elegidos[] = $i;
        }
    }
    return [$total, $elegidos];
}

function dinamica(array $costos, array $urgencias, int $fondo, int $paso = 100): array
{
    $n = count($costos);
    $cap = intdiv($fondo, $paso);
    $w = array_map(fn($c) => intdiv($c, $paso), $costos);
    $t = array_fill(0, $n + 1, array_fill(0, $cap + 1, 0));
    for ($i = 1; $i <= $n; $i++) {
        for ($c = 0; $c <= $cap; $c++) {
            $t[$i][$c] = $t[$i - 1][$c];                                            // no hago el arreglo i
            if ($w[$i - 1] <= $c) {
                $con = $t[$i - 1][$c - $w[$i - 1]] + $urgencias[$i - 1];            // o lo hago
                if ($con > $t[$i][$c]) $t[$i][$c] = $con;
            }
        }
    }
    $elegidos = [];
    for ($i = $n, $c = $cap; $i > 0; $i--) {
        if ($t[$i][$c] !== $t[$i - 1][$c]) { $elegidos[] = $i - 1; $c -= $w[$i - 1]; }
    }
    return [$t[$n][$cap], array_reverse($elegidos)];
}

function medirMs(callable $f): float
{
    $f();
    $suma = 0;
    for ($k = 0; $k < 3; $k++) {
        $t = hrtime(true);
        $f();
        $suma += (hrtime(true) - $t) / 1e6;
    }
    return $suma / 3;
}

$nombres   = ["Ascensor", "Bomba de agua", "Cambio de cubierta del techo", "Portón eléctrico del garaje"];
$costos    = [7000, 4000, 21000, 3000];
$urgencias = [9, 8, 7, 3];
$fondo     = 10000;

echo "PARTE A · MI CASO: fondo de $fondo Bs\n";
foreach ($nombres as $i => $nom) {
    printf("  %-30s %6d Bs   urgencia %2d   urgencia por cada 1000 Bs %.2f\n", $nom, $costos[$i], $urgencias[$i], $urgencias[$i] / $costos[$i] * 1000);
}
[$uv, $ev] = voraz($costos, $urgencias, $fondo);
[$ud, $ed] = dinamica($costos, $urgencias, $fondo);
$ub = fuerzaBruta($costos, $urgencias, $fondo);
$suma = fn($idx) => array_sum(array_map(fn($i) => $costos[$i], $idx));
$lista = fn($idx) => implode(" + ", array_map(fn($i) => $nombres[$i], $idx));
echo "\n";
echo "  Voraz (urgencia por boliviano): " . $lista($ev) . " = urgencia $uv  (gasta " . $suma($ev) . " Bs)\n";
echo "  Dinámica (tabla):               " . $lista($ed) . " = urgencia $ud  (gasta " . $suma($ed) . " Bs)\n";
echo "  Fuerza bruta (los " . (1 << count($costos)) . " subconjuntos): urgencia $ub\n";
echo "  " . ($uv < $ud ? "El voraz se equivoca: $uv contra $ud" : "Aquí el voraz acierta") . "\n\n";


echo "PARTE B · MEDICIÓN: fuerza bruta (2^n) contra dinámica (n x fondo)\n";
echo "Protocolo: 1 calentamiento + 3 corridas medidas + promedio\n";
printf("%9s %10s %9s %10s %16s %7s %15s %7s\n", "arreglos", "fondo Bs", "óptimo", "¿iguales?", "fuerza bruta ms", "x", "dinámica ms", "x");
$antB = $antD = 0;
foreach ([14, 16, 18, 20] as $n) {
    mt_srand($n);
    $cs = []; $us = [];
    for ($i = 0; $i < $n; $i++) { $cs[] = mt_rand(10, 90) * 100; $us[] = mt_rand(1, 10); }
    $f = intdiv(array_sum($cs), 3 * 100) * 100;

    $rb = 0; $rd = 0;
    $tb = medirMs(function () use ($cs, $us, $f, &$rb) { $rb = fuerzaBruta($cs, $us, $f); });
    $td = medirMs(function () use ($cs, $us, $f, &$rd) { $rd = dinamica($cs, $us, $f)[0]; });

    printf("%9d %10d %9d %10s %13.1f ms %7s %12.3f ms %7s\n", $n, $f, $rd, $rb === $rd ? "sí" : "NO",
        $tb, $antB ? "x" . number_format($tb / $antB, 2) : "—",
        $td, $antD ? "x" . number_format($td / $antD, 2) : "—");
    $antB = $tb; $antD = $td;
}