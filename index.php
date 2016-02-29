<?php

	/** 
	*  @author jmartinez@fecliba.org.ar
	*/

	// Desactivo xdebug, ya que no me deja levantar excepciones
	xdebug_disable();

	require_once "include/queryGenerica.php";
	require_once "include/config.php";
	require_once "include/utils.php";

	// Enables debug configuration
	if (isset($_GET["debug"])){
		if ($_GET["debug"] == "true") {
			ini_set("display_errors", 1);
		}
	}

	$mysqli = startConnection($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

	try {
        $cliente = new SoapClient($RUTA_WS);
	} catch (Exception $e){
		die(nl2br("No se pudo conectar al servicio SOAP del SiGeP\n"));
	}

	$id_archivo = getLastId($mysqli, "archivo_pago_directo_item");
	$ultimo_archivo_id = getLastId($mysqli, "debitos_sigep");

	// Comparamos si los ids son iguales. En caso que no sean iguales, debemos enviar los items al SiGeP
	if ($id_archivo  == $ultimo_archivo_id) { 
		echo nl2br("No hay archivos para exportar al SiGeP\n");
	} else {
		// Enviamos los archivos al SiGeP
		do {
            $ultimo_archivo_id++;
            echo nl2br("Archivo ID " . $ultimo_archivo_id . ":\n");
			$query = $queryGenerica . " " . $ultimo_archivo_id;
			$items = $mysqli->query($query) or die($mysqli->error.__LINE__);
			while ($item = $items->fetch_object()) {
				$prestador = iconv(mb_detect_encoding($item->prestador, mb_detect_order(), true), "UTF-8", $item->prestador);
				$params = array(
					"obrasocial" => $item->obraSocial,
					"nroOp" => $item->nroOp,
					"anioOp" => $item->anioOp,
					"nroRemito" => $item->remito,
					"anioRemito" => $item->anioRemito,
					"CodNacional" => $item->codNac,
					"CodFecliba" => $item->codFecliba,
					"nomPrestador" => $prestador,
					"mesPresentacion" => $item->mesPrestacion,
					"anioPresentacion" => $item->anioPrestacion,
					"ImpFac" => $item->impFac,
					"impDeb" => $item->impDeb,
					"impNeto" => $item->impNeto,
					"porcentaje" => $item->porcentaje,
					"planilla" => $item->planilla,
					"nroOrden" => $item->nroOrden,
					"convenio" => $item->convenio,
					"nroFactura" => $item->nroFactura
				);
				try {
					// Si fue agregado con éxito, debemos incluir este registro en nuestra base
					$response = $cliente->__soapCall("agregaDebito", $params);
					writeTable($mysqli, $item, $ultimo_archivo_id, $response);
					echo nl2br("El prestador " . $prestador . " fue agregado con &eacute;xito\n");
				} catch (Exception $e) {
					// Caso contrario se incluirá con el mensaje de error.
					writeTable($mysqli, $item, $ultimo_archivo_id, $e->getMessage());
					echo nl2br("El prestador " . $prestador . "no pudo ser agregado: " . $e->getMessage() . "\n");
				}
			}
		} while ($id_archivo > $ultimo_archivo_id);
	}

	closeConnection($mysqli);
	
?>