<?php 
//dApp::uses('AppController', 'Controller');
//App::uses('CakeEmail', 'Network/Email');
//App::uses('FuncionesHelper', 'View/Helper');    
class BeneficiariosController extends AppController {
	//var $scaffold;
	var $uses = array('Beneficiario', 'Estcivil');
	
	var $paginate = array(
        'limit' => 15,
		/* 'fields' => array('id', 'rut', 'dv', 'nombres', 'paterno', 'materno', 'estcivil_id'), */
		/* 'fields' => array('*'), */
		 'fields' => array('Beneficiario.id', 'Beneficiario.rut', 'Beneficiario.dv', 'Beneficiario.nombres', 'Beneficiario.paterno', 'Beneficiario.materno', 'Beneficiario.estcivil_id', 'Estcivil.descripcion'),
		'order' => array('Beneficiario.rut' => 'asc'),
		'conditions' => array('Beneficiario.activo' =>1)
		
       /* 'contain' => array('Article')*/
    );
	
	public function beforeFilter(){ 
		parent::beforeFilter();
	//	$this->Auth->allow('*');
	}
	
	public function index(){
		//$fields = array('id', 'rut', 'dv', 'nombres', 'paterno', 'materno', 'estcivil_id');
		$conditions = '';
		// echo '<pre>passedArgs:'.print_r($this->passedArgs, 1).'</pre>';
		if( !empty($this->data) ){
			//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
			if( strlen($this->data['Beneficiario']['nombre_benef'])>=3 ){
				$conditions = $this->Beneficiario->filtro_index($this->data['Beneficiario']['nombre_benef']);
				array_push($conditions, array('Beneficiario.activo' =>1) );
				$this->paginate = array('limit' => 200);
				//echo '<pre>conditions:'.print_r($conditions, 1).'</pre>';
			}
		}
		//// $listado = $this->Beneficiario->find('all', array('fields' => $fields, 'conditions' => $conditions ) );
		$this->Beneficiario->recursive = 2;
		$listado = $this->paginate('Beneficiario',  array( $conditions ) );
		/// echo 'listado: <pre>'.print_r($listado, 1).'</pre>';
		$this->set(compact('listado', 'conditions'));
	}
	
	public function agrega(){
		if( !empty($this->data) ){
			if( isset($this->data['Beneficiario']['rut']) && strlen($this->data['Beneficiario']['rut'])<= 12 && strlen($this->data['Beneficiario']['rut'])>=11 ){
				$elRut = $this->Beneficiario->saca_str_rut($this->data['Beneficiario']['rut']);
				$this->data['Beneficiario']['rut'] = $elRut[0];
				$this->data['Beneficiario']['dv'] = $elRut[1];
				$existe_rut = $this->Beneficiario->existe_rut($elRut[0]);
				//echo '<pre>existe_rut:'.isset($existe_rut).', '.is_array($existe_rut).', '.count($existe_rut).'</pre>';
				//echo '<pre>existe_rut:'.print_r($existe_rut, 1).'</pre>';
				if( is_array($existe_rut) ){
					$nombre = trim($existe_rut['Beneficiario']['nombres']).' '.trim($existe_rut['Beneficiario']['paterno']).' '.trim($existe_rut['Beneficiario']['materno']);
					$this->Session->setFlash('El Rut existe en la base de datos ('.$nombre.'), verifique. ', 'sin_id');
					//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
				}else{
					/*
					$this->Beneficiario->create($this->data['Beneficiario']);
					if( $this->Beneficiario->save() ){
						$idRegistro = $this->Beneficiario->id;
						$this->Session->setFlash('Se ha agregado un registro.'.$idRegistro, 'guardado');
						$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$idRegistro));
					}
					*/
					$this->Session->setFlash('Se ha agregado un registro.', 'guardado');
				}
			}else{
				$this->Session->setFlash('El Rut no es valido, verifique. ', 'sin_id');
				//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
			}
			//echo '<pre>elRut:'.print_r($elRut, 1).'</pre>';
			//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
		}
		$estados_civil = $this->Estcivil->find('list', array('fields'=>array('id', 'descripcion')) );
		$this->set( array( 'estados_civil' => $estados_civil ) );
	}
	
