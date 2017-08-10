<?

/**************** LDAP - ACTIVE DIRECTORY ****************/
// El último inicio de sesión se almacena en dos atributos presentes tanto en la cuentas de usuarios como de los equipos: LastLogonTimeStamp y LastLogon.

	echo '<hr>';
	$username = 'jaracena';
	$password = utf8_decode('Jorgé1234');
	$adConec = ldap_connect("ldap://192.168.200.198", 389); // or die();
	ldap_set_option($adConec, LDAP_OPT_PROTOCOL_VERSION, 2);
	ldap_set_option($adConec, LDAP_OPT_REFERRALS, 1);
	$conecActiveDir = ldap_bind($adConec, $username."@gorecoquimbo.cl", $password); // or die('Error en usuario o clave.');
	if(!$conecActiveDir){
		echo 'Error:<br /><pre>'.print_r(error_get_last(),1).'</pre>LDAP:<pre>'
			.print_r( ldap_error(),1).'</pre>';
	}else{
		echo 'LDAP - Exito...<br>';

		
		$ldaptree   = "CN=JARACENA,CN=Computers,DC=gorecoquimbo,DC=cl";
		
		$person = "Gobierno";
		
		$dn = "o=Gobierno Regional, c=cl";
		//$filter="(|(sn=$person*)(givenname=$person*))";
		$justthese = array("ou", "sn", "Gobierno Regional", "mail");
		$sr=ldap_search($conecActiveDir, $dn, $ldaptree, $justthese);
		$info = ldap_get_entries($conecActiveDir, $sr);

		echo $info["count"]." entradas devueltas\n";

	}
?>