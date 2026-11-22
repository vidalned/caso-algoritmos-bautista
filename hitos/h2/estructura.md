-Pagos de expensas Torre Ventura

Elijo una tabla hash con la clave unidad-mes por ejemplo 7B-2026-03

En PHP la tabla hash es el arreglo asociativo

Respaldo: qué tipo de problema es y qué algoritmo lo resuelve

Mi proceso es un problema de búsqueda y no de ordenamiento

Lo que más hago es buscar un pago por su clave exacta unidad-mes para saber si pagó o si debe

Ordenar solo aparece en operaciones que hago poco como ver el historial de una unidad

Comparo tres algoritmos de búsqueda vistos en clase para mis 1272 pagos y unas 31 consultas al mes

| Algoritmo de búsqueda | Estructura que necesita | Costo por consulta | Costo de preparar | Pasos con n = 1272 |
|---|---|---|---|---|
| Búsqueda lineal (clase 4) | lista simple | O(n) | ninguno | hasta 1272 por consulta |
| Ordenar y búsqueda binaria (clases 4 y 5) | arreglo ordenado | O(log n) | ordenar una vez O(n log n) y cada pago nuevo O(n) para mantener el orden | unos 11 por consulta |
| Búsqueda por hash (clase 8) | tabla hash | O(1) promedio | cada pago nuevo O(1) | 1 por consulta |

El más óptimo para mi caso es la búsqueda por hash

Es el más barato por consulta y registrar un pago nuevo también cuesta O(1)

La binaria también es rápida para buscar pero cada mes entran 53 pagos nuevos y mantener el arreglo ordenado cuesta O(n) por cada uno

Qué estructura resuelve cada parte del proceso

La estructura principal es la tabla hash con clave unidad-mes y resuelve buscar si pagó revisar deudas registrar y anular que son las operaciones de todos los meses

Para buscar por número de recibo uso una segunda tabla hash con clave recibo

Para ver el historial de una unidad en orden junto sus 24 pagos y los ordeno con sort solo en ese momento

Para la unidad con más deuda recorro las 53 unidades y me quedo con la mayor

Costo de las operaciones que más hago

| Operación | Veces al mes | Tabla hash (mi elección) | Lista simple | Árbol balanceado |
|---|---|---|---|---|
| Buscar si una unidad pagó un mes | 15 a 20 | O(1) promedio | O(n) | O(log n) |
| Revisar deudas de las 53 unidades | 10 a 15 | 53 x O(1) | 53 x O(n) | 53 x O(log n) |
| Registrar un pago | 53 | O(1) promedio | O(1) | O(log n) |
| Anular un pago | 3 o más | O(1) promedio | O(n) | O(log n) |
| Ver los pagos de una unidad en orden | casi nunca | juntar 24 pagos y ordenar | O(n) | O(log n + k) |
| Unidad con más meses de deuda | al mandar avisos | O(n) recorrer 53 unidades | O(n) | O(log n) |

Por qué la tabla hash

Lo que más hago es buscar por clave exacta si una unidad pagó un mes y revisar deudas que usa esa misma búsqueda

En la tabla hash buscar insertar y borrar por clave cuestan O(1) en promedio

Con mis 1272 pagos de hoy la lista simple tiene que recorrer hasta 1272 pagos por consulta y la tabla hash va directo al casillero

Por qué no el árbol

El árbol balanceado gana en orden rangos y el mayor que son las dos últimas filas de la tabla

Pero esas las hago poco ver el historial casi nunca me lo pedían y la mayor deuda solo la busco al mandar avisos

En lo que más hago que es buscar por clave el árbol cuesta O(log n) y el hash O(1)

Además PHP no trae un árbol balanceado ya hecho

Lo que sacrifico

El hash no guarda orden

Cuando alguien pide su historial junto sus 24 pagos y los ordeno y eso cuesta muy poco

Para la unidad con más deuda recorro las 53 unidades y también cuesta muy poco

Cuándo cambiaría de opinión

Si tuviera que sacar reportes por rango de fechas muchas veces al mes por ejemplo todos los pagos entre marzo y junio usaría un árbol o un arreglo ordenado por fecha

Si tuviera que avisar siempre primero a la unidad que más debe usaría además un heap