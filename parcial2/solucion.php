/*jose vidal bautista aruquipa*/
<?php
class ReceptorIngenuo
{
    private array $lista = []; 
    private int $llegadas = 0;

    public function registrar(string $pedido, int $plazo): void
    {
        $this->lista[] = [$pedido, $plazo, $this->llegadas++];              
    }

    public function prepararSiguiente(): ?string
    {
        if (count($this->lista) === 0) return null;
        $mejor = 0;
        for ($i = 1; $i < count($this->lista); $i++) {                      
            $p = $this->lista[$i]; $m = $this->lista[$mejor];
            if ($p[1] < $m[1] || ($p[1] === $m[1] && $p[2] < $m[2])) $mejor = $i;
        }
        $nombre = $this->lista[$mejor][0];
        array_splice($this->lista, $mejor, 1);                              
        return $nombre;
    }

    public function estaPendiente(string $pedido): bool
    {
        foreach ($this->lista as $p) if ($p[0] === $pedido) return true;   
        return false;   
    }

    public function pendientes(): int
    {
        return count($this->lista);
    }
}

class ReceptorMejorado
{
    private SplPriorityQueue $heap;
    private array $pendientes = [];
    private int $llegadas = 0;

    public function __construct()
    {
        $this->heap = new SplPriorityQueue();
    }

    public function registrar(string $pedido, int $plazo): void
    {
        $this->heap->insert($pedido, [-$plazo, -$this->llegadas]);        
        $this->llegadas++;
        $this->pendientes[$pedido] = true;                                  
    }

    public function prepararSiguiente(): ?string
    {
        if ($this->heap->isEmpty()) return null;
        $nombre = $this->heap->extract();                                
        unset($this->pendientes[$nombre]);                                  
        return $nombre;
    }

    public function estaPendiente(string $pedido): bool
    {
        return isset($this->pendientes[$pedido]);                        
    }

    public function pendientes(): int
    {
        return count($this->pendientes);                                    
    }
}

$guion = [
    ["registrar", "Torta", 120, ""], ["registrar", "Galletas", 30, ""], ["registrar", "Pan", 120, ""], ["registrar", "Brazo", 60, ""],
    ["pendientes", "", 0, "4"],
    ["esta", "Galletas", 0, "True"], ["esta", "Flan", 0, "False"],
    ["preparar", "", 0, "Galletas"], ["esta", "Galletas", 0, "False"],
    ["preparar", "", 0, "Brazo"],
    ["registrar", "Alfajor", 30, ""],
    ["preparar", "", 0, "Alfajor"], ["preparar", "", 0, "Torta"], ["preparar", "", 0, "Pan"],
    ["preparar", "", 0, "(ninguno)"], ["pendientes", "", 0, "0"],
];

function ejecutar($g, string $op, string $arg, int $plazo): string
{
    switch ($op) {
        case "registrar": $g->registrar($arg, $plazo); return "";
        case "preparar": return $g->prepararSiguiente() ?? "(ninguno)";
        case "esta": return $g->estaPendiente($arg) ? "True" : "False";
        default: return (string)$g->pendientes();
    }
}

function probar(string $titulo, $g, array $guion): void
{   
    $bien = 0; $total = 0;
    foreach ($guion as [$op, $arg, $plazo, $esperado]) {
        $obtenido = ejecutar($g, $op, $arg, $plazo);
        if ($op === "registrar") continue;
        $total++;
        if ($obtenido === $esperado) $bien++;
        else echo "   MAL en " . $op . " " . $arg . ": esperado " . $esperado . ", obtuvo " . $obtenido . "\n";
    }
    echo "$titulo: $bien de $total pasos correctos\n";
}

function ejecutarCarga($g, int $n): int
{
    for ($i = 0; $i < $n; $i++) $g->registrar("Q" . $i, ((($i * 6007) % 6) + 1) * 15);
    $control = 0;
    for ($i = 0; $i < $n; $i++) $control += strlen($g->prepararSiguiente());
    return $control;
}

function medirMs(string $clase, int $n): float
{
    ejecutarCarga(new $clase(), $n);                                       
    $suma = 0;
    for ($c = 0; $c < 3; $c++) {
        $g = new $clase();
        $t = hrtime(true);
        ejecutarCarga($g, $n);
        $suma += (hrtime(true) - $t) / 1e6;
    }
    return $suma / 3;
}

probar("ReceptorIngenuo ", new ReceptorIngenuo(), $guion);
probar("ReceptorMejorado", new ReceptorMejorado(), $guion);
echo "\n";

$n = 4000;
echo "MEDICIÓN · protocolo: 1 calentamiento + 3 corridas + promedio\n";
printf("%8s %14s %7s %14s %7s\n", "n", "ingenuo ms", "x", "mejorado ms", "x");
$antI = $antM = 0;
foreach ([$n, 2 * $n, 4 * $n] as $tam) {
    $ti = medirMs("ReceptorIngenuo", $tam);
    $tm = medirMs("ReceptorMejorado", $tam);
    printf("%8d %11.1f ms %7s %11.2f ms %7s\n", $tam, $ti,
        $antI ? "x" . number_format($ti / $antI, 2) : "—", $tm,
        $antM ? "x" . number_format($tm / $antM, 2) : "—");
    $antI = $ti; $antM = $tm;
}