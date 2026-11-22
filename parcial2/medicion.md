jose vidal bautista aruquipa

La carga es ejecutarCarga donde llegan n pedidos y después se preparan los n
Lo medí en PHP con el protocolo 1 corrida de calentamiento 3 corridas medidas y el promedio
En cada corrida uso un receptor nuevo

| n | Ingenuo (lista simple) | x | Mejorado (heap + hash) | x |
|---|---|---|---|---|
| 4000 | 577,4 ms | — | 2,23 ms | — |
| 8000 | 2375,2 ms | x4,11 | 4,97 ms | x2,23 |
| 16000 | 9359,3 ms | x3,94 | 11,17 ms | x2,25 |

-CONCLUCION
el ingenuo se comporta como O(n²)
Al duplicar n el tiempo sube cerca de x4 con x4,11 y x3,94
Es lo esperado porque cada una de las n preparaciones recorre toda la lista O(n) y en total son n x n

el mejorado se comporta como O(n log n)
Al duplicar n el tiempo sube un poco más del doble con x2,23 y x2,25
Cada una de las n operaciones cuesta O(log n) en el heap y ese log n hace que suba algo más que x2

hay ruido porque los cocientes no son exactamente 4 ni 2
el ingenuo pasó de x4,11 a x3,94 y el mejorado mide pocos milisegundos así que cualquier variación de la máquina pesa más
Por eso se promedian 3 corridas y se mira la tendencia y no un número suelto

el peor tiempo medido fue 9359,3 ms unos 9,4 segundos del ingenuo con n = 16000
el mejorado hizo lo mismo en 11,17 ms unas 840 veces más rápido