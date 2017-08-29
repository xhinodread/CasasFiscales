<?php
class Vivienda extends AppModel {
	//  (rol, calle,numero,sector,block,depto,referencia,comuna_id,cod_postal,latitud,longitud,monto_avaluo,activo,created)
	//public $name = 'Vivienda';
	
	public $validate = array(
		'rol' => array('rule' => 'validaDor', 'message' => 'Formato incorrecto, solo alphaNumeric.'),
	/***	'rol' => array('rule' => 'notBlank', 'required' => true, 'allowEmpty' => false, 'message' => 'Requerida.'),***/
	/***	'rol' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Requerido'
            ),
            'between' => array(
                'rule' => array('lengthBetween', 5, 15),
                'message' => 'Between 5 to 15 characters'
            )
     ),***/
		'calle' => array('rule' => 'validaDor', 'message' => 'Requerida.'),
		 /****'calle' => array('rule' => 'alphaNumeric', 'message' => 'Requerida.'),***/
		/** 'calle' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Requerido'
            )
		 ),**/
		'sector' => array('rule' => 'validaDor', 'message' => 'Requerido.'),
		 /****'sector' => array('rule' => 'alphaNumeric', 'message' => 'Requerido.'),****/
		/** 'sector' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Requerido'
            )
		 ),**/
		'numero' => array('rule' => 'numeric', 'message' => 'Formato incorrecto, solo números.'),
		'comuna_id' => array('rule' => 'numeric', 'message' => 'Requerido.'),
		'monto_avaluo' => array('rule' => 'numeric', 'message' => 'Formato incorrecto, solo números y puntos.'),
		'latitud' => array('rule' => '/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/', 'message' => 'Formato incorrecto para la Latitud.'),
		'longitud' => array('rule' => '/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/', 'message' => 'Formato incorrecto para la Longitud.')
	);
	
	public $hasMany = array('Mantencione');
	
	public function validaDor($elRol){
		$value = array_values($elRol);
    $value = $value[0];
		if( strlen(trim($value)) == 0 ){return false;}
		else{ return true;}
	}
	
	public function filtro_index($data = null){
		$viviendaBucar = explode(' ', $data);
		$conditions = array('Vivienda.calle LIKE' => '%'.trim($viviendaBucar[0]).'%', 'Vivienda.activo' =>1) ;
		if( count($viviendaBucar)<=1 ){ return $conditions; }		
		$elNumero = 0;
		$laCalle = '';
		foreach($viviendaBucar as $lista){
			if( is_numeric($lista) ){ $elNumero = $lista; }
			else{ $laCalle .= ' '.$lista; }
		}
		if( $elNumero > 0 ){		
			$conditions =array( array('Vivienda.calle LIKE' => '%'.trim($laCalle).'%', 'Vivienda.numero' => $elNumero, 'Vivienda.activo' =>1) );
		}
		return $conditions;
	}
	
	public function saca_str_monto($elMonto = null){
		return str_replace(',', '', str_replace('.', '', $elMonto));
	}
	
	
	
}