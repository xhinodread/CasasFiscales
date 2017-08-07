<?php 
App::uses('FuncionesHelper', 'View/Helper');
App::uses('HttpSocket', 'Network/Http');
class MantencionesController extends AppController {
	
	var $uses = array('Mantencione','Vivienda');
	
	public function beforeFilter(){ 
		parent::beforeFilter();
	//	$this->Auth->allow('*');
		//$this->Session->write('losValidates', '');
		
		//echo 'before';
		
	}
		
	public function getHistorial($vivienda_id = null){
		$Funciones = new FuncionesHelper(new View());
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		if( is_numeric($vivienda_id) ){
			// 'fields'=>array('Mantencione.created', 'Mantencione.mantentipo_id', 'Mantencione.observacion', 'Mantencione.documento')
			$options = array('fields'=>array('Mantencione.created', 'Mantencione.mantentipo_id', 'Mantentipo.descripcion', 'Mantencione.observacion', 'Mantencione.documento'),
												'conditions'=>array('Mantencione.vivienda_id'=>$vivienda_id),
											 	'order' => array('Mantencione.created DESC'),
											 	'recursive' => 2
											);
			$datos = $this->Mantencione->find('all', $options );
			// echo '<pre>'.print_r($datos, 1).'</pre>';
			// $datos = $Funciones->arrayInNodo1($datos, 'Mantencione');
			$datos = $this->Mantencione->arrayInMantenciones($datos, 'Mantencione');
			//echo '<pre>'.print_r($datos, 1).'</pre>';
			$this->set("datos", $datos);
		}
	}
	
	public function agrega(){
		//$this->render(false);
		// echo '<pre>'.print_r($this->request, 1).'</pre>';
		//echo '<pre>'.print_r($this->passedArgs, 1).'</pre>';
		
		$this->Vivienda->recursive = 0;
		$this->Vivienda->read(null, $this->passedArgs[0]);
		//echo 'Mantencione: <pre>'.print_r($this->Vivienda->data, 1).'</pre>';
		
		$this->set( array( 'vivienda' => $this->Vivienda->data) );
		
	}
	
}
?>