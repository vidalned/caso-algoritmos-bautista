jose vidal bautista aruquips

Cura 
anota cada carnet en un conjunto (arreglo asociativo) y devuelve true si ya estaba. Costo O(n).

Protocolo
1 corrida de calentamiento + 3 corridas medidas + promedio, en PHP.

| n | por pares (s) | x | curado (s) | x |
|---|---|---|---|---|
| 2000 | 0,026179 | — | 0,000039 | — |
| 4000 | 0,105091 | 4,01 | 0,000076 | 1,94 |
| 8000 | 0,418704 | 3,98 | 0,000159 | 2,08 |
| 16000 | 1,688893 | 4,03 | 0,000320 | 2,01 |

conclucion
al realizar las mediciones pude observar que el algoritmo por pares tarda más tiempo a medida que aumenta la cantidad de datos

En cambio el algoritmo curado tarda menos porque utiliza una estructura para comprobar si un carnet ya fue registrado

al duplicar los datos, el algoritmo por pares aumenta aproximadamente cuatro veces su tiempo (4,01, 3,98 y 4,03), mientras que el curado aumenta aproximadamente dos veces (1,94, 2,08 y 2,01). Esto coincide con O(n²) para el algoritmo por pares y con O(n) para el curado

al peor tiempo medido fue 1,69 segundos, del algoritmo por pares con n = 16.000

hubo poco ruido los cocientes del curado variaron entre 1,94 y 2,08 porque sus tiempos son muy pequeños.