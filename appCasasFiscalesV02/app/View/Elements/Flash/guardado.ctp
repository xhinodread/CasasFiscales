<div class="flash flash_success center-block" id="flashGuardado" >
  	<div class="row">
  		<div class="col-md-11 text-center text-black">Guardado</div>
  		<div class="col-md-1">
   			<label title="CERRAR" id="btnCerrar" class="btn btn-alert" >[X]</label>
   		</div>
   	</div>
	<div class="text-center text-black"><?=$message;?></div>
</div>
<script>
$(document).ready(function () {
	$('#btnCerrar').click(function () {
		$('#flashGuardado').fadeOut( "slow", function() {  $('#flashGuardado').hide(); });
	});
	setTimeout( function(){ $('#flashGuardado').fadeOut( "slow", function() {  $('#flashGuardado').hide(); }) } , 3000);
});
</script>