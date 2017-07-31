<?php
class Beneficiario extends AppModel {
	//public $name = 'Beneficiarios';
	//public $useDbConfig = 'SRV58BDDEV02';
	
	public $validate = array('sueldo_base' => array('rule' => 'numeric', 'message' => 'Formato incorrecto, solo números y puntos')	
							,'grado' => array(
									'gradoRule1' => array(
										'rule' => 'numeric',
										'message' => 'Grado incorrecto',
									 ),
									'gradoRule2' => array(
										'rule' => array('range', 0.99, 21),
										'message' => 'Grado incorrecto, debe estar entre 1 and 20'
									)
								/**	,
									'gradoRule2' => array(
										'rule' => array('min', 1),
										'message' => 'Minimum es uno 1.'
									),
									'gradoRule3' => array(
										'rule' => array('max', 5),
										'message' => 'Maximo es uno 5.'
									)
								***/
								) 
						/***	,'grado' => array('rule' => 'numeric', 'message' => 'Grado incorrecto') ***/
							);
		
	/*public $validate = array(
		'sueldo_base' => array('numeric' => array('rule' => array('numeric')
												  , 'message' => 'Formato incorrecto'
												 )
							  )
	);
	*/

	
	public $belongsTo = array('Estcivil');
	public $hasOne = array('Conyuge');

	public function existe_rut($elRut = null){
		return $this->find('first', array('conditions'=>array('Beneficiario.rut'=>$elRut)) );
	}
	
	public function saca_str_rut($elRut = null){
		$elRut = explode('-', $elRut);
		$elRut[0] = str_replace('.', '', $elRut[0]);
		return $elRut;
	}
	
	public function saca_str_monto($elMonto = null){
		/*$elMonto = str_replace('.', '', $elMonto);*/
		return str_replace(',', '', str_replace('.', '', $elMonto));
	}
	
	public function filtro_index($data = null){
		//echo print_r($data, 1);
		$conditions = '';
		$funcionarioBucar = explode(' ', $data);
		switch( count($funcionarioBucar) ){
			case 3:
				$conditions = array('Beneficiario.nombres LIKE' => $funcionarioBucar[0].'%'
							, 'OR' => array('paterno LIKE' => '%'.$funcionarioBucar[1].'%', 'Beneficiario.materno LIKE' => '%'.$funcionarioBucar[2].'%') );
			break;
			case 2: 
				$conditions = array('Beneficiario.nombres LIKE' => $funcionarioBucar[0].'%'
							, 'OR' => array('Beneficiario.paterno LIKE' => '%'.$funcionarioBucar[1].'%') );
			break;
			case 1:
				$conditions = array('Beneficiario.nombres LIKE' => $funcionarioBucar[0].'%' );
			break;
			default: $conditions = array('Beneficiario.nombres LIKE' => '%'.trim($funcionarioBucar[0]).'%' );
			break;
		}
		return $conditions;
	}
		
	public function actualizar($elRut = null){		
		$this->set(array(
			'rut' =>  $elRut[0],
			'dv' =>  $elRut[1],
			'nombres' => $this->data['Beneficiario']['nombres'],
			'paterno' => $this->data['Beneficiario']['paterno'],
			'materno' => $this->data['Beneficiario']['materno'],
			'estcivil_id' => $this->data['Beneficiario']['estcivil_id'],
			'email' => $this->data['Beneficiario']['email'],
			'celular' => $this->data['Beneficiario']['celular'],
			'escalafon' => $this->data['Beneficiario']['escalafon'],
			'grado' => $this->data['Beneficiario']['grado'],
			'sueldo_base' => $this->saca_str_monto($this->data['Beneficiario']['sueldo_base']),
			'created' => date("d-m-Y H:i:s")
		));
		return;
	}
		
	public function agrega_conyugue($array_datos = null){
		$array_datos['rut'] = trim(str_replace('.', '',$array_datos['rut']));
		$evaluador = preg_match("/^0*(\d{1,3}(\.?\d{3})*)\-?([\dkK])$/", $array_datos['rut'] );
		if( $evaluador ){
			$this->Conyuge->create();
			$this->Conyuge->set($array_datos);
			return $this->Conyuge->save();
		}else{
			return false;
		}
	}
	
	public function edita_conyugue($array_datos = null){
		$array_datos['rut'] = trim(str_replace('.', '',$array_datos['rut']));
		if( preg_match("/^0*(\d{1,3}(\.?\d{3})*)\-?([\dkK])$/", $array_datos['rut'] ) ){
			$this->Conyuge->read(null, $array_datos['id']);
			$this->Conyuge->set($array_datos);
			return $this->Conyuge->save();
		}else{
			return false;
		}
	}
	
	
}