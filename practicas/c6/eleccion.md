# Elección

## Mi proceso y sus datos

Mi proceso es el control de pagos de gastos del Edificio Torre Ventura. Son 10 departamentos, así que cada mes se registran 10 pagos, unos 120 al año. En mi muestra tengo 20 registros (enero y febrero). El peor mes es diciembre, porque ahí reviso las deudas de todo el año y también de años anteriores. Con 5 años guardados serían 600 registros y más o menos 120 búsquedas (10 departamentos por 12 meses). Los pagos se anotan en el orden en que la gente paga, no están ordenados.

## La operación que más pesa

Buscar. Para saber si un departamento pagó un mes tengo que encontrar ese registro, y eso lo repito muchas veces.

## Candidatos

Candidato A: revisar la lista uno por uno. En el peor caso el pago no existe y reviso todo, entonces es O(n) por búsqueda.

Candidato B: ordenar una vez por departamento y mes, y después usar búsqueda binaria.

    Binaria:  T(n) = T(n/2) + 1
    a=1, b=2, d=0  ->  b^d = 1  ->  a = b^d  ->  O(log n)

    Ordenar:  T(n) = 2 T(n/2) + n
    a=2, b=2, d=1  ->  b^d = 2  ->  a = b^d  ->  O(n log n)

Entonces B cuesta n log n una sola vez y después O(log n) por búsqueda.

## Elección

Elijo B.

En el peor mes, con A haría hasta 600 comparaciones por búsqueda, y por 120 búsquedas son 72000. Con B son 10 comparaciones por búsqueda, 1200 en total, más unas 5500 de ordenar. Sale como 10 veces menos, y cada año la diferencia va a ser más grande porque los registros se siguen acumulando.

Además, al ordenar por departamento, los pagos de cada uno quedan juntos y puedo ver de una vez qué meses debe.

Lo que medí buscando un valor que no está:

| Elementos | Lineal (ms) | Pasos binaria |
|---|---|---|
| 50000 | 0.3154 | 16 |
| 200000 | 1.2636 | 18 |
| 800000 | 5.4046 | 20 |

La lineal con 16 veces más datos tarda unas 17 veces más. La binaria solo sube 4 pasos.

## Cómo la voy a medir

Voy a usar los mismos tamaños de la práctica 3: 50000, 200000 y 800000. Busco un valor que no está para que sea el peor caso, hago una corrida de calentamiento y después 5 corridas, y saco el promedio con hrtime. En la binaria el tiempo es tan chico que casi no se puede medir, así que ahí cuento los pasos. También voy a medir cuánto tarda ordenar, porque es parte del costo de B.
