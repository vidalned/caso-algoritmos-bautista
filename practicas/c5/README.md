# TALLER - ordenamientos

## Protocolo

1 corrida de calentamiento que no se cuenta (la primera siempre sale más lenta), 3 corridas medidas y promedio. Antes de medir verifico que cada algoritmo ordene bien.

## Tabla de tiempos

|n|Inserción (ms)|MergeSort (ms)|QuickSort (ms)|sort() de PHP (ms)|
|-|-|-|-|-|
|10.000|721,1|8,9|4,0|1,8|
|20.000|2.902,9|18,5|8,4|2,2|
|40.000|11.372,6|38,8|17,5|5,0|
|80.000|45.137,5|81,7|37,0|10,3|

## Conclusiones

Inserción tarda 4 veces más cada vez que duplico los datos. Con 80.000 llegó a 45 segundos

MergeSort y QuickSort solo suben un poco más del doble. Con 80.000 datos QuickSort tardó 37 ms unas 1.200 veces más rápido que inserción.

El `sort()` de PHP ganó a todos porque está hecho en C dentro del lenguaje.

En tiempos muy chicos hay ruido (el `sort()` casi no subió de 10.000 a 20.000), por eso se promedia y se mira la tendencia.

## Mi elección: QuickSort con pivote al medio

Fue el más rápido de los que programé: menos de la mitad del tiempo de MergeSort en todas las cantidades.

No usa memoria extra, ordena en el mismo arreglo

Con el pivote al medio no cae en el peor caso cuando los datos ya vienen ordenados

Es el candidato ideal para mi caso pagos de expensas del Edificio Torre Ventura son miles de registros que crecen cada mes y llegan casi ordenados por fechajusto donde inserción es muy lenta para todo el historial y QuickSort con pivote al último falla

