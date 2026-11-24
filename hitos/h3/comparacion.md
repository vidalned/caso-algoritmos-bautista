Fondo de mantenimiento Torre Ventura

El problema de optimización

Con un fondo limitado elegir qué arreglos hacer para atender la mayor urgencia sin pasarse

Es la mochila 0/1 cada arreglo se hace entero o no se hace

| | Fuerza bruta | Estrategia adecuada (dinámica) |
|---|---|---|
| Cómo resuelve | prueba todos los subconjuntos de arreglos y se queda con el de más urgencia que entra en el fondo | llena una tabla de arreglos x fondo donde cada celda decide entre hacer o no hacer el arreglo |
| Costo | O(2^n · n) | O(n x fondo) |
| Función en el código | fuerzaBruta | dinamica |

El código está en elecAreglo.php

Mi caso real

| Estrategia | Elige | Urgencia | Gasta |
|---|---|---|---|
| Voraz (urgencia por boliviano) | bomba + portón | 11 | 7000 Bs |
| Dinámica | ascensor + portón | 12 | 10000 Bs |
| Fuerza bruta (16 subconjuntos) | ascensor + portón | 12 | 10000 Bs |

La dinámica y la fuerza bruta dan el mismo resultado y el voraz se equivoca

Tamaños que mido

Con 4 arreglos todo tarda casi nada así que simulo más arreglos con costos entre 1000 y 9000 Bs y urgencias del 1 al 10

El fondo es un tercio de la suma de los costos para que siempre haya que elegir

Uso 14 16 18 y 20 arreglos como en la clase 12 porque la fuerza bruta crece como 2^n y cada 2 arreglos más debería tardar unas 4 veces más

Protocolo

1 corrida de calentamiento 3 corridas medidas y el promedio

En cada tamaño el programa comprueba que la fuerza bruta y la dinámica dan el mismo óptimo

Resultados

| Arreglos | Fondo | Óptimo | ¿Mismo resultado? | Fuerza bruta | x | Dinámica | x |
|---|---|---|---|---|---|---|---|
| 14 | 22300 Bs | 45 | sí | 6,1 ms | — | 0,217 ms | — |
| 16 | 26300 Bs | 42 | sí | 26,4 ms | x4,31 | 0,290 ms | x1,33 |
| 18 | 30200 Bs | 52 | sí | 118,1 ms | x4,47 | 0,371 ms | x1,28 |
| 20 | 37400 Bs | 53 | sí | 508,5 ms | x4,31 | 0,529 ms | x1,43 |

-Conclusion

La fuerza bruta se comporta como O(2^n) porque cada 2 arreglos más el tiempo sube cerca de x4 con x4,31 x4,47 y x4,31 y lo que pasa de 4 es el factor n de recorrer cada subconjunto

La dinámica se comporta como O(n x fondo) porque en cada tamaño crecen los arreglos y el fondo a la vez y las celdas de la tabla pasan de 3122 a 4208 a 5436 y a 7480 que es subir x1,35 x1,29 y x1,38 casi lo mismo que mis tiempos

Hay ruido en la dinámica porque mide menos de un milisegundo y por eso el último salto da x1,43 un poco más de lo que predicen las celdas

En los 4 tamaños las dos dan el mismo óptimo y con 20 arreglos la fuerza bruta tardó 508,5 ms contra 0,529 ms de la dinámica unas 960 veces más rápida

Con 30 arreglos la fuerza bruta probaría más de mil millones de subconjuntos y la dinámica seguiría en milisegundos