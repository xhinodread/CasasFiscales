<?

/**************** LDAP - ACTIVE DIRECTORY ****************/
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
		echo 'LDAP - Exito';
	}
?>