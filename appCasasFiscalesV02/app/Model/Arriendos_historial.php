<?
class Arriendos_historial extends AppModel {
	public $validate = array();
	//public $order = "Arriendos_historial.created DESC";
	//public $hasOne = array('destinos');
	public $belongsTo = array('Destino');

	public function beforeSave($options = array()) {
		//debug($options);
		//debug($options[0]);
    //die(); 
		
		//$this->data['Arriendos_historial']['fecha_desde'] = $this->data['bsv']['created'];
		//$this->data['Arriendos_historial']['fecha_hasta'] = date("d/m/Y", strtotime ( '+10 year' , strtotime( str_replace('/', '-', $this->data['bsv']['created']))));
		$this->data['Arriendos_historial']['fecha_vencimiento'] = date("d/m/Y", strtotime(date('m')."/05/".date('Y')));
		//$this->data['Arriendos_historial']['doc_respaldo'] = $this->data['Arriendos_historial']['doc_respaldo']['name'];
		$this->data['Arriendos_historial']['doc_respaldo'] = $options[0];
		$this->data['Arriendos_historial']['created'] = date("d/m/Y H:i:s");
		$this->data['Arriendos_historial']['monto_arriendo'] = str_replace('.', '',$this->data['Arriendos_historial']['monto_arriendo']);
    return true;
	}
	
}
?>