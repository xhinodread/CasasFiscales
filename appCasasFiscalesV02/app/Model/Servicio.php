<?php
class Servicio extends AppModel {
	//public $name = 'Servicio';
	
	
	public function filtro_index($data = null){
		//echo print_r($data, 1);
		$conditions = '';
		$servicioBucar = explode(' ', $data);
		switch( count($servicioBucar) ){
			case 2: 
				/****
				$conditions = array('Servicio.nombre LIKE' => '%'.trim($servicioBucar[0]).'%',
														'OR' => array('Servicio.siglas LIKE' => '%'.trim($servicioBucar[1]).'%')
													 );
				*****/
				$conditions = array('OR' => array( array('Servicio.nombre LIKE' => '%'.trim($servicioBucar[0]).'%'),
																					 array('Servicio.siglas LIKE' => '%'.trim($servicioBucar[1]).'%') 
																				 )
													 );
			break;
			case 1:
			//	$conditions = array('Servicio.nombre LIKE' => '%'.trim($servicioBucar[0]).'%' );
				$conditions = array('OR' => array( array('Servicio.nombre LIKE' => '%'.trim($servicioBucar[0]).'%'),
																					 array('Servicio.siglas LIKE' => '%'.trim($servicioBucar[0]).'%') 
																				 )
													 );
			break;
			default: $conditions = array('Servicio.nombre LIKE' => '%'.trim($servicioBucar[0]).'%' );
			break;
		}
		return $conditions;
	}
	
	public function saca_str_rut($elRut = null){
		$elRut = explode('-', $elRut);
		$elRut[0] = str_replace('.', '', $elRut[0]);
		return $elRut;
	}
	
	public function existe_rut($elRut = null){
		return $this->find('first', array('conditions'=>array('Servicio.rut'=>$elRut)) );
	}
	
}