var RutRegex = new RegExp(/^(\d{1,2})[.](\d{3})[.](\d{3})[\-](\d{1}|k|K)$/);
var RutNoPermitidos = ["11.111.111-1", "22.222.222-2", "33.333.333-3", "44.444.444-4", "55.555.555-5", "66.666.666-6", "77.777.777-7", "88.888.888-8", "99.999.999-9", "1.111.111-4", "2.222.222-8", "3.333.333-1", "4.444.444-5", "5.555.555-9", "6.666.666-2", "7.777.777-6", "8.888.888-k", "9.999.999-3"];

function validarRut(){
	//console.log($("#CrianceroRut").val().length );
	if( ( $("#CrianceroRut").val().length ) == 12 || ( $("#CrianceroRut").val().length ) == 11 ){
		if( RutRegex.test($("#CrianceroRut").val()) ){
			if( !(Valida_Rut($("#CrianceroRut"))) ){
				/*
				$("#CrianceroRut").css("background-color", "red");
				$("#submitX").prop("disabled", true);
				*/
				//pintarTextoRut("red", true);
				return pintarTextoRut("red", true);
			}else{
				if( jQuery.inArray($("#CrianceroRut").val(), RutNoPermitidos) >= 0 ){
					/*
					$("#CrianceroRut").css("background-color", "red");
					$("#submitX").prop("disabled", true);
					*/
					//pintarTextoRut("red", true);
					return pintarTextoRut("red", true);
				}else{
					/*
					$("#CrianceroRut").css("background-color", "white");
					$("#submitX").prop("disabled", false);
					*/
					//pintarTextoRut("white", false);
					return pintarTextoRut("white", false);
				}
			}
		}else{
			/*
			$("#CrianceroRut").css("background-color", "red");
			$("#submitX").prop("disabled", true);
			*/
			//pintarTextoRut("red", true);
			return pintarTextoRut("red", true);
		}
	}else{
		/*
		$("#CrianceroRut").css("background-color", "red");
		$("#submitX").prop("disabled", true);
		*/
		//pintarTextoRut("red", true);
		return pintarTextoRut("red", true);
	}
}

function pintarTextoRut(color, estado){
	$("#CrianceroRut").css("background-color", color);
	$("#submitX").prop("disabled", estado);
	return !(estado);
}

function evalua_formato_rut(valor_rut){ return RutRegex.test(valor_rut); }

function evalua_rut_no_permitidos(valor_rut){ return jQuery.inArray( valor_rut, RutNoPermitidos ); }

function Valida_Rut( Objeto ){
	var tmpstr = "";
	//var intlargo = Objeto.value
	var intlargo = Objeto.val();
	if (intlargo.length> 0)	{
		crut = Objeto.val(); // Objeto.value
		largo = crut.length;
		if ( largo < 2 )	{
			/*alert('rut inválido')*/
			Objeto.focus()
			return false;
		}
		for ( i=0; i < crut.length; i++ )
		if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' ){
			tmpstr = tmpstr + crut.charAt(i);
		}
		rut = tmpstr;
		crut=tmpstr;
		largo = crut.length;
 
		if ( largo> 2 )
			rut = crut.substring(0, largo - 1);
		else
			rut = crut.charAt(0);
 
		dv = crut.charAt(largo-1);
 
		if ( rut == null || dv == null )
		return 0;
 
		var dvr = '0';
		suma = 0;
		mul  = 2;
 
		for (i= rut.length-1 ; i>= 0; i--){
			suma = suma + rut.charAt(i) * mul;
			if (mul == 7)
				mul = 2;
			else
				mul++;
		}
 
		res = suma % 11;
		if (res==1)
			dvr = 'k';
		else if (res==0)
			dvr = '0';
		else{
			dvi = 11-res;
			dvr = dvi + "";
		}
 
		if ( dvr != dv.toLowerCase() ){
			/* alert('El Rut Ingreso es Invalido') */
			Objeto.focus()
			return false;
		}
		/* alert('El Rut Ingresado es Correcto!') */
		Objeto.focus()
		return true;
	}
}

