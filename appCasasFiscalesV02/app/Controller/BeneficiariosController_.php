<?php 
//dApp::uses('AppController', 'Controller');
//App::uses('CakeEmail', 'Network/Email');
//App::uses('FuncionesHelper', 'View/Helper');    

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

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
		if ($this->request->is('post')) {
			if( isset($this->data['Beneficiario']['rut']) && strlen($this->data['Beneficiario']['rut'])<= 12 && strlen($this->data['Beneficiario']['rut'])>=11 ){
				$elRut = $this->Beneficiario->saca_str_rut($this->data['Beneficiario']['rut']);

				$this->request->data['Beneficiario']['rut'] = $elRut[0];
				$this->request->data['Beneficiario']['dv'] = $elRut[1];
				//echo '<pre>this->request->data:'.print_r($this->request->data, 1).'</pre>';
				//echo '<pre>elRut:'.print_r($elRut, 1).'</pre>';
				
				$this->request->data['Beneficiario']['created'] = date("d-m-Y H:i:s");
				$this->request->data['Beneficiario']['activo'] = 1;
				
				$existe_rut = $this->Beneficiario->existe_rut($elRut[0]);
				//echo '<pre>existe_rut:'.isset($existe_rut).', '.is_array($existe_rut).', '.count($existe_rut).'</pre>';
				//echo '<pre>existe_rut:'.print_r($existe_rut, 1).'</pre>';
				if( is_array($existe_rut) && count($existe_rut)>=1 ){
					$nombre = trim($existe_rut['Beneficiario']['nombres']).' '.trim($existe_rut['Beneficiario']['paterno']).' '.trim($existe_rut['Beneficiario']['materno']);
					$this->Flash->sin_id('El Rut existe en la base de datos ('.$nombre.'), verifique. ');
					//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
				}else{
					if(1){
						$this->Beneficiario->create();
						if( $this->Beneficiario->save($this->request->data['Beneficiario']) ){
							$idRegistro = $this->Beneficiario->id;
							$this->Flash->guardado('Se ha agregado un registro.'.$idRegistro);
							$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$idRegistro));
						}
					}else{
						$this->Flash->guardado('Se ha agregado un registro.<pre>'.print_r($this->request->data['Beneficiario'], 1).'</pre>');
					}
				}
			}else{
				$this->Flash->sin_id('El Rut no es valido, verifique. ');
				//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
			}
			//echo '<pre>elRut:'.print_r($elRut, 1).'</pre>';
			//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
		}
		
		$HttpSocket = new HttpSocket();
		$resultsSocket = $HttpSocket->get('http://192.168.200.113:8080/tests/setSocketCasasFiscales.php', 'q=cakephp');
		$escalafon = json_decode($resultsSocket->body, 1);
		//$escalafon = json_decode($resultsSocket['body'], 1);
		//echo '<pre>resultsSocket:'.print_r($escalafon, 1).'</pre>';
		if( !is_array($escalafon) ){ $escalafon = ''; }
		
		$estados_civil = $this->Estcivil->find('list', array('fields'=>array('id', 'descripcion')) );
		$this->set( array( 'estados_civil' => $estados_civil,
						  'escalafon' => $escalafon)
				  );
	}
	
	public function edita(){
		$id_deneficiario = 0;
		$msg ='';
		if ($this->request->is('post')) {
			
			//$this->data['Beneficiario']['rut'] = $this->Beneficiario->saca_rut($this->data['Beneficiario']['rut']);
			// echo '<pre>data- saca_rut:'.print_r($this->Beneficiario->saca_rut($this->data['Beneficiario']['rut']), 1).'</pre>';
			echo '<pre>data:'.print_r($this->data, 1).'</pre>';
			$msg = '<pre>data:'.print_r($this->data, 1).'</pre>';

			if( !isset($this->data['Beneficiarios']['rut']) ){
				$this->Flash->sin_id('Id no valido, no existe, verifique.'.$msg);
				$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
			}

			$elRut = $this->Beneficiario->saca_str_rut($this->data['Beneficiarios']['rut']);
			
			//$this->data['Beneficiario']['rut'] = $elRut[0];
			//$this->data['Beneficiario']['dv'] = $elRut[1];
			//$this->data['Beneficiario']['sueldo_base'] = $this->Beneficiario->saca_str_monto($this->data['Beneficiario']['sueldo_base']);
			
			if( !isset($this->passedArgs['id']) ){ $id_deneficiario = $this->data['Beneficiarios']['id']; }
			else{$id_deneficiario = $this->passedArgs['id'];}
			
			$this->Beneficiario->read(null, $id_deneficiario);
			/*
			$this->Beneficiario->set('rut', $elRut[0] );
			$this->Beneficiario->set('dv', $elRut[1] );
			$this->Beneficiario->set('sueldo_base', $this->Beneficiario->saca_str_monto($this->data['Beneficiario']['sueldo_base']) );
			$this->Beneficiario->set('created', date("d-m-Y H:i:s") );
			*/
			//$this->Beneficiario->actualizar($elRut);
			$this->Beneficiario->set(array(
				'rut' =>  $elRut[0],
				'dv' =>  $elRut[1],
				'nombres' => $this->data['Beneficiarios']['nombres'],
				'paterno' => $this->data['Beneficiarios']['paterno'],
				'materno' => $this->data['Beneficiarios']['materno'],
				'estcivil_id' => $this->data['Beneficiarios']['estcivil_id'],
				'email' => $this->data['Beneficiarios']['email'],
				'celular' => $this->data['Beneficiarios']['celular'],
				'escalafon' => $this->data['Beneficiarios']['escalafon'],
				'grado' => $this->data['Beneficiarios']['grado'],
				'cumple' => $this->data['Beneficiarios']['cumple'],
				'sueldo_base' => $this->Beneficiario->saca_str_monto($this->data['Beneficiarios']['sueldo_base']),
				'created' => date("d-m-Y H:i:s")
			));			
			if( $this->Beneficiario->save() ){
				//$this->Flash->guardado($id_deneficiario.'Se actualizado el registro'.$msg, 'guardado');
				$this->Flash->guardado('Registro actualizado.');
				// $this->Flash->guardado('Se actualizado el registro'.$msg);
				$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
			}
		}
		
		if( isset($this->passedArgs['id']) ){ $id_deneficiario = $this->passedArgs['id']; }
		
		if( !is_numeric($id_deneficiario) || $id_deneficiario <=0 || strlen($id_deneficiario)<=0 ){
			// $this->Session->setFlash('Id no valido, verifique.', 'sin_id');
			$this->Flash->sin_id('Id no valido, or verifique.'.$msg.'-----');
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
			$this->Flash->sin_id('Id no existe, verifique...');
			$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
		}
		
		$HttpSocket = new HttpSocket();
		$resultsSocket = $HttpSocket->get('http://192.168.200.113:8080/tests/setSocketCasasFiscales.php', 'q=cakephp');
		$escalafon = json_decode($resultsSocket->body, 1);
		//$escalafon = json_decode($resultsSocket['body'], 1);
		//echo '<pre>resultsSocket:'.print_r($escalafon, 1).'</pre>';
		if( !is_array($escalafon) ){ $escalafon = ''; }
		
		$estados_civil = $this->Estcivil->find('list', array('fields'=>array('id', 'descripcion')) );
		$this->set( array( 'datos' => $datos,
						   'estados_civil' => $estados_civil,
						   'escalafon' => $escalafon 
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