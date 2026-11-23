ESTSATEGIA DE MI CASO

¿Mi proceso principal admite un voraz o una dinámica?

Mi proceso principal es saber si una unidad pagó un mes y revisar deudas

Eso es un problema de búsqueda y no de optimización

No hay nada que maximizar ni minimizar solo hay que encontrar una clave unidad-mes y la respuesta es sí o no

Por eso no aplica ni el voraz ni la dinámica y lo resuelve la tabla hash del H2 en O(1)

Tampoco hay subproblemas que se repitan cada consulta es independiente de las demás

La decisión que se repite y sí se optimiza

En el edificio había una decisión que se repetía cada 3 a 6 meses elegir qué arreglos hacer con el fondo de mantenimiento

El fondo era de unos 10000 Bs y los arreglos competían por ese dinero

Lo que se quiere optimizar es atender la mayor urgencia sin pasarse del fondo

La urgencia la decidíamos por seguridad y la puse del 1 al 10

| Arreglo | Costo | Urgencia | Urgencia por cada 1000 Bs |
|---|---|---|---|
| Ascensor | 7000 Bs | 9 | 1,29 |
| Bomba de agua | 4000 Bs | 8 | 2,00 |
| Cambio de cubierta del techo | 21000 Bs | 7 | 0,33 |
| Portón eléctrico del garaje | 3000 Bs | 3 | 1,00 |

Cada arreglo se hace entero o no se hace así que es el problema de la mochila 0/1 de la clase 12

El fondo es la capacidad el costo es el peso y la urgencia es el valor

¿Alcanza el voraz?

El voraz más razonable es hacer primero el arreglo con más urgencia por boliviano

Elige la bomba de agua (2,00) luego intenta el ascensor pero 4000 + 7000 = 11000 se pasa del fondo y termina con el portón (1,00)

Resultado del voraz bomba + portón = urgencia 11 gastando 7000 Bs

Pero lo mejor es ascensor + portón = urgencia 12 gastando justo los 10000 Bs

Este es mi contraejemplo con mis propios datos el voraz deja 3000 Bs sin usar y atiende menos urgencia

No cumple la propiedad de elección voraz porque la solución óptima no empieza con la bomba que es lo que eligió el voraz

¿Sirve la dinámica?

Sí porque cumple las dos señales de la clase 12

Los subproblemas se repiten la pregunta con estos arreglos y este dinero ¿cuánta urgencia puedo atender? aparece muchas veces con los mismos valores

Tiene subestructura óptima si hago el ascensor lo que queda es el mismo problema más chico con 3000 Bs y los arreglos que faltan

La tabla tiene n x fondo celdas y cada celda decide entre no hacer el arreglo o hacerlo usando solo celdas ya calculadas

Con mis 4 arreglos y columnas de 100 Bs son 4 x 100 = 400 celdas

La fuerza bruta también da el óptimo pero prueba los 2^n subconjuntos y con 30 arreglos serían más de mil millones

Lo que muestra el caso real

El cambio de cubierta del techo cuesta 21000 Bs y no entra en ningún fondo de 10000 Bs

Ningún algoritmo lo puede elegir hace falta juntar varios fondos o una cuota extraordinaria

Eso no es un error del algoritmo es una limitación de los datos

Mi estrategia

Para buscar pagos y deudas uso la tabla hash del H2 porque es búsqueda

Para elegir los arreglos del fondo uso programación dinámica porque el voraz se equivoca y la fuerza bruta crece como 2^n