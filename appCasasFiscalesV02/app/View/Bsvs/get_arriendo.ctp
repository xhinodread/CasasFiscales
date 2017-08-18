<? if(1){ ?>
	<?=$this->Js->object($datos);?>
<? }else{ ?>
	<?='<pre>'.print_r($datos,1).'</pre>';?>
<? } ?>