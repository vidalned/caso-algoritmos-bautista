jose vidal bautist aruquipa

Comparación y elección

El hospital almacena 300.000 números de historia clínica y realiza 5.000 consultas durante el día. Se comparan tres alternativas para determinar cuál resulta más conveniente.

Ops 1 Búsqueda secuencial

Consiste en recorrer el listado hasta encontrar el número buscado o llegar al final.

300.000 × 5.000 = 1.500.000.000 operaciones.

Costo O(q × n)

Ops 2 Ordenamiento y búsqueda binaria

Consiste en ordenar el listado una sola vez con un algoritmo O(n log n) y luego hacer las consultas con búsqueda binaria.

Ordenamiento: 300.000 × log₂(300.000) ≈ 5.457.000 operaciones.

Búsquedas: 5.000 × log₂(300.000) ≈ 90.950 operaciones.

Total aproximado: 5.457.000 + 90.950 = 5.547.950 operaciones.

Costo O(n log n + q log n)

Ops 3 Ordenamiento cuadrático y búsqueda binaria

Consiste en ordenar el listado con un algoritmo cuadrático y luego hacer las búsquedas binarias.

Ordenamiento: 300.000 × 299.999 / 2 = 44.999.850.000 comparaciones.

Búsquedas: 5.000 × log₂(300.000) ≈ 90.950 operaciones.

Total aproximado: 44.999.850.000 + 90.950 = 44.999.940.950 operaciones.

Costo O(n² + q log n)

Comparación de las tres opciones

1 Búsqueda secuencial: 1.500.000.000 operaciones.

2 Ordenamiento n log n y búsqueda binaria: aproximadamente 5.547.950 operaciones.

3 Ordenamiento cuadrático y búsqueda binaria: aproximadamente 44.999.940.950 operaciones.

Como se puede observar, la segunda opción necesita muchas menos operaciones que las otras dos.

Elección

Elijo la opción 2, porque ordena el listado una sola vez y después cada consulta cuesta aproximadamente 18 pasos. Es mucho más rápida que recorrer toda la lista en cada consulta.

Además, utilizando QuickSort con un buen pivote se puede ordenar el mismo arreglo sin duplicar los 300.000 registros en memoria.

A partir de cuántas consultas cambiaría de opinión

Ordenar cuesta aproximadamente 5.457.000 operaciones y cada consulta secuencial cuesta 300.000 operaciones:

5.457.000 / 300.000 ≈ 18,2.

Con 18 consultas o menos conviene la opción 1; desde 19 consultas conviene la opción 2.

Como el hospital realiza 5.000 consultas diarias, la opción 2 es la más conveniente.