Jose Vidal Bautista Aruquipa

Expediente · Análisis de Algoritmos

Mi caso: control de pagos de expensas de la Torre Ventura

Cuando trabajaba como administrador del edificio tenía que revisar quién pagó cuánto y qué unidades debían

El edificio tiene 53 unidades y guardaba 2 años de pagos que son 1272 registros

Revisar y ordenar todo a mano me tomaba entre 1 y 2 horas

Índice

| Hito | Qué contiene | Carpeta |
|---|---|---|
| H1 | El proceso lento que elegí y por qué quiero optimizarlo (proceso.md) con una muestra de los pagos (datos_muestra.csv) | [h1](h1/) |
| H2 | Inventario de operaciones estructura elegida (tabla hash con clave unidad-mes) y medición lista contra hash | [hitos/h2](hitos/h2/) |
| H3 | Estrategia voraz o dinámica y comparación fuerza bruta contra dinámica con el fondo de mantenimiento | [hitos/h3](hitos/h3/) |
| Grafo | Mi caso como grafo con la red de agua del edificio BFS componentes y medición lista contra matriz | [hitos/h3/grafo.md](hitos/h3/grafo.md) |

Prácticas y parciales

| Entrega | Qué contiene | Carpeta |
|---|---|---|
| Práctica c3 | Medición de la búsqueda lineal con el protocolo calentar repetir y promediar | [practicas/c3](practicas/c3/) |
| Práctica c4 | Comparación medida de búsqueda lineal contra búsqueda binaria | [practicas/c4](practicas/c4/) |
| Práctica c5 | Torneo de ordenamientos un cuadrático contra un n log n con tabla de resultados | [practicas/c5](practicas/c5/) |
| Práctica c6 | Elección argumentada del algoritmo para mi caso con búsqueda binaria | [practicas/c6](practicas/c6/) |
| Parcial 1 | Análisis de fragmentos y recurrencias cura de repetidos con conjunto y elección del hospital | [practicas/parcial1](practicas/parcial1/) |
| Parcial 2 | Pedidos de una pastelería con cola de prioridad y tabla hash | [parcial2](parcial2/) |

Resumen de mis decisiones

Buscar si una unidad pagó un mes es un problema de búsqueda y lo resuelvo con una tabla hash en O(1)

Elegir qué arreglos hacer con el fondo es un problema de optimización tipo mochila y lo resuelvo con programación dinámica porque el voraz se equivoca

¿Mi caso se puede modelar como un grafo?

Los pagos no porque cada pago es un registro suelto y lo que hago es buscar por clave

Pero la red de agua del edificio sí es un grafo de 73 nodos y 72 cañerías y lo demuestro con BFS y componentes en [hitos/h3/grafo.md](hitos/h3/grafo.md)

Todo el código está en PHP
