/*jose vidal bautista aruquipa*/
<?php
class PlanificadorIngenuo
{
    private array $elegidos = [];

    public function elegir(array $paquetes, int $capacidad): array
    {
        $n = count($paquetes); $mejor = 0; $mejorMascara = 0;
        for ($mascara = 0; $mascara < (1 << $n); $mascara++) {               
            $kg = 0; $ganancia = 0;
            for ($i = 0; $i < $n; $i++) {                                     
                if ($mascara & (1 << $i)) { $kg += $paquetes[$i][1]; $ganancia += $paquetes[$i][2]; }
            }
            if ($kg <= $capacidad && $ganancia > $mejor) { $mejor = $ganancia; $mejorMascara = $mascara; }
        }
        $this->elegidos = [];
        for ($i = 0; $i < $n; $i++) if ($mejorMascara & (1 << $i)) $this->elegidos[] = $paquetes[$i][0];
        return [$mejor, $this->elegidos];
    }

    public function estaEnElViaje(string $codigo): bool
    {
        return in_array($codigo, $this->elegidos, true);                     
    }
}

class PlanificadorMejorado
{
    private array $enViaje = [];

    public function elegir(array $paquetes, int $capacidad): array
    {
        $n = count($paquetes);
        $this->enViaje = [];
        if ($n === 0 || $capacidad <= 0) return [0, []];                       

        $mejor = array_fill(0, $capacidad + 1, 0);
        $lleva = [];
        for ($i = 0; $i < $n; $i++) {
            [, $kg, $g] = $paquetes[$i];
            $fila = str_repeat("0", $capacidad + 1);
            for ($c = $capacidad; $c >= $kg; $c--) {                         
                $con = $mejor[$c - $kg] + $g;                                   
                if ($con > $mejor[$c]) { $mejor[$c] = $con; $fila[$c] = "1"; }  
            }
            $lleva[$i] = $fila;
        }

        $codigos = [];
        for ($i = $n - 1, $c = $capacidad; $i >= 0; $i--) {
            if ($lleva[$i][$c] === "1") {
                $codigos[] = $paquetes[$i][0];
                $this->enViaje[$paquetes[$i][0]] = true;                      
                $c -= $paquetes[$i][1];
            }
        }
        return [$mejor[$capacidad], array_reverse($codigos)];
    }

    public function estaEnElViaje(string $codigo): bool
    {
        return isset($this->enViaje[$codigo]);                                 
    }
}

$casos = [
    ["el voraz se equivoca", [["P1", 10, 60], ["P2", 20, 100], ["P3", 30, 120]], 50, 220, ["P2", "P3"]],
    ["cuatro paquetes",      [["P1", 2, 3], ["P2", 3, 4], ["P3", 4, 5], ["P4", 5, 6]], 8, 10, ["P2", "P4"]],
    ["capacidad cero",       [["P1", 5, 10], ["P2", 7, 12]], 0, 0, []],
    ["sin paquetes",         [], 30, 0, []],
    ["nada cabe",            [["P1", 40, 90], ["P2", 50, 100]], 30, 0, []],
    ["entran todos",         [["P1", 5, 10], ["P2", 7, 12], ["P3", 3, 4]], 100, 26, ["P1", "P2", "P3"]],
];

function probar(string $titulo, string $clase, array $casos): void
{
    $bien = 0; $total = 0;
    foreach ($casos as [$que, $paquetes, $capacidad, $esperada, $codigos]) {
        $plan = new $clase();
        [$ganancia, $elegidos] = $plan->elegir($paquetes, $capacidad);
        $total++;
        sort($elegidos); sort($codigos);
        if ($ganancia === $esperada && $elegidos === $codigos) $bien++;
        else echo "   MAL en $que: esperado $esperada con [" . implode(",", $codigos) . "], obtuvo $ganancia con [" . implode(",", $elegidos) . "]\n";
    }
    $p = new $clase();
    $p->elegir($casos[0][1], $casos[0][2]);
    $total += 2;
    if ($p->estaEnElViaje("P2")) $bien++; else echo "   MAL en EstaEnElViaje(P2): esperado True\n";
    if (!$p->estaEnElViaje("P1")) $bien++; else echo "   MAL en EstaEnElViaje(P1): esperado False\n";
    echo "$titulo: $bien de $total pruebas correctas\n";
}

function generar(int $n): array
{
    mt_srand($n);
    $paquetes = [];
    for ($i = 0; $i < $n; $i++) $paquetes[] = ["C$i", mt_rand(5, 59), mt_rand(10, 99)];
    return $paquetes;
}

function ejecutarCarga($plan, int $n): int
{
    $paquetes = generar($n);
    $capacidad = intdiv(array_sum(array_column($paquetes, 1)), 3);
    return $plan->elegir($paquetes, $capacidad)[0];
}

function medirMs(callable $f): float
{
    $f();
    $suma = 0;
    for ($k = 0; $k < 3; $k++) { $t = hrtime(true); $f(); $suma += (hrtime(true) - $t) / 1e6; }
    return $suma / 3;
}

probar("PlanificadorIngenuo ", "PlanificadorIngenuo", $casos);
probar("PlanificadorMejorado", "PlanificadorMejorado", $casos);
echo "\n";

$n = 16;
echo "MEDICIÓN · ingenua (2^n) contra dinámica (n x capacidad) · protocolo: 1 calentamiento + 3 corridas + promedio\n";
printf("%9s %10s %16s %7s %14s %7s %10s %10s\n", "paquetes", "capacidad", "ingenua ms", "x", "dinámica ms", "x", "ganancia", "¿iguales?");
$antI = $antD = 0;
foreach ([$n, $n + 2, $n + 4, $n + 6] as $tam) {
    $cap = intdiv(array_sum(array_column(generar($tam), 1)), 3);
    $gi = 0; $gd = 0;
    $ti = medirMs(function () use ($tam, &$gi) { $gi = ejecutarCarga(new PlanificadorIngenuo(), $tam); });
    $td = medirMs(function () use ($tam, &$gd) { $gd = ejecutarCarga(new PlanificadorMejorado(), $tam); });
    printf("%9d %10d %13.1f ms %7s %11.3f ms %7s %10d %10s\n", $tam, $cap, $ti,
        $antI ? "x" . number_format($ti / $antI, 2) : "—", $td,
        $antD ? "x" . number_format($td / $antD, 2) : "—", $gd, $gi === $gd ? "sí" : "NO");
    $antI = $ti; $antD = $td;
}
echo "\n";
$grandes = generar(1000);
$gg = 0;
$tg = medirMs(function () use ($grandes, &$gg) { $gg = (new PlanificadorMejorado())->elegir($grandes, 10000)[0]; });
printf("ESCALA · dinámica con 1000 paquetes y capacidad 10000: %.1f ms (ganancia %d) · tabla de 1000 x 10001 = 10 millones de celdas\n", $tg, $gg);
echo "La ingenua tendría que probar 2^1000 subconjuntos: imposible\n";