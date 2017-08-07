<?
App::import('Vendor', 'PHPWord', array('file' => 'PHPWord.php')); // ver 0.5
App::import('Vendor', 'Funcionespropias');
class ProcesosController extends AppController{
	public $uses = array();
	//var $helpers = array('Html', 'Form', 'Time');
	//var $componets = array('Session', 'Auth');
	//var $scaffold;
	
	var $componets = array('RequestHandler');
	var $helpers = array('Js' => array('Jquery'));
	
	function index(){
	}
	
	public function admin(){
		
		//echo "<pre>".print_r($this->params, 1)."</pre>";
		
	}
	public function acuse_recibo() {
		ob_start();
		$Funciones = new Funcionespropias();
		$rutaArchivo ='files/plantillas/';
		$nombreArchivo = 'archivo.docx';
		/*
		$arrayCaracter = array('Á', 'É', 'Í', 'Ó', 'Ú');
		$arrayChar = array(chr(193), chr(201), chr(205), chr(211), chr(217));
		$cambioChar = str_replace($arrayCaracter, $arrayChar, $Funciones->cambioChar('CONAF - REGIÓN DE COQUIMBO') );
		*/
		$PHPWord = new PHPWord();
		$objWriter = $PHPWord->loadTemplate(WWW_ROOT.DS.'files'.DS.'plantillas'.DS.'recibo_pago.docx');	
		$objWriter->setValue('Value1' , $Funciones->cambioChar('CONAF - REGIÓN DE COQUIMBO') );
		$objWriter->setValue('Value2', $Funciones->cambioChar(' febrero') );
		$objWriter->setValue('Value3', $Funciones->cambioChar('LILIANA YAÑEZ PORTILLA') );
		$objWriter->setValue('Value4', $Funciones->cambioChar('DIRECTORA REGIONAL CONAF - COQUIMBO') );
		$objWriter->setValue('Value5', $Funciones->cambioChar('REGIMIENTO ARICA N° 901') );
		$objWriter->setValue('Value6', $Funciones->cambioChar('512244769') );
		$objWriter->setValue('Value7', '02/2017' );
		$objWriter->setValue('Value8', '$8.100');
		$objWriter->setValue('Value9', $Funciones->cambioChar('Mónica Tapia Cabrera - Conaf Región de Coquimbo') );
		/*
		$objWriter->setValue('Value10', 'Pluta');
		$objWriter->setValue('myReplacedValue', 'nombreDeLaVariable');
		$objWriter->setValue('time', gmdate("D, d M Y H:i:s") );
		$objWriter->setValue('servicio', 'servicio uno' );
		*/
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=".$nombreArchivo);
		header("Content-Transfer-Encoding: binary");
		
		ob_end_clean();
		
		$objWriter->save($rutaArchivo.$nombreArchivo);
		readfile($rutaArchivo.$nombreArchivo);
		unlink($rutaArchivo.$nombreArchivo);
		
		exit;
	}
	
	function registrarPago(){}
	
	
	public function getData($id = null){
		Configure::write('debug', 0);
		/*
		$this->Expediente->recursive = 3;
		$this->Expediente->id = $id;
		if ( !$this->Expediente->exists() ){
			throw new NotFoundException("No existe");
		}
		$this->set("expediente", $this->Expediente->read(null, $id));
		*/
		$exp1 = array('nroEx'=>'E'.$id.'5/2016', 'monto'=>'21322', 'fechaIngreso'=>'17-06-2016', 'fechaVence'=>'20-05-2016', 'mesPagado'=>'Mayo 2016', 'nroDocPago'=>'5466544', 'tipoDocPago'=>'Deposito', 'fechaRegistro'=>'18-06-2016');
		$exp2 = array('nroEx'=>'E12848/2016', 'monto'=>'10000', 'fechaIngreso'=>'17-05-2016', 'fechaVence'=>'20-05-2016', 'mesPagado'=>'Mayo 2016', 'nroDocPago'=>'6541653', 'tipoDocPago'=>'Cheque', 'fechaRegistro'=>'18-05-2016');
		
		$array = array( 'datos' => array($exp1, $exp2, $exp3) );
		$this->set("datos", $array);
		$this->layout = 'ajax';
	}
	
	function saldarDeuda(){
		ob_start();
		$this->render(false);
		echo "<pre>".print_r($this->data, 1)."</pre>";
		$this->redirect('registrarPago');
		ob_end_flush();
	}
	
	public function verExpedientesgdoc($nroExp = null){
		//Configure::write('debug', 0);
		//$this->layout = 'ajax';
		// $this->autoRender = false;
		//if( $this->request->is('ajax') ){
		
	/*
		if( $this->RequestHandler->isAjax() ){
			//echo ('verexpedientesgdoc: <pre>'.print_r($this->request, 1).'</pre>' );
			return json_encode('si');
		}else{ return false; }
	*/
		//echo ('verexpedientesgdoc: <pre>'.print_r($nroExp, 1).'</pre>' );		
		
		if( isset($this->params['form']['nroExp']) ){
			
			//$sql = "SELECT * 
			// $sql = "SELECT COUNT(*)
			$sql = "SELECT D.materia, D.emisor
					FROM expedientes AS E
					INNER JOIN documentos_expedientes AS DE
						ON (DE.id_expediente = E.id)
					INNER JOIN documentos AS D
						ON (DE.id_documento = D.id)
					WHERE E.numero_expediente = '".trim($this->params['form']['nroExp'])."'
					AND D.id_tipo_documento IN (103, 126) ";
			$expedientesSql = $this->Expediente->query($sql);
			
			$expedientes = $this->Expediente->find('all' , array('conditions' => array( 'numero_expediente' => $this->params['form']['nroExp'])) );
			$valores = '';
			if( count($expedientesSql) > 0 ){
				//$valores .= '<pre>'.print_r($this->params['form']['nroExp'], 1).'</pre>';
				//$valores .= ''.count($expedientesSql).'';
				//$valores .= '<pre>'.print_r($expedientesSql, 1).'</pre>';
				// $valores = print_r($nroExp, 1);
				$valores['materia'] = $expedientesSql[0][0]['materia'];
				$valores['emisor'] = $expedientesSql[0][0]['emisor'];
				
				//$valores = '<pre>'.print_r($valores, 1).'</pre>';
			}
			$this->set("datos", $valores);
		}else{
			$this->set("datos", 'no');
			//'<pre>'.print_r($this, 1).'</pre>';
		}
		$this->layout = 'ajax';
	}
	
	
}
?>