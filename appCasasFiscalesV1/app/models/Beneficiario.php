<?php
class Beneficiario extends AppModel {
	//public $name = 'Beneficiarios';
	public $useDbConfig = 'SRV58BDDEV02';
	
	public $belongsTo = 'Estcivil';

	function existe_rut($elRut = null){
		return $this->find('first', array('conditions'=>array('Beneficiario.rut'=>$elRut)) );
	}
	
	function saca_str_rut($elRut = null){
		$elRut = explode('-', $elRut);
		$elRut[0] = str_replace('.', '', $elRut[0]);
		return $elRut;
	}
	
	function saca_str_monto($elMonto = null){
		/*$elMonto = str_replace('.', '', $elMonto);*/
		return str_replace('.', '', $elMonto);
	}
	
	public function filtro_index($data = null){
		//echo print_r($data, 1);
		$conditions = '';
		$funcionarioBucar = explode(' ', $data);
		switch( count($funcionarioBucar) ){
			case 3:
				$conditions = array('nombres LIKE' => $funcionarioBucar[0].'%'
							, 'OR' => array('paterno LIKE' => '%'.$funcionarioBucar[1].'%', 'materno LIKE' => '%'.$funcionarioBucar[2].'%') );
			break;
			case 2: 
				$conditions = array('nombres LIKE' => $funcionarioBucar[0].'%'
							, 'OR' => array('paterno LIKE' => '%'.$funcionarioBucar[1].'%') );
			break;
			case 1:
				$conditions = array('nombres LIKE' => $funcionarioBucar[0].'%' );
			break;
		}
		return $conditions;
	}
	
}