Pagos de expensas Torre Ventura

Datos:

Cada registro es un pago y guarda el departamento el nombre del propietario el mes el monto la fecha de pago el número de recibo y el estado

El edificio tiene 53 unidades

En el piso 1 hay 4 locales

En los pisos 2 y 3 hay 5 oficinas por piso que son 10 y se nombran como Of 2A

Del piso 4 al 12 hay 3 departamentos por piso que son 27 y se nombran como 7B

Del piso 13 al 18 hay 2 departamentos por piso que son 12

Guardaba 2 años de historia o sea 24 meses así que hoy son 53 x 24 = 1272 pagos

Cada mes entran unos 53 pagos nuevos

En el peor mes además de los 53 pagos hago al menos 31 consultas en total

De esas entre 15 y 20 son para saber si una unidad pagó entre 10 y 15 son para revisar deudas entre 3 y 5 son reclamos con recibo y 3 o más son para anular un pago mal registrado

Operaciones

| N | Operación | Tipo | Veces al mes | Barata en | Sufre en |
|---|---|---|---|---|---|
| 1 | Buscar si una unidad pagó un mes (clave 7B-2026-03) | buscar por clave | 15 a 20 | Tabla hash O(1) promedio | Lista sin ordenar O(n) recorrer los 1272 pagos |
| 2 | Registrar un pago nuevo | insertar | 53 | Todas O(1) | Ninguna |
| 3 | Ver los pagos de una unidad en orden de meses | recorrer en orden o rango | casi nunca | Árbol balanceado O(log n + k) | Tabla hash porque no guarda orden |
| 4 | Listar unidades con más de un mes de deuda | buscar por clave 53 veces | 10 a 15 | Tabla hash 53 preguntas de O(1) | Lista sin ordenar 53 x 1272 unos 67416 pasos |
| 5 | Buscar un pago por número de recibo | buscar por clave | 3 a 5 | Segunda tabla hash con clave recibo O(1) | Lista sin ordenar O(n) |
| 6 | Anular un pago mal registrado | borrar | 3 o más | Tabla hash O(1) promedio | Arreglo O(n) porque hay que correr los demás |
| 7 | Buscar la unidad con más meses de deuda | el mayor | al mandar avisos | Árbol O(log n) o heap O(1) | Tabla hash porque no sabe cuál es el mayor |

Lo que más pesa

Lo que más hago es buscar si una unidad pagó un mes unas 15 a 20 veces al mes

Además reviso deudas otras 10 a 15 veces y eso usa la misma búsqueda

Anular un pago también busca por la misma clave

Por eso lo que más pesa es buscar por clave exacta

Ajuste con lo visto de árboles

Revisé si mi caso necesita orden o rangos

Ver los pagos de una unidad en orden de meses es un rango y un árbol balanceado lo haría en O(log n + k)

Buscar la unidad con más deuda es buscar el mayor y un árbol lo haría en O(log n)

Pero esas dos operaciones las hago poco ver el historial casi nunca me lo pedían y la mayor deuda solo la busco al mandar avisos

Lo que más hago es buscar por clave exacta y ahí el hash cuesta O(1) y el árbol O(log n)

Por eso mi caso es de solo buscar por clave y sigo eligiendo la tabla hash

Con 1272 pagos hasta una lista común sería rápida en una computadora

Lo que me tomaba 1 a 2 horas era hacerlo a mano con planillas y comprobantes

Pero la lista crece con cada mes que se guarda y su búsqueda crece igual O(n)

En cambio la tabla hash sigue costando O(1) aunque se guarden más años