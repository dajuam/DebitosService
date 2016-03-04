<?php

	function startConnection($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
        // Inicializo la conexión con la base de datos
		return new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	}

	function closeConnection($connection) {
		$connection->close();
	}

	function callQuery($connection, $query) {	
		return $connection->query($query);
	}

    function getLastId($connection, $table) { 
		$final = 0;
		if ($table == "archivo_pago_directo_item") {
			// Obtengo el último id del archivo cargado en archivo_pago_directo_item
			$resultado = callQuery($connection, "SELECT * FROM  archivo_pago_directo_item ORDER BY archivo DESC LIMIT 1");
            $final = $resultado->fetch_object()->archivo;
		}
		if ($table == "debitos_sigep") {
			// Obtengo el último id del archivo cargado en debitos_sigep
			$resultado = callQuery($connection, "SELECT ultimo_archivo_id FROM debitos_sigep ORDER BY ultimo_archivo_id DESC LIMIT 1");
			$final = $resultado->fetch_object()->ultimo_archivo_id;
		}
		return $final;
	} 

	function writeTable($connection, $item, $ultimo_archivo_id, $message) {
		callQuery($connection, "INSERT INTO debitos_sigep (`id` ,`ultimo_archivo_id` ,`pdv_numero` ,`importe` ,`status`)VALUES (NULL, $ultimo_archivo_id,  $item->nroFactura,  $item->impFac,  '" . $message . "')");
	}
	
	function mensajeDelSiGeP($response) {
	    if ($response != null) {
	        echo nl2br("Mensaje adicional del SiGeP: " . $response . "\n");
	        echo "<br>";
	    }
	}

?>