jose vidal bautista aruquipa

El problema es elegir que paquetes llevar para ganar lo maximo sin pasarse de la capacidad y cada paquete se lleva entero o no se lleva

Es la mochila 0/1 de la clase 12 la capacidad de la furgoneta es la capacidad el peso del paquete es el peso y la ganancia es el valor

-A Costo de la solucion ingenua

El primer for recorre la mascara de 0 a 2^n o sea prueba una vez cada subconjunto de paquetes y son 2^n subconjuntos

Dentro de ese for hay otro for que recorre los n paquetes para sumar los kg y la ganancia del subconjunto y eso cuesta n

Como un for esta dentro del otro se multiplican 2^n x n y el costo total es O(2^n · n)

Cada paquete puede ir o no ir por eso cada paquete mas duplica el trabajo y cada 2 paquetes mas lo multiplica por 4

EstaEnElViaje en la ingenua usa Contains sobre la lista de elegidos y la recorre entera asi que cuesta O(k) con k paquetes elegidos

-B La recurrencia T(n) = 2 T(n-1) + 1

El teorema maestro de bolsillo tiene la forma T(n) = a T(n/b) + n^d y solo sirve cuando cada paso DIVIDE el problema entre b

Mi recurrencia es T(n) = 2 T(n-1) + 1 y cada paso solo RESTA 1 porque quita un paquete asi que el tamaño no se divide y el teorema no aplica

Se resuelve con el arbol de recursion donde cada llamada abre 2 llamadas una para lo llevo y otra para no lo llevo

En el nivel 0 hay 1 llamada en el nivel 1 hay 2 en el nivel 2 hay 4 y en el nivel k hay 2^k hasta llegar al nivel n con 2^n llamadas

Sumando todos los niveles 1 + 2 + 4 + ... + 2^n = 2^(n+1) - 1 asi que cuesta O(2^n)

Es exponencial igual que Fibonacci sin memoria de la clase 6 y la clase 12

-C Sirve un voraz?

El voraz razonable es llevar primero el paquete con mas ganancia por kg

Uso el primer caso de las pruebas con capacidad 50 kg

P1 pesa 10 kg y gana 60 Bs o sea 6 Bs por kg

P2 pesa 20 kg y gana 100 Bs o sea 5 Bs por kg

P3 pesa 30 kg y gana 120 Bs o sea 4 Bs por kg

El voraz primero toma P1 porque tiene 6 por kg y lleva 10 kg y 60 Bs

Luego toma P2 porque tiene 5 por kg y lleva 30 kg y 160 Bs

Luego intenta P3 pero 30 + 30 = 60 kg y se pasa de 50 asi que no cabe y termina con 160 Bs

Pero lo mejor es llevar P2 + P3 que pesan justo 50 kg y ganan 220 Bs

El voraz se equivoca por 60 Bs y deja 20 kg vacios

No cumple la propiedad de eleccion voraz porque la solucion optima no lleva P1 que es lo primero que eligio el voraz

Mi estrategia programacion dinamica

Funciona porque cumple las dos señales de la clase 12

La primera es que los subproblemas se repiten la pregunta con los primeros i paquetes y c kg ¿cuanto gano como maximo? aparece muchas veces en la recursion con los mismos i y c

La segunda es que tiene subestructura optima si llevo el paquete i lo que queda es el mismo problema con los paquetes anteriores y c menos los kg del paquete i

Cada celda de la tabla decide entre no llevar el paquete o llevarlo mejor[c] = max(mejor[c] , mejor[c - kg] + ganancia) usando solo celdas ya calculadas

Su costo es O(n x capacidad) en vez de O(2^n · n)

Por ejemplo con 20 paquetes y 253 kg la fuerza bruta hace 2^20 x 20 unos 21 millones de pasos y la dinamica llena 20 x 254 unas 5080 celdas

Para saber que paquetes se eligieron guardo para cada paquete una fila de 0 y 1 que anota si mejoro la celda y recorro hacia atras desde la capacidad total

-D Estructura para EstaEnElViaje

La ingenua guarda los elegidos en una lista y para responder la recorre hasta encontrar el codigo eso cuesta O(k)

Yo uso una tabla hash con los codigos elegidos que en PHP es el arreglo asociativo y pregunto isset($enViaje["P2"]) que va directo al casillero en O(1) promedio

Como EstaEnElViaje se consulta miles de veces conviene la tabla hash

Se arma una sola vez al terminar Elegir y despues cada consulta cuesta O(1)