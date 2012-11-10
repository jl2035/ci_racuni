<?php 
	echo form_open(base_url() . 'nastavitve/geslo_update');
	echo 'Novo geslo: '.form_password('geslo').'<br>';
	echo 'Potrditev gesla: '.form_password('potrditev').'<br>';
	echo form_submit('submit', 'Posodobi geslo');
	echo form_close();

?>