	public function edita(){
		$id_deneficiario = 0;
		if( !empty($this->data) ){
			
			//$this->data['Beneficiario']['rut'] = $this->Beneficiario->saca_rut($this->data['Beneficiario']['rut']);
			// echo '<pre>data- saca_rut:'.print_r($this->Beneficiario->saca_rut($this->data['Beneficiario']['rut']), 1).'</pre>';
			//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
			
			if( !isset($this->data['Beneficiario']['rut']) ){
				$this->Session->setFlash('Id no valido, verifique.', 'sin_id');
				$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
			}
			
			$elRut = $this->Beneficiario->saca_str_rut($this->data['Beneficiario']['rut']);
			$this->data['Beneficiario']['rut'] = $elRut[0];
			$this->data['Beneficiario']['dv'] = $elRut[1];
				
			$this->data['Beneficiario']['sueldo_base'] = $this->Beneficiario->saca_str_monto($this->data['Beneficiario']['sueldo_base']);
			
			if( !isset($this->passedArgs['id']) ){ $id_deneficiario = $this->data['Beneficiario']['id']; }
			
			$this->Beneficiario->read(null, $id_deneficiario);
			$this->Beneficiario->set($this->data['Beneficiario']);
			if( $this->Beneficiario->save() ){
				$this->Session->setFlash('Se actualizado el registro', 'guardado');
				$this->redirect(array('controller' => 'beneficiarios',  'id'=>$id_deneficiario));
			}
		}
		
		if( isset($this->passedArgs['id']) ){ $id_deneficiario = $this->passedArgs['id']; }
		
		if( !is_numeric($id_deneficiario) || $id_deneficiario <=0 || strlen($id_deneficiario)<=0 ){
			$this->Session->setFlash('Id no valido, verifique.', 'sin_id');
			$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
		}	
		
		//$this->Beneficiario->read(null, $this->passedArgs['id']);
		// echo '<pre>this:'.print_r($this, 1).'</pre>';
		//echo '<pre>this:'.print_r($this->Beneficiario->data , 1).'</pre>';
		//echo '<pre>passedArgs:'.print_r($this->passedArgs, 1).'</pre>'.$this->passedArgs['id'];
		//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
		
		$datos = $this->Beneficiario->read(null, $id_deneficiario);
		//echo '<pre>datos:'.print_r($datos, 1).'</pre>';
		//echo '-> '.count($datos['Beneficiario']).'|';
		//echo '-> '.count($datos).'|';
		
		if( (count($datos) <= 1) && (count($datos['Beneficiario'])<= 0) ){
			$this->Session->setFlash('Id no existe, verifique.', 'sin_id');
			$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
		}
		
		$estados_civil = $this->Estcivil->find('list', array('fields'=>array('id', 'descripcion')) );
		$this->set( array( 'datos' => $datos,
						   'estados_civil' => $estados_civil 
						 )
				  );
	}

	public function borra($id_deneficiario = null){
		$this->render(false);
		if( strlen($id_deneficiario)>0 && $id_deneficiario > 0 && is_numeric($id_deneficiario) ){
			//echo '<pre>id_deneficiario:'.print_r($id_deneficiario, 1).'</pre>';
			//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
			/*
			echo '<pre>Beneficiario:'.print_r($this->Beneficiario->read(array('activo'), $id_deneficiario), 1).'</pre>';
			*/
			$this->Beneficiario->id = $id_deneficiario; 
   			$this->Beneficiario->read(array('activo')); 
			//echo '<pre>Beneficiario:'.print_r($this->Beneficiario, 1).'</pre>';
			$this->Beneficiario->saveField('activo', 0);			
		}/*else{
			$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
		}*/
		$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
	}
	
}
?>