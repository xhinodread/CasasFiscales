<?php 
App::uses('FuncionesHelper', 'View/Helper');
App::uses('HttpSocket', 'Network/Http');
class MantencionesController extends AppController {
	
	var $uses = array('Mantencione','Vivienda');
	
	public $uploadDir = 'files/ReportesMantencion/';
	
	//public function isAuthorized($user = null) { return true;}
	
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('login');
  }
	
	public function getHistorial($vivienda_id = null){
		$Funciones = new FuncionesHelper(new View());
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		if( is_numeric($vivienda_id) ){			
			//array('fields'=>array('CONVERT(VARCHAR(10), Mantencione.fecha, 103) AS [Mantencione__fecha]', 'Mantencione.mantentipo_id', 'Mantentipo.descripcion', 'Mantencione.observacion', 'Mantencione.documento')
			
			$options = array('fields'=>array('Mantencione.fecha', 'Mantencione.mantentipo_id', 'Mantentipo.descripcion', 'Mantencione.observacion', 'Mantencione.documento'),
											 'conditions'=>array('Mantencione.vivienda_id'=>$vivienda_id),
											 'order' => array('Mantencione.fecha DESC'),
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
		if ($this->request->is('post')) {
			//echo '1<pre>'.print_r($this->data, 1).'</pre>'.'<pre>'.print_r($this->request, 1).'</pre>';
			$fileName = $this->request->data['Mantencione']['documento']['name'];
			$extension = $this->request->data['Mantencione']['documento']['type'];
			$laExtension = explode('/', $extension);
			$error = $this->request->data['Mantencione']['documento']['error'];
			$uploadPath = $this->uploadDir;
      //$uploadFile = $uploadPath.$fileName;
			$nombre = str_replace('-', '_', $this->request->data['Mantencione']['created']).'_'.$this->request->data['Mantencione']['mantentipo_id'].
								'_vivienda_'.$this->request->data['Vivienda']['id'].'_'.date("H_i_s").'.'.$laExtension[1];
			$this->request->data['Mantencione']['documento']['name'] = $nombre;
			$uploadFile = $uploadPath.$nombre;
			if(0){
				//echo '1<pre>'.print_r($this->data, 1).'</pre>';
				echo '1<pre>'.print_r($this->request->data, 1).'</pre>';
			}else{
				if( $extension != 'application/pdf' ){
					$this->Flash->error('Extensión no valida, solo PDF.');
					$this->redirect( array('controller'=> 'viviendas', 'action'=>'edita', $this->request->data['Mantencione']['vivienda_id'] ) );
					//$this->redirect( array('controller'=> 'viviendas', 'action'=>'edita', $this->request->data['Mantencione']['vivienda_id'] ) );
				}
				if( move_uploaded_file($this->request->data['Mantencione']['documento']['tmp_name'], $uploadFile) ){
					$this->Flash->guardado('Archivo Cargado.');
					$this->request->data['Mantencione']['documento'] = $uploadFile;
					$this->request->data['Mantencione']['fecha'] = $this->request->data['Mantencione']['created'];
					$this->request->data['Mantencione']['created'] = null;
					// echo '2<pre>'.print_r($this->data, 1).'</pre>'.'request 2:<pre>'.print_r($this->request->data, 1).'</pre>'.$this->request->data['Mantencione']['vivienda_id'];
					if(1):
						if ($this->Mantencione->save($this->request->data['Mantencione'])) {
								$this->Flash->guardado('Historial de mantención registrado.'.$nombre);
								$this->redirect( array('controller'=> 'viviendas', 'action'=>'edita', 'id' => $this->request->data['Mantencione']['vivienda_id'] ) );
								//$this->redirect($this->referer());
						}else{
								$this->Flash->error('Sin cambios, intente nuevamente.');
								$this->redirect( array('controller'=> 'viviendas', 'action'=>'edita', $this->request->data['Mantencione']['vivienda_id'] ) );
						}
					endif;
				}else{
					$this->Flash->sin_id('SIN ACCION');
					$this->redirect( array('controller'=> 'viviendas', 'action'=>'edita', $this->request->data['Mantencione']['vivienda_id'] ) );
				}
			}
		}
		$this->Vivienda->recursive = 0;
		$this->Vivienda->read(null, $this->passedArgs[0]);
		//echo 'Mantencione: <pre>'.print_r($this->Vivienda->data, 1).'</pre>';
		$mantencion_tipos = $this->Mantencione->getTipos();
		$this->set( array( 'vivienda' => $this->Vivienda->data,
										 	 'mantencion_tipos' => $mantencion_tipos) 
							);
	}
	
	public function index_(){}
	public function edita_(){}
	public function borra_(){}
}
?>