
	<h1>Dodaj storitev</h1>

	<?= form_open(base_url() . 'stranke/insert'); ?>

	<label>Naziv</label>
	<?= form_input(array('id' => 'naziv', 'name' => 'naziv')); ?>
	<br>
	<label>Naslov</label>
	<?= form_input(array('id' => 'naslov', 'name' => 'naslov')); ?>
	<br>
	<label>Pošta</label>
	<?= form_input(array('id' => 'posta', 'name' => 'posta')); ?>
	<br>
	<label>Telefon</label>
	<?= form_input(array('id' => 'telefon', 'name' => 'telefon')); ?>
	<br>
	<label>Email</label>
	<?= form_input(array('id' => 'email', 'name' => 'email')); ?>
	<br>
	<?= form_hidden(array('sid' => $sid)); ?>
	<?= form_submit(array('name' => 'submit', 'value' => 'Shrani')); ?>
	
	<?= form_close(); ?>
