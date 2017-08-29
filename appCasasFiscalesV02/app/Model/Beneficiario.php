<?php
class Beneficiario extends AppModel {
	//public $name = 'Beneficiarios';
	//public $useDbConfig = 'SRV58BDDEV02';
	
	public $validate = array(
			'rut' => array('rule' => 'isUnique', 'message' => 'Rut exite, verifique.'
										,'rule' => 'notBlank', 'message' => 'Necesita un rut.')
			,'dv' => array('rule' => 'notBlank', 'message' => 'Necesita un rut.')
			,'nombres' => array('rule' => 'notBlank', 'message' => 'Necesita un nombre.')
			,'paterno' => array('rule' => 'notBlank', 'message' => 'Necesita un apellido.')
			,'materno' => array('rule' => 'notBlank', 'message' => 'Necesita un apellido.')
			,'celular' => array('rule' => 'notBlank', 'message' => 'Necesita un telefono de contacto.')
			,'estcivil_id' => array('rule' => 'notBlank', 'message' => 'Estado civil.')
			,'email' => array('rule' => 'notBlank', 'message' => 'Correo electrónico requerido.')
			,'sueldo_base' => array('rule' => 'numeric', 'message' => 'Formato incorrecto, solo números y puntos')
			,'escalafon' => array('rule' => 'notBlank', 'message' => 'Escalafon requerido.')
			,'grado' => array(
					'gradoRule1' => array(
						'rule' => 'numeric',
						'message' => 'Grado incorrecto',
					 ),
					'gradoRule2' => array(
						'rule' => array('range', 0.99, 21),
						'message' => 'Grado incorrecto, debe estar entre 1 and 20'
					)
			)
	);
		
	/*public $validate = array(
		'sueldo_base' => array('numeric' => array('rule' => array('numeric')
												  , 'message' => 'Formato incorrecto'
												 )
							  )
	);
	*/

	public $belongsTo = array('Estcivil');
	public $hasOne = array('Conyuge', 'beneficiarios_servicio');

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
		
	public function busca_conyugue_beneficiario($idBeneficiario=null){
		//$rutConyuge = trim(str_replace('.', '',$rutConyuge));
		//$res = $this->Conyuge->find('all', array('conditions'=>array('rut' => $rutConyuge)) );
		$res = $this->Conyuge->find('all', array('conditions'=>array('beneficiario_id' => $idBeneficiario)) );
		return $res;
	}
	
	public function busca_conyuguevERiNICIAL($rutConyuge=null, $idBeneficiario=null){
		/*** PENDIENTE ***/
		$rutConyuge = trim(str_replace('.', '',$rutConyuge));
		$res = $this->Conyuge->find('count', array('conditions'=>array('rut' => $rutConyuge)) );
		//echo '1: '.$res.'<br>';
		//debug($res);
		
		if( $res == 0 ){
			$resRutConyuge = $this->Conyuge->find('count', array('conditions'=>array('beneficiario_id' => $idBeneficiario)) );
			//$elRutConyuge = $this->Conyuge->find('all', array('conditions'=>array('beneficiario_id' => $idBeneficiario)) );
			//debug($elRutConyuge);
			if( $resRutConyuge > 0 ){
				return 2;
			}else{
				return 0;
			}
		}
		/***/
		if( $res == 1 ){
			$elRutConyuge = $this->Conyuge->find('all', array('conditions'=>array('rut' => $rutConyuge)) );
			//debug($elRutConyuge);
		}
		/***/
		/*
		if( $res <= 0 ){
			$res = $this->Conyuge->find('count', array('conditions'=>array('beneficiario_id' => $idBeneficiario)) );
			echo '2: '.$res.'<br>';
		}
		*/
		
		return $res;
	}
	
	public function tiene_conyuge($data = null){		
		$tiene_conyuge = $this->ver_string($data['rut'])
										+$this->ver_string($data['nombres'])
										+$this->ver_string($data['apellidos'])
										+$this->ver_string($data['estcivil_id']);
		
		/****
		$tiene_conyuge = 1;
		if( strlen(trim($data['rut'])) == 0 && trim($data['rut']) == '' ){
			// $tiene_conyuge = 0;
			if( strlen(trim($data['nombres'])) == 0 && trim($data['nombres']) == '' ){
				// $tiene_conyuge = 0;
				if( strlen(trim($data['apellidos'])) == 0 && trim($data['apellidos']) == '' ){
					// $tiene_conyuge = 0;
					if( strlen(trim($data['estcivil_id'])) == 0 && trim($data['estcivil_id']) == '' ){ 
						$tiene_conyuge = 0;
					}
				}
			}
		}else{
			if( strlen(trim($data['nombres'])) == 0 && trim($data['nombres']) == '' ){
				
			}
		}
		****/
		/*
		.strlen(trim($this->data['Conyuge']['nombres']))
		.strlen(trim($this->data['Conyuge']['apellidos']))
		.strlen(trim($this->data['Conyuge']['estcivil_id']))
		*/
		return $tiene_conyuge;
	}
	/*private function ver_string($el_string=null){
		return ( trim($el_string) == '' ? 1 : 0 );
	}*/
	
	
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
			// debug($array_datos);
			// $this->busca_conyugue($array_datos['rut']);
			$this->Conyuge->read(null, $array_datos['id']);
			$this->Conyuge->set($array_datos);
			return $this->Conyuge->save();
		}else{
			return false;
		}
	}
	
	public function borra_conyugue($idBeneficiario = null){
		if( $this->Conyuge->deleteAll(array('beneficiario_id'=>$idBeneficiario)) ){
			return true;
		}else{
			return false;
		}
	}
	
	public function agrega_beneficiario_servicio($idBeneficiario = null, $idServicio = null){
		if( $idServicio <= 0 ){ return -1; }
		if( $this->beneficiarios_servicio->find('count', array('conditions'=> array('beneficiario_id'=>$idBeneficiario))) > 0 ){
			$this->beneficiarios_servicio->updateAll( array('servicio_id' => $idServicio), array('beneficiario_id' => $idBeneficiario));
			return 1;
		}else{
			$this->beneficiarios_servicio->create();
			if( $this->beneficiarios_servicio->save(array('servicio_id' => $idServicio, 'beneficiario_id' => $idBeneficiario)) ){
				return 1;
			}
		}
		return 0;
	}
	
	public function busca_beneficiario_servicio($idBeneficiario = null){
		$varX = $this->beneficiarios_servicio->find('all', array('conditions'=> array('beneficiario_id'=>$idBeneficiario) ) );
		return $varX;
	}
	
	
}