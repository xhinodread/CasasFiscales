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
	
	
}
?>