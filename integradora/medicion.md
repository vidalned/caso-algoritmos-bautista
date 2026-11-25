jose vidal bautista arquipa

Que mido

Comparo la solucion ingenua que prueba todos los subconjuntos y cuesta O(2^n · n) contra mi solucion con programacion dinamica que llena una tabla y cuesta O(n x capacidad)

En el codigo la ingenua es PlanificadorIngenuo y la mia es PlanificadorMejorado

El codigo esta en elecPaquetes.php y la carga es ejecutarCarga con n paquetes al azar con semilla fija y capacidad de un tercio del peso total

Protocolo

Primero hago 1 corrida de calentamiento sin medir

Despues hago 3 corridas medidas con hrtime y saco el promedio sumando las 3 y dividiendo entre 3

En cada tamaño compruebo que las dos den la misma ganancia

Uso 16 18 20 y 22 paquetes porque cada 2 paquetes mas la ingenua deberia tardar unas 4 veces mas

Resultados

| Paquetes | Capacidad | Ingenua | x | Dinamica | x | Celdas de la tabla | Ganancia | ¿Misma ganancia? |
|---|---|---|---|---|---|---|---|---|
| 16 | 179 kg | 31,2 ms | — | 0,070 ms | — | 2880 | 448 | si |
| 18 | 190 kg | 134,4 ms | x4,31 | 0,088 ms | x1,25 | 3438 | 624 | si |
| 20 | 253 kg | 598,4 ms | x4,45 | 0,121 ms | x1,37 | 5080 | 703 | si |
| 22 | 232 kg | 2697,7 ms | x4,51 | 0,130 ms | x1,08 | 5126 | 678 | si |

Las celdas de la tabla son n x (capacidad + 1)

Conclusion

La ingenua se comporta como O(2^n · n) porque cada 2 paquetes mas el tiempo sube cerca de x4 con x4,31 x4,45 y x4,51 y lo que pasa de 4 es el factor n de sumar los paquetes de cada subconjunto

La dinamica se comporta como O(n x capacidad) porque su tiempo sigue a las celdas de la tabla y no a 2^n

En el ultimo tamaño la capacidad bajo de 253 a 232 kg asi que las celdas casi no cambiaron de 5080 a 5126 y por eso la dinamica solo subio x1,08

Hay ruido en la dinamica porque mide decimas de milisegundo y los cocientes x1,25 y x1,37 no siguen exacto a las celdas

En los 4 tamaños las dos dan la misma ganancia y con 22 paquetes la ingenua tardo 2697,7 ms contra 0,130 ms de la dinamica unas 20000 veces mas rapida

Mi solucion a escala

Con 1000 paquetes y capacidad 10000 kg la tabla tiene 1000 x 10001 que son unos 10 millones de celdas

Mi solucion tardo 278,5 ms y la ganancia maxima fue 32970

La ingenua con 1000 paquetes tendria que probar 2^1000 subconjuntos y eso es imposible

¿Que pasa si la capacidad es 1000000000 kg?

Mi solucion cuesta O(n x capacidad) y depende del NUMERO de la capacidad no de cuantos paquetes hay

Con 10000 kg y 1000 paquetes son 10 millones de celdas y tardo 278,5 ms medido

Con 1000000000 kg y 1000 paquetes serian 1 billon de celdas o sea 10^12 que es unas 100000 veces mas y tardaria unas 7 horas si alcanzara la memoria esto es una proyeccion no medida

Pero no alcanza la memoria porque el arreglo mejor tendria 10^9 casillas y en PHP cada una ocupa varios bytes asi que serian decenas de GB

Ademas la fila de 0 y 1 de cada paquete tendria 10^9 caracteres y con 1000 paquetes serian 1000 GB

Por eso se dice que la dinamica de la mochila es pseudo polinomial es rapida solo cuando el numero de la capacidad es chico

La mochila es un problema NP dificil como el agente viajero de la clase 12 y no se conoce un algoritmo rapido para cualquier capacidad

Que haria en ese caso

Si los pesos se pueden redondear sin perder mucho dividiria los kg por una unidad mas grande por ejemplo trabajar en toneladas y la tabla se achica

Si las ganancias son numeros chicos haria la tabla por ganancia en vez de por kg

Si hay muy pocos paquetes por ejemplo menos de 25 usaria la fuerza bruta

Si solo necesito una respuesta rapida usaria el voraz por ganancia por kg como aproximacion sabiendo que puede no ser el optimo