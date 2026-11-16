# Mediciones busqueda lineal

Use busqueda_lineal.php buscando el -1, que no esta en la lista, asi que tiene que recorrer todo. Saque el promedio de 5 corridas.

| Elementos | Promedio (ms) |
|-----------|---------------|
| 50000 (n) | 0.3154 |
| 200000 (4n) | 1.2636 |
| 800000 (16n) | 5.4046 |

Cuando puse 4 veces mas elementos el tiempo subio 4 veces, y con 16 veces mas subio unas 17 veces. O sea que el tiempo crece igual que la cantidad de datos, por eso es O(n).
