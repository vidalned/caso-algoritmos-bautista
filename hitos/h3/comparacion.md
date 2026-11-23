Fondo de mantenimiento Torre Ventura

-El problema de optimización

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

Tamaños que mido

Simulo más arreglos con costos entre 1000 y 9000 Bs y urgencias del 1 al 10

Uso 14 16 18 y 20 arreglos porque la fuerza bruta crece como 2^n y cada 2 arreglos más debería tardar unas 4 veces más

Protocolo 1 corrida de calentamiento 3 corridas medidas y el promedio

Resultados

Pendiente correr la medición en mi máquina