<?php 
//App::uses('AppController', 'Controller');
//App::uses('CakeEmail', 'Network/Email');
//App::uses('FuncionesHelper', 'View/Helper');
App::uses('HttpSocket', 'Network/Http');
class ViviendasController extends AppController {
	//var $uses = array('Vivienda', 'Estcivil');
	
	//public $urlSocket = 'http://192.168.200.113:8080/tests/setSocketCasasFiscales.php';
	
	var $paginate = array();
	
	public function beforeFilter(){ parent::beforeFilter();	}
	
	public function index(){
		$conditions = array('Vivienda.activo' =>1);
		if( !empty($this->data) ){
			if( strlen($this->data['Vivienda']['calle'])>=3 ){
				$conditions = $this->Vivienda->filtro_index(trim($this->data['Vivienda']['calle']));
				$this->paginate = array('limit' => 200);
			}
		}
		$listado = $this->paginate('Vivienda',  array( $conditions ) );
		$this->set(compact('listado', 'conditions'));
	}
	
	public function agrega_(){
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
		$id_vivienda = 0;
		$msg ='';
		$losValidates = $this->Vivienda->invalidFields();
		/*** COMUNAS ***/
		$HttpSocket = new HttpSocket();
		$resultsSocket = $HttpSocket->get($this->urlSocket, array('gabriel'=>0, 'tbl'=>1)) ;
		$comunas = json_decode($resultsSocket->body, 1);
		if( !is_array($comunas) ){ $comunas = ''; }
		/*** PROVINCIAS ***/
		$HttpSocket = new HttpSocket();
		$resultsSocket = $HttpSocket->get($this->urlSocket, array('gabriel'=>0, 'tbl'=>2)) ;
		$provincias = json_decode($resultsSocket->body, 1);
		//echo '<pre>comunas:'.print_r($comunas, 1).'</pre>';
		
		if( !is_array($provincias) ){ $provincias = ''; }
		if ($this->request->is('post')) {
				$msg = '<pre>data:'.print_r($this->data, 1).'</pre>';
				if(0): /*** DEBUG ***/
						//$this->request->data['Vivienda']['comuna_id'] = array_search(trim($this->request->data['Vivienda']['comuna_id']), $comunas);
						$varX = '\\'.trim($this->request->data['Vivienda']['comuna_id']).'/ '.array_search( trim($this->request->data['Vivienda']['comuna_id']), $comunas );
						echo 	'varX: '.$varX.
									'<pre>request:'.print_r($this->request->data, 1).'</pre>'.
									'<pre>comunas:'.print_r($comunas, 1).'</pre>'.
									'<pre>data:'.print_r($this->data, 1).'</pre>'.
									'<pre>validates:'.print_r($this->Vivienda->validates(), 1).'</pre>'.
									'strpos . :'.strpos($this->data['Vivienda']['rol'], '.');
				else:
						if( !isset($this->data['Vivienda']['rol']) ){
							$this->Vivienda->read(null, $id_vivienda);
							$this->Flash->sin_id('Vivienda - Id no valido, no existe, verifique.'.$msg);
							$this->redirect(array('controller' => 'viviendas', 'action'=>'index'));
						}
		
						if( !isset($this->passedArgs['id']) ){ $id_vivienda = $this->data['Vivienda']['id']; }
						else{$id_vivienda = $this->passedArgs['id'];}

						$this->Vivienda->read(null, $id_vivienda);
						$this->Vivienda->set(array(
							'rol' =>  trim($this->request->data['Vivienda']['rol']),
							'calle' => trim($this->request->data['Vivienda']['calle']),
							'numero' => trim($this->request->data['Vivienda']['numero']),
							'sector' => trim($this->request->data['Vivienda']['sector']),
							'block' => trim($this->request->data['Vivienda']['block']),
							'depto' => trim($this->request->data['Vivienda']['depto']),
							'referencia' => trim($this->request->data['Vivienda']['referencia']),
							'comuna_id' => trim($this->request->data['Vivienda']['comuna_id']),
							'cod_postal' => trim($this->request->data['Vivienda']['cod_postal']),
							'latitud' => trim($this->request->data['Vivienda']['latitud']),
							'longitud' => trim($this->request->data['Vivienda']['longitud']),
							'monto_avaluo' => $this->Vivienda->saca_str_monto(trim($this->request->data['Vivienda']['monto_avaluo']))
						));

						if( $this->Vivienda->validates() ){
							if( $this->Vivienda->save() ){
								$this->Flash->guardado('Vivienda - Se ha actualizado un registro.');
								$this->redirect(array('controller' => 'viviendas', 'action'=>'edita', 'id'=>$id_vivienda));
							}
						}else{
							$losValidates = $this->Vivienda->invalidFields();
							// $this->Flash->error('Error en la edicion, verifique... <pre>'.print_r($losValidates,1).'</pre>');
							$this->Flash->error('Vivienda - Error en la edicion, verifique...');
							$this->Session->write('losValidates', $losValidates);
							$this->redirect(array('controller' => 'viviendas', 'action'=>'edita', 'id'=>$id_vivienda));
						}
			endif;
		}

		if( isset($this->passedArgs['id']) ){ $id_vivienda = $this->passedArgs['id']; }
		
		if( !is_numeric($id_vivienda) || $id_vivienda <=0 || strlen($id_vivienda)<=0 ){
			// $this->Session->setFlash('Id no valido, verifique.', 'sin_id');
			$this->Flash->sin_id('Vivienda - Id no valido, or verifique.'.$msg.'-----');
			$this->redirect(array('controller' => 'viviendas', 'action'=>'index'));
		}	
		$datos = $this->Vivienda->read(null, $id_vivienda);
		if( (count($datos) <= 1) && (count($datos['Vivienda'])<= 0) ){
			$this->Flash->sin_id('Vivienda - Id no existe, verifique...');
			$this->redirect(array('controller' => 'viviendas', 'action'=>'index'));
		}
				
		$this->set( array( 'datos' => $datos,
										 	 'comunas' => $comunas,
										   'provincias' => $provincias) 
							);
	}

	public function borra_($id_vivienda = null){
		$this->render(false);
		if( strlen($id_vivienda)>0 && $id_vivienda > 0 && is_numeric($id_vivienda) ){
			$this->Servicio->id = $id_vivienda; 
   		$this->Servicio->read(array('activo')); 
			$this->Servicio->saveField('activo', 0); // INACTIVO, BORRADO...
			// FALTA LA LLAMADA AL METODO pago->morosas()
		}
		$this->redirect(array('controller' => 'servicios', 'action'=>'index'));
	}

}
?>