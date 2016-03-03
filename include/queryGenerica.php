<?php

$queryGenerica = <<<EOT
SELECT '1' obraSocial,
A.orden_pago nroOp,
A.anio_op anioOp,
A.remito,
A.anio_remito anioRemito,
A.cod_nacional_prestador codNac,
B.codigo codFecliba,
G.nombre prestador,
A.mes mesPrestacion,
'20'+A.anio anioPrestacion,
A.importe impFac,
A.debitado impDeb,
A.neto impNeto,
A.porcentaje,
REPLACE(E.codigo, ' ', '') planilla,
A.orden nroOrden,
CASE A.convenio WHEN 'AO' THEN 'A0001F0'
WHEN 'CR' THEN 'A0001F3'
WHEN 'AI' THEN 'A0001F6'
WHEN 'AC' THEN 'A0001F7'
END convenio, 
CONCAT( A.pdv,REPEAT( '0', 8 - LENGTH( A.numero) ) , A.numero) nroFactura,
F.carga fechaIng,
'' docAval,
'A' estado
FROM archivo_pago_directo_item AS A
INNER JOIN prestadores B ON ( B.codigo_nacional = ' '+A.cod_nacional_prestador ) 
INNER JOIN facturas C ON ( C.emisor = B.id
AND C.numero = A.numero
AND C.pdv = A.pdv ) 
INNER JOIN facturas_os D ON ( D.id = C.id ) 
INNER JOIN planillas_facturas E ON ( E.id = D.planilla ) 
INNER JOIN archivo_pago_directo F ON (A.archivo=F.id)
INNER JOIN terceros G ON (B.id=G.id)
WHERE A.debitado <>0 and A.archivo = 
EOT;

?>