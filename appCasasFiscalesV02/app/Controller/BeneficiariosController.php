<?php 
//dApp::uses('AppController', 'Controller');
//App::uses('CakeEmail', 'Network/Email');
//App::uses('FuncionesHelper', 'View/Helper');
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
	
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('login');
  }
	//public function isAuthorized($user = null) { return true;}
	
	public function index(){
		//echo 'Beneficiario: <pre>'.print_r($this->Estcivil, 1).'</pre>';
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
		
		$this->loadModel('beneficiarios_servicio');
		$this->beneficiarios_servicio->bindModel(array('belongsTo' =>array('Servicio' => array('className' => 'Servicio', 'foreignKey' => 'servicio_id'))));
		//echo 'beneficiarios_servicio: <pre>'.print_r($this->beneficiarios_servicio, 1).'</pre>';
		
		$this->Beneficiario->recursive = 2;
		$listado = $this->paginate('Beneficiario',  array( $conditions ) );
		//echo 'listado: <pre>'.print_r($listado[0], 1).'</pre>';
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
					$this->Flash->benef_existe('El Rut existe en la base de datos ('.$nombre.'), verifique. ');
					//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
				}else{

					///$this->request->data['Conyuge']['rut'] = trim(str_replace('.', '', $this->request->data['Conyuge']['rut']));

					if(0):
						if( $this->Beneficiario->validates() ){
						/*	if( $this->Beneficiario->save() ){
								$this->Flash->guardado('Beneficiario - Se ha actualizado un registro.');
								$this->redirect(array('controller' => 'servicios', 'action'=>'edita', 'id'=>$id_servicio));
							}
						*/
							$this->Flash->guardado('Beneficiario - Se ha actualizado un registro.');
							//$this->redirect(array('controller' => 'servicios', 'action'=>'edita', 'id'=>$id_servicio));
						}else{
							$losValidates = $this->Beneficiario->invalidFields();
							// $this->Flash->error('Error en la edicion, verifique... <pre>'.print_r($losValidates,1).'</pre>');
							$this->Flash->error('Beneficiario - Error en la edicion, verifique...');
							$this->Session->write('losValidates', $losValidates);
							//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_servicio));
						}
						echo 'Se ha agregado un registro.<pre>'.print_r($this->request->data, 1).'</pre>';
					endif;
					
					//echo 'request_data:<pre>'.print_r($this->request->data, 1).'</pre>';
					if(1){
						$this->Beneficiario->create();
						if( $this->Beneficiario->save($this->request->data['Beneficiario']) ){
							$idRegistro = $this->Beneficiario->id;
							// $this->Beneficiario->tiene_conyuge($this->data['Conyuge']);							
							/****
							echo '<pre>dataConyuge:'.print_r($this->data['Conyuge'], 1).'</pre>'
								.strlen(trim($this->data['Conyuge']['rut']))
								.strlen(trim($this->data['Conyuge']['nombres']))
								.strlen(trim($this->data['Conyuge']['apellidos']))
								.strlen(trim($this->data['Conyuge']['estcivil_id']))
								.'<br>.....fin';
							****/
							/*****/
							/***if(1){***/
							if( $this->Beneficiario->tiene_conyuge($this->data['Conyuge'] ) == 0 ){
								$this->request->data['Conyuge']['beneficiario_id'] = $idRegistro;
								$this->request->data['Conyuge']['created'] = date("d-m-Y H:i:s");
								if( $this->Beneficiario->agrega_conyugue($this->request->data['Conyuge']) ){
									$this->Flash->guardado('Se ha agregado un nuevo registro.'.$idRegistro);
									//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$idRegistro));
								}else{ $this->Flash->sin_id('No se pudo registrarse, verifique.'); }
							}else{ $this->Flash->guardado('Se ha agregado un nuevo registro.'); }
							$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$idRegistro));
							/***}***/
							/**** DEPRECADO else{
								// $this->data['Conyuge']['id'] /*** $this->data DEPRECADO *** /
								$this->Beneficiario->Conyuge->read(null, $this->request->data['Conyuge']['id']);
								$this->request->data['Conyuge']['rut'] = trim(str_replace('.', '', $this->request->data['Conyuge']['rut']));
								$this->Beneficiario->Conyuge->set($this->request->data['Conyuge']);
								$this->Beneficiario->Conyuge->save();
							}****/
							/*****/
							/*****
							$this->Flash->guardado('Se ha agregado un registro.'.$idRegistro);
							$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$idRegistro));
							*****/
							// $this->Flash->guardado('Se ha agregado un nuevo registro.'.$idRegistro);
						}else{ $this->Flash->error('No se pudo agregarce... Verifique'); }
					}else{
						/**** DEBUG ****/
						echo '<pre>data:'.print_r($this->data, 1).'</pre>';
						echo '<pre>dataConyuge:'.print_r($this->Beneficiario->tiene_conyuge($this->data['Conyuge']), 1).'</pre>';
						$tieneConyuge = 'NO tiene conyuge.';
						if($this->Beneficiario->tiene_conyuge($this->data['Conyuge']) == 0){
							$tieneConyuge = 'tiene conyuge.';
						}
						//$this->Flash->guardado('DEBUG - Se ha agregado un registro.<pre>'.print_r($this->request->data, 1).'</pre>'.'<br>'.$tieneConyuge);
						$this->Flash->exito('DEBUG - Se ha agregado un registro.'.'<br>'.$tieneConyuge);
						//$this->Flash->guardado('Se ha agregado un registro.<pre>'.print_r($this->request->data['Beneficiario'], 1).'</pre>');
					}
				}
			}else{
				// $this->Flash->sin_id('El Rut no es valido, verifique. ');
				//$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
			}
			//echo '<pre>elRut:'.print_r($elRut, 1).'</pre>';
			//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
		}
		
		$HttpSocket = new HttpSocket();
		$resultsSocket = $HttpSocket->get($this->urlSocket, array('gabriel'=>0, 'tbl'=>0)) ;
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
		
		$this->loadModel('Servicio');
		$this->loadModel('beneficiarios_servicio');
		$this->loadModel('Arriendos_historial');
		
		$id_deneficiario = 0;
		$msg ='';
		$losValidates = $this->Beneficiario->invalidFields();
		if ($this->request->is('post')) {
			/***
			//$this->data['Beneficiario']['rut'] = $this->Beneficiario->saca_rut($this->data['Beneficiario']['rut']);
			// echo '<pre>data- saca_rut:'.print_r($this->Beneficiario->saca_rut($this->data['Beneficiario']['rut']), 1).'</pre>';
			//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
			***/
			$msg = '<pre>data:'.print_r($this->data, 1).'</pre>';
			//echo '<pre>data:'.print_r($this, 1).'</pre>';

			if( !isset($this->data['Beneficiario']['rut']) ){
				$this->Flash->sin_id('Id no valido, no existe, verifique.'.$msg);
				$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
			}

			$elRut = $this->Beneficiario->saca_str_rut($this->data['Beneficiario']['rut']);
			
			/***
			this->data['Beneficiario']['rut'] = $elRut[0];
			//$this->data['Beneficiario']['dv'] = $elRut[1];
			//$this->data['Beneficiario']['sueldo_base'] = $this->Beneficiario->saca_str_monto($this->data['Beneficiario']['sueldo_base']);
			***/
			
			if( !isset($this->passedArgs['id']) ){ $id_deneficiario = $this->data['Beneficiario']['id']; }
			else{$id_deneficiario = $this->passedArgs['id'];}
			
			$this->Beneficiario->read(null, $id_deneficiario);
			/***
			$this->Beneficiario->set('rut', $elRut[0] );
			$this->Beneficiario->set('dv', $elRut[1] );
			$this->Beneficiario->set('sueldo_base', $this->Beneficiario->saca_str_monto($this->data['Beneficiario']['sueldo_base']) );
			$this->Beneficiario->set('created', date("d-m-Y H:i:s") );
			***/
			//$this->Beneficiario->actualizar($elRut);
			$this->Beneficiario->set(array(
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
				'cumple' => $this->data['Beneficiario']['cumple'],
				'sueldo_base' => $this->Beneficiario->saca_str_monto($this->data['Beneficiario']['sueldo_base']),
				'created' => date("d-m-Y H:i:s")
			));
			
			/*** SECCION QUE GUARDA ***/
			if( $this->Beneficiario->validates() ){
				if( $this->Beneficiario->save() ){
					
					$this->request->data['beneficiario_servicio']['beneficiario_id'] = $this->request->data['Beneficiario']['id'];
					unset($this->request->data['beneficiario_servicio']['nombre']);
					$asociarServicio = $this->Beneficiario->agrega_beneficiario_servicio($this->request->data['beneficiario_servicio']['beneficiario_id'], 
																																							 $this->request->data['beneficiario_servicio']['servicio_id']);
					
					if(1){
						$msgAsociar = '';
						$this->request->data['beneficiario_servicio']['beneficiario_id'] = $this->request->data['Beneficiario']['id'];
						// unset($this->request->data['beneficiario_servicio']['nombre']);
						$asociarServicio = $this->Beneficiario->agrega_beneficiario_servicio($this->request->data['beneficiario_servicio']['beneficiario_id'], 
																																								 $this->request->data['beneficiario_servicio']['servicio_id']);
						if( $asociarServicio <=0 ){ $msgAsociar = '<br>No se pudo asociar el Servicio'; }

						
						// 0 nuevo conyuge, benefi sin conyuge, INSERSION
						// 1 nuevo conyuge, benefi CON conyuge, ACTUALIZACION
						// 2 conyuge VIEJO, benefi CON conyuge, ACTUALIZACION
						// 3 conyuge VIEJO, benefi sin conyuge, INSERSIONl
						
						/**** /
						if( $tieneConyuge <= 0 ){
							if( $this->Beneficiario->agrega_conyugue($this->request->data['Conyuge']) ){
								$this->Flash->guardado('Se ha agregado un nuevo registro con conyuge.');
								// $this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
							}else{
								$this->Flash->sin_id('No pudo registrarse, verifique.');
							}
						}else{							
							if( $tieneConyuge >= 1 ){
								if($this->Beneficiario->edita_conyugue($this->request->data['Conyuge'])){
									$this->Flash->guardado('ATENCION !!!<br>Este conyugue ya esta asignado, <br>Se ha actualizado un registro con conyuge.');
									// $this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
								}
							}else{
								if($this->Beneficiario->edita_conyugue($this->request->data['Conyuge'])){
									$this->Flash->guardado('Se ha actualizado un registro.');
									// $this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
								}else{
									$this->Flash->sin_id('No pudo registrarse, verifique.');
									// $this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
								}
							}
						}
						/* ***/
						
						/*** Conyuge ***/
						if( strlen(trim($this->request->data['Conyuge']['rut'])) == 0 ){
							//debug($this->request->data['Conyuge']['beneficiario_id']);
							$tieneConyuge = $this->Beneficiario->busca_conyugue_beneficiario($this->request->data['Conyuge']['beneficiario_id']);
							// debug($tieneConyuge);
							if( isset($tieneConyuge[0]['Conyuge']['id']) 
								 && isset($tieneConyuge[0]['Conyuge']['beneficiario_id']) 
								 && $tieneConyuge[0]['Conyuge']['beneficiario_id'] == $this->request->data['Conyuge']['beneficiario_id'] ){
								$this->Beneficiario->borra_conyugue($this->request->data['Conyuge']['beneficiario_id']);
								$this->Flash->guardado('Registro eliminado.');
								$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
							}
						}
						
						$this->request->data['Conyuge']['created'] = date("d-m-Y H:i:s");
						if($this->Beneficiario->edita_conyugue($this->request->data['Conyuge'])){
							// $this->Flash->guardado('Conyuge - Se ha actualizado un registro.'.$msgAsociar);
							$this->Flash->guardado('Se ha actualizado un registro con Conyuge.'.$msgAsociar);
						}else{
							// $this->Flash->exito('Conyuge - No pudo registrarse, verifique.');
							$this->Flash->exito('Registro actualizado sin Conyuge...');
						}
						$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
					
					}else{
						
					  //	$this->Flash->guardado( 'Registro'.print_r($this->request->data, 1) );
						//$this->Flash->guardado('Registro'.print_r($this->request->data['Conyuge']),1);
						echo '<pre>valor'.print_r($valor, 1),'</pre>'.$valor;
						echo '<pre>Registro'.print_r($this->request->data, 1),'</pre>';
						
						/****
						// $this->data['Conyuge']['id'] /*** $this->data DEPRECADO *** /
						$this->Beneficiario->Conyuge->read(null, $this->request->data['Conyuge']['id']);
						$this->request->data['Conyuge']['rut'] = trim(str_replace('.', '', $this->request->data['Conyuge']['rut']));
						$this->Beneficiario->Conyuge->set($this->request->data['Conyuge']);
						$this->Beneficiario->Conyuge->save();
						*****/
					}
					
					
					/*****
					//$this->Flash->guardado($id_deneficiario.'Se actualizado el registro'.$msg, 'guardado');
					$this->Flash->guardado('Registro actualizado.');
					//$this->Flash->guardado('Registro actualizado.'.$msg);
					// $this->Flash->guardado('Se actualizado el registro'.$msg);
					$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
					*****/
				}else{
					$this->Flash->error('No se ha actualizado el registro, verifique...');
				}
			}else{
				$losValidates = $this->Beneficiario->invalidFields();
				// $this->Flash->error('Error en la edicion, verifique... <pre>'.print_r($losValidates,1).'</pre>');
				$this->Flash->error('Error en la edicion, verifique...');
				$this->Session->write('losValidates',$losValidates);
				$this->redirect(array('controller' => 'beneficiarios', 'action'=>'edita', 'id'=>$id_deneficiario));
			}
		}
		
		if( isset($this->passedArgs['id']) ){ $id_deneficiario = $this->passedArgs['id']; }
		
		if( !is_numeric($id_deneficiario) || $id_deneficiario <=0 || strlen($id_deneficiario)<=0 ){
			// $this->Session->setFlash('Id no valido, verifique.', 'sin_id');
			$this->Flash->sin_id('Id no valido, or verifique.'.$msg.'-----');
			$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
		}	
		/***
		//$this->Beneficiario->read(null, $this->passedArgs['id']);
		// echo '<pre>this:'.print_r($this, 1).'</pre>';
		//echo '<pre>this:'.print_r($this->Beneficiario->data , 1).'</pre>';
		//echo '<pre>passedArgs:'.print_r($this->passedArgs, 1).'</pre>'.$this->passedArgs['id'];
		//echo '<pre>data:'.print_r($this->data, 1).'</pre>';
		***/
		$datos = $this->Beneficiario->read(null, $id_deneficiario);
		/***
		//echo '<pre>datos:'.print_r($datos, 1).'</pre>';
		//echo '-> '.count($datos['Beneficiario']).'|';
		//echo '-> '.count($datos).'|';
		***/
		if( (count($datos) <= 1) && (count($datos['Beneficiario'])<= 0) ){
			$this->Flash->sin_id('Id no existe, verifique...');
			$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
		}
		
		$HttpSocket = new HttpSocket();
		$resultsSocket = $HttpSocket->get($this->urlSocket, array('gabriel'=>0, 'tbl'=>0)) ;
		//$resultsSocket = $HttpSocket->get('http://192.168.200.113:8080/tests/setSocketCasasFiscales.php', array('gabriel'=>0, 'tbl'=>0)) ;
		//$resultsSocket = $HttpSocket->get('http://192.168.200.113:8080/tests/setSocketCasasFiscales.php');
		$escalafon = json_decode($resultsSocket->body, 1);
		//$escalafon = json_decode($resultsSocket['body'], 1);
		//echo '<pre>resultsSocket:'.print_r($escalafon, 1).'</pre>';
		if( !is_array($escalafon) ){ $escalafon = ''; }
		
		$this->Servicio->recursive = -1;
		$servicios = $this->Servicio->find( 'list', array( 'fields' =>array('id', 'nombre') ) );
		
		$estados_civil = $this->Estcivil->find('list', array('fields'=>array('id', 'descripcion')) );
		
		$casaAsignada = 'Sin Asignación';
		if( isset($datos['beneficiarios_servicio']['beneficiario_id']) ){
			$sql = "SELECT (select rtrim(calle)+' # '+rtrim(cast(numero as nchar))+', '+rtrim(isnull(sector, '')) from viviendas where id = T1.vivienda_id) casa_asignada"
						 .' FROM bsvs AS T1'
						 .' LEFT JOIN Arriendos_historials AS T2 ON (T2.bsv_id = T1.id)'
						 .' WHERE T1.beneficiario_id = '.$datos['beneficiarios_servicio']['beneficiario_id']
						 .' AND T1.servicio_id = '.$datos['beneficiarios_servicio']['servicio_id']
						 .' AND T2.destino_id = 1';
			//echo '<pre>sql:'.print_r($sql, 1).'</pre>';
			$casaAsignadaTmp = $this->Arriendos_historial->query($sql);
			//echo '<pre>count:'.count($casaAsignadaTmp).'</pre>';
			//echo '<pre>casaAsignadaTmp:'.print_r($casaAsignadaTmp, 1).'</pre>';
			$casaAsignada = (count($casaAsignadaTmp) > 0 ? $casaAsignadaTmp[0][0]['casa_asignada'] : 'Sin Asignación');
		}
		
		$this->set( array( 'datos' => $datos,
						   'estados_civil' => $estados_civil,
						   'escalafon' => $escalafon, 
							 'servicios' => $servicios,
							 'casaAsignada' => $casaAsignada
						 )
				  );
	}

	public function borra($id_deneficiario = null){
		/*** FALTA FUNCION PARA VALIDAR QUE NO TENGA MOROSIDAD EL BENEFICIARIO ***/
		$this->render(false);
		if(1){
			$this->Flash->info('Beneficiario - Accion omitida temporalmemte.');
		}else{
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
				$this->Flash->exito('Registro Eliminado.');
			}		
		}
		$this->redirect(array('controller' => 'beneficiarios', 'action'=>'index'));
	}

}
?>