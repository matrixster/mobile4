<?php
session_start();

?>

<script>

function setCombo(t){
	
	switch(t){
	case "leads":


		setTimeout(function(){setme()},100); 
		function setme(){var combo1= $$('campaign').getValue();  $$('campaigncom').setValue(combo1); } 
	
	break;
	default:
	
	break;
	
	}
	
}


</script>