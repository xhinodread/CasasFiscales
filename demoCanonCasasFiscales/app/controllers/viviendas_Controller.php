<?
class viviendasController extends AppController{
	public $uses = array();
	//var $helpers = array('Html', 'Form', 'Time');
	//var $componets = array('Session', 'Auth');
	//var $scaffold;
	var $helpers = array('GoogleMap'); 
	
	function index($institucionId=null){
		//echo "sw:". $sw.'<-';
		//$lnkPagar = ($sw > 0 ? "$this->Html->link('Pagar', '/procesos/registrarPago')" : "");
		$this->set(compact('institucionId'));
	}
	
	public function admin(){
		//echo "<pre>".print_r($this->params, 1)."</pre>";	
	}
	
	
}
?>