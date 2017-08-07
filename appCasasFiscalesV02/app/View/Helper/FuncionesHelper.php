<?php 
/* /app/View/Helper/LinkHelper.php (using other helpers) */
App::uses('AppHelper', 'View/Helper');

class FuncionesHelper extends AppHelper {
  public $helpers = array('Html');

	public function formatoRut($rut = null){
		$piesas = explode('-', $rut);
		if( !isset($piesas[0]) ){ $piesas[0] = ''; }
		if( !isset($piesas[1]) ){ $piesas[1] = ''; }
		$elRut = number_format($piesas[0], 0, "," , ".");
		return trim($elRut.'-'.$piesas[1]);
	}
	
	public function formatoNum($numero = null){
		return trim(number_format($numero, 0, "," , "."));
	}
	
  public function verificar_email($email) { 
        if(preg_match('/^(([^<>()[\]\\.,;:\s@"\']+(\.[^<>()[\]\\.,;:\s@"\']+)*)|("[^"\']+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d   {1,3}\])|(([a-zA-Z\d\-]+\.)+[a-zA-Z]{2,}))$/',$email)) {
            return true; 
        } 
        return false; 
   }
  
	public function acortarTexto($text) {
    	if (strlen($text) > 20) {
    		$text = substr($text,0,20);
    		$text .= '...';
    	}
        return $text;
    }
	
	public function msgValidacion($arrayEvaluar=null, $campoEvaluar = null, $inputPintar = null) {
		if( isset($arrayEvaluar[$campoEvaluar]) ){
			return '<div class="form-group has-error"><label class="control-label" for="'.$inputPintar.'">'.$arrayEvaluar[$campoEvaluar][0].'</label>';
		}
		return;
	}
	
	public function arrayJquery($elArray = null){
		$elArrayPrincipal = '';
		foreach($elArray as $pnt => $lista){
			$pos = strpos($lista, ',');
			$texto = str_replace("'", "", substr($lista, 0, $pos));
			$key = $pnt;
			$elArray = '{value: "'.$key.'", label: "'.$texto.'"},';
			//echo $elArray;
			$elArrayPrincipal .= trim($elArray);
		}
		return trim($elArrayPrincipal);
	}

	public function arrayInNodo1($arrayDatos = null, $nodo1){
		$arraySalida = array();
		foreach($arrayDatos as $pnt => $lista){
			$arraySalida[$nodo1][$pnt] = $lista[$nodo1];
		}
		return $arraySalida;
	}
	
}
?>
