
	<h1>Prijava</h1>

	<?= form_open(base_url() . 'user/login'); ?>
	
	<label>Uporabnik</label>
	<?= form_input(array('id' => 'username', 'name' => 'username')); ?>
	<br>
	<label>Geslo</label>
	<?= form_password(array('id' => 'password', 'name' => 'password')); ?>
	<br>
	<?= form_submit(array('name' => 'submit', 'value' => 'Prijava'));
	form_close(); ?>
	
