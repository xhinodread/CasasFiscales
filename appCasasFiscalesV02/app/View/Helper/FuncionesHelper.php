<?php 
/* /app/View/Helper/LinkHelper.php (using other helpers) */
App::uses('AppHelper', 'View/Helper');

class FuncionesHelper extends AppHelper {
  public $helpers = array('Html');

	public $CampoRequerido='* Campo Requerido';
		
	
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
	
	public function arrayJqueryConComa($elArray = null){
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
	
	public function arrayJquery($elArray = null){
		$elArrayPrincipal = '';
		foreach($elArray as $pnt => $lista){
			$texto = $lista;
			$key = $pnt;
			$elArray = '{value: "'.trim($key).'", label: "'.trim($texto).'"},';
			$elArrayPrincipal .= trim($elArray);
		}
		return trim($elArrayPrincipal);
	}
	
	public function generaArray($elArray = null){
		$elArrayPrincipal = array();
		foreach($elArray as $pnt => $lista){
			//$texto = $lista;
			//$key = $pnt;
			//$elArray = '{value: "'.$key.'", label: "'.$texto.'"},';
			$elArrayPrincipal[$pnt] = trim($lista);
		}
		return $elArrayPrincipal;
	}

	public function arrayInNodo1($arrayDatos = null, $nodo1){
		$arraySalida = array();
		foreach($arrayDatos as $pnt => $lista){
			$arraySalida[$nodo1][$pnt] = $lista[$nodo1];
		}
		return $arraySalida;
	}
	
	public function beneficiarioNombrePersona($arrayBeneficiarios = null){
		$arraySalida = array();
		foreach($arrayBeneficiarios as $lista){
			// $arraySalida[$lista['Beneficiario']['id']] = (trim($lista['Beneficiario']['nombres'])).' '.(trim($lista['Beneficiario']['paterno'])).' '.(trim($lista['Beneficiario']['materno']));
			$arraySalida[$lista['0']['id']] = array(trim($lista['0']['nombres']).' '.trim($lista['0']['paterno']).' '.trim($lista['0']['materno']) , trim($lista['0']['sueldo_base']) );
			
			
			$arraySalida[$lista['0']['id']] = array(trim($lista['0']['nombres']).' '.trim($lista['0']['paterno']).' '.trim($lista['0']['materno']) ,
																							trim($lista['0']['sueldo_base']) ,
																							trim($lista['0']['servicio_id']) 
																						 );
			
		}
		return $arraySalida;
	}
	
}
?>
