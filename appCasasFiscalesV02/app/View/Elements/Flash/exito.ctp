<div class="flash flash_success center-block" id="flashExito" >
  	<div class="row">
  		<div class="col-md-11 text-center text-black">EXITO</div>
  		<div class="col-md-1">
   			<label title="CERRAR" id="btnCerrar" class="btn btn-alert" >[X]</label>
   		</div>
   	</div>
	<div class="text-center text-black"><?=$message;?></div>
</div>
<script>
$(document).ready(function () {
	$('#btnCerrar').click(function () {
		$('#flashExito').fadeOut( "slow", function() {  $('#flashExito').hide(); });
	});
});
</script>