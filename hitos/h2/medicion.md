Pagos de expensas Torre Ventura

El problema que mido

Saber si una unidad pagó un mes por ejemplo si el 7B pagó marzo

Es la operación que más hago entre 15 y 20 veces al mes y revisar deudas la usa 53 veces cada vez

Algoritmo ingenuo y algoritmo adecuado

| | Ingenuo | Adecuado |
|---|---|---|
| Estructura | lista simple de pagos uno detrás de otro como en las planillas | tabla hash (arreglo asociativo de PHP) con clave unidad-mes |
| Cómo busca | recorre la lista desde el principio comparando unidad y mes hasta encontrarlo o llegar al final | pregunta isset($tabla["7B-2026-03"]) y va directo al casillero |
| Costo por consulta | O(n) | O(1) promedio |
| Función en el código | pagoIngenuo | pagoHash |

Antes de medir el código comprueba que las dos dan la misma respuesta

Tamaños que mido

Hoy tengo 53 unidades x 24 meses = 1272 pagos y con ese tamaño las dos tardan casi nada

Por eso simulo que el edificio guarda más años de historia con las mismas 53 unidades así cada tamaño es el doble del anterior

| Años guardados | Meses | Pagos n |
|---|---|---|
| 2 | 24 | 1272 |
| 4 | 48 | 2544 |
| 8 | 96 | 5088 |
| 16 | 192 | 10176 |

En cada tamaño hago 5000 consultas para que el cronómetro alcance a medir la versión con hash

Casos que cubro

| Caso | Qué representa en mi proceso | Ingenuo | Adecuado |
|---|---|---|---|
| La unidad sí pagó (la clave está) | la consulta normal de si pagó | recorre en promedio la mitad n/2 | O(1) |
| La unidad no pagó (la clave no está) | revisar deudas de una unidad que debe | recorre todo n y es su peor caso | O(1) |
| Mezcla 80 por ciento sí pagó y 20 por ciento no pagó | un mes real | entre n/2 y n | O(1) |

Las 5000 consultas de cada tamaño son la mezcla 4 de cada 5 son de unidades que sí pagaron y 1 de cada 5 de una unidad que no pagó

El caso no pagó es el peor de la ingenua porque tiene que mirar los n pagos para estar segura de que no está

Protocolo

1 corrida de calentamiento 3 corridas medidas y el promedio

La tabla hash se arma una vez antes de medir porque en mi proceso se arma al registrar los pagos y no en cada consulta

El código está en medicion_pagos.php

Resultados

| Años | Pagos n | Ingenuo (lista) | x | Adecuado (hash) | x |
|---|---|---|---|---|---|
| 2 | 1272 | 101,7 ms | — | 0,517 ms | — |
| 4 | 2544 | 203,6 ms | x2,00 | 0,565 ms | x1,09 |
| 8 | 5088 | 426,2 ms | x2,09 | 0,543 ms | x0,96 |
| 16 | 10176 | 852,1 ms | x2,00 | 0,617 ms | x1,14 |

Antes de medir el programa comprobó que la ingenua y el hash dan la misma respuesta en las 1000 consultas de prueba

-Conclusion

La ingenua se comporta como O(n) porque al duplicar los pagos el tiempo sube x2 en cada salto con x2,00 x2,09 y x2,00

El hash se comporta como O(1) porque al duplicar los pagos el tiempo casi no cambia y se queda cerca de medio milisegundo

Hay ruido en el hash porque mide muy poco tiempo y los cocientes saltan entre x0,96 y x1,14 sin seguir una tendencia y en la ingenua el x2,09 también es ruido alrededor de x2

El peor tiempo medido fue 852,1 ms de la ingenua con 16 años de historia y 10176 pagos y el hash hizo las mismas 5000 consultas en 0,617 ms unas 1380 veces más rápido

Fundamento del diseño

Mido la búsqueda por clave porque es la operación que más pesa en mi proceso

Uso tamaños de mi propio edificio 53 unidades por mes y solo cambio los años guardados así el experimento es mi caso y no datos inventados al azar

Incluyo el caso no pagó porque es el peor caso de la ingenua y es justo lo que pasa al revisar deudas

Espero que al duplicar n la ingenua tarde cerca del doble porque es O(n) y que el hash se quede casi igual porque es O(1)