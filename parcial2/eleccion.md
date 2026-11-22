jose vidal bautista aruquipa

jornada normal 120000 pedidos 120000 preparaciones y 40000 consultas de EstaPendiente

Combino dos estructuras una cola de prioridad (heap) y una tabla hash

| Operación | Veces por jornada | Estructura | Costo |
|---|---|---|---|
| Registrar | 120000 | heap + tabla hash | O(log n) en el heap y O(1) en el hash |
| PrepararSiguiente | 120000 | heap (sale el de menor plazo) | O(log n) en el heap y O(1) para sacarlo del hash |
| EstaPendiente | 40000 | tabla hash | O(1) promedio |
| Pendientes | pocas | tabla hash (count) | O(1) |

-ESTRUCRTURA PRINCIPAL  HEAP

Lo que mas hago es sacar el pedido mas urgente 120000 veces

El heap siempre tiene el de menor plazo arriba y sacarlo cuesta O(log n)

Para el desempate la prioridad es plazo y orden de llegada así en empate sale el que llego antes

-Por que ademas la tabla hash 

El heap no sabe buscar por nombre y buscar ahi cuesta O(n)

Por eso guardo los nombres pendientes en una tabla hash y EstaPendiente cuesta O(1)

Al preparar un pedido lo saco del heap y también del hash

-Por qué no sirve la lista simple (n = 120000 y log2 120000 ≈ 17)

-Con la lista simple

Registrar 120000 x 1 = 120000

PrepararSiguiente recorre toda la lista para buscar el menor 120000 x 120000 = 14400000000

EstaPendiente recorre la lista 40000 x 120000 = 4800000000

Total aproximado 19200120000 operaciones

-Con heap + tabla hash

Registrar 120000 x 17 = 2040000

PrepararSiguiente 120000 x 17 = 2040000

EstaPendiente 40000 x 1 = 40000

Total aproximado 4120000 operaciones

La lista simple hace unas 4600 veces más trabajo

Además al sacar un pedido de la lista hay que correr los demás un lugar y eso también es O(n)

-Cuando cambiaria de opinion

Si los plazos posibles fueran pocos y fijos como en la carga de prueba que solo usa 6 plazos (15 30 45 60 75 y 90 minutos) usaría 6 colas normales una por plazo y sacaría siempre de la primera cola que no esté vacía

Cada cola respeta el orden de llegada y registrar y preparar costarían O(1) en vez de O(log n)

También si la pastelería tuviera muy pocos pedidos por ejemplo 20 al día la lista simple alcanzaría porque recorrer 20 no cuesta nada