<?
App::uses('ModelBehavior', 'Model');
class TildesBehavior extends ModelBehavior {
	/***
	public function setup(Model $Model, $settings = array()) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = array('recursive' => true, 'notices' => true, 'autoFields' => true);
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
	}
	*/
	
	private function cambia_tilde($elString= null){
		return $elString;
	}
	
	public function inicio(){ return 'inicio'.date('his'); }
	
	public function separa_string(Model $Model, $elString= null, $arrayParecidos = null){
		
		$varTmp01 = '';
		$varTmp02 = print_r($arrayParecidos, 1);
		$varTmp03 = '';
		$swComparaString = -1;
		
		$arrayString = str_split(utf8_decode(trim($elString)));
		//array_push($arrayString, $elString, count($arrayString) );
		$arrayParecidosSinTilde = array();
		//$arrayAcentuados = array('á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú', 'ñ', 'Ñ');
		$arrayAcentuados = array('á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú');
		//$arrayNoAcentuados = array('a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'n', 'N');
		$arrayNoAcentuados = array('a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U');
		$swAcierto = 0;
		$strLetras = '';
		$strNroLetras = '';
		
		foreach($arrayString as $lista){
			// $strLetras .= ord(($lista)).' '.($lista).', ';
			// $strLetras .= ord(utf8_encode($lista)).' '.utf8_encode($lista).', ';
			$strLetras .= utf8_encode($lista).', ';
			$strNroLetras .= ord(utf8_encode($lista)).', ';
			if( in_array(utf8_encode($lista), $arrayAcentuados) ){
				$swAcierto += 1;
				// $strLetras .= $this->cambia_tilde(utf8_encode($lista));
			}
		}
		
		/*** CUANDO NO TIENE ACENTOS ***/
		if($swAcierto == 0 ){
			$varTmp01 = 'sin tildes, ni eñes';
			foreach($arrayParecidos as $pnt => $lista){ $arrayParecidosSinTilde[$pnt] = (str_replace($arrayAcentuados, $arrayNoAcentuados, $lista)); }
			//$varTmp03 = $this->CompararString( utf8_decode(trim($elString)), $arrayParecidos[0] );
			$varTmp03 = print_r($arrayParecidosSinTilde, 1);
			foreach($arrayParecidosSinTilde as $pnt => $lista){ 
				//$swComparaString .= $this->CompararString( utf8_decode(trim($elString)), trim($lista) ).', '; 
				//echo '<br>'. (trim($elString)).', '.trim($lista);
				if( $this->CompararString( utf8_decode(trim($elString)), trim($lista) ) ){
					$swComparaString = $pnt;
				}
			}
		}else{
			$swComparaString = 0;
			$arrayParecidos[0]=trim($elString);
		}

		if(0){
			return '<ul><li>'.$strLetras.'</li>'
				.'<li>'.$strNroLetras.'</li>'
				.'<li>swAcierto: '.$swAcierto.' '.$varTmp01.'</li>'
				.'<li>arrayParecidos: '.$varTmp02.'</li>'
				.'<li>arrayNoAcentuados: '.$varTmp03.'</li>'
				.'<li>CompararString: '.$swComparaString.'</li>'
				.'<li>RESULTADO: '.$arrayParecidos[$swComparaString].'</li></ul>';
		}else{
			/***
			echo '<li>elString: '.(trim($elString)).'</li>'
				.'<ul><li>'.$strLetras.'</li>'
				.'<li>'.$strNroLetras.'</li>'
				.'<li>swAcierto: '.$swAcierto.' '.$varTmp01.'</li>'
				.'<li>arrayParecidos: '.$varTmp02.'</li>'
				.'<li>arrayNoAcentuados: '.$varTmp03.'</li>'
				.'<li>CompararString: '.$swComparaString.'</li>'				
				.'<li>RESULTADO: '.$arrayParecidos[$swComparaString].'</li></ul>';
			***/
			if($swComparaString >= 0){
				return $arrayParecidos[$swComparaString];
			}else{
				//return trim($elString);
				return false;
			}
		}
	}
	
	private function CompararString($elStringUno=null, $elStringDos=null) {
		$PorcentajesComparacion = 0.15; 
		//echo '<br>'.utf8_encode(strtoupper($elStringUno)).'=='.strtoupper($elStringDos);
		if( utf8_encode(strtoupper($elStringUno)) == strtoupper($elStringDos) ){
			return true;
		}
		//return $this->CodificarPalabra($elStringUno);
		return false;
	}
	
