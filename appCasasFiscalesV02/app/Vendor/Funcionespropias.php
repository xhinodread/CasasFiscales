<?
class Funcionespropias {
	

	static function poneNombrePersona($arrayDatos = null){
		$arraySalida = array();
		foreach($arrayDatos as $lista){
			$arraySalida[$lista['Persona']['id']] = utf8_encode($lista['Persona']['nombres']).' '.utf8_encode($lista['Persona']['apellido_paterno']).' '.utf8_encode($lista['Persona']['apellido_materno']);
		}
		return $arraySalida;
	}

	static function evaluaExistenFechas($arrayThisData = null){
		if( isset($arrayThisData['Expedientes']['desde']) && isset($arrayThisData['Expedientes']['hasta']) ) {
			if( strlen($arrayThisData['Expedientes']['desde']) >0 && strlen($arrayThisData['Expedientes']['hasta']) > 0 ) {
				$desde = explode('/', $arrayThisData['Expedientes']['desde']);
				$hasta = explode('/', $arrayThisData['Expedientes']['hasta']);
				if( !checkdate($desde[1], $desde[0], $desde[2]) )return 0;
				if( !checkdate($hasta[1], $hasta[0], $hasta[2]) )return 0;
				return 1;
			}
		}
		return 0;
	}
	
	static function arrayIn($arrayDatos = null, $nodo1, $nodo2){
		$arraySalida = array();
		foreach($arrayDatos as $lista){
			$arraySalida[] = $lista[$nodo1][$nodo2];
		}
		return $arraySalida;
	}	
	
	static function menuSelecc($laUrl = null, $nombreMenu = null){
		if($laUrl == $nombreMenu){
			return 'active';
		}else{
			return '';
		}
	}
	
	static function espacioLeft($nroTabs = null, $nroEspacios = null ){
		$losTabs = '';
		$losEspacios = '';
		for($x=0; $x<=$nroTabs; $x++)$losTabs .=chr(9);
		for($x=0; $x<=$nroEspacios; $x++)$losEspacios .=chr(32);
		return $losTabs.$losEspacios;
	}
	
	static function cambioChar($elChar = null){
		$arrayCaracter = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', '°');
		$arrayChar = array(chr(225), chr(223), chr(237), chr(243), chr(249), chr(241), chr(193), chr(201), chr(205), chr(211), chr(217), chr(209), chr(176) );
		$cambioChar = str_replace($arrayCaracter, $arrayChar, $elChar);
		return $cambioChar;
	}
	
	static function formatoRut($rut = null){
		$piesas = explode('-', $rut);
		if( !isset($piesas[0]) ){ $piesas[0] = ''; }
		if( !isset($piesas[1]) ){ $piesas[1] = ''; }
		$elRut = number_format($piesas[0], 0, "," , ".");
		return $elRut.'-'.$piesas[1];
	}
	
	static function formatoNum($numero = null){
		return number_format($numero, 0, "," , ".");
	}

	/***
	static function evaluaExistenFechas($arrayThisData = null){
		$nombreFechas = array("day", "month", "year");
		if( isset($arrayThisData['Expedientes']['desde']) && isset($arrayThisData['Expedientes']['hasta']) ) {
			foreach($arrayThisData['Expedientes']['desde'] as $pnt => $lista){
				if( in_array($pnt, $nombreFechas) && strlen($lista) <= 0 )return 0;
			}
			foreach($arrayThisData['Expedientes']['hasta'] as $pnt => $lista){
				if( in_array($pnt, $nombreFechas) && strlen($lista) <= 0 )return 0;
			}
			return 1;
			
		}else{
			return 0;
		}
	}
	***/
	/***
	static function evaluaExisteFecha($arrayThisData = null){
		$nombreFechas = array("day", "month", "year");
		$cntDesde = 0;
		$cntHasta = 0;
		foreach($arrayThisData as $pnt => $lista){
			if( in_array($pnt, $nombreFechas) && strlen($lista) <= 0 )return 0;
		}
		return 1;
	}

	static function evaluaSimpleThisData($arrayThisData = null){
		foreach($arrayThisData as $lista){
			if( strlen($lista) <= 0 )return 0;
		}
		return 1;
	}
	***/

}

?>