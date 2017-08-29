<?
class Bsv extends AppModel {
	public $validate = array();
	
	public $belongsTo = array(
		'Vivienda' => array(
				'className' => 'Vivienda',
				'conditions' => array('Vivienda.activo' => '1'),
				'order' => 'Vivienda.id DESC'
		),
		'Beneficiario' => array(
				'className' => 'Beneficiario',
				'conditions' => array('Beneficiario.activo' => '1'),
				'order' => 'Beneficiario.id DESC'
		),
		'Servicio' => array(
				'className' => 'Servicio',
				'conditions' => array('Servicio.activo' => '1'),
				'order' => 'Servicio.id DESC'
		)
  );
	
	public $hasMany = array(
		'Arriendos_historial' => array(
				'className' => 'Arriendos_historial'
		)
  );
	
	public $uploadDirDevol = 'files/AsignacionDevolucion/';
	public $uploadDirAsig = 'files/AsignacionDevolucion/';
	
	public function nombreFicheroSubirDevol($data = null){
		$uploadFile = 'doc'.date('dmYHis');
		$fileName = $data['Arriendos_historial']['doc_respaldo']['name'];
		$extension = $data['Arriendos_historial']['doc_respaldo']['type'];
		$laExtension = explode('/', $extension);
		$uploadPath = $this->uploadDirDevol;
		$nombre = str_replace('/', '_', $data['bsv']['created']).'_'.$data['Arriendos_historial']['destino_id'].
						'_vivienda_'.$data['bsv']['vivienda_id'].'_'.date("H_i_s").'.'.$laExtension[1];
		//$this->request->data['Arriendos_historial']['doc_respaldo']['name'] = $nombre;
		$uploadFile = $uploadPath.$nombre;
		return array($uploadFile, $nombre);
	}
	
	public function nombreFicheroSubirAsig($data = null){
		$uploadFile = 'doc'.date('dmYHis');
		$fileName = $data['Arriendos_historial']['doc_respaldo']['name'];
		$extension = $data['Arriendos_historial']['doc_respaldo']['type'];
		$laExtension = explode('/', $extension);
		$uploadPath = $this->uploadDirAsig;
		$nombre = str_replace('/', '_', $data['bsv']['created']).'_'.$data['Arriendos_historial']['destino_id'].
						'_vivienda_'.$data['bsv']['vivienda_id'].'_'.date("H_i_s").'.'.$laExtension[1];
		//$this->request->data['Arriendos_historial']['doc_respaldo']['name'] = $nombre;
		$uploadFile = $uploadPath.$nombre;
		return array($uploadFile, $nombre, $extension);
	}
	
}
?>