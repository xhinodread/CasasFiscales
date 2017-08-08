<?php
class Mantencione extends AppModel {
	/*** id, vivienda_id, mantencion_id, observacion, documento, created ***/
	
	public $belongsTo = array('Mantentipo');
	// public $hasOne = array('Vivienda');
		
	/*	
	public $validate = array(
		'documento' => array(
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::uploadError
			'uploadError' => array(
				'rule' => 'uploadError',
				'message' => 'Something went wrong with the file upload',
				'required' => FALSE,
				'allowEmpty' => TRUE,
			),
			'mimeType' => array(
					'rule' => array('mimeType', array('"application/pdf"')),
					'message' => 'Invalid file, only PDF allowed, cachay',
					'required' => FALSE,
				 /* 'allowEmpty' => TRUE,* 
			),	
			// custom callback to deal with the file upload
			'processUpload' => array(
				'rule' => 'processUpload',
				'message' => 'Something went wrong processing your file',
				'required' => FALSE,
				'allowEmpty' => TRUE,
				'last' => TRUE,
			)
		)
  );
	
	*/
	
	//public $virtualFields = array('fecha' => 'CONVERT(VARCHAR(10), Mantencione.fecha, 103)');
	
	public function arrayInMantenciones($arrayDatos = null, $nodo1){
		//echo '<pre>'.print_r($arrayDatos, 1).'</pre>';
		$arraySalida = array();
		foreach($arrayDatos as $pnt => $lista){
			$arrayDatos[$pnt][$nodo1]['mantentipo_id'] = $arrayDatos[$pnt]['Mantentipo']['descripcion'];
			foreach($lista[$nodo1] as $pntDos => $listaDos){
				if( isset($arrayDatos[$pnt][$nodo1]['fecha']) ){
					//$arrayDatos[$pnt][$nodo1]['fecha'] = date('d/m/Y H:i:s', strtotime($arrayDatos[$pnt][$nodo1]['fecha']));
					$arrayDatos[$pnt][$nodo1]['fecha'] = date('d/m/Y', strtotime($arrayDatos[$pnt][$nodo1]['fecha']));
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
	
	public function getTipos(){
		$data = array();
		$sql = "SELECT id, descripcion FROM mantentipos";
		foreach($this->query($sql) as $lista){
			$data[$lista[0]['id']] = $lista[0]['descripcion'];
		}
		return $data;
	}
	
	
	
	
}
?>