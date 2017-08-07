<?php
class Mantencione extends AppModel {
	/*** id, vivienda_id, mantencion_id, observacion, documento, created ***/
	
	public $belongsTo = array('Mantentipo');
	// public $hasOne = array('Vivienda');
	
	public function arrayInMantenciones($arrayDatos = null, $nodo1){
		//echo '<pre>'.print_r($arrayDatos, 1).'</pre>';
		$arraySalida = array();
		foreach($arrayDatos as $pnt => $lista){
			$arrayDatos[$pnt][$nodo1]['mantentipo_id'] = $arrayDatos[$pnt]['Mantentipo']['descripcion'];
			foreach($lista[$nodo1] as $pntDos => $listaDos){
				if( isset($arrayDatos[$pnt][$nodo1]['created']) ){
					$arrayDatos[$pnt][$nodo1]['created'] = date('d/m/Y H:i:s', strtotime($arrayDatos[$pnt][$nodo1]['created']));
					break;
				}
			}
		}
		foreach($arrayDatos as $pnt => $lista){
			$valor = $lista[$nodo1];
			$arraySalida[$nodo1][$pnt] = $valor;
		}
		return $arraySalida;
	}
	
}
?>