	private function CodificarPalabra($Palabra){
		$Texto = strtoupper($Palabra);
		//Remplazamos acentos
		//Texto = QuitarAcentos(Texto);
		//Solo emplearemos mayúsculas para el código
		//Texto = Palabra.ToUpper();
		//$Texto = $this->AjustarTexto($Texto);
		//Si el texto no contiene letras, sale de la función
		if (strlen($Texto) == 0){
				return 0;
		}
		//Separamos el primer caracter de la cadena y ajustamos a la pronunciación
		$ArrayCodigo = str_split(utf8_decode(trim($Texto)));
		//$Codigo = $Texto[0].ToString();
		$Codigo = $ArrayCodigo[0];		
		
		switch ($Codigo){
				case "J":
						$Codigo = "Y";
						break;
				case "C":
				case "Z":
						$Codigo = "S";
						break;
				case "V":
						$Codigo = "B";
						break;
		}
		//Recoremos los caracteres de la cadena a partir del segundo caracter
		//$PosChar = 1;
		//while (PosChar < Texto.Length){
		for($PosChar = 1; $PosChar < strlen($Texto); $PosChar++ ){
				//Char Caracter = Texto[PosChar];
				$Caracter = $ArrayCodigo[$PosChar];
				//Ignora los caracteres repetidos que no filtremos previamente
				//if (Caracter != Texto[PosChar - 1]){
			  if ($Caracter != $ArrayCodigo[$PosChar - 1]){
						//switch (Caracter.ToString()){
						switch ($Caracter){
								case "P":
										$Codigo = $Codigo + "0";
										break;
								case "B":
								case "V":
										$Codigo = $Codigo + "1";
										break;
								case "F":
								case "H":
										$Codigo = $Codigo + "2";
										break;
								case "T":
								case "D":
										$Codigo = $Codigo + '3';
										break;
								case "S":
								case "Z":
								case "C":
								case "X":
										//Esta parte me recuerda el chiste: Se me cayo la Zanahoria, me estan pensando con Z eso debio ser Celicia
										$Codigo = $Codigo + "4";
										break;
								case "Y":
								case "L":
										$Codigo = $Codigo + "5";
										break;
								case "N":
								case "Ñ":
								case "M":
										$Codigo = $Codigo + "6";
										break;
								case "Q":
								case "K":
										$Codigo = $Codigo + "7";
										break;
								case "G":
								case "J":
										$Codigo = $Codigo + "8";
										break;
								case "R":
										$Codigo = $Codigo + "9";
										break;
						}
				}

				//if ("AEIOUW".IndexOf(Caracter) > -1){
				if( strpos("AEIOUW", $Caracter) > -1 ){
						$Codigo = $Codigo + $Caracter;
				}
				$PosChar++;
		}
		return $Codigo;
	}
	
	public function AjustarTexto($Texto){
		/*
			$Texto = Texto.Replace("AA", "A");
			$Texto = Texto.Replace("NN", "N");
			$Texto = Texto.Replace("SS", "S");
			$Texto = Texto.Replace("TT", "T");
			$Texto = Texto.Replace("LL", "Y");
			$Texto = Texto.Replace("TH", "T");
			$Texto = Texto.Replace("NN", "N");
			$Texto = Texto.Replace("SS", "S");

			if (!String.IsNullOrWhiteSpace($Texto)){
					if ($Texto[0] == 'H'){
							//Elimina la H al principio de la palabra
							$Texto = $Texto.Substring(1); 
					}
			}

			//Elimina espacios
			while ($Texto.IndexOf(" ") > -1){
					$Texto = $Texto.Replace(" ", String.Empty); 
			}

			//Eliminamos cualquier carácter diferente a letras
			int PosChar = 0;
			while (PosChar < $Texto.Length){
					if ("ABCDEFGHIJKLMNOPQRSTUVWXYZ".IndexOf($Texto[PosChar]) < 0) {
							$Texto = $Texto.Replace($Texto[PosChar].ToString(), String.Empty);
							PosChar--;
					}
					PosChar++;
			}

			return $Texto;
			*/
	}	

		
}
?>