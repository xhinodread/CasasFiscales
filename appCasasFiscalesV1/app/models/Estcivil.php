<?php
class Estcivil extends AppModel {
	//public $name = 'Beneficiarios';
	public $useDbConfig = 'SRV58BDDEV02';
	
	public function _filtro_index($data = null){
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