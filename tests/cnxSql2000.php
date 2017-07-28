<?
if(0):
	// usr_web
	// gore4321*-
	// $srv ="srv03w2k3sql01.gorecoquimbo.cl";
	// $srv ="developers01.gorecoquimbo.cl";
	 $srv ="SRV53BDDEV01.gorecoquimbo.cl";
	 // $connectionMs = mssql_connect($srv,"usr_web","gore4321*-", true); // or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	 $connectionMs = mssql_connect($srv, "usr_remoto", "4321*-", true) or die('<pre>'.print_r(error_get_last(), true).'</pre>.'.mssql_get_last_message());
	$conextado = -1;
	if($connectionMs){
		$vecDbs = array("DbEvalFunc", "tempdb", "DB_Cometidos");
		mssql_select_db($vecDbs[0], $connectionMs);
		echo 'Conextado';
	}else{
		echo "<pre>".print_r( error_get_last(), 1 )."</pre>"."<pre>".print_r( mssql_get_last_message(), 1 )."</pre>";
	}
	
	
	$sql = "SELECT * FROM periodos";
	$rs = mssql_query($sql, $connectionMs);
	
	echo '<br />Cuenta: '.mssql_num_rows($rs).'<br />';
	$unRow = mssql_fetch_assoc($rs);
	echo '<br />unRow: '.print_r($unRow, 1).'<br />';

	
endif;


$serverName = "SRV53BDDEV01.gorecoquimbo.cl"; //serverName\instanceName
/*
$connectionInfo = array( "Database"=>"DB_Cometidos", "UID"=>"usr_remoto", "PWD"=>"4321*-");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( '<pre>'.print_r( sqlsrv_errors(), true)).'</pre>';
}

*/
$c = new PDO("sqlsrv:Server=$serverNam;Database=DB_Cometidos", "usr_remoto", "4321*-");

if( $c ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( '<pre>'.print_r( 'errorr')).'</pre>';
}


?> 