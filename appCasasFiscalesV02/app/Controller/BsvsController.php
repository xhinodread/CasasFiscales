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
						$arrayDatos[] = array('created'=>trim($listaDos['created']),
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
			array_multisort($aux, SORT_ASC, $arrayDatos);
			
			$datosX = array();
			$datosX['Arriendo'] =$arrayDatos;
			$this->set('datos', $datosX);
		}
	}
	
	public function agrega($vivienda_id = null, $ultimo_estado = null){
		
		$this->loadModel('Destino');
		$this->loadModel('Vivienda');
		$this->loadModel('Beneficiario');
		
		
		if ($this->request->is('post')) {
			$this->Flash->Alert('post');
		}
		
		
		
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
		
		$this->Beneficiario->recursive = -1;
		$beneficiarios = $this->Beneficiario->find( 'all', array('fields'=> array('Beneficiario.id', 'Beneficiario.nombres',
																																							'Beneficiario.paterno', 'Beneficiario.materno')) );
		$sql = 'SELECT T1.id, T1.nombres, T1.paterno, T1.materno, T1.sueldo_base FROM Beneficiarios as T1 LEFT JOIN bsvs as T2 ON (T1.id = T2.beneficiario_id) WHERE T2.beneficiario_id is null';
		$beneficiariosX = $this->Beneficiario->query($sql);
		
		$this->set( array(
				'datos' => 'datos',
				'idEstado' => $idEstado,
				'vivienda_id' => $vivienda_id,
				'ultimo_estado' => $ultimo_estado,
				'listaDestino' => array_reverse($listaDestino),
				'vivienda' => $this->Vivienda->data,
				'beneficiarios' => $beneficiarios,
				'beneficiariosX' => $beneficiariosX
			) 
		);
	}
	
	
	
}
?>