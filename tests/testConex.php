<?
echo 'testconex';


if(1):

	// Sqlserver 2012   usrDevelop   54ufh9!kF9
	// usrtest', 'password' => '7azs3o4d!SD'
	$srv ="192.168.200.130";
	echo 'Mssql: '.$srv.'<br />';
	$connectionMs = mssql_connect($srv,"usrtest","7azs3o4d!SD", true); // or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	if($connectionMs){
		echo 'mssql:<pre>'.print_r($connectionMs, true).'</pre>';
	}else{
		echo '<pre>'.print_r(error_get_last(), true).'</pre>.<pre>'.mssql_get_last_message().'</pre>';
	}
	mssql_select_db("testCake", $connectionMs);
	echo 'Nombre DB : testCake<hr />';
	
	$sql = "SELECT * FROM Tabla1 ";
	$rst = mssql_query($sql, $connectionMs) or die('<pre>'.print_r(error_get_last(), true).'</pre>.<pre>'.mssql_get_last_message().'</pre>');
	echo 'Query: '.$sql.'<br />'.print_r(mssql_fetch_assoc($rst), 1).'<hr />';
	echo '<br />Cuenta: '.mssql_num_rows($rst).'<br />';


	// Sqlserver 2012
	$srv ="192.168.200.128";
	echo 'Mssql: '.$srv.'<br />';
	$connectionMs = mssql_connect($srv,"usrtest","7azs3o4d", true); // or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	if($connectionMs){
		echo 'mssql:<pre>'.print_r($connectionMs, true).'</pre>';
	}else{
		echo '<pre>'.print_r(error_get_last(), true).'</pre>.<pre>'.mssql_get_last_message().'</pre>';
	}
	mssql_select_db("testCake", $connectionMs);
	echo 'Nombre DB : testCake<hr />';
	
	$sql = "SELECT * FROM Tabla1 ";
	$rst = mssql_query($sql, $connectionMs) or die('<pre>'.print_r(error_get_last(), true).'</pre>.<pre>'.mssql_get_last_message().'</pre>');
	echo 'Query: '.$sql.'<br />'.print_r(mssql_fetch_assoc($rst), 1).'<hr />';
	echo '<br />Cuenta: '.mssql_num_rows($rst).'<br />';


// Sqlserver 2000
	$srv ="srv03w2k3sql01.gorecoquimbo.cl";
	echo 'Mssql: '.$srv.'<br />';
	$connectionMs = mssql_connect($srv,"usr_cometida","pas_cometida", true); // or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	if($connectionMs){
		echo 'mssql:<pre>'.print_r($connectionMs, true).'</pre>';
	}else{
		echo '<pre>'.print_r(error_get_last(), true).'</pre>.<pre>'.mssql_get_last_message().'</pre>';
	}
	
	/*** DEVELOP 2016 ***/
	$srv ="SRV53BDDEV01.gorecoquimbo.cl";
	//$srv ="srv03w2k3sql01.gorecoquimbo.cl";
	//$srv ="192.168.200.122";
	// 'usr_cometida', 'pas_cometida'
	// "usr_remoto","4321*-"
	echo 'Mssql: '.$srv.'<br />';
	// $connectionMs = mssql_connect($srv,'usr_cometida', 'pas_cometida', true); // or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	$connectionMs = mssql_connect($srv, "usr_remoto", "4321*-", true);
	if($connectionMs){
		mssql_select_db("DbEvalFunc", $connectionMs);
		echo 'mssql:<pre>'.print_r($connectionMs, true).'</pre>';
	}else{
		echo '<pre>'.print_r(error_get_last(), true).'</pre>.<pre>'.mssql_get_last_message().'</pre>';
	}
	///////
	echo 'Mssql usr_web : '.$srv.'<br />';
	$connectionMs = mssql_connect($srv,'usr_web', 'gore4321*-', true); // or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	if($connectionMs){
		echo 'mssql:<pre>'.print_r($connectionMs, true).'</pre>';
	}else{
		echo '<pre>'.print_r(error_get_last(), true).'</pre>.<pre>'.mssql_get_last_message().'</pre>';
	}
	$db_comentidos = mssql_select_db("DB_soporteinf", $connectionMs);
	echo 'Nombre DB : '.$db_comentidos.'<hr />';
	
	
	echo '<hr>';
	$srv ="192.168.33.20";
	echo 'MySql: '.$srv.'<br />';
	$connectionMy = mysql_connect($srv,"cqbogore","cqbogore", true); // or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	if($connectionMy){
		mysql_select_db('encuestas', $connectionMy);
		echo ' mysql:<pre>'.print_r($connectionMy, true).'</pre>';
	}else{
		echo '<pre>'.print_r(error_get_last(), true).'</pre>';
	}
	
	echo '<hr>';
	$srv ="192.168.200.180";
	echo 'Pg: '.$srv.'<br />';
	$connectionPg = pg_connect("host=$srv port=5432 dbname=exedoc user=exedoc password=exedoc") or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	if($connectionPg){
		echo ' Pgsql:<pre>'.print_r($connectionPg, true).'</pre>';
	}
	
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
	
		
	
	//$conexionPost = pg_connect("host=192.168.200.180 port=5432 dbname=exedoc user=exedoc password=exedoc") or die('Could not connect exedocNuevo<br />: ' . pg_last_error());
	
	/*
	if(0){
		$srv ="srv03w2k3sql01.gorecoquimbo.cl";
		$conexion_personal = mssql_connect($srv,"usr_cometida","pas_cometida") or die ("No se puede conectar a la base de datos") ;	
	}else{
		$srv ="developers01.gorecoquimbo.cl";
		$conexion_personal= mssql_connect($srv, 'usr_cometida', 'pas_cometida') or die ("No se puede conectar a la base de datos<br /><pre>".print_r(error_get_last(),true))."</pre>";
		//$conexion_personal = mssql_connect("srv03w2k3sql01.gorecoquimbo.cl","usr_cometida","pas_cometida") or die ("No se puede conectar a la base de datos") ;	
	}
	$conextado = mssql_select_db("personal",$conexion_personal);
	
	echo $srv.'<pre>'.print_r($conextado, true).'</pre>';
	*/
endif;
?>