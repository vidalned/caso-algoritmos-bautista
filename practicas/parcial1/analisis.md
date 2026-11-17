jose vidal bautista aruquipa
a)analisis de  cuatro fragmentos

f1 O(n) tiene un solo bucle que recorre todos los datos una vez

f2 O(n²) tiene dos bucles anidados, donde cada dato se compara con los que le siguen

f3 O(log n) divide los datos a la mitad en cada vuelta, por eso necesita menos pasos aunque aumenten los datos

f4 O(n log n) Un bucle de n vueltas y, adentro, otro que duplica k hasta llegar a n (log n vueltas).
Recurrencias

b)recurencias
(i) T(n) = 3 T(n/2) + n
a = 3, b = 2, d = 1 → b^d = 2 → a > b^d → O(n^log₂3) ≈ O(n^1,585) 
dominan las hojas

(ii) T(n) = T(n/2) + n²
a = 1, b = 2, d = 2 → b^d = 4 → a < b^d → O(n²) 
domina la raíz