<?php
function unidades(): array
{
    $u = [];
    for ($i = 1; $i <= 4; $i++) $u[] = "L$i";                                   
    foreach ([2, 3] as $piso) foreach (["A", "B", "C", "D", "E"] as $l) $u[] = "Of $piso$l";   
    for ($piso = 4; $piso <= 12; $piso++) foreach (["A", "B", "C"] as $l) $u[] = "$piso$l";    
    for ($piso = 13; $piso <= 18; $piso++) foreach (["A", "B"] as $l) $u[] = "$piso$l";        
    return $u;                                                                     
}
function generarPagos(int $meses): array
{
    $pagos = [];
    $recibo = 1;
    foreach (range(0, $meses - 1) as $m) {
        $mes = sprintf("%04d-%02d", 2020 + intdiv($m, 12), $m % 12 + 1);
        foreach (unidades() as $unidad) {
            $pagos[] = ["unidad" => $unidad, "mes" => $mes, "monto" => 210, "recibo" => "R" . $recibo++];
        }
    }
    return $pagos;
}
function generarConsultas(array $pagos, int $cantidad): array
{
    mt_srand(11);
    $u = unidades();
    $c = [];
    for ($i = 0; $i < $cantidad; $i++) {
        if ($i % 5 === 4) {
            $c[] = [$u[mt_rand(0, 52)], "2099-01"];                               
        } else {
            $p = $pagos[mt_rand(0, count($pagos) - 1)];
            $c[] = [$p["unidad"], $p["mes"]];                                    
        }
    }
    return $c;
}

function pagoIngenuo(array $lista, string $unidad, string $mes): bool
{
    foreach ($lista as $p) {                                                      
        if ($p["unidad"] === $unidad && $p["mes"] === $mes) return true;
    }
    return false;
}

function construirTabla(array $lista): array
{
    $tabla = [];
    foreach ($lista as $p) $tabla[$p["unidad"] . "-" . $p["mes"]] = $p;        
    return $tabla;
}

function pagoHash(array $tabla, string $unidad, string $mes): bool
{
    return isset($tabla["$unidad-$mes"]);                                        
}
function medirMs(callable $f): float
{
    $f();
    $suma = 0;
    for ($c = 0; $c < 3; $c++) {
        $t = hrtime(true);
        $f();
        $suma += (hrtime(true) - $t) / 1e6;
    }
    return $suma / 3;
}


$pagos = generarPagos(24);
$tabla = construirTabla($pagos);
$prueba = generarConsultas($pagos, 1000);
$iguales = true;
foreach ($prueba as [$u, $m]) if (pagoIngenuo($pagos, $u, $m) !== pagoHash($tabla, $u, $m)) $iguales = false;
echo "Unidades: " . count(unidades()) . " · ¿Ingenua y hash dan la misma respuesta? " . ($iguales ? "sí" : "NO") . "\n\n";

$consultas = 5000;
echo "MEDICIÓN · $consultas consultas por tamaño (80% sí pagó, 20% no pagó)\n";
echo "Protocolo: 1 calentamiento + 3 corridas medidas + promedio\n";
printf("%6s %8s %14s %7s %14s %7s\n", "años", "pagos n", "ingenua ms", "x", "hash ms", "x");
$antI = $antH = 0;
foreach ([2, 4, 8, 16] as $anios) {
    $pagos = generarPagos($anios * 12);
    $tabla = construirTabla($pagos);                                         
    $c = generarConsultas($pagos, $consultas);

    $ti = medirMs(function () use ($pagos, $c) { foreach ($c as [$u, $m]) pagoIngenuo($pagos, $u, $m); });
    $th = medirMs(function () use ($tabla, $c) { foreach ($c as [$u, $m]) pagoHash($tabla, $u, $m); });

    printf("%6d %8d %11.1f ms %7s %11.3f ms %7s\n", $anios, count($pagos), $ti,
        $antI ? "x" . number_format($ti / $antI, 2) : "—", $th,
        $antH ? "x" . number_format($th / $antH, 2) : "—");
    $antI = $ti; $antH = $th;
}