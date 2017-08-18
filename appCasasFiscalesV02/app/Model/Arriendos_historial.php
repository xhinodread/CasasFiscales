<?
class Arriendos_historial extends AppModel {
	public $validate = array();
	//public $order = "Arriendos_historial.created DESC";
	//public $hasOne = array('destinos');
	public $belongsTo = array('Destino');
	
}
?>