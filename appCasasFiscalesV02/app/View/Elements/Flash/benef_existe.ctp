<div class="flash flash_error center-block" id="flashError" >
  	<div class="row">
  		<div class="col-md-11 text-center text-black">¡¡¡ ATENCIÓN !!!</div>
  		<div class="col-md-1">
   			<label title="CERRAR" id="btnCerrar" class="btn btn-alert" >[X]</label>
   		</div>
   	</div>
	<div class="text-center text-aliceblue"><?=$message;?></div>
</div>
<script>
$(document).ready(function () {
	$('#btnCerrar').click(function () {
		$('#flashError').fadeOut( "slow", function() {  $('#flashError').hide(); });
	});
	setTimeout( function(){ $('#flashError').fadeOut( "slow", function() {  $('#flashError').hide(); }) } , 6000); 
});
</script>