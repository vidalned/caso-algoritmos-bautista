Jose Vidal Bautista Aruquipa

Búsqueda binaria a mano

Datos ordenados

| Posición | 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 |
|---|---|---|---|---|---|---|---|---|
| Valor | 3 | 8 | 12 | 19 | 25 | 31 | 40 | 47 |

La búsqueda binaria solo sirve si los datos están ordenados y en cada paso mira el del medio y descarta la mitad

1 Buscar el 31

| Paso | Quedaban | Medio | Comparo | Decisión |
|---|---|---|---|---|
| 1 | 3 8 12 19 25 31 40 47 | 19 | 31 es mayor que 19 | me voy a la derecha |
| 2 | 25 31 40 47 | 31 | 31 es igual a 31 | lo encontré |

Miré 19 y 31 y fueron 2 pasos

2 Buscar el 5

| Paso | Quedaban | Medio | Comparo | Decisión |
|---|---|---|---|---|
| 1 | 3 8 12 19 25 31 40 47 | 19 | 5 es menor que 19 | me voy a la izquierda |
| 2 | 3 8 12 | 8 | 5 es menor que 8 | me voy a la izquierda |
| 3 | 3 | 3 | 5 es mayor que 3 | ya no quedan números |

Miré 19 8 y 3 y fueron 3 pasos y el 5 no está

Cuando el número no está es el peor caso porque hay que descartar hasta que no queda nada

3 Máximo de pasos

| Datos n | Potencia de 2 que lo alcanza | Máximo de pasos binaria | Pasos de la lineal en el peor caso |
|---|---|---|---|
| 8 | 2^3 = 8 | 4 | 8 |
| 1000 | 2^10 = 1024 | 10 | 1000 |
| 1000000 | 2^20 = 1048576 | 20 | 1000000 |

Es porque en cada paso se descarta la mitad así que el máximo de pasos crece como log2 n

En cambio la lineal en el peor caso mira todos los datos y crece como n

Con un millón de datos la lineal mira un millón y la binaria veinte
