<?php
function armarRed(): array
{
    $nodos = ["Bomba", "Tanque"];
    $aristas = [["Bomba", "Tanque"]];
    for ($p = 18; $p >= 1; $p--) {
        $nodos[] = "Piso $p";
        $aristas[] = [$p === 18 ? "Tanque" : "Piso " . ($p + 1), "Piso $p"];   // la montante baja piso por piso
    }
    $unidadesPorPiso = [];
    for ($i = 1; $i <= 4; $i++) $unidadesPorPiso[1][] = "L$i";
    foreach ([2, 3] as $p) foreach (["A", "B", "C", "D", "E"] as $l) $unidadesPorPiso[$p][] = "Of $p$l";
    for ($p = 4; $p <= 12; $p++) foreach (["A", "B", "C"] as $l) $unidadesPorPiso[$p][] = "$p$l";
    for ($p = 13; $p <= 18; $p++) foreach (["A", "B"] as $l) $unidadesPorPiso[$p][] = "$p$l";
    foreach ($unidadesPorPiso as $p => $us) {
        foreach ($us as $u) { $nodos[] = $u; $aristas[] = ["Piso $p", $u]; }
    }
    return [$nodos, $aristas];
}

function listaAdyacencia(array $nodos, array $aristas): array
{
    $g = [];
    foreach ($nodos as $n) $g[$n] = [];
    foreach ($aristas as [$a, $b]) { $g[$a][] = $b; $g[$b][] = $a; }
    return $g;
}

function bfs(array $g, string $origen): array
{
    $distancia = [$origen => 0];
    $cola = new SplQueue();
    $cola->enqueue($origen);
    while (!$cola->isEmpty()) {
        $u = $cola->dequeue();
        foreach ($g[$u] as $v) {
            if (!isset($distancia[$v])) {                
                $distancia[$v] = $distancia[$u] + 1;
                $cola->enqueue($v);
            }
        }
    }
    return $distancia;                                   
}

function componentes(array $g): array
{
    $visto = [];
    $zonas = [];
    foreach (array_keys($g) as $n) {
        if (isset($visto[$n])) continue;
        $zona = array_keys(bfs($g, $n));
        foreach ($zona as $v) $visto[$v] = true;
        $zonas[] = $zona;
    }
    return $zonas;
}

function esUnidad(string $n): bool
{
    return $n !== "Bomba" && $n !== "Tanque" && strpos($n, "Piso") !== 0;
}

[$nodos, $aristas] = armarRed();
$g = listaAdyacencia($nodos, $aristas);
$V = count($nodos);
$E = count($aristas);
$unidades = array_values(array_filter($nodos, 'esUnidad'));
echo "PARTE A · LA RED DE AGUA COMO GRAFO\n";
echo "  Nodos: $V (bomba + tanque + 18 pisos + " . count($unidades) . " unidades)\n";
echo "  Aristas (cañerías): $E\n";
echo "  Como E = V - 1 y está todo conectado, no tiene ciclos: es un ÁRBOL\n";
echo "  Lista de adyacencia: V + E = " . ($V + $E) . "   ·   Matriz: V x V = " . ($V * $V) . " celdas, casi todas «no hay cañería»\n";
echo "  Ejemplos de la lista:\n";
foreach (["Bomba", "Tanque", "Piso 12", "12A"] as $n) echo "    " . str_pad($n, 8) . " -> " . implode(", ", $g[$n]) . "\n";
echo "\n";

$d = bfs($g, "Bomba");
$llegan = array_filter($unidades, fn($u) => isset($d[$u]));
echo "PARTE B · BFS DESDE LA BOMBA: ¿a qué unidades llega el agua?\n";
echo "  Llega a " . count($llegan) . " de " . count($unidades) . " unidades\n";
foreach (["18A", "12A", "Of 2A", "L1"] as $u) echo "  " . str_pad($u, 6) . " está a {$d[$u]} tramos de la bomba\n";
echo "  La unidad más lejana está a " . max(array_map(fn($u) => $d[$u], $unidades)) . " tramos (los locales del piso 1)\n\n";

