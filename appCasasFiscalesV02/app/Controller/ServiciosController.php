<?php 
//App::uses('AppController', 'Controller');
//App::uses('CakeEmail', 'Network/Email');
//App::uses('FuncionesHelper', 'View/Helper');
App::uses('HttpSocket', 'Network/Http');
class ServiciosController extends AppController {
	//var $uses = array('Beneficiario', 'Estcivil');
	
	var $paginate = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('edita');
	}
	
	//public function isAuthorized($user = null) { return true;}
	
	public function index(){
		$conditions = array('Servicio.activo' =>1);
		if( !empty($this->data) ){
			if( strlen($this->data['Servicio']['nombre'])>=3 ){
				$conditions = $this->Servicio->filtro_index(trim($this->data['Servicio']['nombre']));
				array_push($conditions, array('Servicio.activo' =>1) );
				$this->paginate = array('limit' => 200);
			}
		}
		$listado = $this->paginate('Servicio',  array( $conditions ) );
		$this->set(compact('listado', 'conditions'));
	}
	
	public function agrega(){
		if ($this->request->is('post')) {
		if(0):
			echo '<pre>data:'.print_r($this->data, 1).'</pre>'.'<pre>validates:'.print_r($this->Servicio->validates(), 1).'</pre>';
		else:
			if( isset($this->data['Servicio']['rut']) && strlen($this->data['Servicio']['rut'])<= 12 && strlen($this->data['Servicio']['rut'])>=11 ){
				
				// $elRut = $this->Servicio->saca_str_rut($this->data['Servicio']['rut']);
				/*** EVALUA SI EL RUT TRAE PUNTOS ***/
				$elRut = trim($this->data['Servicio']['rut']);
				if( strpos($elRut, '.') >= 1 ){
					$elRut = $this->Servicio->saca_str_rut($elRut);
					$elRut = $elRut[0].'-'.$elRut[1];
				}

				$this->request->data['Servicio']['rut'] = $elRut;
				///$this->request->data['Servicio']['dv'] = $elRut[1];
				//echo '<pre>this->request->data:'.print_r($this->request->data, 1).'</pre>';
				//echo '<pre>elRut:'.print_r($elRut, 1).'</pre>';
				
				$this->request->data['Servicio']['created'] = date("d-m-Y H:i:s");
				$this->request->data['Servicio']['activo'] = 1;
				
				$existe_rut = $this->Servicio->existe_rut($elRut[0]);
				//echo '<pre>existe_rut:'.isset($existe_rut).', '.is_array($existe_rut).', '.count($existe_rut).'</pre>';
				//echo '<pre>existe_rut:'.print_r($existe_rut, 1).'</pre>';
				if( is_array($existe_rut) && count($existe_rut)>=1 ){
					$nombre = trim($existe_rut['Servicio']['nombres']).' '.trim($existe_rut['Servicio']['paterno']).' '.trim($existe_rut['Servicio']['materno']);
					$this->Flash->sin_id('Servicio - El Rut existe en la base de datos ('.$nombre.'), verifique. ');
					//$this->redirect(array('controller' => 'servicios', 'action'=>'index'));
				}else{
					///$this->request->data['Conyuge']['rut'] = trim(str_replace('.', '', $this->request->data['Conyuge']['rut']));
					if(0){
						$this->Flash->guardado('Servicio - Se ha agregado un registro.<pre>'.print_r($this->request->data, 1).'</pre>');
					}else{
						$this->Servicio->create();
						if( $this->Servicio->save($this->request->data['Servicio']) ){
							$idRegistro = $this->Servicio->id;
							$this->Flash->guardado('Servicio - Se ha agregado un nuevo registro.'.$idRegistro);
							$this->redirect(array('controller' => 'servicios', 'action'=>'edita', 'id'=>$idRegistro));
						}else{
							$this->Flash->sin_id('Servicio - No pudo agregarse.<pre>'.print_r($this->request->data, 1).'</pre>');
						}
					}
				}
			}else{
				$this->Flash->sin_id('Servicio - El Rut no es valido, verifique. ');
			}
		endif;
		}
		// $this->set();
	}
	
	public function edita(){
		//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
		$id_servicio = 0;
		$msg ='';
		$losValidates = $this->Servicio->invalidFields();
		if ($this->request->is('post')) {
				$msg = '<pre>data:'.print_r($this->data, 1).'</pre>';
				if(0):
						echo '<pre>data:'.print_r($this->data, 1).'</pre>'.
									'<pre>validates:'.print_r($this->Servicio->validates(), 1).'</pre>'.
									'strpos . :'.strpos($this->data['Servicio']['rut'], '.').
									'saca_str_rut :'.print_r($this->Servicio->saca_str_rut($this->data['Servicio']['rut'], '.'), 1);
				else:	
						if( !isset($this->data['Servicio']['rut']) ){
							$this->Flash->sin_id('Servicio - Id no valido, no existe, verifique.'.$msg);
							$this->redirect(array('controller' => 'servicios', 'action'=>'index'));
						}
						
						/*** EVALUA SI EL RUT TRAE PUNTOS ***/
						$elRut = trim($this->data['Servicio']['rut']);
						if( strpos($elRut, '.') >= 1 ){
							$elRut = $this->Servicio->saca_str_rut($elRut);
							$elRut = $elRut[0].'-'.$elRut[1];
						}

						if( !isset($this->passedArgs['id']) ){ $id_servicio = $this->data['Servicio']['id']; }
						else{$id_servicio = $this->passedArgs['id'];}

						$this->Servicio->read(null, $id_servicio);
						$this->Servicio->set(array(
							//'rut' =>  $elRut[0],
							'rut' =>  $elRut,
							'nombre' => trim($this->data['Servicio']['nombre']),
							'siglas' => trim($this->data['Servicio']['siglas']),
							'jefe_servicio' => trim($this->data['Servicio']['jefe_servicio']),
							'subrogante' => trim($this->data['Servicio']['subrogante']),
							'direccion' => trim($this->data['Servicio']['direccion']),
							'telefonos' => trim($this->data['Servicio']['telefonos']),
							'email' => trim($this->data['Servicio']['email'])
						));

						if( $this->Servicio->validates() ){
							if( $this->Servicio->save() ){
								$this->Flash->guardado('Servicio - Se ha actualizado un registro.');
								$this->redirect(array('controller' => 'servicios', 'action'=>'edita', 'id'=>$id_servicio));
							}
						}else{
							$losValidates = $this->Servicio->invalidFields();
							// $this->Flash->error('Error en la edicion, verifique... <pre>'.print_r($losValidates,1).'</pre>');
							$this->Flash->error('Servicio - Error en la edicion, verifique...');
							$this->Session->write('losValidates', $losValidates);
							$this->redirect(array('controller' => 'servicios', 'action'=>'edita', 'id'=>$id_deneficiario));
						}
			endif;
		}

		if( isset($this->passedArgs['id']) ){ $id_servicio = $this->passedArgs['id']; }
		
		if( !is_numeric($id_servicio) || $id_servicio <=0 || strlen($id_servicio)<=0 ){
			// $this->Session->setFlash('Id no valido, verifique.', 'sin_id');
			$this->Flash->sin_id('Servicio - Id no valido, or verifique.'.$msg.'-----');
			$this->redirect(array('controller' => 'servicios', 'action'=>'index'));
		}	
		$datos = $this->Servicio->read(null, $id_servicio);
		if( (count($datos) <= 1) && (count($datos['Servicio'])<= 0) ){
			$this->Flash->sin_id('Servicio - Id no existe, verifique...');
			$this->redirect(array('controller' => 'servicios', 'action'=>'index'));
		}
		$this->set( array( 'datos' => $datos ) );	
	}

	public function borra($id_servicio = null){
		$this->render(false);
		if( strlen($id_servicio)>0 && $id_servicio > 0 && is_numeric($id_servicio) ){
			$this->Servicio->id = $id_servicio; 
   		$this->Servicio->read(array('activo')); 
			$this->Servicio->saveField('activo', 0); // INACTIVO, BORRADO...
			// FALTA LA LLAMADA AL METODO pago->morosas()
		}
		$this->redirect(array('controller' => 'servicios', 'action'=>'index'));
	}

}
?>