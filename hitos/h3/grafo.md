Mi caso como grafo
Torre Ventura

¿Mi caso se puede modelar como un grafo?

| Parte de mi caso | ¿Es un grafo? | Por qué |
|---|---|---|
| Pagos de expensas | No | cada pago es un registro suelto que no se une con otros y lo que hago es buscar por la clave unidad-mes y eso ya lo resuelve la tabla hash del H2 en O(1) |
| Red de agua del edificio | Sí | la bomba el tanque los pisos y las unidades están unidos por cañerías y hay caminos que recorrer |

En los pagos no hay caminos ni conexiones que recorrer así que un grafo no aporta nada ahí

Pero en la red de agua sí porque son cosas unidas entre sí

El modelo

| Parte del grafo | En la red de agua | Cantidad |
|---|---|---|
| Nodos | la bomba el tanque elevado los pisos y las unidades | 1 + 1 + 18 + 53 = 73 |
| Aristas | las cañerías | 72 |
| Cómo se conecta | la bomba sube el agua al tanque el tanque baja por la montante piso por piso y cada piso reparte a sus unidades | |

Como tiene 73 nodos y 72 aristas y está todo conectado no tiene ciclos así que es un árbol que es un grafo sin ciclos

Ejemplo de la lista de adyacencia

| Nodo | Vecinos |
|---|---|
| Bomba | Tanque |
| Tanque | Bomba y Piso 18 |
| Piso 12 | Piso 13 Piso 11 12A 12B y 12C |
| 12A | Piso 12 |

Cómo lo guardo

| Representación | Memoria | ¿La uso? |
|---|---|---|
| Lista de adyacencia | V + E = 145 | sí porque guarda solo las cañerías que existen |
| Matriz de adyacencia | V x V = 5329 | no porque casi todas las celdas serían no hay cañería |

Qué algoritmo uso para cada pregunta

| Pregunta del administrador | Algoritmo | Estructura | Costo |
|---|---|---|---|
| ¿A qué unidades llega el agua y a cuántos tramos? | BFS desde la bomba | cola (SplQueue) | O(V + E) |
| Si se rompe una cañería ¿quiénes se quedan sin agua? | componentes con un BFS por zona | cola | O(V + E) |

No uso DFS porque no necesito ciclos ni dependencias y BFS además me da la distancia en tramos

El código está en grafo.php

Resultado del BFS desde la bomba

| Unidad | Tramos desde la bomba |
|---|---|
| 18A | 3 |
| 12A | 9 |
| Of 2A | 19 |
| L1 | 20 que es la más lejana |

El agua llega a las 53 unidades

Si se rompe la cañería entre el piso 12 y el piso 11

| | Antes del corte | Después del corte |
|---|---|---|
| Zonas | 1 | 2 |
| Unidades con agua | 53 | 15 del piso 12 al 18 |
| Unidades sin agua | 0 | 38 del piso 11 para abajo |

Medición lista contra matriz

Para ver la diferencia simulo redes más grandes como un condominio con varias torres

Uso 500 1000 2000 y 4000 nodos y en cada tamaño corro el mismo BFS con lista y con matriz

Protocolo 1 corrida de calentamiento 3 corridas medidas y el promedio y el programa comprueba que las dos visitan los mismos nodos

| Nodos | Lista | x | Matriz | x | ¿Mismo resultado? |
|---|---|---|---|---|---|
| 500 | 0,06 ms | — | 5,3 ms | — | sí (500) |
| 1000 | 0,12 ms | x2,01 | 21,2 ms | x3,98 | sí (1000) |
| 2000 | 0,25 ms | x1,99 | 83,3 ms | x3,93 | sí (2000) |
| 4000 | 0,60 ms | x2,44 | 330,8 ms | x3,97 | sí (4000) |

Conclusión

La lista se comporta como O(V + E) porque al duplicar los nodos el tiempo sube cerca de x2 con x2,01 y x1,99

La matriz se comporta como O(V²) porque al duplicar los nodos el tiempo sube x4 con x3,98 x3,93 y x3,97 ya que para cada nodo revisa toda su fila

Hay ruido en la lista porque mide menos de un milisegundo y por eso el último salto da x2,44 en vez de x2

El peor tiempo fue 330,8 ms de la matriz con 4000 nodos contra 0,60 ms de la lista unas 550 veces más rápida y las dos visitan los mismos nodos

Por eso elijo la lista de adyacencia porque en una red de cañerías cada nodo tiene pocos vecinos

Para qué me serviría como administrador

Cuando hay un corte de agua saber de inmediato qué unidades avisar en vez de revisar piso por piso

Supuse que el agua baja por una sola montante desde el tanque si hubiera dos montantes habría más aristas y podría haber ciclos