echo "PARTE C · SE ROMPE LA CAÑERÍA ENTRE EL PISO 12 Y EL PISO 11\n";
$sinTramo = array_values(array_filter($aristas, fn($a) => !($a[0] === "Piso 12" && $a[1] === "Piso 11")));
$g2 = listaAdyacencia($nodos, $sinTramo);
$zonas = componentes($g2);
echo "  Ahora hay " . count($zonas) . " zonas\n";
$d2 = bfs($g2, "Bomba");
$sinAgua = array_values(array_filter($unidades, fn($u) => !isset($d2[$u])));
echo "  Se quedan sin agua " . count($sinAgua) . " unidades: " . implode(", ", array_slice($sinAgua, 0, 6)) . " ... " . end($sinAgua) . "\n";
echo "  Siguen con agua " . (count($unidades) - count($sinAgua)) . " unidades (pisos 12 al 18)\n";
echo "  Cada BFS cuesta O(V + E): con 73 nodos y 72 cañerías es inmediato\n\n";


function arbolAzar(int $V): array
{
    mt_srand($V);
    $aristas = [];
    for ($i = 1; $i < $V; $i++) $aristas[] = [mt_rand(0, $i - 1), $i];   // cada nodo nuevo cuelga de uno anterior
    return $aristas;
}

function bfsLista(array $g, int $origen): int
{
    $visto = [$origen => true]; $cola = new SplQueue(); $cola->enqueue($origen); $cuenta = 0;
    while (!$cola->isEmpty()) {
        $u = $cola->dequeue(); $cuenta++;
        foreach ($g[$u] as $v) if (!isset($visto[$v])) { $visto[$v] = true; $cola->enqueue($v); }
    }
    return $cuenta;
}

function bfsMatriz(array $m, int $V, int $origen): int
{
    $visto = [$origen => true]; $cola = new SplQueue(); $cola->enqueue($origen); $cuenta = 0;
    while (!$cola->isEmpty()) {
        $u = $cola->dequeue(); $cuenta++;
        $fila = $m[$u];
        for ($v = 0; $v < $V; $v++) if ($fila[$v] === "1" && !isset($visto[$v])) { $visto[$v] = true; $cola->enqueue($v); }
    }
    return $cuenta;
}

function medirMs(callable $f): float
{
    $f();
    $suma = 0;
    for ($k = 0; $k < 3; $k++) { $t = hrtime(true); $f(); $suma += (hrtime(true) - $t) / 1e6; }
    return $suma / 3;
}

echo "PARTE D · MEDICIÓN: el mismo BFS con lista de adyacencia y con matriz\n";
echo "Protocolo: 1 calentamiento + 3 corridas medidas + promedio\n";
printf("%7s %12s %7s %12s %7s %11s\n", "nodos", "lista ms", "x", "matriz ms", "x", "¿iguales?");
$antL = $antM = 0;
foreach ([500, 1000, 2000, 4000] as $V) {
    $ar = arbolAzar($V);
    $g = array_fill(0, $V, []);
    $m = array_fill(0, $V, str_repeat("0", $V));
    foreach ($ar as [$a, $b]) { $g[$a][] = $b; $g[$b][] = $a; $m[$a][$b] = "1"; $m[$b][$a] = "1"; }
    $rl = 0; $rm = 0;
    $tl = medirMs(function () use ($g, &$rl) { $rl = bfsLista($g, 0); });
    $tm = medirMs(function () use ($m, $V, &$rm) { $rm = bfsMatriz($m, $V, 0); });
    printf("%7d %9.2f ms %7s %9.1f ms %7s %11s\n", $V, $tl, $antL ? "x" . number_format($tl / $antL, 2) : "—",
        $tm, $antM ? "x" . number_format($tm / $antM, 2) : "—", $rl === $rm ? "sí ($rl)" : "NO");
    $antL = $tl; $antM = $tm;
}