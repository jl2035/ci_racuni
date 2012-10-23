
	<h1>Dodaj storitev</h1>

	<?= form_open(base_url() . 'storitve/insert'); ?>

	<label>Naziv</label>
	<?= form_input(array('id' => 'naziv', 'name' => 'naziv')); ?>
	<br>
	<label>Cena</label>
	<?= form_input(array('id' => 'cena', 'name' => 'cena')); ?>
	<br>
	<?= form_hidden(array('sid' => $sid)); ?>
	<?= form_submit(array('name' => 'submit', 'value' => 'Shrani')); ?>
	
	<?= form_close(); ?>
