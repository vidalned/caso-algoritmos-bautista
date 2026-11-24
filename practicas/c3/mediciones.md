Mediciones búsqueda lineal

Qué mido

| | Detalle |
|---|---|
| Algoritmo | búsqueda lineal recorre la lista uno por uno hasta encontrar el valor o llegar al final |
| Código | busqueda_lineal.php |
| Qué busco | el -1 que no está en la lista |
| Caso | peor caso porque tiene que recorrer toda la lista para estar seguro de que no está |
| Costo esperado | O(n) |

Protocolo

| Paso | Qué hice |
|---|---|
| Calentar | 1 corrida sin medir para que PHP prepare todo antes de medir |
| Repetir | 5 corridas medidas con hrtime |
| Promediar | sumé los 5 tiempos y dividí entre 5 |

Resultados

| Elementos | Veces n | Promedio | x respecto a la fila anterior |
|---|---|---|---|
| 50000 | n | 0,3154 ms | — |
| 200000 | 4n | 1,2636 ms | x4,01 |
| 800000 | 16n | 5,4046 ms | x4,28 |

Lo que esperaba contra lo que medí

| Salto | Datos | Si es O(n) el tiempo debería subir | Subió |
|---|---|---|---|
| de n a 4n | x4 | x4 | x4,01 |
| de 4n a 16n | x4 | x4 | x4,28 |
| de n a 16n | x16 | x16 | x17,14 |

Conclusión

Cuando puse 4 veces más elementos el tiempo subió 4 veces y con 16 veces más subió unas 17 veces

O sea que el tiempo crece igual que la cantidad de datos y por eso es O(n)

El primer salto da x4,01 casi exacto y el segundo da x4,28 un poco más de lo esperado

Esa diferencia es ruido de la máquina y también puede ser que con 800000 elementos la lista ya no entra entera en la memoria rápida del procesador como vimos en la clase 8

Por eso se calienta se repite y se promedia y se mira la tendencia y no un número suelto