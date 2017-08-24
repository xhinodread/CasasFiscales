<?php 
class BsvsController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
  }
	
	public function isAuthorized($user = null) { return true;}
	
	public function index($vivenda_id = null) {
		//$this->render(false);
		//echo '<pre>'.print_r( $this->Bsv->find('all') ).'</pre>';
		
		$this->Bsv->recursive = 2;
		$this->set( array('datos' => $this->Bsv->find('all') )  );
		//$this->set("datos", $this->Bsv->find('all'));
	}
	
	public function getArriendo($vivienda_id = null){
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		if( is_numeric($vivienda_id) ){
			
			// 'fields'=>array('Arriendos_historial.created', 'Arriendos_historial.destino_id', 'Beneficiario.nombres', 'Arriendos_historial.observacion', 'Arriendos_historial.doc_respaldo'),
			$options = array(
											 'conditions'=>array('Bsv.vivienda_id'=>$vivienda_id),
											 'order' => array('Bsv.created DESC'),
											 'recursive' => 2
											);
			$datos = $this->Bsv->find('all', $options );
			//// $datos = $this->Arriendo->arrayInMantenciones($datos, 'Mantencione');
			//echo 'datos: <pre>'.print_r($datos, 1).'</pre>';
			////$this->set('datos', $datos);
			
			$unArray = array();
			$arrayDatos = array();
			foreach($datos as $listaUno){
				if( isset($listaUno['Arriendos_historial']) ){					
					foreach($listaUno['Arriendos_historial'] as $listaDos){
						$arrayDatos[] = array('created'=>$listaDos['created'], //date('d/m/Y', strtotime(trim($listaDos['created']))), // trim(date("d/m/Y", strtotime(trim($listaDos['created'])))),
																	'destino'=>trim($listaDos['Destino']['descripcion']), 
																	'beneficiario'=>trim($listaUno['Beneficiario']['nombres']).' '.trim($listaUno['Beneficiario']['paterno']).' '.trim($listaUno['Beneficiario']['materno']),
																	'monto_arriendo'=>trim($listaDos['monto_arriendo']), 
																	'observacion'=>trim($listaDos['observacion']), 
																	'doc_respaldo'=>trim($listaDos['doc_respaldo']));
					}
				}
			}
			foreach ($arrayDatos as $key => $row) {
				$aux[$key] = $row['created'];
			}
			array_multisort($aux, SORT_DESC, $arrayDatos);
			
			$datosX = array();
			$datosX['Arriendo'] =$arrayDatos;
			$this->set('datos', $datosX);
		}
	}
	
	public function agrega($vivienda_id = null, $ultimo_estado = null, $beneficiario_id = null){
		
		$this->loadModel('Destino');
		$this->loadModel('Vivienda');
		$this->loadModel('Beneficiario');
		
		if ($this->request->is('post')) {
			
			unset($this->request->data['Vivienda']);
			unset($this->request->data['X']);		
			unset($this->request->data['bsv']['beneficiario_nombre']);
			
			$this->request->data['Arriendos_historial']['fecha_desde'] = $this->request->data['bsv']['created'];
			$this->request->data['Arriendos_historial']['fecha_hasta'] = date("d/m/Y", strtotime ( '+10 year' , strtotime( str_replace('/', '-', $this->request->data['bsv']['created']))));
			$this->request->data['Arriendos_historial']['fecha_vencimiento'] = date("d/m/Y", strtotime(date('m')."/05/".date('Y')));
			
			//echo '<pre>'.print_r($this->request->data, 1).'</pre>';
			// $this->Flash->exito( '<pre>'.print_r($this->request->data, 1).'</pre>' );
			
			if( isset($this->request->data['Arriendos_historial']) && $this->request->data['Arriendos_historial']['destino_id'] == 2 ){
				$opciones = array( 'conditions' => array( 'beneficiario_id'=> $this->request->data['bsv']['beneficiario_id'],
																								 	'vivienda_id'=> $this->request->data['bsv']['vivienda_id'],
																								 	'servicio_id'=> $this->request->data['bsv']['servicio_id']
																								) 
												 );
				$this->Bsv->recursive=-1;
				$idBsv = $this->Bsv->find('first', $opciones);
				//echo 'idBsv<pre>'.print_r($idBsv, 1).'</pre>';
				
				if( isset($idBsv['Bsv']['id']) ){
					$this->request->data['Arriendos_historial']['bsv_id'] = $idBsv['Bsv']['id'];
					
					/***
					$this->Arriendos_historial->create();
					if( $this->Arriendos_historial->save($this->request->data['Arriendos_historial']) ){
						$this->Flash->exito('Registro agregado.');
					}else{
						$this->Flash->error('No se pudo agregar el historial.');
					}
					***/
				}
				
				$this->Flash->exito('Devolucion');				
			}else{
				$this->Flash->exito('Asignacion');
			}
			
			
			if(0):
			$this->Bsv->create();
			if( $this->Bsv->save($this->request->data['bsv']) ){
				$lastInsertID = $this->Bsv->getLastInsertID();
				$this->request->data['Arriendos_historial']['bsv_id'] = $lastInsertID;
				$this->Arriendos_historial->create();
				if( $this->Arriendos_historial->save($this->request->data['Arriendos_historial']) ){
					$this->Flash->exito('Registro agregado.');
				}else{
					$this->Flash->error('No se pudo agregar el historial.');
				}
			}else{
				$this->Flash->error('No se pudo agregarel registro.');
			}
			endif;
			
			echo '<pre>'.print_r($this->request->data, 1).'</pre>';
			
		}/*** FIN SECCION GRABADO ***/
			
		$options = array('fields'=>array('descripcion', 'id'));
		$destinos = $this->Destino->find('list', $options );
		
		$idEstado=0;
		if( is_numeric($ultimo_estado) ){
			// 400;
			$this->Flash->error($this->msgAsignaciones['parametros']);
			$this->redirect( array('controller'=>'viviendas', 'action'=>'edita', 'id'=>$vivienda_id) );
		}else{
			if( isset($destinos[trim($ultimo_estado)]) ){
			$idEstado = $destinos[trim($ultimo_estado)];
			}else{
				// 404;
				$this->Flash->error('Parametros no Validos');
				$this->redirect( array('controller'=>'viviendas', 'action'=>'edita', 'id'=>$vivienda_id) );
			}
		}
		
		$listaDestino = array();
		foreach( $destinos as $pnt => $listado ){
			//echo $pnt.' '.$listado.'<br>';
			$listaDestino[$listado] = $pnt;
		}
		
		$this->Vivienda->recursive = 0;
		$this->Vivienda->read(null, $vivienda_id);

		
		$this->Beneficiario->recursive = 1;
		$elBeneficiario = $this->Beneficiario->find( 'first', array('conditions'=> array('Beneficiario.id'=> $beneficiario_id), 
																																'fields'=> array('Beneficiario.id', 'Beneficiario.nombres', 'Beneficiario.paterno', 'Beneficiario.materno'
																																								, 'beneficiarios_servicio.servicio_id')
																															 )
																							 );
		
				
		$this->Beneficiario->recursive = -1;
		$beneficiarios = $this->Beneficiario->find( 'all', array('fields'=> array('Beneficiario.id', 'Beneficiario.nombres',
																																							'Beneficiario.paterno', 'Beneficiario.materno')
																														) 
																							);
		
				
		$sql = 'SELECT T1.id, T1.nombres, T1.paterno, T1.materno, T1.sueldo_base, T3.servicio_id'
			.' FROM Beneficiarios as T1'
			.' LEFT JOIN bsvs as T2 ON (T1.id = T2.beneficiario_id)'
			.' LEFT JOIN beneficiarios_servicios as T3 ON (T1.id = T3.beneficiario_id)'
			.' WHERE T2.beneficiario_id is null'
			.' AND T3.beneficiario_id is not null';
		
		$sql = 'SELECT T1.id, T1.nombres, T1.paterno, T1.materno, T1.sueldo_base, T2.servicio_id'	
					.' FROM Beneficiarios as T1'
					.' LEFT JOIN beneficiarios_servicios as T2 ON (T2.beneficiario_id = T1.id)'
					.' LEFT JOIN bsvs as T3 ON (T3.beneficiario_id = T1.id)'
					.' LEFT JOIN Arriendos_historials as T4 ON (T4.bsv_id = T3.id)'
					.' WHERE T2.servicio_id is not null'
					.' AND T4.monto_arriendo is null';
		$beneficiariosX = $this->Beneficiario->query($sql);
		
		$this->set( array(
				'datos' => 'datos',
				'idEstado' => $idEstado,
				'vivienda_id' => $vivienda_id,
				'ultimo_estado' => $ultimo_estado,
				'listaDestino' => array_reverse($listaDestino, true),
				'vivienda' => $this->Vivienda->data,
				'elBeneficiario' => $elBeneficiario,
				'beneficiarios' => $beneficiarios,
				'beneficiariosX' => $beneficiariosX
			) 
		);
	}
	
	
	
}
?>